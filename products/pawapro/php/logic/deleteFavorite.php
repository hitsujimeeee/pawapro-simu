<?php
require_once '../global.php';
require_once '../userCommonModule.php';

$userName = isset($_POST['userName']) ? $_POST['userName'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$deckUserId = isset($_POST['deckUserId']) ? $_POST['deckUserId'] : null;
$deckId = isset($_POST['deckId']) ? $_POST['deckId'] : null;

//入力されたユーザー情報のバリデーションチェック
$result = validateUserInfo($userName, $password);

if(!$deckUserId || !$deckId) {
	$result = array('status'=>-1, 'msg'=>'エラーが発生しました。ページを再読み込みしてください。');
}

if(!$result) {

	try{
		$dbh = DB::connect();
		$userId = getID($dbh, $userName, $password);

		//既に登録済みのユーザー
		if($userId !== null) {
			$sql = "
			UPDATE
				DECK_FAVORITE
			SET
				DELETE_FLAG  = 1
			WHERE
				FAV_USER_ID = :userId
			AND
				DECK_USER_ID = :deckUserId
			AND
				DECK_ID = :deckId
			AND
				DELETE_FLAG = 0";
			$stmt = $dbh->prepare($sql);
			$stmt -> bindValue('userId', $userId);
			$stmt -> bindValue('deckUserId', $deckUserId);
			$stmt -> bindValue('deckId', $deckId);

			$count = $stmt->execute();
			if ($count > 0) {
				$result = array('status'=>1, 'msg'=>'お気に入り解除しました');
			} else {
				$result = array('status'=>1, 'msg'=>'このデッキはまだお気に入り登録していません。');
			}
		} else {
			$result = array('status'=>1, 'msg'=>'このデッキはまだお気に入り登録していません。');
		}
	} catch (PDOException $e) {
		die();
	}

}

$dbh = null;
header('Content-type: application/json');
echo json_encode($result);

?>
