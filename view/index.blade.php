<!DOCTYPE html>
<html lang="ja" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
			$(document).ready(function(){
				$('select').formSelect();
			});
		</script>

	</head>
	<body>

		<div class="container">
			<nav>
				<div class="nav-wrapper">
					<div class="container">
						<div class="col s12">
							<h4 class="center-align" style="padding-top: 10px;">旅行するときの計画メモ</h4>
						</div>
					</div>
				</div>
			</nav>

			<div class="nav-content">
				@if($er == 1)
				<h2>追加に失敗しました</h2>
				@elseif($er == 2)
				<h2>アイデアの編集に失敗しました</h2>
				@endif
			</div>


			@if($id > 0)
			<div class="mermaid">
				flowchart LR;
				@foreach($node as $iter)
				 {{str_replace(" ", "_", $iter["base"])}}-->{{$iter["relation"]}}{{$iter["dist"]}};
			 	@endforeach
			</div>
			@endif
			<div class="row" >
				<div class="col s12">
					<ul class="tabs z-depth-1" style="height: 60px;">
						@foreach($list as $theme)
							<li class="tab">
								@if($id == $theme->id)
									<a class="active" targt="_self" href="./?id={{$theme->id}}">{{$theme->discussion_title}}</a>
								@else
									<a target="_self" href="./?id={{$theme->id}}">{{$theme->discussion_title}}</a>
								@endif
						</li>
						@endforeach
					</ul>
				</div>
			</div>


			<div class="row">
				<div class="green lighten-5 col s12">
					<form class="" name="theme" action="./api/addTheme.php" method="post">
						<input type="text" required name="title" placeholder="目的地を入力" value="">
						@if($login)
							<a href="javascript:theme.submit()" class="btn-floating btn waves-effect waves-light red">
								<i class="tiny material-icons">file_upload</i>
							</a>
						@else
							<a disabled="disabled" href="javascript:theme.submit()" class="btn-floating btn waves-effect waves-light grey">
								<i class="tiny material-icons">file_upload</i>
							</a>
						@endif
					</form>
				</div>
			</div>
			<div class="row">
				<div class="grey lighten-4 col s12">
					<form class="" name="comment" action="./api/editNode.php" method="post">
						<div class="input-field">
							<select name="base">
								<option value="0">派生元</option>
								@foreach($node_item as $obj)
									<option value='{{$obj["id"]}}'>{{$obj["text"]}}</option>
								@endforeach
							</select>
						</div>
						<input type="hidden" name="id" value="<?php echo $id ?>"/>
						<input type="text" name="detail" value="" placeholder="行き方/所要時間etcを入力">
						<select class="" name="dist">
							<option value="0">コメント対象</option>
							@foreach($node_item as $obj)
								<option value='{{$obj["id"]}}'>{{$obj["text"]}}</option>
							@endforeach
						</select>
						<input type="text" name="comment" value="" placeholder="場所を入力">
						@if($login)
						<a href="javascript:comment.submit()" class="btn-floating btn waves-effect waves-light green">
							<i class="tiny material-icons">edit</i>
						</a>
						@else
							<a disabled="disabled" href="javascript:comment.submit()" class="btn-floating btn waves-effect waves-light grey">
								<i class="tiny material-icons">edit</i>
							</a>
						@endif
					</form>
				</div>
			</div>

			@if(!$login)
			<div class="row">
				<form class="" name="login" action="./api/login.php" method="post">
					<input type="hidden" name="id" value="{{$id}}"/>
					<input type="password" name="password" placeholder="パスワード" value="">
					<a href="javascript:login.submit()" class="btn-floating btn waves-effect waves-light grey darken-1">
						<i class="tiny material-icons">vpn_key</i>
					</a>
				</form>
			</div>
			@endif

		</div>
	</body>
</html>
