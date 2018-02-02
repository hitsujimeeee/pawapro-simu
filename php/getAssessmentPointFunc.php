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

function getChangeBallAssessmentPoint($dbh, $changeBallType, $changeBallValue) {
	//変化球の総変量を求める
	$totalChangeValue = array_reduce($changeBallValue, "sum") - $changeBallValue[0];

	$typeList = array(
		array("2", "2", "1", "0"),
		array("A", "B", "A", "0"),
		array("B", "B", "B", "B", "B", "C", "0"),
		array("B", "A", "C", "B", "D", "B", "0"),
		array("B", "B", "C", "0"),
		array("A", "A", "0")
	);

	$cList = array();
	for ($i = 0; $i < count($changeBallType); $i++) {
		if ($changeBallValue[$i] > 0) {
			$cList[] = array(
				'type'=> $typeList[$i][$changeBallType[$i]-1],
				'value'=> $changeBallValue[$i]
			);
		}
	}


	//var_dump($cList);
	$changeTypeCount = count($cList) - 1;
	$matchCountA = 0;
	$matchCountB = 0;

	for ($i = 0; $i < count($cList); $i++) {
		switch($cList[$i]["type"]) {
			case "A":
				$matchCountA++;
				break;
			case "B":
				$matchCountB++;
				break;
		}
	}


	$nowBaseAssessment = 0;



	if ($changeTypeCount === 2) {
		switch($totalChangeValue) {
			case 12:
				if ($matchCountA === 2 && $cList[1]['value'] === 6) {
					//A6A6
					$nowBaseAssessment = 69 + (int)$cList[0]['type'] - 1;
				} else if ($matchCountA === 1 && $matchCountB === 1 && $cList[1]['value'] === 6) {
					//A6B6
					$nowBaseAssessment = 70 + (int)$cList[0]['type'] - 1;
				} else if ($matchCountB === 2) {
					//B6B6
					//今は無し
				}
				break;
			case 13:
				if ($matchCountA === 2 && $changeTypeCount === 2) {
					//A6A7
					if ($cList[1]['value'] === 6 || $cList[1]['value'] === 7) {
						$nowBaseAssessment = 73 + (int)$cList[0]['type'] - 1;
					}
				} else if ($matchCountA === 1 && $matchCountB === 1) {
					//A7B6
					if (($cList[1]['type'] === 'A' && $cList[1]['value'] === 7) || ($cList[2]['type'] === 'A' && $cList[2]['value'] === 7)) {
						$nowBaseAssessment = 74 + (int)$cList[0]['type'] - 1;
					}
				} else if ($matchCountB === 2) {
					//B7B6
					//今は無し
				}
				break;
			case 14:
				if ($matchCountA === 2 && $cList[1]['value'] === 7) {
					//A7A7
					$nowBaseAssessment = 77 + (int)$cList[0]['type'] - 1;
				} else if ($matchCountA === 1 && $matchCountB === 1) {
					//A7B7
					$nowBaseAssessment = 78 + (int)$cList[0]['type'] - 1;
				} else if ($matchCountB === 2 && $cList[1]['value'] === 7) {
					//B7B7
					$nowBaseAssessment = 79 + (int)$cList[0]['type'] - 1;
				}
				break;
		}
	} else if ($changeTypeCount === 3) {

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
