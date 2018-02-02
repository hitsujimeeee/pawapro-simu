<?php
require_once '../global.php';

$count = 0;

try{
	$dbh = DB::connect();

	$sql = '
	SELECT
		COUNT(*) C
	FROM
		QUIZ
	WHERE
		DELETE_FLAG = 0
	';

	$sth = $dbh->query($sql);
	$row = $sth->fetch(PDO::FETCH_ASSOC);

	$count = (int)(((int)$row['C']-1)/50);

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	$dbh->rollback();
	die();

}

echo json_encode($count);

?>
