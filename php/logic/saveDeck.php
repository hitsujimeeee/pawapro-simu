<?php
require_once '../global.php';
require_once '../userCommonModule.php';

$userName = isset($_POST['userName']) ? $_POST['userName'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$deckId = isset($_POST['deckId']) ? $_POST['deckId'] : null;
$deckData = isset($_POST['deckData']) ? $_POST['deckData'] : null;


$result = validateUserInfo($userName, $password);
if($result) {
	header('Content-type: application/json');
	echo json_encode($result);
	exit();
}

if(!$deckData) {
	header('Content-type: application/json');
	echo json_encode(array('status'=>-1, 'msg'=>'エラーが発生しました。'));
	exit();
}


try{
	$dbh = DB::connect();
	$userId = getID($dbh, $userName, $password);

	if($userId == null) {
		$userId = makeNewUser($dbh, $userName, $password);
	}
	if(!$deckId) {
		$deckId = makeUniqueId();
	}

	$sql = "
	SELECT
		COUNT(*) C
	FROM
		DECK
	WHERE
		USER_ID = :userId
	AND
		ID = :deckId
	";
	$stmt = $dbh->prepare($sql);
	$stmt -> bindValue('userId', $userId);
	$stmt -> bindValue('deckId', $deckId);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;


	if ((int)$row['C'] > 0) {
		//登録済みの場合はUPDATE
		$sql = "
		UPDATE
			DECK
		SET
			NAME = :name,
			CHARA1_ID = :chara1_id,
			CHARA2_ID = :chara2_id,
			CHARA3_ID = :chara3_id,
			CHARA4_ID = :chara4_id,
			CHARA5_ID = :chara5_id,
			CHARA6_ID = :chara6_id,
			CHARA1_LV = :chara1_lv,
			CHARA2_LV = :chara2_lv,
			CHARA3_LV = :chara3_lv,
			CHARA4_LV = :chara4_lv,
			CHARA5_LV = :chara5_lv,
			CHARA6_LV = :chara6_lv,
			CHARA1_RARE = :chara1_rare,
			CHARA2_RARE = :chara2_rare,
			CHARA3_RARE = :chara3_rare,
			CHARA4_RARE = :chara4_rare,
			CHARA5_RARE = :chara5_rare,
			CHARA6_RARE = :chara6_rare,
			TYPE = :type,
			SCHOOL = :school,
			SUMMARY = :summary,
			AUTHOR = :author,
			GAME_ID = :gameId,
			TWITTER_ID = :twitterId,
			PRIVATE_FLAG = :privateFlag,
			RENEW_DATE = NOW()
		WHERE
			USER_ID = :userId
		AND
			ID = :deckId
		";

		$stmt = $dbh->prepare($sql);
		$stmt -> bindValue('name', $deckData['name']);
		for($i = 0; $i < 6; $i++) {
			if($deckData['chara'][$i]) {
				$stmt -> bindValue('chara' . ($i+1) . '_id', $deckData['chara'][$i]['id']);
				$stmt -> bindValue('chara' . ($i+1) . '_lv', $deckData['chara'][$i]['lv']);
				$stmt -> bindValue('chara' . ($i+1) . '_rare', $deckData['chara'][$i]['rare']);
			} else {
				$stmt -> bindValue('chara' . ($i+1) . '_id', null);
				$stmt -> bindValue('chara' . ($i+1) . '_lv', null);
				$stmt -> bindValue('chara' . ($i+1) . '_rare', null);
			}
		}
		$stmt -> bindValue('type', $deckData['type']);
		$stmt -> bindValue('school', $deckData['school']);
		$stmt -> bindValue('summary', $deckData['summary']);
		$stmt -> bindValue('author', $deckData['author']);
		$stmt -> bindValue('gameId', $deckData['gameId']);
		$stmt -> bindValue('twitterId', $deckData['twitterId']);
		$stmt -> bindValue('privateFlag', $deckData['privateFlag']);
		$stmt -> bindValue('userId', $userId);
		$stmt -> bindValue('deckId', $deckId);
		$stmt->execute();
		$result = array(
			'status'=>0,
			'msg'=>'デッキを更新しました。',
			'deckId'=>$deckId,
			'userId'=>$userId
		);
	} else {
		$deckId = makeUniqueId();

		//登録がない場合はINSERT
		$sql = "
		INSERT INTO
			DECK
		(
			ID,
			USER_ID,
			NAME,
			CHARA1_ID,
			CHARA2_ID,
			CHARA3_ID,
			CHARA4_ID,
			CHARA5_ID,
			CHARA6_ID,
			CHARA1_LV,
			CHARA2_LV,
			CHARA3_LV,
			CHARA4_LV,
			CHARA5_LV,
			CHARA6_LV,
			CHARA1_RARE,
			CHARA2_RARE,
			CHARA3_RARE,
			CHARA4_RARE,
			CHARA5_RARE,
			CHARA6_RARE,
			TYPE,
			SCHOOL,
			SUMMARY,
			AUTHOR,
			GAME_ID,
			TWITTER_ID,
			PRIVATE_FLAG
		)
		VALUES (
			:deckId,
			:userId,
			:name,
			:chara1_id,
			:chara2_id,
			:chara3_id,
			:chara4_id,
			:chara5_id,
			:chara6_id,
			:chara1_lv,
			:chara2_lv,
			:chara3_lv,
			:chara4_lv,
			:chara5_lv,
			:chara6_lv,
			:chara1_rare,
			:chara2_rare,
			:chara3_rare,
			:chara4_rare,
			:chara5_rare,
			:chara6_rare,
			:type,
			:school,
			:summary,
			:author,
			:gameId,
			:twitterId,
			:privateFlag
		)
		";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindValue('name', $deckData['name']);
		for($i = 0; $i < 6; $i++) {

			if($deckData['chara'][$i]) {
				$stmt -> bindValue('chara' . ($i+1) . '_id', $deckData['chara'][$i]['id']);
				$stmt -> bindValue('chara' . ($i+1) . '_lv', $deckData['chara'][$i]['lv']);
				$stmt -> bindValue('chara' . ($i+1) . '_rare', $deckData['chara'][$i]['rare']);
			} else {
				$stmt -> bindValue('chara' . ($i+1) . '_id', null);
				$stmt -> bindValue('chara' . ($i+1) . '_lv', null);
				$stmt -> bindValue('chara' . ($i+1) . '_rare', null);
			}
		}
		$stmt -> bindValue('type', $deckData['type']);
		$stmt -> bindValue('school', $deckData['school']);
		$stmt -> bindValue('summary', $deckData['summary']);
		$stmt -> bindValue('author', $deckData['author']);
		$stmt -> bindValue('gameId', $deckData['gameId']);
		$stmt -> bindValue('twitterId', $deckData['twitterId']);
		$stmt -> bindValue('privateFlag', $deckData['privateFlag']);
		$stmt -> bindValue('userId', $userId);
		$stmt -> bindValue('deckId', $deckId);
		$stmt->execute();
		$result = array(
			'status'=>0,
			'msg'=>'デッキを新規登録しました。',
			'deckId'=>$deckId,
			'userId'=>$userId
		);
;	}

	$stmt = null;
	$sql = '
		UPDATE
			DECK_CHARACTER
		SET
			CHARA_ID = NULL
		WHERE
			DECK_ID = :deckId';
	$stmt = $dbh->prepare($sql);
	$stmt -> bindValue('deckId', $deckId);
	$stmt->execute();

	if(isset($deckData['makedChara'])) {
		for ($i = 0; $i < count($deckData['makedChara']); $i++) {
			$sql = '
		INSERT INTO
			DECK_CHARACTER
		(
			DECK_ID,
			USER_ID,
			NO,
			CHARA_ID
		)
		VALUES
		(
			:deckId,
			:userId,
			:no,
			:charaId
		)
		ON DUPLICATE KEY
		UPDATE
			CHARA_ID = :charaId
		';
			$stmt = $dbh->prepare($sql);
			$stmt -> bindValue('charaId', $deckData['makedChara'][$i]);
			$stmt -> bindValue('userId', $userId);
			$stmt -> bindValue('deckId', $deckId);
			$stmt -> bindValue('no', $i+1);
			$stmt->execute();
			$stmt = null;
		}
	}

}catch (PDOException $e){
	die();
}

$dbh = null;

header('Content-type: application/json');
echo json_encode($result);

?>
