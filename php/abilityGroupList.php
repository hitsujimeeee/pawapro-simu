<?php
require_once 'global.php';
$json = file_get_contents('php://input');
$post = json_decode($json, true);
$pageType = $post['pageType'];
$data = array();
$category_str = $pageType === 0 ? '\'0\', \'5\', \'7\', \'9\'' : '\'4\', \'6\', \'7\', \'8\'';
try{
	$dbh = DB::connect();

	$sql = 'SELECT ID, PAIR
		FROM ABILITY_HEADER
		WHERE CATEGORY IN (' . $category_str . ')
		ORDER BY CATEGORY, SORT_ORDER
		';
	// SQL の実行
	$sth = $dbh->query($sql);

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$data[] = array(
			'id'=>(int)$row['ID'],
			'pair'=>$row['PAIR'] === null ? null : (int)$row['PAIR']
		);
	}
	$abilityGroupList = array();

	foreach($data as $d) {
		$sql = '
			SELECT D.ID,
			D.NAME,
			D.POWER,
			D.SPEED,
			D.TECH,
			D.SCREWBALL,
			D.MENTAL,
			D.UPPER,
			D.LOWER,
			D.ASSESSMENT,
			D.TYPE
			FROM ABILITY_HEADER H
			INNER JOIN ABILITY_DETAIL D
			ON H.ID = D.HEADER_ID
			WHERE H.ID = ?
			ORDER BY FIELD(D.TYPE, 3, 2, 4, 0, 1) ASC,
			(LOWER IS NULL) DESC';
		$sth = $dbh->prepare($sql);
		$sth->bindParam(1, $d['id'], PDO::PARAM_INT);
		$sth->execute();
		$abilityList= array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$abilityList[] = array(
				'id'=>$row['ID'],
				'name'=>$row['NAME'],
				'point'=>array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['SCREWBALL'], (int)$row['MENTAL']),
				'assessment'=>$row['ASSESSMENT'],
				'upper'=>$row['UPPER'],
				'lower'=>$row['LOWER'],
				'type'=>(int)$row['TYPE']
			);
		}
		array_push($abilityGroupList, array('id'=>$d['id'], 'list'=>$abilityList, 'pair'=>$d['pair']));
	}


	$sql = 'SELECT
			D.ID,
			D.HEADER_ID,
			D.NAME,
			H.COLOR
		FROM SUBPOSITION_HEADER H
		INNER JOIN SUBPOSITION_DETAIL D
		ON H.ID = D.HEADER_ID
		WHERE CATEGORY = ' . $pageType . '
		ORDER BY D.ID';
	// SQL の実行
	$sth = $dbh->query($sql);
	$subPosList = [];

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$subPosList[] = array(
			'id'=>(int)$row['ID'],
			'headerId'=>(int)$row['HEADER_ID'],
			'name'=>$row['NAME'],
			'color'=>(int)$row['COLOR']
		);
	}

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

$ret = array(
	'abilityGroupList'=>$abilityGroupList,
	'subPosGroupList'=>$subPosList
);

$dbh = null;
echo json_encode($ret);
?>
