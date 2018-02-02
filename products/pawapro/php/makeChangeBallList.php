<?php
require_once 'global.php';

function makeChangeBallList () {

	$data = array();
	try{
		$dbh = DB::connect();

		$sql = 'SELECT CATEGORY, ID, NAME
			FROM CHANGE_BALL_HEADER
			ORDER BY CATEGORY, ID
		';

		$sth = $dbh->prepare($sql);

		// SQL の実行
		$sth->execute();

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array(
				'category'=>(int)$row['CATEGORY'],
				'id'=>(int)$row['ID'],
				'name'=>$row['NAME']
			);
		}
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	$str = '';
	for ($i = 1; $i <= 6; $i++) {
		$str .= '<td><select class="changeBallType">';
		foreach($data as $d) {
			if($d['category'] === $i) {
				$str .= '<option value="' . $d['id'] . '">' . $d['name'] . '</option>';
			}

		}
		$str .= '</select></td>';
	}



	$dbh = null;
	return $str;
}
?>
