<?php
require_once(dirname(__FILE__)."/../svr/BrainStormModule.php");
$module = new BrainStorm();
$dist = 0;
$base = 0;
$ins_id = 0;
if(array_key_exists("dist", $_POST)){
	$dist = (int)$_POST["dist"];
}
if(array_key_exists("base", $_POST)){
	$base = (int)$_POST["base"];
}

if($dist == 0 && $base > 0){
	$ins_id = $module->editNode($_POST["id"], $_POST["comment"]);
	$result = $module->addRelation($base, $ins_id, $_POST["detail"]);
}else if($dist > 0 && $base == 0){
	$ins_id = $module->editNode($_POST["id"], $_POST["comment"]);
	$result = $module->addRelation($ins_id, $dist, $_POST["detail"]);
}else if($dist > 0 && $base > 0){
	$result = $module->addRelation($base, $dist, $_POST["detail"]);
}else if($dist == 0 && $base == 0){
	$ins_id = $module->editNode($_POST["id"], $_POST["comment"]);
}

if((int)$result > 0){
	header("Location: ../?id=".$_POST["id"]);
}else{
	header("Location: ../?er=2");
}
?>
