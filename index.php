<?php
require_once(dirname(__FILE__)."/svr/BrainStormModule.php");
$module = new BrainStorm();
$list = $module->getBrainStormThemes();
$id = 0;
if(array_key_exists("id", $_GET)){
	$id = (int)$_GET["id"];
}

$er = 0;
if(array_key_exists("er", $_GET)){
	$er = 1;
}

$node = $module->getDiscussionNode($id);
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
	<head>
		<meta charset="utf-8">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/8.14.0/mermaid.min.js" integrity="sha512-vLumCjg7NKEQKGM+xAgBYTvQ90DVu6Eo7vS1T/iPf2feNLcrpGxvumuUUmE3CPiCUPgviyKbtpWGDbhnVnmJxg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<title></title>

	</head>
	<body>
		<?php if($er == 1){ ?>
			<h2>追加に失敗しました</h2>
		<?php } ?>

		<?php if($id > 0){ ?>
		<div class="mermaid">
			graph LR;
			<?php foreach ($node as $key => $value) { ?>
       <?php echo str_replace(" ", "_", $value["base"])."-->".$value["relation"].$value["dist"].";"?>
			<?php } ?>
		</div>
		<?php } ?>
		<ul>
			<?php foreach ($list as $key => $value) { ?>
				<li> <a href="./?id=<?php echo $value->id; ?>"><?php echo $value->id." ".$value->discussion_title ?></a></li>
			<?php } ?>
		</ul>

		<form class="" action="./api/addTheme.php" method="post">
			<input type="text" name="title" value="">
			<input type="submit" name="" value="テーマ追加">
		</form>

		<script src="./js/src/brain_storm.js"></script>
	</body>
</html>
