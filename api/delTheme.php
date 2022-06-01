<?php
require_once(dirname(__FILE__)."/../svr/BrainStormModule.php");
$module = new BrainStorm();
$result = $module->delTheme($_POST["id"]);
if((int)$result > 0){
	header("Location: ../");
}else{
	header("Location: ../?er=1");
}
?>
