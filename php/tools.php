<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　その他のツール';
		$description = 'パワプロアプリ育成シミュレーター作者が作った細々したツールを置いています。';
		require_once './headInclude.php';
		?>
	</head>
	<style>
		p.item {
			margin-left: 1em;
		}

		section.mainSection {
			margin-top: 1em;
		}
	</style>
	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-wrench" aria-hidden="true"></i>その他ツール</h2>
			</header>
			<section class="mainSection">
				<p class="item">・<a href="../data/vampGauge.zip">ヴァンプ高校 ブラッドゲージ管理ツール(※zipファイル)</a></p>
				<p class="item">・<a href="./hirameki.php">ひらめきシミュレーター</a></p>
				<p class="item">・<a href="./blankCountSimulate.php">査定調査お助けくん</a></p>
			</section>

		<?php include('./adsense/responsive.php') ?>
		
		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
