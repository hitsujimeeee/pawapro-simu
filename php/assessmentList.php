<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　実査定表ジェネレーター';
		$description = '実査定表を自動で生成します';
		require_once './headInclude.php';
		?>
	</head>
	<script>
		function exec(t) {
			$.get({
				url:'./logic/outputAssessmentList.php?type=' + t,
			}).done(function(res){
				console.log(res);
			});
		}

		function execBase(t) {
			$.get({
				url:'./logic/outputBaseAssessmentList.php?type=' + t,
			}).done(function(res){
				console.log(res);
			});
		}

		function screenShot() {
			var canvas = document.getElementById("canvas");
			var ctx = canvas.getContext("2d");

			$('#assList').css('display', 'table');

			var width = $('#assList').width();
			var height = $('#mytable').height() + 6;
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);


			var data = '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '">' +
				'<style>' +
				'#assList {' +
				'	border-collapse: collapse;' +
				'	border: 1px solid #000;' +
				'	background-color: #fff;' +
				'	display: none;' +
				'	visibility: visible;' +
				'	font-size: 16px;' +
				'}' +

				'#assList th, #assList td {' +
				'	height: 25px;' +
				'	min-height: 25px;' +
				'	min-width: 60px;' +
				'	padding: 0px;' +
				'	border-right: 1px solid #000;' +
				'}' +

				'#assList th {' +
				'	border: 1px solid #000;' +
				'	text-align: center;' +
				'}' +

				'#assList tr td:nth-child(n+3) {' +
				'	text-align: right;' +
				'}' +

				'#assList tr:nth-child(even) {' +
				'	background-color: #E3ECF5;' +
				'}' +

				'#assList tr:nth-child(odd){' +
				'	background-color: #BDD7EE;' +
				'}' +

				'#assList tr:nth-child(-n+3) {' +
				'	background-color: #6fa7ff;' +
				'}' +
				'</style>' +
				'<foreignObject width="100%" height="100%">' + $('#mytable').html() +
				'</foreignObject>' +
				'</svg>';

			$('#assList').css('display', 'none');
			canvg("canvas", data);

			var DOMURL = self.URL || self.webkitURL || self;
			var img = new Image();
			var svg = new Blob([data], {
				type: "image/svg+xml;charset=utf-8"
			});

			var url = DOMURL.createObjectURL(svg);
			img.onload = function(){
//				ctx.drawImage(img, 0, 0);
//				img.crossOrigin = 'anonymous';

				DOMURL.revokeObjectURL(url);
			}
			img.src = url;

		}
//
//		function outputCanvas() {
//			var img = document.getElementById("canvas").toDataURL();
//			$('#targetImg').attr('src', img);
//			$('#canvas').css('display', 'none');
//
//		}
	</script>

	<style>
		#assList {
			border-collapse: collapse;
			border: 1px solid #000;
			background-color: #fff;
			display: none;
			visibility: visible;
			font-size: 16px;
		}

		#assList th, #assList td {
			height: 25px;
			min-height: 25px;
			min-width: 60px;
			padding: 0px;
			border-right: 1px solid #000;
		}

		#assList th {
			text-align: center;
			border: 1px solid #000;
		}

		#assList tr td:nth-child(n+3) {
			text-align: right;
		}

		#assList tr:nth-child(even) {
			background-color: #E3ECF5;
		}

		#assList tr:nth-child(odd){
			background-color: #BDD7EE;
		}

		#assList tr:nth-child(-n+3) {
			background-color: #6fa7ff;
		}

	</style>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<form action="./logic/outputAssessmentList.php" method="get">
				<button>野手特能表出力</button>
				<input type="hidden" name="type" value="0">
				<input type="hidden" name="spFlag" value="0">
			</form>

			<form action="./logic/outputAssessmentList.php" method="get">
				<button>野手金特表出力</button>
				<input type="hidden" name="type" value="0">
				<input type="hidden" name="spFlag" value="1">
			</form>

			<form action="./logic/outputAssessmentList.php" method="get">
				<button>投手特能表出力</button>
				<input type="hidden" name="type" value="1">
				<input type="hidden" name="spFlag" value="0">
			</form>

			<form action="./logic/outputAssessmentList.php" method="get">
				<button>投手金特表出力</button>
				<input type="hidden" name="type" value="1">
				<input type="hidden" name="spFlag" value="1">
			</form>

			<form action="./logic/outputBaseAssessmentList.php" method="get">
				<button>野手基礎査定表出力</button>
				<input type="hidden" name="type" value="0">
			</form>

			<div id="mytable">
				<div xmlns="http://www.w3.org/1999/xhtml" style="font-size:16px;">
					<table id="assList">
						<tr>
							<th class="listHeader" colspan="11" style="text-align:left;font-size:28px;height:40px;">ヘッダ</th>
						</tr>
						<tr>
							<th rowspan="2">ランク</th>
							<th rowspan="2" style="width:12em;">能力名</th>
							<th style="width:6em;">必要経験点</th>
							<th rowspan="2" style="width:5em;">実査定値</th>
							<th rowspan="2">単独</th>
							<th colspan="6">査定効率(単独)</th>
						</tr>
						<tr>
							<th>コツ0</th>
							<th>0</th>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
						</tr>
					</table>
				</div>


			</div>

			<div>
				<button onclick="screenShot()">スクショ</button>
			</div>
			<canvas id="canvas" width="0" height="0"></canvas>
			<div>
				<img id="targetImg">
			</div>
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
