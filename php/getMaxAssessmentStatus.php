<?php
require_once 'global.php';

$data = array();
$post = null;
$json = file_get_contents('php://input');
$post = json_decode($json, true);
$basePoint = $post['basePoint'];
$abilityNow = $post['ability'];
$map = $post['map'];
$pairList = array();
$dbh = DB::connect();

try {

	$dbh = DB::connect();

	//特能グループ全取得
	$abilityGroup = array();
	$sql = '
			SELECT ID,
			--NAME,
			CASE CATEGORY
				WHEN 0 THEN 1
				ELSE 0
			END BATTER_ABILITY,
			PAIR
			FROM ABILITY_HEADER
			ORDER BY CATEGORY, SORT_ORDER, ID';

	$sth = $dbh->query($sql);

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$abilityGroup[] = array(
			'id'=>(int)$row['ID'],
			'flag'=>(int)$row['BATTER_ABILITY'],
			'pair'=>$row['PAIR']
		);
	}
	$sth = null;

} catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

foreach($abilityGroup as $ag) {
	if($ag['pair'] !== null) {
		$pairList[] = array(
			'id'=>$ag['id'],
			'pair'=>(int)$ag['pair']
		);
	}
}

$newBaseAbility = getNewBaseAbility($basePoint, $map[2]);
$newAbility = getNewDisplayAbility($dbh, $abilityNow, $map[2], $pairList);
$data = array(
	'baseAbility'=>$newBaseAbility,
	'ability'=>$newAbility
);




$dbh = null;
header('Content-Type: application/json');
echo json_encode($data);






function getNewBaseAbility($baseAbility, $route) {
	$baseTypeStr = array('DA', 'ME', 'PO', 'SP', 'SH', 'DE', 'CA');
	$list = array();
	for ($i = 0; $i < count($baseAbility); $i++) {
		$hitFlag = false;
		for ($j = 0; $j < count($route); $j++) {
			if(is_numeric(substr($route[$j], 0, 1))) {
				continue;
			}

			if(substr($route[$j], 0, 2) === $baseTypeStr[$i]) {
				$hitFlag = true;
				preg_match('/[0-9]+/', $route[$j], $m);
				$list[] = (int)$m[0];
				break;
			}
		}
		if (!$hitFlag) {
			$list[] = $baseAbility[$i];
		}
	}
	return $list;
}

function getNewAbility($ability, $route) {
	$list = array();
	$abilityGroup = $GLOBALS['abilityGroup'];
	foreach ($route as $id) {
		if (is_numeric(substr($id, 0, 1))) {
			preg_match('/^[0-9]+/', $id, $m);
			preg_match('/[A-Z][0-9]+$/', $id, $m2);
			$ability[$m[0]]['id'] = $m2[0];
		}
	}

	foreach ($ability as $ab) {
		if ($ab['id'] !== null) {
			$list[] = $ab['id'];
		}

	}

	return $list;
}


function getNewDisplayAbility($dbh, $ability, $route, $pairList) {
	$list = array();
	foreach ($route as $id) {
		if (is_numeric(substr($id, 0, 1))) {
			preg_match('/^[0-9]+/', $id, $m);
			preg_match('/[A-Z][0-9]+$/', $id, $m2);
			$ability[$m[0]]['id'] = $m2[0];
			$pairId = getPairId($m[0], $pairList);
			if ($pairId !== null) {
				$ability[$pairId]['id'] = null;
			}
		}
	}

	foreach ($ability as $ab) {
		if ($ab['id'] !== null) {
			$sql = 'SELECT NAME, TYPE
					FROM ABILITY_DETAIL
					WHERE ID = ?
					LIMIT 1
			';
			$sth = $dbh->prepare($sql);
			$sth->bindParam(1, $ab['id'], PDO::PARAM_STR);

			// SQL の実行
			$sth->execute();
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			$list[] = array(
				'id'=>$ab['id'],
				'name'=>$row['NAME'],
				'type'=>$row['TYPE']
			);
		} else {
			$list[] = null;
		}
	}
	return $list;

}


//IDを引数に特能情報を取得
function getAbility($data, $id) {
	foreach($data as $row) {
		if ($row['id'] === $id) {
			return $row;
		}
	}
	return null;
}


function getPairId($id, $pairList) {
	for ($i = 0; $i < count($pairList); $i++) {
		if($pairList[$i]['id'] === (int)$id) {
			return $pairList[$i]['pair'];
		}
	}
	return null;
}



?>


