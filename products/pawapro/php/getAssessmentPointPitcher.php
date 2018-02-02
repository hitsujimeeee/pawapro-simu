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

	$pointList = [
		0, 2658, 2680, 2700, 2740, 2760, 2780, 2820, 2840, 2860,
		2902, 2922, 2942, 2962, 3002, 3022, 3062, 3082, 3102, 3122,
		3162, 3184, 3204, 3244, 3264, 3284, 3324, 3344, 3364, 3404,
		3424, 3444, 3466, 3506, 3526, 3546, 3586, 3606, 3626, 3666,
		3686, 3706, 3726, 3768, 3788, 3808, 3848, 3868, 3889, 3929,
		3949, 3969
	];

	//基礎能力の査定値取得
	$basePoint = (int)getAssessmentPointOfBaseAbilityPitcher($dbh, $basePoint);
	$basePoint += (int)getChangeBallAssessmentPoint($dbh, $changeBallType, $changeBallValue);

	if ($basePoint > 100) {
		$basePoint = $pointList[$basePoint-100];
	} else {
		$basePoint = null;
	}

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
