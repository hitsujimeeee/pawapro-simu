<?php
require_once 'global.php';
require_once './userCommonModule.php';
require_once './lib/Parsedown.php';

$userId = isset($_GET['userId']) ? $_GET['userId'] : null;
$deckId = isset($_GET['deckId']) ? $_GET['deckId'] : null;
$rarelityList = ['', 'PSR', 'SR', 'PR', 'R', 'PN', 'N'];
$rarelityGraphList = ['SR', 'SR', 'SR', 'R', 'R', 'R', 'R'];
$reffrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
$targetTypeList = [];
$schoolList = [];
$dbh = DB::connect();
$sql = 'SELECT NAME FROM DECK_PLAYER_TYPE';
foreach ($dbh->query($sql) as $row) {
	$targetTypeList[] = $row['NAME'];
}


$sql = 'SELECT NAME FROM SCHOOL';
foreach ($dbh->query($sql) as $row) {
	$schoolList[] = $row['NAME'];
}

$hitReffrer = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . dirname($_SERVER['REQUEST_URI']) . '/deckList.php';
$editFlag = ($reffrer && $reffrer === $hitReffrer);

//0:不正
//1:新規作成
//2:編集
//3:閲覧
$mode = 0;

//リファラとURLパラメーターからモードを設定
if (!$editFlag) {
	//閲覧モード(ユーザーIDとデッキIDのみの連携)
	$mode = 3;
	$dbUserId = $userId;
} else if ($editFlag && ($userId === null && $deckId === null)) {
	//新規作成モード(ユーザー名とパスワードのみの連携)
	$mode = 1;
} else if ($editFlag && $userId && $deckId) {
	//更新モード(全情報連携)
	$mode = 2;
} else {
	//不正なアクセス
	echo 'このページは表示できません。';
	exit;
}

if($mode === 2 || $mode === 3) {
	require_once './logic/getDeck.php';
	$deckData = getDeck($userId, $deckId);
	if(!$deckData) {
		echo 'このページは表示できません。';
		exit;
	}
	$Parsedown = new Parsedown();
	$summary = $Parsedown->setMarkupEscaped(true)->setBreaksEnabled(true)->text($deckData['summary']);
	$totalBonusPoint = getTotalBonusPoint($deckData['lv'], $deckData['rare']);
	if ($mode === 3) {
		$deckEventDetail = getDeckEventDetail($dbh, array($deckData['chara'][0], $deckData['chara'][1], $deckData['chara'][2], $deckData['chara'][3], $deckData['chara'][4], $deckData['chara'][5]));
	}
} else {
	$summary = '';
}

function getBonusCount($lv, $rarelity) {
	$baseLevel = [40, 35, 25, 20, 15, 10];
	if ($lv == null || $rarelity == null){
		return '';
	}
	$dif = $lv - $baseLevel[$rarelity];
	if ($dif <= 0) {
		return '';
	}

	$c = (int)($dif / 2) + ($dif % 2);
	return '+' . $c;
}

function getTotalBonusPoint($lvList, $rareList) {
	$total = 0;
	$baseLevel = [40, 35, 25, 20, 15, 10];
	$perBase = [0.5, 0, 0, 0, 0, 0];
	$perMag = [0.1, 0.15, 0.1, 0.05, 0, 0];
	for ($i = 0; $i < 6; $i++) {
		$lv = $lvList[$i];
		$rare = $rareList[$i];

		if ($lv == null || $rare == null || (int)$rare === 0){
			continue;
		}
		$dif = $lv - $baseLevel[$rare-1];
		if ($dif <= 0) {
			continue;
		}

		$c = (int)($dif / 2);
		$total += $perBase[$rare-1] + $c * $perMag[$rare-1];
	}
	return $total;
}

function getDeckEventDetail($dbh, $charaList) {
	$trainingList = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	$eventTypeList = [[], []];
	foreach ($charaList as $c) {
		if($c === null) continue;
		$sql = '
			SELECT
				*
			FROM
				EVENT_CHARACTER
			WHERE
				ID = :id';
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('id', $c);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row['TRAINING_TYPE'] !== null) {
			$trainingType = $row['TRAINING_TYPE'];
			if(strlen($trainingType) > 1) {
				$split = str_split($trainingType);
				foreach ($split as $s) {
					$trainingList[(int)$s]++;
				}
			} else {
				$trainingList[(int)$trainingType]++;
			}

		}
		$eventTypeList[(int)$row['EVENT_TYPE']][] = $c;
	}
	return array(
		'trainingList'=>$trainingList,
		'eventTypeList'=>$eventTypeList
	);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ | デッキシェア';
	$description = 'パワプロアプリのデッキをシェアする機能です';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/deckCreator.css">
	<script src="https://cdn.jsdelivr.net/clipboard.js/1.6.0/clipboard.min.js"></script>
	<script src="../js/plugin/jquery.history.js"></script>
	<script src="../js/deckCreator.js?ver20180602"></script>
	<script>
		var savedCharaList = [
			<?php
			if (isset($deckData)) {
				$str = '';
				for ($i = 0; $i < count($deckData['chara']); $i++) {
					if ($deckData['chara'][$i] === null) {
						break;
					}
					$str .= '{id:\'' . $deckData['chara'][$i] . '\', lv:' . ($deckData['lv'][$i] ? $deckData['lv'][$i] : 'null') . ', rare:' . ($deckData['rare'][$i] ? $deckData['rare'][$i] : 'null') . '}, ';
				}
				$str = substr($str, 0, strlen($str)-2);
				echo $str;
			}
			?>
		];
		var savedMakedCharaList = [
			<?php
			$str = '';
			if(isset($deckData['makedChara'])) {
				foreach ($deckData['makedChara'] as $r) {
					if($r) {
						$str .= '\'' . $r . '\',';
					}
				}
				$str = substr($str, 0, strlen($str)-1);
			}
			echo $str;
			?>];
		var mode = <?= $mode ?>;

		function deleteDeck() {
			// 「OK」時の処理開始 ＋ 確認ダイアログの表示
			if(!$('#deckId').val()) {
				alert('このデッキは削除できません。');
				return;
			}

			if(window.confirm('デッキを削除します。よろしいですか？')){
				deckCreator.showBlockMessage('処理中……');

				$.ajax({
					type:'POST',
					url:'./logic/deleteDeck.php',
					data:{
						userName:$('#loginUserName').val(),
						password:$('#loginPassword').val(),
						deckId:$('#deckId').val()
					}
				}).done(function(res) {
					if(res.status === -1) {
						alert(res.msg);
						return;
					}
					window.location.replace('./deckList.php');
				}).fail(function(res) {
					res.msg = '<i class="fa fa-times" aria-hidden="true" style="color:#00ff00"></i>' + res.msg;
					$('.blockMsg').html(res.msg);
					$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
				});

			}

		}

	</script>
</head>

<body>

	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<?php if ($mode === 3) { ?>
			<h2><i class="fa fa-retweet" aria-hidden="true"></i>デッキシェア</h2>
			<?php } else if ($mode === 2) { ?>
			<h2><i class="fa fa-wrench" aria-hidden="true"></i>デッキ編集</h2>
			<?php } else { ?>
			<h2><i class="fa fa-wrench" aria-hidden="true"></i>デッキ作成</h2>
			<?php } ?>
		</header>
		<hr class="abHr" />

		<!-- デッキ名 -->
		<section>
			<?php if ($mode === 3) { ?>
			<header><h3><?= htmlspecialchars($deckData['name'])?></h3></header>
			<div class="viewDeckAttribute">
				<div class="viewDeckType">
					<span><?= htmlspecialchars($targetTypeList[$deckData['type']])?></span>
					<p class="arrow_box">対象とする育成選手のタイプです</p>
				</div>
				<div class="viewSchoolType">
					<span><?= htmlspecialchars($schoolList[$deckData['school']])?></span>
					<p class="arrow_box">対象とする高校です</p>
				</div>
				<div class="viewfavCount">
					<span><?= (int)$deckData['favCount'] > 0 ? '<i class="fa fa-heart" style="color:#ff6add"></i>' . htmlspecialchars($deckData['favCount']) : '' ?></span>
				</div>
<!--
				<?php if ($totalBonusPoint > 0) { ?>
				<div class="viewBonusPoint">
					<span>↑<?php //$totalBonusPoint ?>%</span>
					<p class="arrow_box">上限開放ボーナスの合計値です</p>
				</div>
				<?php } ?>
-->
			</div>
			<?php } else { ?>
			<header><i class="fa fa-book"></i>デッキ名(30文字まで)</header>
			<p><input type="text" id="deckName" data-form-name="デッキ名" maxlength="30" value="<?= htmlspecialchars(isset($deckData) ? $deckData['name'] : '')?>" required></p>
			<?php } ?>
			<input type="hidden" id="userId" value="<?= $userId ?>">
			<input type="hidden" id="deckId" value="<?= $deckId ?>">
		</section>

		<!-- イベキャラ選択 -->
		<section>
			<?php if ($mode === 3) { ?>
			<div class="evCharaContainer">
				<ul>
					<?php for ($i = 0; $i < count($deckData['chara']); $i++) {?>
					<li class="eveCharaImg">
						<div class="relative">
							<img class="eveIcon" onerror="this.src='../img/noface.jpg';" src="../img/eventChara/<?= $deckData['chara'][$i] ? $rarelityGraphList[$deckData['rare'][$i]] . '/' . $deckData['chara'][$i] . '.jpg?20180411' : 'noimage.jpg' ?>">
							<div class="lvText"><?= $deckData['lv'][$i] ? 'Lv' . $deckData['lv'][$i] : '' ?></div>
							<?php if ((int)$deckData['rare'][$i] === 1) {?>
							<img class="rarelityBadge" src="../img/icon/PSR_icon.png">
							<?php } else if ((int)$deckData['rare'][$i] === 3) {?>
							<img class="rarelityBadge" src="../img/icon/PR_icon.png">
							<?php } else if ((int)$deckData['rare'][$i] === 5) {?>
							<img class="rarelityBadge" src="../img/icon/PN_icon.png">
							<?php } else if ((int)$deckData['rare'][$i] === 6) {?>
							<img class="rarelityBadge" src="../img/icon/N_icon.png">
							<?php } ?>


							<?php //<div class="bonusText"><?= getBonusCount($deckData['lv'][$i], $deckData['rare'][$i]) </div>?>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>

			<!-- デッキの詳細 -->
			<div class="deackDetail">
				<div class="deckTraining">
					<?php for ($i = 0; $i < count($deckEventDetail['trainingList']); $i++) {?>
					<div class="trainingCell"><img class="summaryTrainingIcon<?= ($deckEventDetail['trainingList'][$i] > 0 ? ' nonOpacity' : '') ?>" src="../img/practice<?= $i ?>.jpg">
						<?php if ($deckEventDetail['trainingList'][$i] > 1) { ?>
						<div class="countNum">×<?= $deckEventDetail['trainingList'][$i] ?></div>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<div class="eventType">
					<div>
						<span>前<?= count($deckEventDetail['eventTypeList'][0]) ?></span>
						<?php if (count($deckEventDetail['eventTypeList'][0]) > 0) {?>
						<p class="arrow_box" style="width:<?= count($deckEventDetail['eventTypeList'][0]) * 10+10?>vw;max-width:400px">
							<?php foreach($deckEventDetail['eventTypeList'][0] as $row) { ?>
							<img class="evTypeTooltip" src="../img/eventChara/SR/<?= $row ?>.jpg?20180411">
							<?php } ?>
						</p>
						<?php } ?>
					</div>
					<div>
						<span>後<?= count($deckEventDetail['eventTypeList'][1]) ?></span>
						<?php if (count($deckEventDetail['eventTypeList'][1]) > 0) {?>
						<p class="arrow_box" style="width:<?= count($deckEventDetail['eventTypeList'][1]) * 10+10?>vw;max-width:400px">
							<?php foreach($deckEventDetail['eventTypeList'][1] as $row) { ?>
							<img class="evTypeTooltip" src="../img/eventChara/SR/<?= $row ?>.jpg?20180411">
							<?php } ?>
						</p>
						<?php } ?>
					</div>
				</div>
			</div>

			<?php } else { ?>
			<header><i class="fa fa-cube"></i>イベキャラ<button onclick="deckCreator.openRemodal();">編集</button></header>
			<div class="evCharaContainer">
				<ul class="contaner">
					<?php for ($i = 0; $i < 6; $i++) { ?>
					<li class="eveCharaImg">
						<div class="eveImageArea" onclick="deckCreator.deleteSelectedEveChara(<?= $i ?>)">
							<img onerror="this.src='../img/noface.jpg';" src="../img/eventChara/<?= isset($deckData) && $deckData['chara'][$i] ? $rarelityGraphList[$deckData['rare'][$i]] . '/' . $deckData['chara'][$i] . '.jpg?20180411' : 'noimage.jpg' ?>">
							<div class="trainingIcon"><img class="trainingIcon hiddenDisplay"></div>
						</div>
						<div>
							<input type="number" class="charaLv" min="1" max="50" placeholder="Lv" value="<?= isset($deckData) && $deckData['lv'][$i] ? $deckData['lv'][$i] : ''?>"<?= !isset($deckData) || !$deckData['chara'][$i] ? ' disabled=true' : '' ?> tabindex="<?= $i+1 ?>">
						</div>
						<div>
							<select class="rareRank"<?= !isset($deckData) || !$deckData['chara'][$i] ? ' disabled=true' : '' ?> tabindex="<?= $i+7 ?>" onclick="deckCreator.updateEveCharaList();">
								<?php for ($j = 0; $j < count($rarelityList); $j++) { ?>
								<option value="<?= $j ?>"<?= (isset($deckData) && $deckData['rare'][$i] == $j ? ' selected' : '') ?>><?= $rarelityList[$j] ?></option>
								<?php } ?>
							</select>
						</div>

					</li>
					<?php } ?>
				</ul>
			</div>



		<?php } ?>
		</section>


		<!-- 育成タイプ -->
		<?php if ($mode !== 3) { ?>
		<section>
			<header><i class="fa fa-cube"></i>育成タイプ</header>
			<p>
				<select id="charaType">
				<?php
					for($i = 0; $i < count($targetTypeList); $i++) {
					echo '<option value="' . $i . '"' . (isset($deckData) && $deckData['type'] == $i ? ' selected' : '') . '>' . $targetTypeList[$i] . '</option>';
					}
				?>
				</select>
			</p>
		</section>
		<?php } ?>

		<!-- 対象高校 -->
		<?php if ($mode !== 3) { ?>
		<section>
			<header><i class="fa fa-building-o"></i>対象高校</header>
			<p>
				<select id="school">
				<?php
					for($i = 0; $i < count($schoolList); $i++) {
					echo '<option value="' . $i . '"' . (isset($deckData) && $deckData['school'] == $i ? ' selected' : '') . '>' . $schoolList[$i] . '</option>';
					}
				?>
				</select>
			</p>
		</section>
		<?php } ?>

		<section>
			<header><i class="fa fa-pencil"></i>特徴・コンセプト</header>
			<?php if ($mode === 3) { ?>
			<div class="summary"><?= $summary ?></div>
			<?php } else { ?>
			<textarea type="text" class="summary" id="summary" data-form-name="特徴・コンセプト" maxlength="500"><?= htmlspecialchars(isset($deckData) ? $deckData['summary'] : '') ?></textarea>
			<p><span id="restTextCount">500</span>/500</p>
			<?php } ?>

		</section>

		<section>
			<header>
				<i class="fa fa-cube" aria-hidden="true"></i>作成選手一覧
				<?php if ($mode !== 3) { ?>
				<button onclick="deckCreator.openMakedCharaList()">編集</button>
				<?php } ?>
			</header>
			<section id="batterMakedDisplay" class="hiddenDisplay">
				<header><img class="iconGraph" src="../img/icon/bat.png">野手</header>
				<div class="table-responsive">
					<table id="batterDisplayTable" class="modern makedCharaTable">
						<tr>
							<th></th>
							<th>選手名</th>
							<th>守備位置</th>
							<th>弾道</th>
							<th>打</th>
							<th>力</th>
							<th>走</th>
							<th>肩</th>
							<th>守</th>
							<th>補</th>
							<th>査定</th>
							<th></th>
						</tr>
					</table>
				</div>
			</section>

			<section id="pitcherMakedDisplay" class="hiddenDisplay">
				<header><img class="iconGraph" src="../img/icon/ball.png">投手</header>
				<div class="table-responsive">
					<table id="pitcherDisplayTable" class="modern makedCharaTable">
						<tr>
							<th></th>
							<th>選手名</th>
							<th>守備位置</th>
							<th>球速</th>
							<th>コン</th>
							<th>スタ</th>
							<th>↑</th>
							<th>←</th>
							<th>↙</th>
							<th>↓</th>
							<th>↘</th>
							<th>→</th>
							<th></th>
						</tr>
					</table>
				</div>
			</section>
		</section>

		<section>
			<header><i class="fa fa-user"></i>作者情報</header>
			<table class="modern authorInfo">
				<tr>
					<th>作者名</th>
					<td>
						<?php if ($mode === 3) { ?>
						<?= htmlspecialchars($deckData['author']) ?>
						<?php } else { ?>
						<input type="text" id="author" data-form-name="作者名" maxlength="20" value="<?= htmlspecialchars(isset($deckData) ? $deckData['author'] : '') ?>">
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>パワプロID</th>
					<td>
						<?php if ($mode === 3) { ?>
						<?= htmlspecialchars($deckData['gameId']) ?>
						<?php } else { ?>
						<input type="text" id="gameId" data-form-name="パワプロID" maxlength="10" value="<?= htmlspecialchars(isset($deckData) ? $deckData['gameId'] : '') ?>">
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>TwitterID</th>
					<td>
						<?php if ($mode === 3) { ?>
						<a onclick="ga('send', 'event', 'link', 'click', 'deckTwitter');" href="https://twitter.com/<?= htmlspecialchars(trim($deckData['twitterId'])) ?>" target="_blank"><?= trim($deckData['twitterId']) !== '' ? '@' . htmlspecialchars(trim($deckData['twitterId'])) : '' ?></a>
						<?php } else { ?>
						<input type="text" id="twitterId" data-form-name="TwitterID" maxlength="15" value="<?= htmlspecialchars(isset($deckData) ? $deckData['twitterId'] : '') ?>">
						<?php } ?>
					</td>
				</tr>
			</table>
		</section>

		<!-- ユーザー情報欄 -->
		<section>
			<?php if ($mode === 3) { ?>
			<div>
				<button id="favButton" class="favButton" data-fav-status="0" onclick="deckCreator.setFavarite();">お気に入り</button>
			</div>
			<?php } else { ?>
			<div>
				<button onclick="deckCreator.save(0);">保存</button>
				<button onclick="deckCreator.save(1);">非公開で保存</button>
				<button onclick="deleteDeck();">削除</button>
			</div>
			<div>▼公開用URL:<button id="copyText" data-clipboard-target="#openURL">クリップボードにコピー</button></div>
			<div id="openURL" class="openURL"><?= $mode === 2 ? (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] : ''?></div>
			<?php } ?>
		</section>

	</main>

	<div class="remodal" data-remodal-id="eveCharaRemodal" id="eveCharaRemodal" data-remodal-options="hashTracking:false">
		<button data-remodal-action="confirm" class="remodal-close"></button>
		<div class="eveCharaListCond">
			<div>
				絞り込み：
				<select id="limitType" onChange="deckCreator.sortEveCharaList()">
					<option value="0">すべて</option>
					<option value="1">打者のみ</option>
					<option value="2">投手のみ</option>
					<option value="3">スタッフのみ</option>
					<option value="4">前イベのみ</option>
					<option value="5">後イベのみ</option>
				</select>
			</div>
			<div>
				並び順：
				<select id="sortOrderType" onChange="deckCreator.sortEveCharaList()">
					<option value="0">登録順</option>
					<option value="1">名前順</option>
					<option value="2">得意練習順</option>
				</select>
				<select id="sortOrderDir" onChange="deckCreator.sortEveCharaList()">
					<option value="0">昇順</option>
					<option value="1">降順</option>
				</select>
			</div>
		</div>
		<hr class="abHr" style="margin:1em 0;">
		<ul id="eveCharaList">
			<?php
			require_once "global.php";
			require_once "./logic/getEveCharaList.php";
			$dbh = DB::connect();
			$list = getEveCharaList($dbh);
			$count = count($list);
			$evTypeList = ['前イベ', '後イベ'];
			$evTypeClass = ['evBefore', 'evAfter'];
			for ($i = 0; $i < $count; $i++) {
				$item = $list[$i];
				$src = $item['trainingType'] !== null ? ' src="../img/practice' . $item['trainingType'] . '.jpg"' : '';
				$selectedClass = isset($deckData) && in_array($item['id'], $deckData['chara']) ? ' selectedItem' : ''; ?>
			<li class="eveCharaListItem" data-chara-id="<?= $item['id'] ?>" data-chara-name="<?= $item['name'] ?>" data-chara-read="<?= $item['yomi'] ?>" data-training-type="<?= $item['trainingType'] ?>" data-chara-type="<?= $item['charaType'] ?>" data-event-type="<?= $item['eventType'] ?>">
				<img class="evecharaIcon<?= $selectedClass ?>" src="../img/eventChara/SR/<?= $item['id'] ?>.jpg?20180411"><img class="trainingIcon"<?= $src ?>>
				<div class="nameArea"><?= $item['name'] ?></div>
				<div class="evTypeArea">
					<span class="<?= $evTypeClass[$item['eventType']] ?>"><?= $evTypeList[$item['eventType']] ?></span>
				</div>
			</li>
			<?php } ?>
		</ul>
		<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
	</div>

	<div class="remodal" data-remodal-id="makedCharaRemodal" id="makedCharaRemodal" data-remodal-options="hashTracking:false">
		<button data-remodal-action="close" class="remodal-close"></button>
		<section id="batterSection">
			<header><img class="iconGraph" src="../img/icon/bat.png">野手</header>
			<div class="table-responsive">
				<table id="batterTable" class="modern makedCharaTable">
					<tr>
						<th></th>
						<th>選手名</th>
						<th>守備位置</th>
						<th>弾道</th>
						<th>打</th>
						<th>力</th>
						<th>走</th>
						<th>肩</th>
						<th>守</th>
						<th>補</th>
						<th>査定</th>
						<th></th>
					</tr>
				</table>
			</div>
		</section>

		<section id="pitcherSection">
			<header><img class="iconGraph" src="../img/icon/ball.png">投手</header>
			<div class="table-responsive">
				<table id="pitcherTable" class="modern makedCharaTable">
					<tr>
						<th></th>
						<th>選手名</th>
						<th>守備位置</th>
						<th>球速</th>
						<th>コン</th>
						<th>スタ</th>
						<th>↑</th>
						<th>←</th>
						<th>↙</th>
						<th>↓</th>
						<th>↘</th>
						<th>→</th>
						<th></th>
					</tr>
				</table>
			</div>
		</section>
		<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
	</div>


	<?php include('./optionMenu.php'); ?>

	<?php include('../html/footer.html'); ?>

</body>

</html>
