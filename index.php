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
	$er = (int)$_GET["er"];
}

$node = $module->getDiscussionNode($id);
$node_item = $module->getNodeItem($id);
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<!-- Compiled and minified CSS -->
		    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

		    <!-- Compiled and minified JavaScript -->
		    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/8.14.0/mermaid.min.js" integrity="sha512-vLumCjg7NKEQKGM+xAgBYTvQ90DVu6Eo7vS1T/iPf2feNLcrpGxvumuUUmE3CPiCUPgviyKbtpWGDbhnVnmJxg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<title></title>

		<script type="text/javascript">
		$(document).ready(function(){
    	$('.tabs').tabs();
  	});
</script>

	</head>
	<body>
		<p>旅行するときの計画メモ</p>
		<?php if($er == 1){ ?>
			<h2>追加に失敗しました</h2>
		<?php }elseif($er == 2){ ?>
			<h2>アイデアの編集に失敗しました</h2>
		<?php } ?>

		<?php if($id > 0){ ?>
		<div class="mermaid">
			flowchart LR;
			<?php foreach ($node as $key => $value) { ?>
       <?php echo str_replace(" ", "_", $value["base"])."-->".$value["relation"].$value["dist"].";"?>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="row" >
			<div class="col s12">
				<ul class="tabs">
					<?php foreach ($list as $key => $value) { ?>
						<li class="tab col s1">
						<?php if($id == $value->id){ ?>
							<a class="active" targt="_self" href="./?id=<?php echo $value->id ?>"><?php echo $value->discussion_title ?></a>
						<?php }else{ ?>
							<a target="_self" href="./?id=<?php echo $value->id ?>"><?php echo $value->id." ".$value->discussion_title ?></a>
						<?php } ?>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<form class="" action="./api/addTheme.php" method="post">
			<input type="text" name="title" placeholder="目的地を入力" value="">
			<input type="submit" name="" value="テーマ追加">
		</form>

		<form class="" action="./api/editNode.php" method="post">
			<select class="" name="base">
				<option value="0">派生元</option>
				<?php foreach($node_item as $key => $obj){ ?>
					<option value='<?php echo $obj["id"] ?>'><?php echo $obj["text"] ?></option>
				<?php } ?>
			</select>
			<input type="hidden" name="id" value="<?php echo $id ?>"/>
			<input type="text" name="detail" value="" placeholder="行き方/所要時間etcを入力">
			<select class="" name="dist">
				<option value="0">コメント対象</option>
				<?php foreach($node_item as $key => $obj){ ?>
					<option value='<?php echo $obj["id"] ?>'><?php echo $obj["text"] ?></option>
				<?php } ?>
			</select>
			<input type="text" name="comment" value="" placeholder="場所を入力"><input type="submit" value="アイデア追加"/>
		</form>


		<script src="./js/src/brain_storm.js"></script>
	</body>
</html>
