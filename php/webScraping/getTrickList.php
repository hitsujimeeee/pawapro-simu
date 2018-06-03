<?php
require_once("../global.php");
require_once("../lib/phpQuery-onefile.php");

$allFlag = isset($_POST['allFlag']) ? (int)$_POST['allFlag'] : 1;
$trickFrom = isset($_POST['trickFrom']) ? (int)$_POST['trickFrom'] : 0;
$trickTo = isset($_POST['trickTo']) ? (int)$_POST['trickTo'] : 0;

$charaList = getCharaDataList();
$abilityList = getAbilityDataList();

//設定値
$limitCount = $allFlag ? 300 : $trickTo - $trickFrom;	//処理イベキャラ数上限
$skipCount = $allFlag ? 0 : $trickFrom -1;	//最初のnキャラ数分スキップ

$count = 0;
$doCount = 0;
mb_regex_encoding("UTF-8");

$fp = fopen("./itemList.csv", "w");
fputcsv($fp, ['CHARA_ID', 'GET_TYPE', 'ABILITY_ID']);


echo(str_pad(" ",4096). '<br>');
ob_end_flush();
ob_start('mb_output_handler');

//個別ページのURLごとに処理
foreach ($charaList as $chara){
	if($count < $skipCount) {
		$count++;
		continue;
	}

	$rand = getRandomInt(3000, 5000) / 1000;
	sleep($rand);

    $url = 'https://xn--odkm0eg.gamewith.jp/article/show/' . $chara['GAMEWITH_URL'];
	$doc = getDOMDocument($url);

	$list = searchDOM($doc['.matome'], $chara['ID'], $chara['NAME'], $abilityList);

	foreach ($list as $l) {
		fputcsv($fp, $l);
	}

	$count++;

	echo($chara['NAME'] . ': ' . $url . '<br>');

	ob_flush();
	flush();

	$doCount++;
	if ($doCount >= $limitCount){
		break;
	}
}

fclose($fp);

//phpQueryを使ってページのDOMツリーを取得
function getDOMDocument($url) {
	$html = file_get_contents($url);
	return phpQuery::newDocument($html);
}

function searchDOM($parent, $id, $name, $abilityList) {
	$trickType = '';
	$list = [];
	foreach(pq($parent)->find('tr') as $r) {

		if (pq($r)->find('> *:contains(で入手できるコツ)')->text()) {
			$text = pq($r)->find('> *:contains(で入手できるコツ)')->text();
			preg_match('/(.+)で入手できるコツ/', pq($r)->text(), $tempArray);
			$trickType = trim($tempArray[1]);
			$trickType = getTrickTypeID($trickType);
		} else {
			foreach(pq($r)->find('td') as $td) {
				if(pq($td)->html() && pq($td)->html() !== '-') {
					$abilityID = getAbilityID($abilityList, str_replace('★', '', pq($td)->text()));
					if($abilityID === null) {
						$abilityID = '???';
					} else if ($abilityID === 'G22') {
						$list[] = [$id, $name, $trickType, 'G23'];
					}
					$list[] = [$id, $trickType, $abilityID];
				}
			}
		}
	}

	$uniqueList = [];
	foreach($list as $l) {
		if(!in_array($l, $uniqueList)) {
			$uniqueList[] = $l;
		}
	}

	return $uniqueList;
}

function getCharaDataList() {

	$dbh = DB::connect();
	try{
		$sql = '
			SELECT
				ID, NAME, GAMEWITH_URL
			FROM
				EVENT_CHARACTER
		';
		// SQL の実行
		$sth = $dbh->query($sql);
		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		$dbh = null;

	}catch (PDOException $e){
		die();
	}
	return $data;
}

function getTrickTypeID($trickType) {
	$itemList = ['練習', '全レア度のイベント', 'SR,PSRのイベント', 'R,PRのイベント', 'N,PNのイベント', 'コンボ', '別Ver.のイベント', '告白', 'デート', 'クリスマス', '初詣', 'バレンタイン', 'エピローグ'];
	$id = array_search(str_replace('．', '.', convertTrickTypeName($trickType)), $itemList);
	if($id !== false) {
		return $id;
	}
	return '???';

}

function getRandomInt($min, $max){
	return rand($min, $max);
}

function getAbilityDataList() {
	$dbh = DB::connect();
	try{
		$sql = '
			SELECT
				ID, NAME
			FROM
				ABILITY_DETAIL
		';
		// SQL の実行
		$sth = $dbh->query($sql);
		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		$dbh = null;

	}catch (PDOException $e){
		die();
	}
	return $data;
}


function getAbilityID($list, $name) {
	$normalizationName = str_replace(['◯', '〇'], '○', $name);
	$normalizationName = str_replace(['☓', '✕'], '×', $normalizationName);

	//個別対応クレンジング
	switch($normalizationName) {
		case '速攻':
			$normalizationName = '速攻○';
			break;
		case '接戦':
			$normalizationName = '接戦○';
			break;
		case '球速対抗心':
			$normalizationName = '速球対抗心';
			break;
	}


	if ($normalizationName === 'オリジナル変化球') {
		return 'ORI';
	}
	for ($i = 0; $i < count($list); $i++) {
		if (str_replace(['◯', '〇'], '○', $list[$i]['NAME']) == $normalizationName) {
			return $list[$i]['ID'];
		}
	}

	switch($normalizationName) {
		case 'ミート':
			return 'T000';
		case 'パワー':
			return 'T001';
		case '走力':
			return 'T002';
		case '肩力':
			return 'T003';
		case '球速':
			return 'T004';
		case 'コントロール':
			return 'T005';
		case 'スタミナ':
			return 'T006';
		case '守備力':
			return 'T007';
		case 'スライダー':
			return 'C000';
		case 'フォーク':
			return 'C001';
		case '左キラー(野手)':
			return 'S002';
		case '左キラー(投手)':
			return 'S203';
	}

	return null;
}

//コツイベントの種類名をクレンジング
function convertTrickTypeName($trickType) {
	switch($trickType) {
		case '全レアイベント':
			return '全レア度のイベント';
			break;
		case '別Ver.イベ':
			return '別Ver.のイベント';
		case '別Ver．イベ':
			return '別Ver.のイベント';
			
	}
	return $trickType;
}


?>