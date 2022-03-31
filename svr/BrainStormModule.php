<?php
require("./vendor/autoload.php");
class BrainStorm{
	//ORMと.ENVにする
	private $env = null;

	public function __construct(){
		$env = Dotenv\Dotenv::createImmutable(__DIR__."/../env");
		$env->load();
		ORM::configure("mysql:host=localhost;dbname=".$_ENV["DB_DB"]);
		ORM::configure("username", $_ENV["DB_USER"]);
		ORM::configure("password", $_ENV["DB_PASS"]);
	}

	public function getBrainStormThemes(){
		$list = ORM::for_table("brain_storm")->find_many();
		return $list;
	}
}

?>
