<?php
require_once(dirname(__FILE__)."/svr/BrainStormModule.php");
$module = new BrainStorm();
$id = 0;
if(array_key_exists("id", $_GET)){
	$id = (int)$_GET["id"];
}

$er = 0;
if(array_key_exists("er", $_GET)){
	$er = (int)$_GET["er"];
}

echo $module->disp($id, $er);
?>
