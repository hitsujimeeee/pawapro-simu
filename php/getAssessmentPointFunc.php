<?php

//基礎能力の査定値取得
function getAssessmentPointOfBaseAbility($dbh, $basePointAim) {
	$point = 0;
	for ($i = 0; $i < count($basePointAim); $i++) {

		$sql = 'SELECT ASSESSMENT
			FROM BASE_POINT_HEADER
			WHERE TYPE = ?
			AND POINT = ?
			LIMIT 1';

		$sth = $dbh->prepare($sql);

		$sth->bindParam(1, $i, PDO::PARAM_INT);
		$sth->bindParam(2, $basePointAim[$i], PDO::PARAM_INT);

		// SQL の実行
		$sth->execute();
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$point += $row['ASSESSMENT'];
		$sth = null;
	}
	$point = $point + 7.84 * round($point / 47.04) + 11.27;
	return $point;
}



//基礎能力の査定値取得(総査定値ボーナスを行わない)
function getAssessmentPointOfBaseAbilityRaw($dbh, $basePointAim) {
	$point = 0;
	for ($i = 0; $i < count($basePointAim); $i++) {

		$sql = 'SELECT ASSESSMENT
			FROM BASE_POINT_HEADER
			WHERE TYPE = ?
			AND POINT = ?
			LIMIT 1';

		$sth = $dbh->prepare($sql);

		$sth->bindParam(1, $i, PDO::PARAM_INT);
		$sth->bindParam(2, $basePointAim[$i], PDO::PARAM_INT);

		// SQL の実行
		$sth->execute();
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$point += $row['ASSESSMENT'];
		$sth = null;
	}
	return $point;
}

function getChangeBallAssessmentPoint($dbh, $changeBallType, $changeBallValue, $dictionary) {
	//変化球の総変量を求める
	$totalChangeValue = array_reduce($changeBallValue, "sum") - $changeBallValue[0];

	$typeList = array(
		array("1", "2", "1", "0"),
		array("A", "B", "A", "0"),
		array("B", "B", "B", "B", "B", "C", "0"),
		array("B", "A", "C", "B", "D", "B", "0"),
		array("B", "B", "C", "0"),
		array("A", "A", "0")
	);

	$cList = [];

	for ($i = 0; $i < count($changeBallType); $i++) {
		if ($changeBallValue[$i] > 0) {
			if ($i === 0) {
				$cList[] = $typeList[$i][$changeBallType[$i]-1];
			} else {
				$cList[] = $typeList[$i][$changeBallType[$i]-1] . $changeBallValue[$i];
			}
		}
	}

	asort($cList);
	$cStr = implode($cList);

	$nowBaseAssessment = 0;

	for ($i = 0; $i < count($dictionary); $i++) {
		if ($dictionary[$i]['ITEM'] === $cStr) {
			$nowBaseAssessment = (int)$dictionary[$i]['POINT'];
		}
	}

	return $nowBaseAssessment;
}




//基礎能力の査定値取得(総査定値ボーナスを行わない)
function getAssessmentPointOfBaseAbilityPitcher($dbh, $basePointAim) {
	$point = 0;
	for ($i = 0; $i < count($basePointAim); $i++) {

		$sql = 'SELECT ASSESSMENT
			FROM BASE_POINT_HEADER
			WHERE TYPE = ?
			AND POINT = ?
			LIMIT 1';

		$sth = $dbh->prepare($sql);


		$idx = ($i+7);
		$sth->bindParam(1, $idx, PDO::PARAM_INT);
		$sth->bindParam(2, $basePointAim[$i], PDO::PARAM_INT);

		// SQL の実行
		$sth->execute();
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$point += $row['ASSESSMENT'];
		$sth = null;
	}
	return $point;
}


//特能の査定値取得
function getAssessmentPointOfAbility($dbh, $abilityAim) {
	$point = 0;
	for($i = 0; $i < count($abilityAim); $i++) {
		$sql = 'SELECT D.ID,
			D.LOWER,
			D.UPPER,
			D.ASSESSMENT,
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
		$sth->bindParam(1, $abilityAim[$i], PDO::PARAM_STR);

		// SQL の実行
		$sth->execute();
		$abilityGroup = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$abilityGroup[] = array(
			'id'=>$row['ID'],
			'lower'=>$row['LOWER'],
			'upper'=>$row['UPPER'],
			'assessment'=>$row['ASSESSMENT'],
			'type'=>$row['TYPE']
			);
		}


		$temp = $abilityAim[$i];

		while($temp) {
			$ability = getAbility($abilityGroup, $temp);
			if($ability['type'] === 2 || $ability['type'] === 3) {
				break;
			}
			$point += $ability['assessment'];
			$temp = $ability['lower'];
		}
	}
	return $point;
}

//渡された査定値から、選手ランクを取得
function getAssessmentRank($dbh, $point) {
	$sql = 'SELECT RANK_STR, POINT_FROM
			FROM ASSESSMENT_RANK
			WHERE POINT_FROM <= ' . $point  . '
			AND POINT_TO > ' . $point;

	$sth = $dbh->prepare($sql);
	$sth->execute();
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	if($row) {
		return $row['RANK_STR'];
	}
	return null;
}


//渡された査定値から、ゲージの長さを取得
function getAssessmentMeterLength($dbh, $point) {
	$sql = 'SELECT RANK_STR, POINT_FROM
			FROM ASSESSMENT_RANK
			WHERE POINT_FROM <= ' . $point  . '
			AND POINT_TO > ' . $point;

	$sth = $dbh->prepare($sql);
	$sth->execute();
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	if($row) {
		if($row['RANK_STR'] === 'G') {
			return 0;
		} else {
			return (($point - (int)($row['POINT_FROM'])) / 14) * 10;
		}
	}
	return null;
}


function sum($pre, $cur) {
	return $pre + $cur;
}


?>
