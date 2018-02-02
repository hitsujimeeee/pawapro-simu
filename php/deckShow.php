<!DOCTYPE html>
<?php
require_once 'global.php';
$dbh = DB::connect();
?>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ デッキウォッチ';
		$description = 'パワプロアプリのイベキャラデッキをみんなで共有しましょう。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/assessment.css">
		<script src="../js/assessment.js"></script>
		<script>
		</script>
		<style>
			.iconContainer {
				position: relative;
				width: 64px;
				height:64px;
			}

			.iconImg {
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
			}

			.lv {
				position: absolute;
				bottom: -0.3em;
				right: 0;
				font-weight: bold;
				font-size: 1.2em;
				text-shadow:
					#fff 1px 1px 0px,
					#fff -1px 1px 0px,
					#fff 1px -1px 0px,
					#fff -1px -1px 0px;
			}

			.iconArea {
				display: flex;
			}

			.makeChara th {
				text-align: center;
			}
		</style>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<h2 class="pageHeader"><i class="fa fa-retweet"></i>デッキシェア</h2>
			<section>
				<br>
				<h3>強化太平楽テンプレ</h3>
				<div class="iconArea">
					<div class="iconContainer">
						<img class="iconImg" src="../img/charaIcon/294SR.jpg" style="width:64px;">
						<div class="lv">Lv45</div>
					</div>
					<div class="iconContainer">
						<img class="iconImg" src="../img/charaIcon/kaminariSR.jpg" style="width:64px;">
						<div class="lv">Lv45</div>
					</div>
					<div class="iconContainer">
						<img class="iconImg" src="../img/charaIcon/nijimaSR.jpg" style="width:64px;">
						<div class="lv">Lv45</div>
					</div>
					<div class="iconContainer">
						<img class="iconImg" src="../img/charaIcon/moroiSR.jpg" style="width:64px;">
						<div class="lv">Lv45</div>
					</div>
					<div class="iconContainer">
						<img class="iconImg" src="../img/charaIcon/646.jpg" style="width:64px;">
						<div class="lv">Lv45</div>
					</div>
					<div class="iconContainer">
						<img class="iconImg" src="../img/charaIcon/noumiSR.jpg" style="width:64px;">
						<div class="lv">Lv45</div>
					</div>

				 </div>

				<br>
				<div>
					<p>■デッキ特徴・コンセプト</p>
					<textarea style="width:80%;height:5em;">1/19(木)から始まった太平楽強化キャンペーンのテンプレデッキです。
					</textarea>
				</div>
				<br>
				<br>

				<div>
					<p>■作成選手</p>
					<table class="modern makeChara">
						<tr>
							<th></th>
							<th>名前</th>
							<th>弾道</th>
							<th>打</th>
							<th>力</th>
							<th>走</th>
							<th>肩</th>
							<th>守</th>
							<th>捕</th>
							<th>査定</th>
						</tr>
						<tr>
							<td><img src="../img/charaIcon/4b1adf05.png" width="64px"></td>
							<td style="width:2.5em;text-align:center;"><a href="">雷</a></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/trajectory2.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/rankB.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/rankD.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/rankE.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/rankD.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/rankB.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;"><img src="../img/rankC.png" width="28px;"></td>
							<td style="width:2.5em;text-align:center;">2100</td>
						</tr>
					</table>
				</div>

				<br>
				<div>
					<p>■考案者情報</p>
					<table class="modern">
						<tr><th>パワプロID</th><td>0123456789</td></tr>
						<tr><th>Twitter</th><td><a href="https://twitter.com/hitsujiPawapro">@hitsujiPawapro</a></td></tr>
					</table>
				</div>


			</section>

		</main>
		<?php include('../html/footer.html'); ?>
	</body>

</html>

<!-- https://jsfiddle.net/dpgjx1ca/ -->
