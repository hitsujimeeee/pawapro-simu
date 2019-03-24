<?php
require_once 'global.php';
$data = array();
$post = null;
$json = file_get_contents('php://input');
$post = json_decode($json, true);
$basePointNow = $post['now']['basePoint'];
$basePointAim = $post['aim']['basePoint'];
$abilityNow = $post['now']['ability'];
$abilityAim = $post['aim']['ability'];
$trickLevel = $post['trickLevel'];
$StrickLevel = $post['StrickLevel'];
$RtrickLevel = $post['RtrickLevel'];
$subPositionNow = $post['now']['subPosition'];
$subPositionAim = $post['aim']['subPosition'];
$point = array(0, 0, 0, 0, 0);
$pageType = $post['pageType'];
$tyoushi = isset($post['tyoushi']) ? $post['tyoushi'] : null;

try{
	$dbh = DB::connect();

	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sense_per = $post['sense'];
	$magArray = array(1, 0.7, 0.5, 0.4, 0.3, 0.2);

	for($i = 0; $i < count($basePointNow); $i++) {

		//処理する必要がない場合
		if ($basePointAim[$i] <= $basePointNow[$i]){
			continue;
		}

		$mag = 1 - $post['baseTrickLevel'][$i] * 0.02;
		$sql = 'SELECT SUM(IF(D.POWER = 0, 0, GREATEST(FLOOR(D.POWER * ' . $sense_per . ' * ' . $mag . '), 1))) POWER,
				SUM(IF(D.SPEED = 0, 0, GREATEST(FLOOR(D.SPEED * '. $sense_per . ' * ' . $mag . '), 1))) SPEED,
				SUM(IF(D.TECH = 0, 0, GREATEST(FLOOR(D.TECH * '. $sense_per . ' * ' . $mag . '), 1))) TECH,
				SUM(IF(D.SCREWBALL = 0, 0, GREATEST(FLOOR(D.SCREWBALL * '. $sense_per . ' * ' . $mag . '), 1))) SCREWBALL,
				SUM(IF(D.MENTAL = 0, 0, GREATEST(FLOOR(D.MENTAL * '. $sense_per . ' * ' . $mag . '), 1))) MENTAL
				FROM BASE_POINT_HEADER H
				LEFT JOIN BASE_POINT_DETAIL D
				ON H.TYPE = D.TYPE
				AND H.POINT BETWEEN D.POINT_FROM AND D.POINT_TO
				WHERE H.TYPE = ?
				AND H.POINT > ? AND H.POINT <= ?
			';
		$sth = $dbh->prepare($sql);
		$type = $pageType * 7 + $i;
		$sth->bindParam(1, $type, PDO::PARAM_INT);
		$sth->bindParam(2, $basePointNow[$i], PDO::PARAM_INT);
		$sth->bindParam(3, $basePointAim[$i], PDO::PARAM_INT);

		// SQL の実行
		$sth->execute();
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$point[0] += $row['POWER'];
		$point[1] += $row['SPEED'];
		$point[2] += $row['TECH'];
		$point[3] += $row['SCREWBALL'];
		$point[4] += $row['MENTAL'];

		$sth = null;
	}



	//特能計算部分
	$abPoint = array(0, 0, 0, 0, 0);
	$magArray = array(1, 0.7, 0.5, 0.4, 0.3, 0.2);

	for($i = 0; $i < count($abilityNow); $i++) {
		$sql = 'SELECT D.ID,
				D.NAME,
				D.POWER,
				D.SPEED,
				D.TECH,
				D.SCREWBALL,
				D.MENTAL,
				D.LOWER,
				D.UPPER,
				D.TYPE
				FROM ABILITY_HEADER H
				INNER JOIN ABILITY_DETAIL D
				ON H.ID = D.HEADER_ID
				WHERE H.ID = (
					SELECT HEADER_ID
					FROM ABILITY_DETAIL
					WHERE ID = ?
					LIMIT 1
				)
			';



		$sth = $dbh->prepare($sql);
		$id = $abilityNow[$i] ? $abilityNow[$i] : $abilityAim[$i];
		$sth->bindParam(1, $id, PDO::PARAM_STR);

		// SQL の実行
		$sth->execute();
		$abilityGroup = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$abilityGroup[] = array(
				'id'=>$row['ID'],
				'name'=>$row['NAME'],
				'power'=>$row['POWER'],
				'speed'=>$row['SPEED'],
				'tech'=>$row['TECH'],
				'screwball'=>$row['SCREWBALL'],
				'mental'=>$row['MENTAL'],
				'lower'=>$row['LOWER'],
				'upper'=>$row['UPPER'],
				'type'=>$row['TYPE']
			);
		}



		$resetFlag = false;
		$temp = $abilityNow[$i];
		$temp_point = array(0, 0, 0, 0, 0);
		while($temp) {

			$ability = getAbility($abilityGroup, $temp);

			if($ability['type'] !== 2 && $ability['type'] !== 3) {
				break;
			}
			$mag = $magArray[$trickLevel[$i]];//倍率
			$temp_point[0] += (int)($ability['power'] * $mag * $sense_per);
			$temp_point[1] += (int)($ability['speed'] * $mag * $sense_per);
			$temp_point[2] += (int)($ability['tech'] * $mag * $sense_per);
			$temp_point[3] += (int)($ability['screwball'] * $mag * $sense_per);
			$temp_point[4] += (int)($ability['mental'] * $mag * $sense_per);
			$temp = $ability['upper'];
			if ($temp === $abilityAim[$i]) {
				break;
			}
		}

		//不整合検知(チャンス△→チャンス×に変わった場合等に経験点が加算されないように)
		if ($temp === null) {
//			$now_type = getAbility($abilityGroup, $abilityNow[$i])['type'];
			$now_type = getAbility($abilityGroup, $abilityNow[$i]);
			$now_type = $now_type['type'];
			$aim_type = getAbility($abilityGroup, $abilityAim[$i]);
			$aim_type = $aim_type['type'];
			if ($aim_type !== null && ($now_type === 2 || $now_type === 3) && ($aim_type === 2 || $aim_type === 3)) {
				$resetFlag = true;
			}
		}


		$temp = $abilityAim[$i];


		while($temp) {
			$ability = getAbility($abilityGroup, $temp);
			if($ability['type'] === 2 || $ability['type'] === 3) {
				break;
			}
			if ($ability['type'] == '0' || $ability['type'] == '4') {
				$mag = $magArray[$trickLevel[$i]];//倍率
			} else if ($ability['type'] == '1') {
				$mag = $magArray[$StrickLevel[$i]];//倍率
			} else {
				$mag = $magArray[$RtrickLevel[$i]];//倍率
			}
			$temp_point[0] += (int)($ability['power'] * $mag * $sense_per);
			$temp_point[1] += (int)($ability['speed'] * $mag * $sense_per);
			$temp_point[2] += (int)($ability['tech'] * $mag * $sense_per);
			$temp_point[3] += (int)($ability['screwball'] * $mag * $sense_per);
			$temp_point[4] += (int)($ability['mental'] * $mag * $sense_per);
			$temp = $ability['lower'];

			//鉄腕
			if ($ability['id'] === 'S214') {
				if ($tyoushi === null) {
					$temp_point[2] += (int)(20 * $sense_per);
					$temp_point[4] += (int)(30 * $sense_per);
				} else if ($tyoushi === 'G23') {
					$temp_point[2] += (int)(20 * $sense_per) * 2;
					$temp_point[4] += (int)(30 * $sense_per) * 2;
				}
			}

			if ($temp === $abilityNow[$i]) {
				break;
			}
		}


		//不整合検知(チャンス◎→チャンス○に変わった場合等に経験点が加算されないように)
		if ($temp === null) {
			$now_type = getAbility($abilityGroup, $abilityNow[$i]);
			$now_type = $now_type['type'];
			$aim_type = getAbility($abilityGroup, $abilityAim[$i]);
			$aim_type = $aim_type['type'];
			if ($now_type !== null && ($now_type !== 2 && $now_type !== 3) && ($aim_type !== 2 && $aim_type !== 3)) {
				$resetFlag = true;
			}
		}

		if (!$resetFlag) {
			for ($j = 0; $j < count($temp_point); $j++) {
				$abPoint[$j] += $temp_point[$j];
			}
		}
	}

	for ($i = 0; $i < count($abPoint); $i++) {
		$point[$i] += $abPoint[$i];
	}




	//サブポジ部分

	for($i = 0; $i < count($subPositionAim); $i++) {
		if (!$subPositionAim[$i]) {
			continue;
		}

		$sql = '
				SELECT D.ID,
				D.POWER,
				D.SPEED,
				D.TECH,
				D.SCREWBALL,
				D.MENTAL
				FROM SUBPOSITION_HEADER H
				INNER JOIN SUBPOSITION_DETAIL D
				ON H.ID = D.HEADER_ID
				WHERE H.ID = (
					SELECT HEADER_ID
					FROM SUBPOSITION_DETAIL
					WHERE ID = ?
					LIMIT 1
				)
				ORDER BY D.ID
		';


		$sth = $dbh->prepare($sql);
		$sth->bindParam(1, $subPositionAim[$i], PDO::PARAM_INT);

		// SQL の実行
		$sth->execute();
		$group = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$group[] = array(
				'id'=>$row['ID'],
				'power'=>$row['POWER'],
				'speed'=>$row['SPEED'],
				'tech'=>$row['TECH'],
				'screwball'=>$row['SCREWBALL'],
				'mental'=>$row['MENTAL']
			);
		}
		$temp_point = array(0, 0, 0, 0, 0);
		$tempNow = getSubPositonIndex($group, $subPositionNow[$i]);
		$tempAim = getSubPositonIndex($group, $subPositionAim[$i]);
		while ($tempAim >= 0) {
			$row = $group[$tempAim];
			$temp_point[0] += (int)($row['power'] * $sense_per);
			$temp_point[1] += (int)($row['speed'] * $sense_per);
			$temp_point[2] += (int)($row['tech'] * $sense_per);
			$temp_point[3] += (int)($row['screwball'] * $sense_per);
			$temp_point[4] += (int)($row['mental'] * $sense_per);
			$tempAim--;
			if($tempAim == $tempNow) {
				break;
			}
		}

		if (!($tempAim === -1 && $tempNow !== -1)) {

			for ($j = 0; $j < count($temp_point); $j++) {
				$point[$j] += $temp_point[$j];
			}
		}

	}

	//変化球部分
	if($pageType === 1) {
		$changeBallNow = $post['now']['changeBall'];
		$changeBallAim = $post['aim']['changeBall'];
		$NowPointlist = getChangeBallLearningPoint($changeBallNow, $post['changeBallType'], $post['changeBallTrickLevel'], $sense_per, $dbh);
		$AimPointlist = getChangeBallLearningPoint($changeBallAim, $post['changeBallType'], $post['changeBallTrickLevel'], $sense_per, $dbh);
		for($i = 0; $i < count($point); $i++) {
			$point[$i] += max($AimPointlist[$i] - $NowPointlist[$i], 0);
		}
	}

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


$dbh = null;
header('Content-Type: application/json');
echo json_encode($point);

//IDを引数に特能情報を取得
function getAbility($data, $id) {
	foreach($data as $row) {
		if ($row['id'] == $id) {
			return $row;
		}
	}
	return null;
}

//IDを引数に、サブポジのindexを取得
function getSubPositonIndex($data, $id) {
	for($i = 0; $i < count($data); $i++) {
		if ((int)$data[$i]['id'] == (int)$id) {
			return $i;
		}
	}
	return -1;
}


function getLearningChangeBallCount($arr) {
	$count = 0;
	for ($i = 1; $i < count($arr); $i++) {
		if ($arr[$i] > 0) {
			$count++;
		}
	}
	return $count;
}

function getChangeBallLearningPoint($changeLevelArray, $typeArray, $trickLevel, $sense_per, $dbh) {
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
	$sql = '
		SELECT
			SUM(IF(D.POWER = 0, 0, GREATEST(FLOOR(D.POWER * ' . $sense_per . ' * :mag), 1))) POWER,
			SUM(IF(D.SPEED = 0, 0, GREATEST(FLOOR(D.SPEED * '. $sense_per . ' * :mag), 1))) SPEED,
			SUM(IF(D.TECH = 0, 0, GREATEST(FLOOR(D.TECH * '. $sense_per . ' * :mag), 1))) TECH,
			SUM(IF(D.SCREWBALL = 0, 0, GREATEST(FLOOR(D.SCREWBALL * '. $sense_per . ' * :mag), 1))) SCREWBALL,
			SUM(IF(D.MENTAL = 0, 0, GREATEST(FLOOR(D.MENTAL * '. $sense_per . ' * :mag), 1))) MENTAL
		FROM CHANGE_BALL_HEADER H
		INNER JOIN CHANGE_BALL_DETAIL D
		ON H.POINT_TYPE = D.POINT_TYPE
		WHERE H.CATEGORY = :category
		AND H.ID = :id
		AND D.CHANGE_LEVEL <= :changeLevel
		';
	$list = array(0, 0, 0, 0, 0);
	$techBias = array(14, 58, 147, 296);
	$screwBias = array(5, 20, 50, 100);
	$mentalBias = array(8, 30, 75, 150);
	$learningCount = getLearningChangeBallCount($changeLevelArray);

	//第２ストレート部分
	if(!$changeLevelArray) {
		return $list;
	}

	if($changeLevelArray[0] > 0) {
		$sth = $dbh->prepare($sql);
		$sth->bindValue('category', 1, PDO::PARAM_INT);
		$sth->bindValue('id', $typeArray[0], PDO::PARAM_INT);
		$sth->bindValue('changeLevel', $changeLevelArray[0], PDO::PARAM_INT);
		$sth->bindValue('mag', 1, PDO::PARAM_INT);
		$sth->execute();
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$list = array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['SCREWBALL'], (int)$row['MENTAL']);
	}



	for ($i = 1; $i < count($changeLevelArray); $i++) {
		if ($changeLevelArray[$i] > 0) {
			$mag = 1 - $trickLevel[$i] * 0.03;
			$category = $i + 1;

			$sth = $dbh->prepare($sql);
			$sth->bindValue('category', $category, PDO::PARAM_INT);
			$sth->bindValue('id', $typeArray[$i], PDO::PARAM_INT);
			$sth->bindValue('changeLevel', $changeLevelArray[$i], PDO::PARAM_INT);
			$sth->bindValue('mag', $mag, PDO::PARAM_INT);
			$sth->execute();
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			$tempList = array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['SCREWBALL'], (int)$row['MENTAL']);
			for ($j = 0; $j < count($list); $j++) {
				$list[$j] += $tempList[$j];
			}
		}
	}

	if($learningCount >= 2) {
		$mult_lv = getMultiplyChangeLevel($changeLevelArray);
		$list[2] += $techBias[$learningCount-2]+3*$mult_lv;
		$list[3] += 12*($screwBias[$learningCount-2]+$mult_lv);
		$list[4] += $mentalBias[$learningCount-2]+1.5*$mult_lv;
	}

	for($i = 0; $i < count($list); $i++) {
		$list[$i] = (int)$list[$i];
	}
	return $list;
}

function getMultiplyChangeLevel($array) {
	$lv = 0;
	for ($i = 1; $i < count($array); $i++) {
		for ($j = $i + 1; $j < count($array); $j++) {
			$lv += $array[$i] * $array[$j];
		}
	}
	return $lv;
}

?>
