<?php
require_once '../global.php';
require_once '../userCommonModule.php';

$userName = isset($_POST['userName']) ? $_POST['userName'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$deckUserId = isset($_POST['deckUserId']) ? $_POST['deckUserId'] : null;
$deckId = isset($_POST['deckId']) ? $_POST['deckId'] : null;

$result = validateUserInfo($userName, $password);
if($result) {
	header('Content-type: application/json');
	echo json_encode($result);
	exit();
}

$result = null;
try{
	$dbh = DB::connect();
	$userId = getID($dbh, $userName, $password);

	//未登録ユーザーの場合はユーザーを新規作成
	if($userId === null) {
		$userId = makeNewUser($dbh, $userName, $password);
	}
	$sql = "SELECT
				COUNT(*) C
			FROM
				DECK_FAVORITE
			WHERE
				FAV_USER_ID = :userId
			AND
				DECK_USER_ID = :deckUserId
			AND
				DECK_ID = :deckId
			AND
				DELETE_FLAG = 0";
	$stmt = $dbh->prepare($sql);
	$stmt -> bindParam('userId', $userId);
	$stmt -> bindParam('deckUserId', $deckUserId);
	$stmt -> bindParam('deckId', $deckId);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ((int)$row['C'] === 0) {
		$stmt = null;
		$sql = "INSERT INTO
					DECK_FAVORITE
				(
					FAV_USER_ID,
					DECK_USER_ID,
					DECK_ID
				)
				VALUES
				(
					:userId,
					:deckUserId,
					:deckId
				)
				ON DUPLICATE KEY
				UPDATE
					DELETE_FLAG = 0
				";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('userId', $userId);
		$stmt -> bindParam('deckUserId', $deckUserId);
		$stmt -> bindParam('deckId', $deckId);
		$stmt->execute();

		$result = array('status'=>1, 'msg'=>'お気に入り登録しました');
	} else {
		$result = array('status'=>0, 'msg'=>'すでにお気に入り登録済みです');
	}

}catch (PDOException $e){
	die();
}

$dbh = null;
header('Content-type: application/json');
echo json_encode($result);

?>
