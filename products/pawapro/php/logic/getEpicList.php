<?php
require 'global.php';
function getEpicList () {
	$data = array();

	try{
		$dbh = DB::connect();

		$sql = 'SELECT ID, NAME, EPIC_TYPE, TURN, PERSONNEL
			FROM EPIC_LIST
	';
		// SQL の実行
		$sth = $dbh->query($sql);

		$data = $sth->fetchAll();
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	$dbh = null;
	return $data;
}
?>
