<!DOCTYPE html>
<html lang="ja">

<head>
	<?php
		$title = 'パワプロアプリ育成シミュレーター | 課金額シミュレーター';
		$description = 'パワプロアプリの課金額計算ツールです。ガチャで選手をMAX開放するのに幾ら必要かを計算します。';
		require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/moneyCalc.css?ver20171104">
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script src="../js/moneyCalc.js?ver20171104"></script>
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2><i class="fa fa-jpy"></i>課金額シミュレーター</h2>
		</header>

		<section id="targetSection">
			<header><i class="fa fa-cube"></i>欲しいキャラ</header>
			<p>
				<select id="targetRarelity">
					<option value="0">PSR50</option>
					<option value="1">SR45</option>
				</select>
			</p>
		</section>

		<section class="ownStatusSection">
			<header><i class="fa fa-cube"></i>手持ち状態</header>
			<p>
				<select id="ownStatus">
					<option value="0">未所持</option>
					<option value="1">母体獲得済み</option>
					<option value="2">+1</option>
					<option value="3">+2</option>
					<option value="4">+3</option>
					<option value="5">+4</option>
				</select>
			</p>
		</section>

		<section id="condSection">
			<p><i class="fa fa-cube"></i>条件</p>

			<div class="condInSec">
				<div>▶出現割合</div>
				<table class="modern condList">
					<tr>
						<th>PSR出現率</th>
						<td>
							<input type="text" class="sRate">
						</td>
					</tr>
					<tr>
						<th>SR出現率</th>
						<td>
							<input type="text" class="sRate">
						</td>
					</tr>
					<tr>
						<th>PR出現率</th>
						<td>
							<input type="text" class="sRate">
						</td>
					</tr>
					<tr>
						<th>R出現率</th>
						<td>
							<input type="text" class="sRate">
						</td>
					</tr>
				</table>
			</div>
			<div class="condInSec">

				<div>▶出現キャラ</div>
				<table class="modern condList">
					<tr>
						<th>ピックアップキャラ数</th>
						<td>
							<input type="text" id="pCount">
						</td>
					</tr>
					<tr>
						<th>上記以外のキャラ数</th>
						<td>
							<input type="text" id="allCount">
						</td>
					</tr>
					<tr>
						<th>ピックアップ出現率</th>
						<td>
							<input type="text" id="pRate">
						</td>
					</tr>
				</table>
			</div>

			<div class="condInSec">
				<div class="margin-left">▶確定枠</div>
				<table class="modern condList">
					<tr>
						<th>確定数</th>
						<td>
							<input type="text" id="confCount">
						</td>
					</tr>
					<tr>
						<th style="border-bottom:1px solid #000">確定レアリティ</th>
						<td>
							<select id="confRarelity">
								<option value="0">SR以上</option>
								<option value="1" selected>PR以上</option>
							</select>
						</td>
						<tr>
							<td colspan="2">
								<div>
									<input type="radio" class="isConfPickUp" name="confType" value="1">ピックアップキャラのみ</div>
								<div>
									<input type="radio" class="isConfPickUp" name="confType" value="0" checked>ピックアップ以外も含む</div>
							</td>
						</tr>
				</table>
			</div>


			<div class="condInSec condOthers">
				<div class="margin-left">▶その他</div>
				<div>
					<input type="checkbox" id="psrseed">PSRをSRの素材にする<i class="fa fa-question-circle help" style="color:#0000ff; margin-left:1em;"></i>
					<p class="arrow_box">
						目標がSR45のとき、同キャラのPSRを合成素材として使う場合チェックを付けてください。
						<br>
					</p>
				</div>
				<div>
					<input type="checkbox" id="mixFlag" checked>素材合成をON<i class="fa fa-question-circle help" style="color:#0000ff; margin-left:1em;"></i>
					<p class="arrow_box">
						素材合成をONにすると、RやPRをその上位のレアリティに合成するようになります。
						<br> 例えばPSR50を作る場合、手持ちのRをPRに合成してPR+5を作り、さらにPRとPR+5をSRに合成してSR+5を作ってPSRに合成するようにします。
						<br> 同一レアリティへの合成は行いません。
						<br>
					</p>
				</div>
				<div>
					<input type="checkbox" id="simFlag" checked>1万回やって平均を取る<i class="fa fa-question-circle help" style="color:#0000ff; margin-left:1em;"></i>
					<p class="arrow_box">
						1回の試行だとバラツキが出るため、1万回処理を実行して平均を出します。
						<br>
					</p>
				</div>

			</div>

			<p class="execForm">
				<button onclick="moneyCalc.calc();">計算開始</button>
			</p>
			<div class="manualAnnotation">
				※使い方、注意事項は<a href="./manual.php#idx4">マニュアル</a>をご参照ください。
			</div>
		</section>

		<div id="displayArea"></div>
		<div id="compChartArea"></div>
		<div id="botaiChartArea"></div>

		<?php include('./adsense/responsive.php') ?>


	</main>

	<?php include('./optionMenu.php'); ?>


	<?php include('../html/footer.html'); ?>
</body>

</html>
