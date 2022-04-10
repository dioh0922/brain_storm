<?php
require("./vendor/autoload.php");
class BrainStorm{
	//ORMと.ENVにする
	private $env = null;

	public function __construct(){
		$env = Dotenv\Dotenv::createImmutable(__DIR__."/../env");
		$env->load();
		ORM::configure("mysql:host=localhost;charset=utf8;dbname=".$_ENV["DB_DB"]);
		ORM::configure("username", $_ENV["DB_USER"]);
		ORM::configure("password", $_ENV["DB_PASS"]);
	}

	public function getBrainStormThemes(){
		$list = ORM::for_table("brain_storm")->find_many();
		return $list;
	}

	public function getDiscussionNode(int $id){
		$result = [];

		//対象のネタに関する記述を取ってくる
		$node = ORM::for_table("brain_storm")
		->join("brain_storm_node", ["brain_storm.id", "=", "brain_storm_node.target_discus_id"])
		->where("brain_storm.id", $id)
		->find_many();

		foreach ($node as $key => $value) {
			$relation = ORM::for_table("brain_storm_node")->table_alias("base_node")
			->select("base_node.summary", "base")
			->select("dist_node.summary", "dist")
			->join("brain_storm_relation", ["base_node.node_id", "=", "brain_storm_relation.base_node_id"])
			->join("brain_storm_node", ["dist_node.node_id", "=", "brain_storm_relation.dist_node_id"], "dist_node")
			->where("dist_node.node_id", $value->node_id)
			->find_many();
			foreach ($relation as $key => $relation_obj) {
				$tmp = ["base" => $relation_obj->base, "dist" => $relation_obj->dist];
				$result[] = $tmp;
			}
		}

		return $result;
	}

	private function _a(int $id){
		$list = ORM::for_table("brain_storm")
		->join("brain_storm_node", ["brain_storm.id", "=", "brain_storm_node.target_discus_id"])
		->join("brain_storm_relation", ["brain_storm_node.node_id", "=", "brain_storm_relation.base_node_id"])
		->where("brain_storm.id", $id)
		->find_many();
		return $list;
	}
}

?>
