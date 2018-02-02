<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　パワプロクイズ一覧';
		$description = 'パワプロの4択クイズができます。また、クイズを作って他のユーザーに出題することもできます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/lib/simplePagination.css">
		<link rel="stylesheet" href="../css/quiz.css">
		<script type="text/javascript" src="../js/plugin/jquery.simplePagination.js"></script>
		<script src="../js/quizList.js"></script>

	</head>

	<body>
		<?php include('../php/header.php'); ?>
		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>パワプロクイズ一覧</h2>
			</header>

			<section>
				<ul id="quizList"></ul>
				<div class="pageDisplay"></div>
			</section>
		</main>
		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>
</html>


