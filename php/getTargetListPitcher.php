<?php
require_once 'global.php';
require_once "getAssessmentPointFunc.php";


$data = array();

$json = file_get_contents('php://input');
$post = json_decode($json, true);
$basePoint = $post['basePoint'];
$abilityNow = $post['ability'];
$baseTrickLevel = $post['baseTrickLevel'];
$baseLimitBreak = $post['baseLimitBreak'];
$changeBallType = $post['changeBallType'];
$changeBallValue = $post['changeBallValue'];

$expPoint = $post['expPoint'];
$sense_per= $post['sense'];
$abilityOnly = $post['abilityOnly'];
$nonStamina = $post['nonStamina'];
$targetList = array();
$baseTargetList = array();
$magArray = array(1, 0.7, 0.5, 0.4, 0.3, 0.2);
$abilityList = array();
$pairList = array();

$baseTypeStr = array('SP', 'CO', 'ST');
$expPointStr = ['POWER', 'SPEED', 'TECH', 'SCREWBALL', 'MENTAL'];
$pointList = null;

$nowBaseAssessment = 0;
$outsideFlag = false;


try{
	$dbh = DB::connect();

	$total = array_sum($changeBallValue);

	//変化球の組み合わせとポイントの対応表取得
	$sql = 'SELECT ITEM, POINT FROM CHANGE_BALL_POINT WHERE TOTAL >=' . $total;
	$sth = $dbh->query($sql);
	$dictionary = $sth->fetchAll();

	//ポイント→査定値の対応表取得
	$pointList = [];
	$sql = 'SELECT VALUE FROM PITCHER_POINT_VALUE ORDER BY POINT';
	$sth = $dbh->query($sql);
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$pointList[] = (int)$row['VALUE'];
	}

	if (!$abilityOnly) {
		$nowBaseAssessment = getChangeBallAssessmentPoint($dbh, $changeBallType, $changeBallValue, $dictionary);

		if ($nowBaseAssessment === 0) {
			$outsideFlag = true;
		}

		for($i = 0; $i < count($basePoint); $i++) {

			if($basePoint[$i] === 0) {
				continue;
			}

			$mag = (1 - $baseTrickLevel[$i] * 0.02) * $sense_per;
			$set = array();
			$nowAssessment = null;
			$point = [0, 0, 0, 0, 0];

			$sql = '
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
				TYPE = :type
			AND
				POINT >= :nowPoint
			AND
				POINT <= :limit';

			$limit = $basePoint[$i] > $baseLimitBreak[$i] ? $basePoint[$i] : $baseLimitBreak[$i];
			$sth = $dbh->prepare($sql);
			$sth->bindValue('type', $i+7, PDO::PARAM_INT);
			$sth->bindValue('nowPoint', $basePoint[$i], PDO::PARAM_INT);
			$sth->bindValue('limit', $limit, PDO::PARAM_INT);
			$sth->execute();

			//現在の査定値を取得
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			if ($row) {
				$nowBaseAssessment += (double)$row['ASSESSMENT'];
				$nowAssessment = (double)$row['ASSESSMENT'];
				$assessment = $nowAssessment;
			}

			if ($i === 2 && $nonStamina) {
				continue;
			}


			while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
				$breakFlag = false;

				//取得に必要な総経験点を加算
				//残り経験点を超えたら終了
				for ($j = 0; $j < 5; $j++) {
					$point[$j] += (int)$row[$expPointStr[$j]] === 0 ? 0 : (int)(max(bcmul((int)$row[$expPointStr[$j]], $mag, 1), 1));
					if ($point[$j] > $expPoint[$j]) {
						$breakFlag = true;
						break;
					}
				}

				if($breakFlag) {
					break;
				}

				//査定値が切り替わるタイミングでtargetListに追加する
				if((double)$row['ASSESSMENT'] > $assessment) {
					$total = $point[0] + $point[1] + $point[2] + $point[3] + $point[4];
					$val = (int)($row['ASSESSMENT'] - $nowAssessment);
					$set[] = array(
						'id'=>$baseTypeStr[$i] . $row['POINT'],
						'type'=>0,
						'point'=>$point,
						'val'=>$val,
						'eff'=>$val/(double)$total
					);
					$assessment = (double)$row['ASSESSMENT'];
				}

			}
			if(count($set) > 0) {
				usort($set, "compAssessmentEfficiency");
				array_push($baseTargetList, $set);
			}
			$sth = null;
		}

		if ($pointList[$nowBaseAssessment] !== 0) {
			for ($i = 0; $i < count($baseTargetList); $i++) {
				for ($j = 0; $j < count($baseTargetList[$i]); $j++) {
					$total = array_reduce($baseTargetList[$i][$j]["point"], "sum");
					$targetVal = $baseTargetList[$i][$j]["val"] + $nowBaseAssessment;
					$val = $pointList[$targetVal] - $pointList[$nowBaseAssessment];
					$baseTargetList[$i][$j]["eff"] = ($val*100)/$total;
				}
			}

			for ($i = 0; $i < count($baseTargetList); $i++) {
				usort($baseTargetList[$i], "compAssessmentEfficiency");
			}
			usort($baseTargetList, 'compAssessmentEfficiencyAll');

			$targetList = $baseTargetList;
		} else {
			$outsideFlag = true;
		}
	} else {
		$baseTargetList = null;
	}



	//特能グループ全取得
	$abilityGroup = array();
	$sql = '
			SELECT ID,
			--NAME,
			CASE CATEGORY
				WHEN 4 THEN 1
				WHEN 5 THEN 1
				ELSE 0
			END PITCHER_ABILITY,
			PAIR
			FROM ABILITY_HEADER
			ORDER BY ID';

	$sth = $dbh->query($sql);

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$abilityGroup[] = array(
			'id'=>(int)$row['ID'],
			//			'name'=>$row['NAME'],
			'flag'=>(int)$row['PITCHER_ABILITY'],
			'pair'=>$row['PAIR']
		);
	}
	$sth = null;

	//ペア特能用一時保存配列
	$pairArray = array();

	for ($i = 0; $i <count($abilityGroup); $i++) {
		if($abilityGroup[$i]['flag'] === 0) {
			continue;
		}

		$sql = '
			SELECT D.ID,
			--D.NAME,
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
			ORDER BY FIELD(D.TYPE, 3, 2, 4, 0, 1) DESC,
			(LOWER IS NULL) DESC';

		$sth = $dbh->prepare($sql);
		$sth->bindParam(1, $abilityGroup[$i]['id'], PDO::PARAM_INT);
		$sth->execute();
		$abilityList = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$abilityList[] = array(
				'id'=>$row['ID'],
				//				'name'=>$row['NAME'],
				'power'=>$row['POWER'],
				'speed'=>$row['SPEED'],
				'tech'=>$row['TECH'],
				'screwball'=>$row['SCREWBALL'],
				'mental'=>$row['MENTAL'],
				'assessment'=>$row['ASSESSMENT'],
				'upper'=>$row['UPPER'],
				'lower'=>$row['LOWER'],
				'type'=>$row['TYPE']
			);
		}

//		var_dump($abilityGroup[$i]['id']);


		$nowState = $abilityNow[$i];

		//現在の特能の状態によってスタート地点($tempId)を変える
		if ($nowState['id'] === null) {
			$tempId = getStartAbility($abilityList);
		} else {
			$ability = getAbility($abilityList, $nowState['id']);

			if((int)$ability['type'] !== 2 && (int)$ability['type'] !== 3) {
				//赤特能の場合は
				$tempId = $ability['upper'];
			} else {
				$tempId = $nowState['id'];
			}
		}
		$set = array();
		$valueList = array(0, 0, 0, 0, 0);
		$assessment = 0;

		//鉄腕
		if ((int)$abilityGroup[$i]['id'] === 88) {
			if ($abilityNow[132] === null || $abilityNow[132]['id'] === null) {
				$valueList[2] += (int)(20 * $sense_per);
				$valueList[4] += (int)(30 * $sense_per);
			} else if ($abilityNow[132]['id'] === 'G23') {
				$valueList[2] += (int)(20 * $sense_per) * 2;
				$valueList[4] += (int)(30 * $sense_per) * 2;
			}
		}

		//打ち消し合うタイプの特能を既に習得している場合、査定値にマイナス補正を掛ける。
		if($abilityGroup[$i]['pair'] !== null) {
			$pairList[] = array(
				'id'=>$abilityGroup[$i]['id'],
				'pair'=>(int)$abilityGroup[$i]['pair']
			);
			if($abilityNow[$abilityGroup[$i]['pair']]['id'] !== null) {
				$sql = '
					SELECT
						assessment,
						type
					FROM
						ABILITY_DETAIL
					WHERE
						ID = ?
					LIMIT 1
				';
				$sth = $dbh->prepare($sql);
				$sth->bindParam(1, $abilityNow[$abilityGroup[$i]['pair']]['id'], PDO::PARAM_STR);
				$sth->execute();
				$row = $sth->fetch(PDO::FETCH_ASSOC);
				$assessment -= (int)bcmul((double)$row['assessment'], 100);
			}
		}

		while($tempId) {
			$ability = getAbility($abilityList, $tempId);

			//現在の特能が金特かつ金特のコツレベルが0の場合は終了
			if ((int)$ability['type'] === 1 && $nowState['StrickLevel'] === 0) {
				break;
			}

			$mag = (int)$ability['type'] === 1 ? $magArray[$nowState['StrickLevel']] : $magArray[$nowState['trickLevel']];
			for ($j = 0; $j < count($valueList); $j++) {
				$valueList[$j] += (int)($ability[mb_strtolower($expPointStr[$j])] * ($sense_per * $mag));
			}
			$assessment += (int)bcmul((double)$ability['assessment'], 100);

			$stopFlag = false;
			//手持ちの経験点内に収まるかチェック
			for ($j = 0; $j < count($expPoint); $j++) {
				if ($valueList[$j] > $expPoint[$j]) {
					$stopFlag = true;
				}
			}

			if ($stopFlag === true) {
				break;
			}

			$total = array_sum($valueList);
			if ($total !== 0 && $assessment > 0) {
				$set[] = array(
					//					'idx'=>$i,
					'id'=>$i . $ability['id'],
					'type'=>1,
					'point'=>$valueList,
					'val'=>$assessment,
					'eff'=>$assessment/(double)$total,
					'total'=>$total
				);
			}
			$tempId = $ability['upper'];
			if (!$tempId && ($ability['type'] == '2' || $ability['type'] == '3')) {
				$tempId = getStartAbility($abilityList);
			}
		}
		if(count($set) > 0) {
			//ペア特能の場合は、ペアリスト内にペアの特能がセットがあるかチェック。
			//ある場合はsetに追加する
			if($abilityGroup[$i]['pair'] !== null) {
				$pairExistFlag = false;
				for($j = 0; $j < count($pairArray); $j++) {
					if ($pairArray[$j]['pairId'] === (int)$abilityGroup[$i]['pair']) {
						$pairArray[$j]['set'] = array_merge($set, $pairArray[$j]['set']);
						$pairExistFlag = true;
						break;
					}
				}
				if(!$pairExistFlag) {
					$pairArray[] = array('pairId'=>$abilityGroup[$i]['id'], 'set'=>$set);
				}
			} else {
				usort($set, "compAssessmentEfficiency");
				array_push($targetList, $set);
			}
		}

	}

	foreach($pairArray as $pArray) {
		$pairSet = $pArray['set'];
		usort($pairSet, "compAssessmentEfficiency");
		array_push($targetList, $pairSet);
	}

	usort($targetList, 'compAssessmentEfficiencyAll');

//	$baseNowAssessment = (int)bcmul(getAssessmentPointOfBaseAbilityRaw($dbh, $basePoint), 100);
	$abNowAssessment = (int)bcmul(getAssessmentPointOfAbility($dbh, getOwnAbilityList($abilityNow)),100);

	$data = array(
		'targetList'=>$targetList,
		'baseTargetList'=>$baseTargetList,
		'baseNowAssessment'=>$nowBaseAssessment,
		'abNowAssessment'=>$abNowAssessment,
		'pointList'=>$pointList,
		'outsideFlag'=>$outsideFlag
	);



}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}



$dbh = null;
header('Content-Type: application/json');
echo json_encode($data);


function getOwnAbilityList($list) {
	$newList = array();
	foreach($list as $l) {
		if($l['id']) {
			$newList[] = $l['id'];
		}
	}
	return $newList;
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

//特能グループから、起点となる特能を探し、idを返す。
function getStartAbility($list) {
	foreach($list as $row) {
		if ($row['lower'] === null && ($row['type'] === '0' || $row['type'] === '1' || $row['type'] === '4')) {
			return $row['id'];
		}
	}
}

//査定効率でソート用
function compAssessmentEfficiency($v1, $v2) {
	return $v2['eff'] >= $v1['eff'] ? 1 : -1;
}


//全体を査定効率でソート用
function compAssessmentEfficiencyAll($v1, $v2) {
	return $v2[0]['eff'] >= $v1[0]['eff'] ? 1 : -1;
}

function getMatchCount($arr, $target) {
	$count = 0;
	for ($i = 0; $i < count($arr); $i++) {
		if ($arr[$i] === $target) {
			$count++;
		}
	}
	return $count;
}


?>
