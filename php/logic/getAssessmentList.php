<?php

function getAssessmentList($dbh, $type, $spFlag) {

	$category = ['0', '4'][$type];
	$typeStr = ["'0', '4'", "'0', '1', '4'"][$spFlag];

	$List = [];
	$gList = [];

	try{
		$sql = "
		SELECT
			D.ID,
			D.HEADER_ID,
			D.NAME,
			D.POWER,
			D.SPEED,
			D.TECH,
			D.SCREWBALL,
			D.MENTAL,
			D.UPPER,
			D.LOWER,
			D.ASSESSMENT,
			D.TYPE,
			H.SORT_ORDER
		FROM
			ABILITY_DETAIL D
		INNER JOIN
			ABILITY_HEADER H
		ON
			D.HEADER_ID = H.ID
		WHERE
			H.CATEGORY = " . $category . "
		AND
			D.TYPE IN (" . $typeStr . ")
		ORDER BY
			H.SORT_ORDER, D.ID
		";
		$sth = $dbh->query($sql);

		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$point = array(
				(int)$row['POWER'],
				(int)$row['SPEED'],
				(int)$row['TECH'],
				(int)$row['SCREWBALL'],
				(int)$row['MENTAL']
			);
			$assessment = (double)$row['ASSESSMENT'];
			$list[] = array(
				'id'=>$row['ID'],
				'headerId'=>$row['HEADER_ID'],
				'name'=>$row['NAME'],
				'point'=>$point,
				'underPoint'=>[0, 0, 0, 0, 0],
				'assessment'=>$assessment,
				'totalAssessment'=>(double)$row['ASSESSMENT'],
				'upper'=>$row['UPPER'],
				'lower'=>$row['LOWER'],
				'type'=>(int)$row['TYPE'],
				'totalPoint'=>getTotalValue($point, 1),
				'sortOrder'=>(int)$row['SORT_ORDER'],
				'eff'=>array(
					getEff($assessment, $point, 1),
					getEff($assessment, $point, 0.7),
					getEff($assessment, $point, 0.5),
					getEff($assessment, $point, 0.4),
					getEff($assessment, $point, 0.3),
					getEff($assessment, $point, 0.2)
				)
			);

			//サブポジ捕手
			if ($row['ID'] === 'A013') {
				$list[] = array(
					'id'=>'A013X',
					'headerId'=>$row['HEADER_ID'],
					'name'=>$row['NAME'],
					'point'=>$point,
					'underPoint'=>[0, 0, 0, 0, 0],
					'assessment'=>$assessment,
					'totalAssessment'=>(double)$row['ASSESSMENT'],
					'upper'=>$row['UPPER'],
					'lower'=>$row['LOWER'],
					'type'=>(int)$row['TYPE'],
					'totalPoint'=>getTotalValue($point, 1) + 60,
					'sortOrder'=>(int)$row['SORT_ORDER'],
					'eff'=>array(
					getEffSubCather($assessment, $point, 1),
					getEffSubCather($assessment, $point, 0.7),
					getEffSubCather($assessment, $point, 0.5),
					getEffSubCather($assessment, $point, 0.4),
					getEffSubCather($assessment, $point, 0.3),
					getEffSubCather($assessment, $point, 0.2)
				)
				);
			}
		}

		$sth = null;

		//緑特能
		if ($spFlag === 0) {
			$category = ["'5', '7'", "'6', '7'"][$type];

			$sql = "
			SELECT
				D.ID,
				D.HEADER_ID,
				D.NAME,
				D.POWER,
				D.SPEED,
				D.TECH,
				D.SCREWBALL,
				D.MENTAL,
				D.UPPER,
				D.LOWER,
				D.ASSESSMENT,
				D.TYPE,
				H.SORT_ORDER
			FROM
				ABILITY_DETAIL D
			INNER JOIN
				ABILITY_HEADER H
			ON
				D.HEADER_ID = H.ID
			WHERE
				H.CATEGORY IN (" . $category . ")
			AND
				D.ASSESSMENT <> 0
			ORDER BY
				H.SORT_ORDER, D.ID
			";
			$sth = $dbh->query($sql);

			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$point = [0, 0, 0, 0, 0];
				$assessment = (double)$row['ASSESSMENT'];
				$gList[] = array(
					'id'=>$row['ID'],
					'headerId'=>$row['HEADER_ID'],
					'name'=>$row['NAME'],
					'point'=>$point,
					'underPoint'=>[0, 0, 0, 0, 0],
					'assessment'=>$assessment,
					'totalAssessment'=>(double)$row['ASSESSMENT'],
					'upper'=>$row['UPPER'],
					'lower'=>$row['LOWER'],
					'type'=>(int)$row['TYPE'],
					'totalPoint'=>getTotalValue($point, 1),
					'sortOrder'=>(int)$row['SORT_ORDER'],
					'eff'=>array(
					getEff($assessment, $point, 1),
					getEff($assessment, $point, 0.7),
					getEff($assessment, $point, 0.5),
					getEff($assessment, $point, 0.4),
					getEff($assessment, $point, 0.3),
					getEff($assessment, $point, 0.2)
				)
				);
			}

			$sth = null;
		}


	}catch (PDOException $e){
		die();
	}

	$dbh = null;

	//下位含む実査定値を取得
	for ($i = 0; $i < count($list); $i++) {
		if ($list[$i]['lower'] !== null) {
			$ability = getAbility($list, $list[$i]['lower']);
			while($ability) {
				$list[$i]['totalAssessment'] += $ability['assessment'];
				$ability = getAbility($list, $ability['lower']);
			}
		}
	}


	//金特の場合に不要な特能全部除去
	if ($spFlag === 1) {
		for ($i = 0; $i < count($list); $i++) {
			if ($list[$i]['lower'] !== null) {
				$ability = getAbility($list, $list[$i]['lower']);
				while($ability) {
					for ($j = 0; $j < count($ability['point']); $j++) {
						$list[$i]['underPoint'][$j] += $ability['point'][$j];
					}
					$ability = getAbility($list, $ability['lower']);
				}
				$list[$i]['eff'] = array(
					getEffSability($list[$i]['totalAssessment'], $list[$i]['point'], $list[$i]['underPoint'], 1),
					getEffSability($list[$i]['totalAssessment'], $list[$i]['point'], $list[$i]['underPoint'], 0.7),
					getEffSability($list[$i]['totalAssessment'], $list[$i]['point'], $list[$i]['underPoint'], 0.5),
					getEffSability($list[$i]['totalAssessment'], $list[$i]['point'], $list[$i]['underPoint'], 0.4),
					getEffSability($list[$i]['totalAssessment'], $list[$i]['point'], $list[$i]['underPoint'], 0.3),
					getEffSability($list[$i]['totalAssessment'], $list[$i]['point'], $list[$i]['underPoint'], 0.2)
				);
			}
		}
		$list = array_filter($list, "filterSAbility");
	}

	usort($list, $spFlag === 0 ? "sortAbilityList" : "sortAbilityListSP");

	//上位の特能を下位の下にもってく
	for ($i = 0; $i < count($list); $i++) {
		if ($list[$i]['upper'] !== null && $list[$i]['id'] !== 'A013') {
			for ($j = $i; $j < count($list); $j++) {
				if($list[$i]['upper'] === $list[$j]['id']) {
					$ability = array_splice($list, $j, 1);
					array_splice($list, $i+1, 0, $ability);
					break;
				}
			}
			$ability = getAbility($list, $list[$i]['upper']);
		} else if ($list[$i]['id'] == 'A013') {
			for ($j = $i; $j < count($list); $j++) {
				if($list[$j]['id'] == 'A013X') {
					$ability = array_splice($list, $j, 1);
					array_splice($list, $i+1, 0, $ability);
					break;
				}
			}
		}
	}

	foreach($gList as $l) {
		array_push($list, $l);
	}
	return $list;
}


function getTotalValue($list, $mag) {
	$total = 0;
	foreach($list as $l) {
		$total += floor($l * $mag);
	}
	return $total;
}

function getAbility($list, $id) {
	for ($i = 0; $i < count($list); $i++) {
		if ($list[$i]['id'] === $id) {
			return $list[$i];
		}
	}
	return null;
}

function getEff($ass, $point, $mag) {
	$total = getTotalValue($point, $mag);
	if ($total) {
		return $ass/$total;
	}
	return 99999999;
}

function getEffSability($ass, $point, $underPoint, $mag) {
	$total = getTotalValue($point, $mag) + getTotalValue($underPoint, 1);
	if ($total) {
		return $ass/$total;
	}
	return 99999999;
}

function getEffSubCather($ass, $point, $mag) {
	$total = getTotalValue($point, $mag) + 60;
	if ($total) {
		return $ass/$total;
	}
	return 99999999;
}

function sortAbilityList($a, $b){
	$aEff = $a['eff'][0];
	$bEff = $b['eff'][0];
	if($b['assessment'] == 0 && $b['totalPoint'] == 0) {
		return -1;
	}else if($a['assessment'] == 0 && $a['totalPoint'] == 0) {
		return 1;
	}
	if ($bEff > $aEff) {
		return 1;
	} else if ($bEff == $aEff) {
		if ($b['assessment'] > $a['assessment']) {
			return 1;
		} else if ($a['assessment'] > $b['assessment']) {
			return -1;
		}
		return $b['sortOrder'] < $a['sortOrder'] ? 1 : -1;
	}
	return -1;
}


function sortAbilityListSP($a, $b){
	$aEff = $a['eff'][1];
	$bEff = $b['eff'][1];
	if($b['assessment'] == 0 && $b['totalPoint'] == 0) {
		return -1;
	}else if($a['assessment'] == 0 && $a['totalPoint'] == 0) {
		return 1;
	}
	if ($bEff > $aEff) {
		return 1;
	} else if ($bEff == $aEff) {
		if ($b['assessment'] > $a['assessment']) {
			return 1;
		} else if ($a['assessment'] > $b['assessment']) {
			return -1;
		}
		return $b['sortOrder'] < $a['sortOrder'] ? 1 : -1;
	}
	return -1;
}


function filterSAbility($item) {
	return $item['type'] === 1;
}


?>
