<?php
header("Content-type: text/plain; charset=UTF-8");
require_once("../global.php");
require_once("../lib/phpQuery-onefile.php");

$allFlag = (int)$_POST['allFlag'];
$url = "https://xn--odkm0eg.gamewith.jp/article/show/10913";
$doc = getDOMDocument($url);

$urlList = [];

$charaList = getCharaDataList();

//設定値
$limitCount = 300;	//処理イベキャラ数上限
$skipCount = 295;	//最初のnキャラ数分スキップ

//個別ページのURLリスト作成
foreach($doc['div.pwpr_icon_table a'] as $row) {
	if (pq($row)->attr('href')) {
		$urlList[] = pq($row)->attr('href');
	}
}

//新キャラ用に別途取得
foreach($doc['div.pwpr_event_table a'] as $row) {
	if (pq($row)->attr('href')) {
		$urlList[] = pq($row)->attr('href');
	}
}

$uniqueList = array_unique($urlList);
$urlList = array_values($uniqueList);

$charaURL = [];

$count = 0;

//個別ページのURLごとに処理
foreach ($urlList as $url){

    if (!$allFlag && isCompletedURL($url, $charaList)) {
        continue;
    }


	$rand = getRandomInt(500, 1000) / 1000.00;
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
    
    $url = str_replace('https://xn--odkm0eg.gamewith.jp/article/show/', '', $url);

    $charaURL[] = array(
		'id'=>$id,
		'url'=>$url
	);

	$count++;

	if ($count >= $limitCount){
		break;
	}
}

usort($charaURL, "mySort");

$fp = fopen("./charaURL.csv", "w");
foreach($charaURL as $c) {
	fputcsv($fp, $c);
}
fclose($fp);

header('Content-type: application/json');
echo json_encode($charaURL);

function mySort($a, $b) {
	return ($a['id'] < $b['id']) ? -1 : 1;
}

function isCompletedURL($url, $charaList) {

    foreach($charaList as $chara) {
        if ($url === 'https://xn--odkm0eg.gamewith.jp/article/show/' . $chara['GAMEWITH_URL']) {
            return true;
        }
    }
    return false;
}


//phpQueryを使ってページのDOMツリーを取得
function getDOMDocument($url) {
	$html = file_get_contents($url);
	return phpQuery::newDocument($html);
}

function getCharaDataList() {

	try{
        $dbh = DB::connect();
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

function getCharaID($list, $name) {
	for ($i = 0; $i < count($list); $i++) {
		if ($list[$i]['NAME'] == $name) {
			return $list[$i]['ID'];
		}
	}

	return null;
}

function getRandomInt($min, $max){
	return rand($min, $max);
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