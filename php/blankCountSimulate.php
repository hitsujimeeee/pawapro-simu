<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　査定調査お助けくん';
		$description = '最適な空き数を計算できる';
		require_once './headInclude.php';
		?>
	</head>
	<script>
		var bestCount = {
			trueList: null,
			truePoint: 999999,
			list: [
				[392, 1],
				[784, 5],
				[3920, 4],
				[1960, 8],
				[2352, 1],
				[3528, 1],
				[5880, 3],
				[6107, 1],
				[2744, 10],
				[1568, 10],
				[1011, 1],
				[3136, 1],
				[1176, 1],
				[7840, 5]
			],

			exec: function() {
				var targetValue = Math.round(Number($('#targetValue').val())*100);
				var bottomBorder = bestCount.calcAndDisplay(0, targetValue);
				var topBorder = bestCount.calcAndDisplay(1, targetValue);

				var str= '実査定の範囲: ' + bottomBorder.toFixed(2) + ' <= x < ' + topBorder.toFixed(2);
				$('#rangeArea').html(str);
			},

			calcAndDisplay: function(type, targetValue) {
				bestCount.trueList = null;
				bestCount.truePoint = 999999;
				bestCount.recallFunc(bestCount.list, 0, [], targetValue, type);
				var border = Math.floor((bestCount.truePoint)/1400+type) * 14 - bestCount.calcPoint(bestCount.list, bestCount.trueList, 0) / 100;

				var str = '';
				for (var i = 0;i < bestCount.trueList.length; i++) {
					if (bestCount.trueList[i] > 0) {
						str += '査定値' + bestCount.list[i][0]/100 + 'の特能:' + bestCount.trueList[i] + '個。<br>';
					}
				}

				str += '査定が予想通りの場合、表示査定は' + (Math.floor(bestCount.truePoint/1400)*14) + 'になります。(実査定:' + (bestCount.truePoint/100).toFixed(2) + ')<br>';
				str += '実査定の幅: x' + (type ? '<' : '>=') + ' ' + border.toFixed(2) + '<br>';

				$('#' + (type ? 'topArea' : 'bottomArea')).html(str);

				return border;
			},


			recallFunc: function(list, depth, useList, targetValue, dealType) {
				var newList = null;

				var point = bestCount.calcPoint(list, useList, targetValue);

				if (point < bestCount.truePoint && ((dealType === 0 && point % 1400 <= 78.4) || (dealType === 1 && point % 1400 > 1400 -78.4))) {
					bestCount.trueList = useList.concat();
					bestCount.truePoint = point;
				}

				if (depth >= list.length || point > bestCount.truePoint) {
					return;
				}

				for (var i = 0; i < list[depth][1]; i++) {
					newList = useList.concat();
					newList[depth] = i;
					bestCount.recallFunc(list, depth+1, newList, targetValue, dealType);
				}

			},

			calcPoint: function(list, useList, targetValue) {
				var sum = 1127 + targetValue;
				for (var i = 0; i < useList.length; i++) {
					if (useList[i] > 0) {
						sum += list[i][0] * useList[i];
					}
				}
				return sum;
			}
		};
	</script>
	<style>
		#displayArea {
			border: 2px dashed #ffd700;
			background-color: #fffacd;
			width: 95%;
			margin: auto;
		}
	</style>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>査定調査お助けくん</h2>
			</header>
			<section>
				<div>
					予想査定値=<input type="number" id="targetValue">
					<button onclick="bestCount.exec()">実行</button>
				</div>
				<div id="displayArea">
					<p>■下限値判定</p>
					<div id="bottomArea"></div>
					<p>------------------</p>
					<p>■上限値判定</p>
					<div id="topArea"></div>
					<p>------------------</p>
					<div id="rangeArea"></div>
				</div>
			</section>
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
