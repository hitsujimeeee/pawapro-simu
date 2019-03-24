<?php
require_once 'global.php';
function getAbilityList ($pageType) {
	$data = array();
	$category_str = $pageType === 0 ? '\'0\', \'5\', \'7\', \'9\'' : '\'4\', \'6\', \'7\', \'8\'';
	$abilityList = array();
	try{
		$dbh = DB::connect();

		$sql = 'SELECT ID, NAME, CATEGORY, PAIR
			FROM ABILITY_HEADER
			WHERE CATEGORY IN (' . $category_str . ')
			ORDER BY SORT_ORDER
			';
		// SQL の実行
		$sth = $dbh->query($sql);

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array(
				'id'=>$row['ID'],
				'name'=>$row['NAME'],
				'category'=>$row['CATEGORY'],
				'pair'=>$row['PAIR'],
				'abTrick'=> false,
				'SabTrick'=> false,
				'RabTrick'=> false,
			);
		}

		$sql = 'SELECT H.ID HEADER_ID, D.TYPE
			FROM ABILITY_HEADER H
			INNER JOIN
				ABILITY_DETAIL D
			ON
				H.ID = D.HEADER_ID
			WHERE H.CATEGORY IN (' . $category_str . ')
			GROUP BY
				H.ID, D.TYPE
			ORDER BY H.SORT_ORDER
			';
		// SQL の実行
		$sth = $dbh->query($sql);

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$abilityList[] = array(
				'id'=>$row['HEADER_ID'],
				'type'=>(int)$row['TYPE']
			);
		}

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	$dbh = null;

	for ($i = 0; $i < count($data); $i++) {
		$abTrickFlag = false;
		$SabTrickFlag = false;
		$RabTrickFlag = false;
		for ($j = 0; $j < count($abilityList); $j++) {
			$ab = $abilityList[$j];
			if ($data[$i]['id'] == $ab['id']) {
				if ($ab['type'] === 0 || $ab['type'] === 2 || $ab['type'] === 3 || $ab['type'] === 4) {
					$data[$i]['abTrick'] = true;
					$abTrickFlag = true;
				} else if ($ab['type'] === 1) {
					$data[$i]['SabTrick'] = true;
					$SabTrickFlag = true;
				} else if ($ab['type'] === 6) {
					$data[$i]['RabTrick'] = true;
					$RabTrickFlag = true;
				}

				if ($abTrickFlag && $SabTrickFlag && $RabTrickFlag) {
					break;
				}
			}
		}
	}

	return $data;
}
?>
