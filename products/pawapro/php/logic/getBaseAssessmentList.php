<?php

function getBaseAssessmentList($dbh, $type) {

	$typeList = [[0, 1, 2, 3, 4, 5, 6], [7, 8, 9]][$type];

	$List = [];

	try{

		for ($i = 0; $i < count($typeList); $i++) {
			$sql = "
			SELECT
				POINT,
				POWER,
				SPEED,
				TECH,
				SCREWBALL,
				MENTAL,
				ASSESSMENT
			FROM
				BASE_POINT_VIEW
			WHERE
				TYPE = " . $typeList[$i] . "
			ORDER BY
				POINT
			";

			$sth = $dbh->query($sql);

			$preAs = null;
			$set = [];
			$totalExp = 0;
			$allExp = 0;
			$borderAss = 0;

			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$expPoint = array(
					(int)$row['POWER'],
					(int)$row['SPEED'],
					(int)$row['TECH'],
					(int)$row['SCREWBALL'],
					(int)$row['MENTAL']
				);
				$totalVal = getTotalValue($expPoint, 1);

				$totalExp += $totalVal;
				if((int)$row['POINT'] === 30) {
					$borderAs = (double)$row['ASSESSMENT'];
				}
				if ((int)$row['POINT'] > 30) {
					$allExp += $totalVal;
				}




				$assessment = (double)$row['ASSESSMENT'];
				$dAss = $assessment - $preAs;	//前回査定切り替え地点との査定値の差
				$set[] = array(
					'point'=>(int)$row['POINT'],
					'assessment'=>$assessment,
					'totalPoint'=>$totalExp,
					'dAss'=>$dAss,
					'eff'=>($preAs === null || $preAs === $assessment ? null : $dAss / $totalExp),
					'allEff'=>$allExp !== 0 && $preAs !== $assessment ? ($assessment-$borderAs) / $allExp : null
				);

				if($preAs === null || $preAs !== $assessment) {
					$totalExp = 0;
				}

				$preAs = $assessment;
			}

			$list[] = $set;

			$sth = null;
		}


	}catch (PDOException $e){
		die();
	}

	$dbh = null;

	return $list;
}


function getTotalValue($list, $mag) {
	$total = 0;
	foreach($list as $l) {
		$total += floor($l * $mag);
	}
	return $total;
}

function getEff($ass, $point, $mag) {
	$total = getTotalValue($point, $mag);
	if ($total) {
		return $ass/$total;
	}
	return 99999999;
}


?>
