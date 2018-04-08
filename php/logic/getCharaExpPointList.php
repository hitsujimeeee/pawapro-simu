<?php
require_once './global.php';

function getCharaExpPointList(){
	$data = [];

	try{
		$dbh = DB::connect();
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		$sql = 'SELECT LV, EXP_POINT
		FROM CHARA_EXP_POINT
		ORDER BY LV
		';
		// SQL の実行
		$sth = $dbh->query($sql);
		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		$dbh = null;
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	return $data;
}
?>
