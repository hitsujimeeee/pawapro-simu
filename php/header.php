<!-- ヘッダー -->
<?php
$urlPadding = './';
if(basename(realpath("./")) === 'php') {
	$urlPadding = '../';
}
?>
<header>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo $urlPadding; ?>">パワプロアプリ育成シミュレーター</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_target">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="nav_target">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a data-toggle="dropdown" href="javascript:return 0;">育成シミュ▼</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $urlPadding; ?>php/batter.php">野手シミュ</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/pitcher.php">投手シミュ</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/assessment.php">査定計算機</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/characters.php">作成選手一覧</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/sateiList.php">査定表</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $urlPadding; ?>php/moneyCalc.php">課金額シミュ</a></li>
					<li><a href="<?php echo $urlPadding; ?>php/limitOpen.php">上限開放予報</a></li>
					<li><a href="<?php echo $urlPadding; ?>php/quizHome.php">パワプロクイズ</a></li>
					<li class="dropdown">
						<a data-toggle="dropdown" href="javascript:return 0;">デッキシェア▼</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $urlPadding; ?>php/deckList.php">デッキ編集</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/deckSearch.php">デッキ検索</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a data-toggle="dropdown" href="javascript:return 0;">その他▼</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $urlPadding; ?>php/about.php">このサイトについて</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/manual.php">使い方</a></li>
							<li><a href="<?php echo $urlPadding; ?>php/data.php">データ一覧</a></li>
							<li><a onclick="ga('send', 'event', 'link', 'click', 'board');" href="http://jbbs.shitaraba.net/game/58946/" target="_blank">掲示板</a></li>
							<li><a onclick="ga('send', 'event', 'link', 'click', 'blog');" href="http://studiowool.hatenablog.com/" target="_blank">Blog</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
