<!DOCTYPE html>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ育成シミュレーター | 作成選手一覧';
	$description = 'パワプロアプリの育成シミュレーターです。当サイトで登録した選手を閲覧できます。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/characters.css">
	<script src="../js/commonModule.js?ver20171001"></script>
	<script src="../js/characters.js?ver20171001"></script>
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2><i class="fa fa-address-book-o" aria-hidden="true"></i>作成選手一覧</h2>
		</header>

		<section id="batterSection">
			<header><img class="iconGraph" src="../img/icon/bat.png">野手</header>
			<div class="table-responsive">
				<table id="batterTable" class="modern">
					<tr>
						<th></th>
						<th>選手名</th>
						<th>守備位置</th>
						<th>弾道</th>
						<th>打</th>
						<th>力</th>
						<th>走</th>
						<th>肩</th>
						<th>守</th>
						<th>補</th>
						<th>査定</th>
						<th></th>
						<th></th>
					</tr>
				</table>
			</div>
		</section>

		<?php include('./adsense/responsive.php') ?>

		<section id="pitcherSection">
			<header><img class="iconGraph" src="../img/icon/ball.png">投手</header>
			<div class="table-responsive">
				<table id="pitcherTable" class="modern">
					<tr>
						<th></th>
						<th>選手名</th>
						<th>守備位置</th>
						<th>球速</th>
						<th>コン</th>
						<th>スタ</th>
						<th>↑</th>
						<th>←</th>
						<th>↙</th>
						<th>↓</th>
						<th>↘</th>
						<th>→</th>
						<th></th>
						<th></th>
					</tr>
				</table>
			</div>
		</section>

		<?php include('./adsense/responsive.php') ?>

		<!--削除確認用モーダルウインドウ-->
		<div id="confirmModal" class="remodal" data-remodal-id="confirmModal" data-remodal-options="hashTracking:false">
			<button data-remodal-action="close" class="remodal-close"></button>
			<div class="remodalMsg"><i class="fa fa-info-circle fa-lg" style="color:#1d9d74"></i>選手情報を削除します。よろしいですか？</div>
			<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
			<button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
		</div>
	</main>

	<?php include('./optionMenu.php'); ?>


	<?php include('../html/footer.html'); ?>
</body>

</html>

<!-- https://jsfiddle.net/dpgjx1ca/ -->
