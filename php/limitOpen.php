<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ育成シミュレーター | 上限開放予報士';
		$description = 'パワプロアプリの上限開放確率計算ツールです。手持ちの合成素材で何Lv開放出来るか、Lv毎の確率を予想します。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/limitOpen.css">
		<script src="../js/limitOpen.js"></script>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-bar-chart"></i>上限開放予報士くん</h2>
			</header>

			<section id="targetSection">
				<header><i class="fa fa-cube"></i>開放対象キャラ</header>
				<p>
					<select id="targetRarelity">
						<option value="0">PSR</option>
						<option value="1">SR</option>
						<option value="2">PR</option>
					</select>
					<select id="targetLevel">
						<option value="0">0</option>
						<option value="1">+1</option>
						<option value="2">+2</option>
						<option value="3">+3</option>
						<option value="4">+4</option>
					</select>
				</p>

			</section>
			<section id="materialSection">
				<p><i class="fa fa-cube"></i>合成素材</p>
				<div>
					<dl id="cardList">
						<dt><div>PSR</div></dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>PSR(別ver)</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>PSR+5</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>SR</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>SR(別ver)</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>SR+5</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>PR</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>PR(別ver)</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt>PR+5</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt class="last-line">R</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt class="last-line">R(別ver)</dt>
						<dd><input type="number" class="cardCount"></dd>
						<dt class="last-line">R+5</dt>
						<dd><input type="number" class="cardCount"></dd>
					</dl>
				</div>
				<div class="optArea">
					<input type="checkbox" id="optimise" onclick="limitOpen.syncCheckText('optimiseValue', this.checked)"><span>素材合成を行う</span>
					&nbsp;&nbsp;<span>閾値</span><input type="number" id="optimiseValue" min="0" max="99" value="70" disabled>％
				</div>
				<div>
					<button class="execute" onclick="limitOpen.outputResult()">実行</button>
				</div>
				<div id="outputArea">
					<div id="hukidashi" class="hukidashi">
						<b>上限開放したいキャラクターのレアリティ、開放数</b>と、<b>所持している合成素材</b>を入力して<b>「実行」</b>ボタンを押してください。<br><br>
						詳しい使い方はこちら→<a href="./manual.php#idx3">マニュアル</a>
					</div>
				</div>
				<div><img src="../img/yohokun.jpg"></div>
			</section>

			<section>
				<header><i class="fa fa-line-chart"></i>上限開放率一覧</header>
				<div class="table-responsive">
					<table class="modern perData table">
						<tr>
							<th>　</th>
							<th>PSR</th>
							<th>PSR(別ver)</th>
							<th>PSR+5</th>
							<th>SR</th>
							<th>SR(別ver)</th>
							<th>SR+5</th>
							<th>PR</th>
							<th>PR(別ver)</th>
							<th>PR+5</th>
							<th>R</th>
							<th>R(別ver)</th>
							<th>R+5</th>
						</tr>
						<tr>
							<th>PSR</th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<th>SR</th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<th>PR</th>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</div>
				<p>※「130%」は、+1確定でさらに30%の確率で+1開放を表しています。</p>
			</section>
		</main>

		<?php include('./optionMenu.php'); ?>


		<?php include('../html/footer.html'); ?>
	</body>

</html>
