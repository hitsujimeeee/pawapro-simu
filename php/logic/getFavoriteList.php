
<?php
require_once '../global.php';
require_once '../userCommonModule.php';

if(isset($_POST['userName'])) {
	$userName = $_POST['userName'];
} else {
	exit();
}

if(isset($_POST['password'])) {
	$password = $_POST['password'];
} else {
	exit();
}

$result = array();

try{
	$dbh = DB::connect();
	$userId = getID($dbh, $userName, $password);

	//既に登録済みのユーザー
	if($userId !== null) {
		$sql = "SELECT
					DECK_USER_ID, DECK_ID
				FROM
					DECK_FAVORITE
				WHERE
					FAV_USER_ID = :userId
				AND
					DELETE_FLAG = 0";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('userId', $userId);
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$result[] = $row['DECK_ID'];
		}
	}

}catch (PDOException $e){
	die();
}

$dbh = null;
echo json_encode($result, JSON_UNESCAPED_UNICODE);

?>
