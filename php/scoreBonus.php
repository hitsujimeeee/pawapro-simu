<!DOCTYPE html>
<html lang="ja">
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@hitsujiPawapro" />
	<meta name="og:url" content="http://studiowool.webcrow.jp/products/pawapro/php/scoreBonus.php" />
	<meta name="og:title" content="パワプロアプリ　スコアボーナスチェッカー" />
	<meta name="og:description" content="チーム総合力と上限突破ボナから、スタジアムスコアの倍率を計算できます。" />
	<meta name="og:image" content="http://studiowool.webcrow.jp/products/pawapro/img/thumbnail.jpg" />
	<head>
		<?php
		$title = 'パワプロアプリ　スコアボーナスチェッカー';
		$description = 'チーム総合力と上限突破ボナから、スタジアムスコアの倍率を計算できます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/scoreBonus.css">
		<script src="../js/scoreBonus.js"></script>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-percent" aria-hidden="true"></i>スコアボーナスチェッカー</h2>
			</header>
			<section>
				<div class="teamDetailContainer">
					<div class="teamDetail">
						<div><i class="fa fa-cube"></i>チーム情報</div>
						<div class="teamTableContainer">
							<table class="modern teamTable">
								<tr>
									<th>チーム総合力</th>
									<td><input type="number" id="teamRank" class="teamInput"></td>
								</tr>
								<tr>
									<th>上限突破ボナ</th>
									<td><input type="number" id="limitBonus" class="teamInput"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div id="displayArea" class="display">
					<p>あなたのチームのスコア倍率は<span id="scoreMag"></span>です。</p>
					<p>左上チーム(チーム総合力-1500)を対戦相手に選択した場合、スコア倍率は<span id="scoreMagWeak"></span>になります。</p>
					<p>中央チーム(チーム総合力+1000)を対戦相手に選択した場合、スコア倍率は<span id="scoreMagPwfl"></span>になります。</p>
					<p>ホームラン1本(基礎点10000pt)につき、最終スコアに<span id="scoreSimulate"></span>分が加算されます。</p>
				</div>
				<div class="annotation">
					※スコア倍率の計算方法はこちらをご覧ください<br>
					&nbsp;⇒<a href="http://studiowool.hatenablog.com/entry/2017/05/13/212255" target="_blank">【パワプロ情報学入門】</a>
				</div>
				<div class="shareArea">
					<button class="shareButton" onClick="scoreBonus.sendTwitter();">結果をTwitterで呟く</button>
					<a class="shareLink" href="" target="_blank"></a>
				</div>

			</section>

			<?php include('./adsense/responsive.php') ?>

			<hr class="abHr">

			<section>
				<div class="operateContainer">
					<div class="operateArea">
						<div><i class="fa fa-cube"></i>野手出番操作</div>
						<div class="operateTableContainer">
							<table class="modern operateTable">
								<tr>
									<th>対戦相手</th>
									<td>
										<select id="battingOpponent" class="operateInput batterOperate">
											<option value="0">左上</option>
											<option value="1">中央</option>
											<option value="2">下</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>打撃成績</th>
									<td>
										<select id="battingResult" class="operateInput batterOperate">
											<option value="2000">単打</option>
											<option value="6000">二塁打</option>
											<option value="20000">三塁打</option>
											<option value="10000">本塁打</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>打点</th>
									<td>
										<select id="battingScore" class="operateInput batterOperate">
											<option value="0"></option>
											<option value="4000">1</option>
											<option value="8000">2</option>
											<option value="12000">3</option>
											<option value="16000">4</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>変化量</th>
									<td>
										<select id="battingChangeBall" class="operateInput batterOperate">
											<option value="0"></option>
											<option value="1000">1</option>
											<option value="2000">2</option>
											<option value="3500">3</option>
											<option value="5000">4</option>
											<option value="6500">5</option>
											<option value="8000">6</option>
											<option value="10000">7</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>展開</th>
									<td>
										<select id="battingScene" class="operateInput batterOperate">
											<option value="0"></option>
											<option value="5000">同点</option>
											<option value="5000">勝ち越し</option>
											<option value="12000">逆転</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>サヨナラ</th>
									<td>
										<select id="battingSayonara" class="operateInput batterOperate">
											<option value="0"></option>
											<option value="30000">あり</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div id="battingDisplay" class="display"></div>
			</section>

			<hr class="abHr">

			<section>
				<div class="operateContainer">
					<div class="operateArea">
						<div><i class="fa fa-cube"></i>投手出番操作</div>
						<div class="operateTableContainer">
							<table class="modern operateTable">
								<tr>
									<th>対戦相手</th>
									<td>
										<select id="pitchingOpponent" class="operateInput pitchingOperate">
											<option value="0">左上</option>
											<option value="1">中央</option>
											<option value="2">下</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>投球成績</th>
									<td>
										<select id="pitchingResult" class="operateInput pitchingOperate">
											<option value="0">フライ・ゴロ</option>
											<option value="10000">三振</option>
											<option value="13000">三球三振</option>
											<option value="20000">併殺</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>ランナー</th>
									<td>
										<select id="pitchingRunner" class="operateInput pitchingOperate">
											<option value="0">無し</option>
											<option value="1000">1塁</option>
											<option value="1500">2塁</option>
											<option value="2000">3塁</option>
											<option value="2500">1,2塁</option>
											<option value="3000">1,3塁</option>
											<option value="35000">2,3塁</option>
											<option value="45000">満塁</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>奪ｽﾄﾗｲｸ数</th>
									<td>
										<select id="pitchingStrike" class="operateInput pitchingOperate">
											<option value="0">0</option>
											<option value="1000">1</option>
											<option value="2000">2</option>
											<option value="3000">3</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>アウト数</th>
									<td>
										<select id="pitchingOutCount" class="operateInput pitchingOperate">
											<option value="1000">1</option>
											<option value="2000">2</option>
											<option value="3000">3</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div id="pitchingDisplay" class="display"></div>
			</section>
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
