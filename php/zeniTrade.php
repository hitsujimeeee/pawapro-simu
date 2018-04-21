<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　銭ペナゼニ交換計算機';
		$description = 'パワプロアプリのイベント銭ペナにおいて、ゼニ交換に掛かる金額を計算します。';
		require_once './headInclude.php';
		?>
		<style>
			#zeniTable input {
				width: 4em;
				text-align: right;
			}

			#zeniTable {
				margin-left: 0.5em;
			}

			#zeniTable tr td:nth-child(2), #zeniTable tr td:nth-child(4){
				text-align: right;
			}

			.totalArea {
				margin-left: 0.2em;
				font-size: 1.5em;
			}

			.discountArea {
				margin-left: 0.5em;
			}
		</style>
		<script src="../js/zeniTrade.js"></script>


	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-yen" aria-hidden="true"></i>銭ペナ ゼニ交換計算機</h2>
			</header>
			<section>

				<div class="totalArea">
					合計金額：\<span id="totalValue" style="font-weight:bold;">0</span>
				</div>
				<div class="discountArea">
					割引率：
					<select id="discountPer">
						<option value="0">0%</option>
						<option value="1">1%</option>
						<option value="2">2%</option>
						<option value="3">3%</option>
						<option value="5">5%</option>
						<option value="10">10%</option>
					</select>
				</div>
				<table class="modern" id="zeniTable">
					<tr>
						<th>アイテム名</th>
						<th>値段</th>
						<th>選択数</th>
						<th>最大数</th>
					</tr>
					<?php
						$itemList = [
							['【限】[PR]凡田夏之介', 750000, 1],
							['[PR]凡田夏之介', 1500000, 1],
							['[R]凡田夏之介', 600000, 6],
							['[PSR]凡田大介', 13000000, 1],
							['[SR]凡田大介', 4000000, 6],
							['[PR]凡田大介', 1300000, 6],
							['[R]凡田大介', 600000, 6],
							['SRガチャ券', 5000000, 2],
							['PRダイジョーブ博士像', 5000000, 2],
							['銀のきらめき', 4500000, 1],
							['天才の入部届', 3000000, 3],
							['【限】SR30％ガチャ券', 1500000, 1],
							['SR30％ガチャ券', 3000000, 3],
							['【限】SR20％ガチャ券', 1250000, 1],
							['SR20％ガチャ券', 2500000, 4],
							['【限】SR10％ガチャ券', 1000000, 1],
							['SR10％ガチャ券', 2000000, 5],
							['Rダイジョーブ博士像', 2000000, 5],
							['銅のきらめき', 1500000, 3],
							['PRガチャ券', 1250000, 5],
							['ゲドーくん像(プラチナ)', 750000, 3],
							['Rガチャ券', 500000, 10],
							['カロリーバー', 500000, 30],
							['覚醒のカギ', 500000, 5],
							['ゲドーくん像(金)', 400000, 5],
							['ダイジョーブの成功手形', 250000, 2],
							['ダイジョーブのメス', 250000, 2],
							['まねき猫', 250000, 30],
							['MAXパワドリンク', 250000, 30],
							['野球神のお守り', 250000, 30],
							['パワストーン', 150000, 10],
							['ゲドーくん像(銀)', 125000, 10],
							['投手の極意', 100000, 50],
							['野手の極意', 100000, 50],
							['マネージャーの極意', 100000, 50],
							['サポーター', 75000, 50],
							['ビルドパワドリンク', 75000, 50],
							['万能パワドリンク', 75000, 50],
							['ロックオンバット極', 50000, 50],
							['ナイスピッチボール極', 50000, 50],
							['金のジョウロ', 50000, 3],
							['【限】ドッグフード', 5000, 10],
							['ドッグフード', 50000, 50],
							['ゲドーくん像(銅)', 30000, 20],
							['ロックオンバット', 25000, 50],
							['ナイスピッチボール', 25000, 50],
							['恋愛成就のお守り', 25000, 50],
							['ともだちスタンプ', 25000, 50],
							['調子MAXドリンク', 25000, 50],
							['アロマグッズ', 15000, 50]
						];

					foreach($itemList as $item) { ?>
					<tr>
						<td><?= $item[0]?></td>
						<td>\<span class="price"><?= number_format($item[1])?></span><input type="hidden" value="<?= $item[1]?>" class="basePrice"></td>
						<td><input type="number" class="tradeAmount" max="<?=item[2]?>" min="0"></td>
						<td><?= $item[2]?></td>
					</tr>
					<?php } ?>
				</table>
			</section>

			<?php include('./adsense/responsive.php') ?>

		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
