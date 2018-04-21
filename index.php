<!DOCTYPE html>
<html lang="ja">
<head>
	<?php
	$title = 'パワプロアプリ育成シミュレーター';
	$description = 'パワプロアプリの育成シミュレーターです。査定最大化、経験点計算、査定計算、課金額予想、上限開放予想などを行うツールを置いてます。';
	require_once './php/headInclude.php';
	?>
	<link rel="stylesheet" href="./css/lib/swiper.min.css"/>
	<link rel="stylesheet" href="./css/index.css?ver20170917">
	<script src="./js/plugin/swiper.jquery.min.js"></script>
	<script src="./js/index.js?ver20180226"></script>
</head>
<body>
	<?php include('./php/header.php'); ?>

	<main>
		<header><h1 class="siteTitle">パワプロアプリ育成シミュレーター</h1></header>
		<section>
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide slideBoard slideBatter">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>野手シミュレーター</header>
								<div class="slideSummary">
									野手能力の取得に必要な経験点の計算ができます。<br>
									残った経験点から査定が最大になるように振り分けをしてくれる<span style="color:#f00;">査定最大化機能</span>あり。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/batter.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide slideBoard slidePitcher">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>投手シミュレーター</header>
								<div class="slideSummary">
									投手能力の取得に必要な経験点の計算ができます。<br>
									残った経験点から査定が最大になるように振り分けをしてくれる<span style="color:#f00;">査定最大化機能</span>あり。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/pitcher.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide slideBoard slideCalcAssessment">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>査定計算機</header>
								<div class="slideSummary">
									選手能力を入力すると査定値を計算してくれます。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/assessment.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide slideBoard slideCalcMoney">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>課金額シミュレーター</header>
								<div class="slideSummary">
									ガチャで目標の選手をSR45(またはPSR50)にするのに幾ら掛かるかを計算します。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/moneyCalc.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide slideBoard slideLimitOpen">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>上限開放予報士くん</header>
								<div class="slideSummary">
									手持ちの素材でどれくらい上限開放出来るかを予想します。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/limitOpen.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide slideBoard slideDeckShare">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>デッキシェア</header>
								<div class="slideSummary">
									貴方の考えたデッキを他の人に共有してみたり、他の人の考えたデッキを見てみたりできます。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/deckShare.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide slideBoard slideQuiz">
						<div class="slideAlpha">
							<div class="slideContents">
								<header>パワプロクイズ</header>
								<div class="slideSummary">
									パワプロの知識を磨いて目指せパワプロ博士！<br>
									自分でクイズを作って、他の人に出題する事もできます。
								</div>
								<div class="slideLinkArea">
									<a class="btn btn-warning" href="./php/quizHome.php">CLICK<i class="fa fa-hand-o-left"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>

		</section>

		<section>

			<div class="categoryTitle">育成シミュレーター</div>
			<div class="otherMenu">
				<ul>
					<li>
						<div class="menuIcon"><a href="./php/batter.php"><img src="./img/menu001.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/batter.php">野手シミュレーター</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/pitcher.php"><img src="./img/menu002.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/pitcher.php">投手シミュレーター</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/assessment.php"><img src="./img/menu003.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/assessment.php">査定計算機</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/characters.php"><i class="fa fa-user" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/characters.php">作成選手一覧</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/sateiList.php"><i class="fa fa-clipboard" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/sateiList.php">査定表</a></div>
					</li>
				</ul>
			</div>

			<?php include('./php/adsense/responsive.php') ?>

			<div class="categoryTitle">便利ツール</div>
			<div class="otherMenu">
				<ul>

					<li>
						<div class="menuIcon"><a href="./php/moneyCalc.php"><img src="./img/menu005.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/moneyCalc.php">課金額シミュレーター</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/limitOpen.php"><img src="./img/menu006.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/limitOpen.php">上限開放予報士くん</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/deckShare.php"><img src="./img/menu007.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/deckShare.php">デッキシェア</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/quizHome.php"><img src="./img/menu008.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/quizHome.php">パワプロクイズ</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/hirameki.php"><img src="./img/menu009.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/hirameki.php">ひらめきシミュレーター</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/scoreBonus.php"><img src="./img/menu014.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/scoreBonus.php">スコアボーナスチェッカー</a></div>
					</li>
                    <li>
                        <div class="menuIcon"><a href="./php/entakuLevel.php"><i class="fa fa-trophy fa-fw" aria-hidden="true"></i></a></div>
                        <div class="menuTitle"><a href="./php/entakuLevel.php">円卓高校練習レベル計算機</a></div>
                    </li>
					<li>
						<div class="menuIcon"><a href="./php/epicMemo.php"><i class="fa fa-sticky-note fa-fw" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/epicMemo.php">円卓エピックメモ</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/zeniTrade.php"><i class="fa fa-yen fa-fw" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/zeniTrade.php">銭ペナアイテム交換計算機</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/tools.php"><i class="fa fa-wrench fa-fw" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/tools.php">その他ツール</a></div>
					</li>
				</ul>
			</div>

			<?php include('./php/adsense/responsive.php') ?>

			<div class="categoryTitle">その他</div>
			<div class="otherMenu">
				<ul>
					<li>
						<div class="menuIcon"><a href="./php/about.php"><i class="fa fa-home fa-fw" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/about.php">このサイトについて</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/manual.php"><img src="./img/menu011.png" class="mainImage"></a></div>
						<div class="menuTitle"><a href="./php/manual.php">使い方</a></div>
					</li>
					<li>
						<div class="menuIcon"><a href="./php/data.php"><i class="fa fa-folder-open-o fa-fw" aria-hidden="true"></i></a></div>
						<div class="menuTitle"><a href="./php/data.php">データ一覧</a></div>
					</li>
					<li>
						<div class="menuIcon"><a onclick="ga('send', 'event', 'link', 'click', 'board');" href="http://jbbs.shitaraba.net/game/58946/" target="_blank"><i class="fa fa-comments"></i></a></div>
						<div class="menuTitle"><a onclick="ga('send', 'event', 'link', 'click', 'board');" href="http://jbbs.shitaraba.net/game/58946/" target="_blank">不具合報告・要望投稿掲示板</a></div>
					</li>
					<li>
						<div class="menuIcon"><a onclick="ga('send', 'event', 'link', 'click', 'blog');" href="http://studiowool.hatenablog.com/" target="_blank"><img src="./img/menu015.png" class="mainImage"></a></div>
						<div class="menuTitle"><a onclick="ga('send', 'event', 'link', 'click', 'blog');" href="http://studiowool.hatenablog.com/" target="_blank">Blog</a></div>
					</li>
				</ul>
			</div>
		</section>

		<section>

			<div class="histories">
				<div class="historiesHeader">
					<i class="fa fa-info-circle" aria-hidden="true"></i>更新情報
				</div>
				<div class="historiesRecord">

					<dl class="historyList">
						<?php
						require './php/getHistories.php';
						$data = getHistories();
						$preDate = null;
						foreach ($data as $d) {
							$newClass = '';
							if(!$preDate || ((strtotime(date("Y/m/d")) - strtotime($d['date']))/ (60 * 60 * 24) <= 7 && $preDate == $d['date'])) {
								$newClass = 'newItem';
							}
							echo '<dt>' . date('Y年m月d日', strtotime($d['date'])) . '</dt>';
							echo '<dd class="' . $newClass . '">'. $d['description'] . '</dd>';
							if(!$preDate) {
								$preDate = $d['date'];
							}
						}
						?>
					</dl>
				</div>
			</div>
		</section>

	</main>
	<?php include('./html/footer.html'); ?>
</body>

</html>
