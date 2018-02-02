<?php
require_once 'global.php';
require_once "getAssessmentPointFunc.php";

$data = array();
$post = null;

$json = file_get_contents('php://input');
$post = json_decode($json, true);
$basePointAim = $post['basePoint'];
$abilityAim = $post['ability'];
$point = 0;
$rankStr = '';
$meter = 0;
try{
	$dbh = DB::connect();

	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	//基礎能力の査定値取得
	$point += getAssessmentPointOfBaseAbility($dbh, $basePointAim);

	//特能計算部分
	$abPoint = getAssessmentPointOfAbility($dbh, $abilityAim);
//	var_dump($abPoint);

	$point = (int)(($point+ $abPoint)/14) * 14;

	$sql = 'SELECT RANK_STR, POINT_FROM
			FROM ASSESSMENT_RANK
			WHERE POINT_FROM <= ' . $point  . '
			AND POINT_TO > ' . $point;

	$sth = $dbh->prepare($sql);
	$sth->execute();
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	if($row) {
		$rankStr = $row['RANK_STR'];
		if ($rankStr === 'G') {
			$meter = 0;
		} else {
			$meter = ($point - (int)($row['POINT_FROM'])) / 14;
		}
	}

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


$dbh = null;
header('Content-Type: application/json');
echo json_encode(array('point'=>$point,'rank'=>$rankStr,'meter'=>$meter));


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
