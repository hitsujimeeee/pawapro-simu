<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　パワプロクイズ';
		$description = 'パワプロの4択クイズができます。また、クイズを作って他のユーザーに出題することもできます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/quiz.css?ver20170917">
		<script src="../js/quiz.js?ver20170917"></script>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>パワプロクイズ</h2>
			</header>
			<section>
				<div class="contentContainer">
					<div id="contentsArea" class="contentsArea"></div>
					<div id="contentsDetail" class="contentsDetail"></div>
				</div>
				<div id="optionArea"></div>

				<div class="hiddenDisplay commentArea">
					<div id="ansResult"></div>
					<div id="commentText"></div>
					<div class="voteArea">
						<button onclick="quiz.vote(1)"><i class="fa fa-thumbs-o-up"></i>GOOD</button>
						<button onclick="quiz.vote(0)"><i class="fa fa-thumbs-o-down"></i>BAD</button>
					</div>
					<div class="voteResult"></div>
				</div>

				<div class="nextButtonArea">
					<button class="nextButton" style="visibility:hidden;" onclick="quiz.next();">次へ</button>
					<span id="restQuizCounter"></span>
				</div>

				<?php include('./adsense/responsive.php') ?>

			</section>
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
