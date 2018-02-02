<?php

require_once 'global.php';
require_once 'userCommonModule.php';

$json = file_get_contents('php://input');
$post = json_decode($json, true);
$name = $post['name'];
$password = $post['password'];
$charaId = $post['charaId'];

$result = null;

try{
	$dbh = DB::connect();
	$userId = getId($dbh, $name, $password);
	//既に登録済みのユーザー
	if($userId !== null) {
		$sql = "UPDATE M_CHARACTER SET DELETE_FLAG = '1', UPDATE_DATE = NOW() WHERE ID = :charaId AND USER_ID = :userId";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('charaId', $charaId, PDO::PARAM_STR);
		$stmt -> bindParam('userId', $userId, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$result = array(
				'state'=>1,
				'msg'=>'選手情報を削除しました'
			);
		} else {
			$result = array(
				'state'=>-1,
				'msg'=>'指定した選手情報は存在しません。'
			);
		}
	} else {
		$result = array(
			'state'=>-1,
			'msg'=>'ユーザー名またはパスワードが違います'
		);
	}
	$stmt = null;

}catch (PDOException $e){
	die();
}


$dbh = null;
header('Content-type: application/json');
echo json_encode($result);

?>
