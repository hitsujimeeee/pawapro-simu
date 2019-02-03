<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　実査定表ジェネレーター';
		$description = '実査定表を自動で生成します';
		require_once './headInclude.php';
		?>
	</head>
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
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
