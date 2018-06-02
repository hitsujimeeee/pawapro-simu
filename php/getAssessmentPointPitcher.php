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
$outsideFlag = false;

try{
	$dbh = DB::connect();

	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	$total = array_sum($changeBallValue);

	//変化球の組み合わせとポイントの対応表取得
	$sql = 'SELECT ITEM, POINT FROM CHANGE_BALL_POINT WHERE TOTAL >=' . $total;
	$sth = $dbh->query($sql);
	$dictionary = $sth->fetchAll();

	//基礎能力の査定値取得
	$basePoint = (int)getAssessmentPointOfBaseAbilityPitcher($dbh, $basePoint);
	$changeBallPoint = (int)getChangeBallAssessmentPoint($dbh, $changeBallType, $changeBallValue, $dictionary);
	if ($changeBallPoint === 0 && $total !== 0) {
		$outsideFlag = true;
	}
	$basePoint += $changeBallPoint;

	$basePoint = convertPointToAssessment($basePoint) + 33;

	if (hasOriginalChangeBall($changeBallType, $changeBallValue)) {
		$basePoint += 113;
	}

	//特能計算部分
	$abPoint = getAssessmentPointOfAbility($dbh, $ability);


}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


$dbh = null;
header('Content-Type: application/json');
echo json_encode(array('basePoint'=>$basePoint, 'abPoint'=>$abPoint, 'outsideFlag'=>$outsideFlag));


//IDを引数に特能情報を取得
function getAbility($data, $id) {
	foreach($data as $row) {
		if ($row['id'] === $id) {
			return $row;
		}
	}
	return null;
}

function hasOriginalChangeBall($changeBallType, $changeBallValue) {

	for ($i = 0; $i < count($changeBallType); $i++) {
		if ($changeBallValue[$i] > 0) {
			$cType = getChangeBallType($i, $changeBallType[$i]);
			if ($cType === '0') {
				return true;
			}
		}
	}
	return false;
}

?>
