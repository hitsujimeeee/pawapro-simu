<?php
require 'global.php';
function getHistories () {
	$data = array();

	try{
		$dbh = DB::connect();

		$sql = 'SELECT date_format(ENTRY_DATE, \'%Y-%m-%d\') ENTRY_DATE, DESCRIPTION
			FROM HISTORIES
			ORDER BY ENTRY_DATE DESC
	';
		// SQL の実行
		$sth = $dbh->query($sql);

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array(
				'date'=>$row['ENTRY_DATE'],
				'description'=>$row['DESCRIPTION']
			);
		}
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	$dbh = null;
	return $data;
}
?>
