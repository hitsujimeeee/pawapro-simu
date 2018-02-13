<?php
require_once 'global.php';
require_once "getAssessmentPointFunc.php";

$data = array();
$post = null;

$json = file_get_contents('php://input');
$post = json_decode($json, true);
$ability = $post['ability'];
$basePoint = $post['basePoint'];
$changeBallType = $post['changeBallType'];
$changeBallValue = $post['changeBallValue'];

try{
	$dbh = DB::connect();

	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	//変化球の組み合わせとポイントの対応表取得
	$sql = 'SELECT ITEM, POINT FROM CHANGE_BALL_POINT';
	$sth = $dbh->query($sql);
	$dictionary = $sth->fetchAll();

	//ポイント→査定値の対応表取得
	$pointList = [];
	$sql = 'SELECT VALUE FROM PITCHER_POINT_VALUE ORDER BY POINT';
	$sth = $dbh->query($sql);
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$pointList[] = (int)$row['VALUE'];
	}

	//基礎能力の査定値取得
	$basePoint = (int)getAssessmentPointOfBaseAbilityPitcher($dbh, $basePoint);
	$basePoint += (int)getChangeBallAssessmentPoint($dbh, $changeBallType, $changeBallValue, $dictionary);

	$basePoint = $pointList[$basePoint];

	//特能計算部分
	$abPoint = getAssessmentPointOfAbility($dbh, $ability);


}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


$dbh = null;
header('Content-Type: application/json');
echo json_encode(array('basePoint'=>$basePoint, 'abPoint'=>$abPoint));


//IDを引数に特能情報を取得
function getAbility($data, $id) {
	foreach($data as $row) {
		if ($row['id'] === $id) {
			return $row;
		}
	}
	return null;
}

?>
