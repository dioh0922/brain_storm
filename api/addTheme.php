<?php
require_once(dirname(__FILE__)."/../svr/BrainStormModule.php");
$module = new BrainStorm();
$result = $module->addTheme($_POST["title"]);
if((int)$result > 0){
	header("Location: ../");
}else{
	header("Location: ../?er=1");
}
?>
