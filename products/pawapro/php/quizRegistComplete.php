<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　パワプロクイズ';
		$description = 'パワプロの4択クイズができます。また、クイズを作って他のユーザーに出題することもできます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/quiz.css">
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>パワプロクイズ</h2>
			</header>
			<section>
				<p>登録が完了しました。</p>
				<p><a class="button tryButton" href="./quizHome.php">戻る</a></p>
			</section>
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
