<?php
require_once(dirname(__FILE__)."/../svr/BrainStormModule.php");
$module = new BrainStorm();
$password = "";
if(array_key_exists("password", $_POST)){
	$password = $_POST["password"];
}

$success = $module->login($password);
if($success){
	header("Location: ../?id=".$_POST["id"]);
}else{
	header("Location: ../?er=2");
}

?>
