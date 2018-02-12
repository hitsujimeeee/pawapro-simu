<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　査定表';
		$description = 'パワプロの査定表です。新しい特能が追加されるたび更新していきます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/sateiList.css?">
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-clipboard" aria-hidden="true"></i>査定表</h2>
			</header>
			<section>
				<header>
					■野手基本能力査定表
				</header>
				<div>
					<a href="../img/satei/sateiBatterBase.png">
						<img class="sateiImg" src="../img/satei/sateiBatterBase.png?<?= filemtime ('../img/satei/sateiBatterBase.png'); ?>" alt="野手基礎能力査定表">
					</a>
				</div>
			</section>

			<section>
				<header>
					■野手特殊能力査定表
				</header>
				<div>
					<a href="../img/satei/sateiBatter.png">
						<img class="sateiImg" src="../img/satei/sateiBatter.png?<?= filemtime ('../img/satei/sateiBatter.png'); ?>" alt="野手特殊能力査定表">
					</a>
				</div>
			</section>

			<section>
				<header>
					■野手金特査定表
				</header>
				<div>
					<a href="../img/satei/sateiBatterS.png">
						<img class="sateiImg" src="../img/satei/sateiBatterS.png?<?= filemtime ('../img/satei/sateiBatterS.png'); ?>" alt="野手金特査定表">
					</a>
				</div>
			</section>

			<section>
				<header>
					■投手特殊能力査定表
				</header>
				<div>
					<a href="../img/satei/sateiPitcher.png">
						<img class="sateiImg" src="../img/satei/sateiPitcher.png?<?= filemtime ('../img/satei/sateiPitcher.png'); ?>" alt="投手特殊能力査定表">
					</a>
				</div>
			</section>

			<section>
				<header>
					■投手金特査定表
				</header>
				<div>
					<a href="../img/satei/sateiPitcherS.png">
						<img class="sateiImg" src="../img/satei/sateiPitcherS.png?<?= filemtime ('../img/satei/sateiPitcherS.png'); ?>" alt="投手金特査定表">
					</a>
				</div>
			</section>

		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
