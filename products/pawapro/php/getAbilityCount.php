<?php
require_once 'global.php';

$count = 0;

try{
	$dbh = DB::connect();

	$sql = 'SELECT COUNT(*) C
		FROM ABILITY_HEADER
		';
	// SQL の実行
	$sth = $dbh->query($sql);
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	$count =$row['C'];
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

$dbh = null;
echo (int)$count;

?>
