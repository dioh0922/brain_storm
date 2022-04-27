<?php
require_once(dirname(__FILE__)."/../svr/BrainStormModule.php");
$module = new BrainStorm();
$ins_id = $module->editNode($_POST["id"], $_POST["comment"]);
if(array_key_exists("dist", $_POST)){
	if($_POST["dist"] != 0){
		$result = $module->addRelation($ins_id, (int)$_POST["dist"], $_POST["detail"]);
	}
}
if(array_key_exists("base", $_POST)){
	if($_POST["base"] != 0){
		$result = $module->addRelation((int)$_POST["base"], $ins_id, $_POST["detail"]);
	}
}
if((int)$result > 0){
	header("Location: ../?id=".$_POST["id"]);
}else{
	header("Location: ../?er=2");
}
?>
