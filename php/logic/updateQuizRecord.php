<?php
require_once '../global.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$result = isset($_POST['result']) ? (int)$_POST['result'] : null;
$type = $result === 1 ? 'CORRECT' : 'FAILED';

try{
	$dbh = DB::connect();

	$dbh->beginTransaction();

	$sql = '
	UPDATE
		QUIZ
	SET
		' . $type . ' = ' . $type . ' + 1
	WHERE
		ID = :id
	';

	$sth = $dbh->prepare($sql);
	$sth->bindValue('id', $id);
	$sth->execute();

	$dbh->commit();

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	$dbh->rollback();
	die();

}

?>
