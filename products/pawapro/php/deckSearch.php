<?php
require_once 'global.php';
$dbh = DB::connect();
$sql = 'SELECT * FROM DECK_PLAYER_TYPE ORDER BY ID';
$targetTypeList = [];
foreach ($dbh->query($sql) as $row) {
	$targetTypeList[] = $row['NAME'];
}

$sql = 'SELECT * FROM SCHOOL ORDER BY ID';
$schoolList = [];
foreach ($dbh->query($sql) as $row) {
	$schoolList[] = $row['NAME'];
}

$sql = 'SELECT ID, NAME FROM EVENT_CHARACTER ORDER BY ID';
$evChara = [];
foreach ($dbh->query($sql) as $row) {
	$evChara[] = array(
		'id'=>$row['ID'],
		'name'=>$row['NAME']
	);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ | デッキ検索';
	$description = 'パワプロアプリのデッキ共有機能です。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/deckSearch.css">
	<script src="../js/deckSearch.js"></script>
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2><i class="fa fa-search"></i>デッキ検索</h2>
		</header>

		<section>
			<div class="acordionHeader" data-toggle="collapse" data-target="#searchCond">
				<header>検索条件<i class="fa closeIcon" aria-hidden="true"></i></header>
			</div>
			<div id="searchCond" class="collapse in">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>デッキ名：<input type="text" id="deckName"></p>
						<p>
							育成タイプ：
							<select id="targetType">
								<?php foreach($targetTypeList as $key=>$val) {?>
								<option value="<?= $key ?>"><?= $val ?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							育成高校：
							<select id="school">
								<?php foreach($schoolList as $key=>$val) {?>
								<option value="<?= $key ?>"><?= $val ?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							イベキャラ
							<select id="evChara">
								<option value=""></option>
								<?php foreach($evChara as $row) {?>
								<option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
								<?php } ?>
							</select>
						</p>
						<p>作者名：<input type="text" id="authorName"></p>
						<p>twitter：<input type="text" id="twitterId"></p>
						<p><input type="checkbox" id="favOnly">お気に入りのみ</p>

						<p>
							並び順
							<select id="sortOrder">
								<option value="0">作成日順</option>
								<option value="1">最終更新日順</option>
								<option value="2">お気に入り数順</option>
							</select>
							<select id="sortDir">
								<option value="0">降順</option>
								<option value="1">昇順</option>
							</select>
						</p>
						<hr class="abHr" />

						<button onclick="deckSearch.search();">検索</button>
						<button onclick="deckSearch.reset();">リセット</button>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="deckArea" id="deckArea">
				<div class="newInfo">新着デッキ</div>
				<ul id="deckList"></ul>
				<div class="pageDisplay" style="display:none;">
					<div><a onclick="deckSearch.sendPage(-1);return false;" class="scrollButton">＜＜</a></div>
					<div><span id="pageNum"></span>/<span id="totalPageNum"></span></div>
					<div><a onclick="deckSearch.sendPage(1);return false;" class="scrollButton">＞＞</a></div>
				</div>
				<div class="noResult hiddenDisplay">検索条件に該当するデッキは存在しません。</div>
			</div>
		</section>

		<?php include('./optionMenu.php'); ?>

	</main>
	<?php include('../html/footer.html'); ?>

</body>

</html>
