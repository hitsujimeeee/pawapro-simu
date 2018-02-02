<!DOCTYPE html>
<?php
require_once 'global.php';
$dbh = DB::connect();
?>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ育成シミュレーター | このサイトについて';
	$description = 'パワプロアプリの育成シミュレーターです。このページではこのサイトに関する情報を掲載しています。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/about.css">

</head>

<body>
	<?php include('../php/header.php'); ?>
	<main>
		<header class="pageHeader">
			<h2><i class="fa fa-home"></i>このサイトについて</h2>
		</header>
		<section>
			<p class="secHeader"><i class="fa fa-window-maximize"></i>ページ紹介</p>
			<hr class="abHr">
			<section class="despBox">
				<header>
					<p><a href="./batter.php"><img class="iconGraph" src="../img/icon/bat.png">野手シミュレーター</a></p>
					<p><a href="./pitcher.php"><img class="iconGraph" src="../img/icon/ball.png">投手シミュレーター</a></p>
				</header>
				<article>
					目標能力までに必要な経験点を計算できます。使い方は<a href="./manual.php">使い方ページ</a>をご参考ください。<br>
					野手シミュレーターでは<strong>実査定値、選手ランク</strong>の計算も可能で、残った経験点から最大の査定になるように計算する<strong>査定最大化機能</strong>もあります。<br>
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./deckShare.php"><i class="fa fa-retweet"></i>デッキシェア</a></p>
				</header>
				<article>
					自分の考えたデッキを他の人に共有したり、他の人の考えたデッキを見たりできます。<br>
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./moneyCalc.php"><i class="fa fa-jpy"></i>課金額シミュレーター</a></p>
				</header>
				<article>
					期間限定ガチャでお目当てキャラをPSR50(SR45)にするのに幾らかかるかをシミュレートします。<br>
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./limitOpen.php"><i class="fa fa-jpy"></i>上限開放予報士くん</a></p>
				</header>
				<article>
					手持ちの合成素材でSR,PSRキャラをどれくらい上限開放できるかを計算します。<br>
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./assessment.php"><i class="fa fa-calculator"></i>査定計算機</a></p>
				</header>
				<article>
					野手のステータスから実査定値、選手ランクを計算するツールです。<br>
					野手シミュレーターから余計な機能を取り除き、査定値計算に特化させています。
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./characters.php"><i class="fa fa-user"></i>作成選手一覧</a></p>
				</header>
				<article>
					野手シミュレーター、投手シミュレーターで作成し、保存した選手の一覧を閲覧できます。<br>
					選手の保存方法は<a href="./manual.php#saveSection">使い方ページ</a>をご参考ください。<br>
					過去に作成した選手情報を、このページから編集することもできます。
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./hirameki.php"><i class="fa fa-lightbulb-o"></i>ひらめきシミュレーター</a></p>
				</header>
				<article>
					ブレインマッスル高校のひらめき特訓の確率計算シミュレーターです。<br>
					デッキのキャラクター情報、ロック中情報などを入力し、疑似的にブレインシャッフルを行えます。
				</article>
			</section>

			<section id="contact" class="despBox">
				<header>
					<p><a href="./manual.php"><i class="fa fa-book"></i>使い方</a></p>
				</header>
				<article>
					このサイトの使い方をまとめています。<br>
				</article>
			</section>

			<section class="despBox">
				<header>
					<p><a href="./data.php"><i class="fa fa-folder-open-o"></i>データ一覧</a></p>
				</header>
				<article>
					このサイトで使用している各種能力の経験点、査定値をまとめています。<br>
				</article>
			</section>

		</section>
		<section>
			<p class="secHeader"><i class="fa fa-paper-plane"></i>連絡先</p>
			<hr class="abHr">
			<div class="contactArticle">
				不具合報告・要望投稿掲示板: <a onclick="ga('send', 'event', 'link', 'click', 'board');" href="http://jbbs.shitaraba.net/game/58946/" target="_blank">掲示板</a><br>
				Twitter: <a onclick="ga('send', 'event', 'link', 'click', 'twitter.com/hitsujiPawapro');" href="https://twitter.com/hitsujiPawapro" target="_blank">@hitsujiPawapro</a><br>
			</div>
			<div class="contactMessage">
				不具合、計算結果の間違い、または要望などございましたら上記連絡先までご報告ください。
			</div>
		</section>

		<section>
			<p class="secHeader"><i class="fa fa-link"></i>リンク</p>
			<hr class="abHr">
			<div class="contactArticle">
				<dl class="linkList">
					<dt><a onclick="ga('send', 'event', 'link', 'click', 'blog');" href="http://studiowool.hatenablog.com/" target="_blank">パワプロ情報学入門</a>(管理人)</dt>
					<dd>パワプロ関連のちょっと気になる確率の話、計算による効率化の話などを徒然と書いてます。</dd>
					<dt><a onclick="ga('send', 'event', 'link', 'click', 'mspwpr2.wixsite.com/mspwpr');" href="http://mspwpr2.wixsite.com/mspwpr" target="_blank">細かすぎて伝わらない 査定理論 (とその他いろいろ) の部屋</a>(ms@査定算出ツール公開中さん<a onclick="ga('send', 'event', 'link', 'click', 'twitter.com/mspwpr');" href="https://twitter.com/mspwpr" target="_blank">@mspwpr</a>)</dt>
					<dd>査定理論を細かく解説しています。当サイトの査定計算にはこちらの計算式を使わせていただいています。</dd>
                    <dt><a onclick="ga('send', 'event', 'link', 'click', 'lemonedpawapro.online/');" href="http://livedoor-blog.lemonedpawapro.online/" target="_blank">レモネード＠パワプロアプリblog</a>(レモネードさん<a onclick="ga('send', 'event', 'link', 'click', 'twitter.com/mspwpr');" href="https://twitter.com/lemonedpawapro" target="_blank">@lemonedpawapro</a>)</dt>
                    <dd>円卓サクセスに関しての考察や立ち回り・データ等が公開されています。エンタクルスを効率よく回したい方必見です。</dd>
                </dl>
			</div>
		</section>
	</main>

	<?php include('../html/footer.html'); ?>
</body>

</html>
