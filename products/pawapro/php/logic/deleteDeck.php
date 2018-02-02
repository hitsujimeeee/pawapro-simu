<?php
require_once '../global.php';
require_once '../userCommonModule.php';

$userName = isset($_POST['userName']) ? $_POST['userName'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$deckId = isset($_POST['deckId']) ? $_POST['deckId'] : null;


$result = validateUserInfo($userName, $password);
if($result) {
	header('Content-type: application/json');
	echo json_encode($result);
	exit();
}

if(!$deckId) {
	header('Content-type: application/json');
	echo json_encode(array('status'=>-1, 'msg'=>'エラーが発生しました。'));
	exit();
}

try{
	$dbh = DB::connect();
	$userId = getID($dbh, $userName, $password);

	if($userId) {
		$sql = "
		DELETE FROM
			DECK
		WHERE
			ID = :deckId
		AND
			USER_ID = :userId
		";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindValue('deckId', $deckId);
		$stmt -> bindValue('userId', $userId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt = null;

		$result = array(
			'status'=>0,
			'msg'=>'デッキを削除しました。',
			'deckId'=>$deckId,
			'userId'=>$userId
		);

	} else {
		$result = array(
			'status'=>-1,
			'msg'=>'ユーザー名、パスワードが違います。',
			'deckId'=>$deckId,
			'userId'=>$userId
		);
	}

}catch (PDOException $e){
	die();
}

$dbh = null;

header('Content-type: application/json');
echo json_encode($result);

?>
