<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　パワプロクイズ';
		$description = 'パワプロの4択クイズができます。また、クイズを作って他のユーザーに出題することもできます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/quiz.css?ver20170917">
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>パワプロクイズ</h2>
			</header>
			<section>
				<p><a class="button tryButton" href="./quizMain.php">挑戦する</a></p>
				<p><a class="button makeButton" href="./quizMake.php">問題を作る</a></p>
				<p><a class="button listButton" href="./quizList.php">問題一覧</a></p>
			</section>

			<?php include('./adsense/responsive.php') ?>

		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
