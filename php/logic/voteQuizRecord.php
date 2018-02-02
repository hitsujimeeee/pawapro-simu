<?php
require_once '../global.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$voteFlag = isset($_POST['voteFlag']) ? (int)$_POST['voteFlag'] : null;
$type = $voteFlag === 1 ? 'VOTE_GOOD' : 'VOTE_BAD';

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
	die();
}

?>
