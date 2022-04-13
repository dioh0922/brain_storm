<?php
require_once(dirname(__FILE__)."/svr/BrainStormModule.php");
$module = new BrainStorm();
$list = $module->getBrainStormThemes();
$node = $module->getDiscussionNode(1);

?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
	<head>
		<meta charset="utf-8">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/8.14.0/mermaid.min.js" integrity="sha512-vLumCjg7NKEQKGM+xAgBYTvQ90DVu6Eo7vS1T/iPf2feNLcrpGxvumuUUmE3CPiCUPgviyKbtpWGDbhnVnmJxg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<title></title>

	</head>
	<body>
		<div class="mermaid">
			graph LR;
			<?php foreach ($node as $key => $value) { ?>
       <?php echo str_replace(" ", "_", $value["base"])."-->".$value["relation"].$value["dist"].";"?>
			<?php } ?>
		</div>
		<ul>
			<?php foreach ($list as $key => $value) { ?>
				<li onClick="selectTheme(<?php echo $value->id; ?>)"><?php echo $value->id." ".$value->discussion_title ?></li>
			<?php } ?>
		</ul>

		<script src="./js/src/brain_storm.js"></script>
	</body>
</html>
