<!DOCTYPE html>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ　デッキシェア';
	$description = 'パワプロアプリのデッキを他のユーザーに公開したり、他のユーザーのデッキを見たりできます。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/deckShare.css">
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2><i class="fa fa-retweet" aria-hidden="true"></i>デッキシェア</h2>
		</header>
		<section class="menuContainer">
			<div class="linkBoxWrapper" id="deckSearch">
				<a href="./deckSearch.php">
					<div class="linkBox">
						<div class="linkText">探す</div>
					</div>
				</a>
			</div>
			<div class="linkBoxWrapper" id="deckList">
				<a href="./deckList.php">
					<div class="linkBox">
						<div class="linkText">作る</div>
					</div>
				</a>
			</div>
		</section>
	</main>

	<?php include('./optionMenu.php'); ?>

	<?php include('../html/footer.html'); ?>
</body>

</html>
