<?php
require_once 'global.php';

function getSubPositionList ($pageType, $tabType) {

	$data = array();
	try{
		$dbh = DB::connect();

		$sql = 'SELECT ID, NAME
			FROM SUBPOSITION_HEADER
			WHERE CATEGORY = ?
			ORDER BY SORT_ORDER
		';

		$sth = $dbh->prepare($sql);

		$sth->bindParam(1, $pageType, PDO::PARAM_INT);
		// SQL の実行
		$sth->execute();

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array(
				'id'=>$row['ID'],
				'name'=>$row['NAME']
			);
		}
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	$dbh = null;
	$idx = 0;

	for ($i = 0; $i < count($data); $i++) {
		$d = $data[$i];
		echo '<li name="subPosition" default="' . $d['name'] . '" onclick="commonModule.changeSubPosition(' . $tabType . ', ' . $idx . ', ' . $d['id'] . ');">' . $d['name'] . '</li>';
		$idx++;
	}

}
?>
