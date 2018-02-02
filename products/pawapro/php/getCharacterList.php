<?php
require_once 'global.php';
require_once 'userCommonModule.php';
require_once "./getAssessmentPointFunc.php";

$json = file_get_contents('php://input');
$post = json_decode($json, true);
$name = isset($post['name']) ? $post['name'] : null;
$password = isset($post['password']) ? $post['password'] : null;
$userId = isset($post['userId']) ? $post['userId'] : null;

$charaList = array();

try{
	$dbh = DB::connect();
	if($userId === null) {
		$userId = getID($dbh, $name, $password);
	}

	//既に登録済みのユーザー
	if($userId !== null) {
		$sql = "SELECT ID, DATA FROM M_CHARACTER WHERE USER_ID = :userId AND DELETE_FLAG = '0' ORDER BY ENTRY_DATE";
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue('userId', $userId);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$unzip = gzinflate($row['DATA']);
			$charaIdx16 = convertx64Tox16($row['ID']);

			$imgURL = '../img/charaFace/' . substr($charaIdx16, 0, 2) . '/' . $charaIdx16 . '.jpg';
			if (!file_exists($imgURL)) {
				$imgURL = '../img/noface.jpg';
			}

			$data = json_decode($unzip, true);

			$point = 0;
			$rankStr = '';
			$meter = 0;
			if((int)$data['charaType'] === 0) {
				//基礎能力の査定値取得
				$point = getAssessmentPointOfBaseAbility($dbh, $data['basePoint'][1]);

				//特能計算部分
				$abPoint = getAssessmentPointOfAbility($dbh, $data['ability'][1]);

				$point = (int)(($point+ $abPoint)/14) * 14;
				$rankStr = getAssessmentRank($dbh, $point);
				$meter = getAssessmentMeterLength($dbh, $point);
			}

			$data['name'] = htmlspecialchars($data['name']);

			$charaList[] = array(
				'id'=>$row['ID'],
				'imgURL'=>$imgURL,
				'data'=>$data,
				'assessment'=>$point,
				'rankStr'=>$rankStr,
				'meter'=>$meter
			);
		}
		$state = 1;
	} else {
		$state = -1;
	}

}catch (PDOException $e){
	die();
}

$data = array(
	'userId'=>$userId,
	'charaList'=>$charaList
);

$result = array('state'=>$state, 'data'=>$data);

$dbh = null;
header('Content-type: application/json');
echo json_encode($result);


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
