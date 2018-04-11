<?php
require_once("./php/global.php");
require_once("./php/lib/phpQuery-onefile.php");

$url = "https://xn--odkm0eg.gamewith.jp/article/show/10913";
$doc = getDOMDocument($url);

$charaList = getCharaDataList();
$abilityList = getAbilityDataList();

//個別ページのURLリスト作成
foreach($doc['td.pwpr_before:not(.bold)'] as $row) {
	if (pq($row)->find('a')->attr('href')) {
		$urlList[] = pq($row)->find('a')->attr('href');
	}
}

//個別ページのURLリスト作成
foreach($doc['td.pwpr_after:not(.bold)'] as $row) {
	if (pq($row)->find('a')->attr('href')) {
		$urlList[] = pq($row)->find('a')->attr('href');
	}
}

$uniqueList = array_unique($urlList);
$urlList = array_values($uniqueList);

$count = 0;
mb_regex_encoding("UTF-8");

$fp = fopen("./itemList.csv", "w");
fputcsv($fp, ['CHARA_ID', 'GET_TYPE', 'TRICK_ID']);


echo(str_pad(" ",4096). '<br>');
ob_end_flush();
ob_start('mb_output_handler');

//個別ページのURLごとに処理
foreach ($urlList as $url){
//	if($count < 200) {
//		$count++;
//		continue;
//	}

	$rand = getRandomInt(3000, 5000) / 1000;
	sleep($rand);

	$doc = getDOMDocument($url);

	$name = $doc['.article-hero > h1._title']->text();
	preg_match('/^【パワプロアプリ】(.+?)(の評価|のイベント)/', $name, $retArray);
	$name = $retArray[1];
	$name = preg_replace(['/［/', '/］/', '/（/', '/）/'], ['[', ']', '(', ')'], $name);
	$name = preg_replace("/\(.+?\)/", "", $name);
	$name = preg_replace("/（.+?）/", "", $name);
	$name = convertExceptionName($name);

	$id = getCharaID($charaList, $name);
	if($id === null) {
		$id = '???';
	}
	$list = searchDOM($doc['.matome'], $id, $name, $abilityList);

	foreach ($list as $l) {
		fputcsv($fp, $l);
	}

	$count++;

	echo($name . '<br>');

	ob_flush();
	flush();

	if ($count >= 300){
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
				if(pq($td)->html()) {
					$abilityID = getAbilityID($abilityList, str_replace('★', '', pq($td)->text()));
					if($abilityID === null) {
						$abilityID = '???';
					} else if ($abilityID === 'G22') {
						$list[] = [$id, $name, $trickType, 'G23'];
					}
					$list[] = [$id, $name, $trickType, $abilityID];
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
				ID, NAME
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

function getCharaID($list, $name) {
	for ($i = 0; $i < count($list); $i++) {
		if ($list[$i]['NAME'] == $name) {
			return $list[$i]['ID'];
		}
	}

	return null;
}

function getTrickTypeID($trickType) {
	$itemList = ['練習', '全レア度のイベント', 'SR,PSRのイベント', 'R,PRのイベント', 'N,PNのイベント', 'コンボ', '別Ver.のイベント', '別Ver.イベ', '告白', 'デート', 'クリスマス', '初詣', 'バレンタイン', 'エピローグ'];
	$id = array_search(str_replace('．', '.', $trickType), $itemList);
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

//おかしい名前を個別に修正
function convertExceptionName($name) {
	switch($name) {
		case 'アンドロメダ嵐丸':
			return '[アンドロメダ]嵐丸';
		case 'アンドロメダ大西':
			return '[アンドロメダ]大西';
	}
	return $name;
}


?>
