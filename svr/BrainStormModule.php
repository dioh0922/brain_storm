<?php
require(dirname(__FILE__)."/../vendor/autoload.php");
use eftec\bladeone\BladeOne;
session_start();

class BrainStorm{
	//ORMと.ENVにする
	private $env = null;

	public function __construct(){
		$env = Dotenv\Dotenv::createImmutable(__DIR__."/../../env");
		$env->load();
		ORM::configure("mysql:host=localhost;charset=utf8;dbname=".$_ENV["DB_DB"]);
		ORM::configure("username", $_ENV["DB_USER"]);
		ORM::configure("password", $_ENV["DB_PASS"]);
	}

	public function getBrainStormThemes(){
		$list = ORM::for_table("brain_storm")->find_many();
		return $list;
	}

	public function disp(int $id, int $er){
		$node = $this->getDiscussionNode($id);
		$node_item = $this->getNodeItem($id);
		$list = $this->getBrainStormThemes();
		$login = false;
		if(session_status() == PHP_SESSION_ACTIVE && array_key_exists("login", $_SESSION)){
			$login = true;
		}
		$blade = new BladeOne(dirname(__FILE__)."/../view", "./cache", BladeOne::MODE_AUTO);
		return $blade->run("index", compact("list", "node", "node_item", "id", "er", "login"));
	}

	public function login(string $password){
		$result = false;
		if(openssl_encrypt($password, "AES-128-ECB", $_ENV["EDIT_KEY"]) == $_ENV["EDIT_PASSWORD"]){
			$_SESSION["login"] = "on";
			$result = true;
		}
		return $result;
	}

	public function getDiscussionNode(int $id){
		$result = [];

		//対象のネタに関する記述を取ってくる
		$node = ORM::forTable("brain_storm")
		->join("brain_storm_node", ["brain_storm.id", "=", "brain_storm_node.target_discus_id"])
		->where("brain_storm.id", $id)
		->findMany();

		foreach ($node as $key => $value) {
			$relation = ORM::forTable("brain_storm_node")->tableAlias("base_node")
			->select("base_node.summary", "base")
			->select("dist_node.summary", "dist")
			->select("brain_storm_relation.relation_summary", "relation")
			->join("brain_storm_relation", ["base_node.node_id", "=", "brain_storm_relation.base_node_id"])
			->join("brain_storm_node", ["dist_node.node_id", "=", "brain_storm_relation.dist_node_id"], "dist_node")
			->where("dist_node.node_id", $value->node_id)
			->findMany();
			foreach ($relation as $key => $relation_obj) {
				$tmp = [
					"base" => str_replace(" ", "_", $relation_obj->base),
					"dist" => str_replace(" ", "_", $relation_obj->dist),
					"base_id" => $relation_obj->base_id,
					"dist_id" => $relation_obj->dist_id,
					"relation" => ""
				];
				if(!empty($relation_obj->relation)){
					$tmp["relation"] = sprintf("|%s|", str_replace(" ", "_", $relation_obj->relation));
				}
				$result[] = $tmp;
			}
		}

		return $result;
	}

	public function getNodeItem(int $id){
		$result = [];
		$result = ORM::forTable("brain_storm_node")
		->select("node_id", "id")
		->select("summary", "text")
		->where("target_discus_id", $id)
		->findMany();
		return $result;
	}

	public function editNode(int $id, string $text){
		$idea = ORM::forTable("brain_storm_node")->create();
		$idea->summary = $text;
		$idea->target_discus_id = $id;
		$idea->edit_date = date("Y-m-d H:i:s");
		$idea->save();
		return $idea->id;
	}

	public function addTheme(string $title){
		$result = 0;
		$theme = ORM::forTable("brain_storm")->create();
		$theme->discussion_title = $title;
		$theme->save();
		$result = $theme->id;
		if($theme->id > 0){
			$this->editNode($theme->id, $title);
		}
		return $result;
	}

	public function addRelation(int $id, int $dist, string $detail){
		$result = 0;
		$exist = ORM::forTable("brain_storm_relation")
		->select("relation_id", "id")
		->where(["base_node_id" => $id, "dist_node_id" => $dist])
		->findOne();
		if($exist == false){
			$relation = ORM::forTable("brain_storm_relation")->create();
			$relation->base_node_id = $id;
			$relation->dist_node_id = $dist;
			$relation->relation_summary = $detail;
			$relation->save();
			$result = $relation->id;
		}else{
			$result = $exist->id;
		}
		return $result;
	}

}

?>
