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
$isCatcher = $post['isCather'];
$isFirst = $post['isFirst'];
$isSecond = $post['isSecond'];
$isThird = $post['isThird'];
$nonCatcher = $post['nonCatcher'];	//キャッチャー〇を取得しないフラグ
$nonMoody = isset($post['nonMoody']) ? $post['nonMoody'] : 0;
$expPoint = $post['expPoint'];
array_splice($expPoint, 3, 1);
$sense_per= $post['sense'];
$targetList = array();
$magArray = array(1, 0.7, 0.5, 0.4, 0.3, 0.2);
$abilityList = array();
$pairList = array();

$baseTypeStr = array('DA', 'ME', 'PO', 'SP', 'SH', 'DE', 'CA');
$expPointStr = ['POWER', 'SPEED', 'TECH', 'MENTAL'];

try{
	$dbh = DB::connect();

	for($i = 0; $i < count($basePoint); $i++) {

		if($basePoint[$i] === 0) {
			continue;
		}

		$mag = (1 - $baseTrickLevel[$i] * 0.02) * $sense_per;
		$nowAssessment = null;
		$set = array();
		$point = [0, 0, 0, 0];

		$sql = '
				SELECT
					POINT,
					POWER,
					SPEED,
					TECH,
					MENTAL,
					ASSESSMENT
				FROM
					BASE_POINT_VIEW
				WHERE
					TYPE = :type
				AND
					POINT >= :nowPoint
				AND
					POINT <= :limit
		';

		if ($i === 0) {
			$limit = 4;
		} else {
			$limit = $basePoint[$i] > $baseLimitBreak[$i-1] ? $basePoint[$i] : $baseLimitBreak[$i-1];
		}
		$sth = $dbh->prepare($sql);
		$sth->bindValue('type', $i, PDO::PARAM_INT);
		$sth->bindValue('nowPoint', $basePoint[$i], PDO::PARAM_INT);
		$sth->bindValue('limit', $limit, PDO::PARAM_INT);
		$sth->execute();

		//現在の査定値を取得
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			$nowAssessment = (double)$row['ASSESSMENT'];
			$assessment = $nowAssessment;
		}
		while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$breakFlag = false;
			for ($j = 0; $j < 4; $j++) {
				$point[$j] += (int)$row[$expPointStr[$j]] === 0 ? 0 : (int)(max(bcmul((int)$row[$expPointStr[$j]], $mag, 1), 1));
				if ($point[$j] > $expPoint[$j]) {
					$breakFlag = true;
					break;
				}
			}

			if($breakFlag) {
				break;
			}

			if((double)$row['ASSESSMENT'] > $assessment) {
				$total = $point[0] + $point[1] + $point[2] + $point[3];
				$val = (int)bcmul((double)$row['ASSESSMENT'], 100) - (int)bcmul($nowAssessment, 100);
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
			array_push($targetList, $set);
		}
		$sth = null;
	}

	$catcherPoint = array(0, 0, 0, 0);
	$firstPoint = array(0, 0, 0, 0);
	$secondPoint = array(0, 0, 0, 0);
	$thirdPoint = array(0, 0, 0, 0);

	//キャッチャーでない場合に、キャッチャー○用の必要経験点を取得しておく
	if(!$isCatcher) {
		$sql = '
		SELECT
			POWER,
			SPEED,
			TECH,
			MENTAL
		FROM
			SUBPOSITION_DETAIL
		WHERE
			ID = 1
	';
		$sth = $dbh->query($sql);
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$catcherPoint = array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['MENTAL']);
	}

	//ファーストでない場合に、ファースト○用の必要経験点を取得しておく
	if(!$isFirst) {
		$sql = '
		SELECT
			POWER,
			SPEED,
			TECH,
			MENTAL
		FROM
			SUBPOSITION_DETAIL
		WHERE
			ID = 4
	';
		$sth = $dbh->query($sql);
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$firstPoint = array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['MENTAL']);
	}

	//セカンドでない場合に、セカンド○用の必要経験点を取得しておく
	if(!$isSecond) {
		$sql = '
		SELECT
			POWER,
			SPEED,
			TECH,
			MENTAL
		FROM
			SUBPOSITION_DETAIL
		WHERE
			ID = 7
	';
		$sth = $dbh->query($sql);
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$secondPoint = array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['MENTAL']);
	}

	//サードでない場合に、サード○用の必要経験点を取得しておく
	if(!$isThird) {
		$sql = '
		SELECT
			POWER,
			SPEED,
			TECH,
			MENTAL
		FROM
			SUBPOSITION_DETAIL
		WHERE
			ID = 10
	';
		$sth = $dbh->query($sql);
		$row = $sth->fetch(PDO::FETCH_ASSOC);
		$thirdPoint = array((int)$row['POWER'], (int)$row['SPEED'], (int)$row['TECH'], (int)$row['MENTAL']);
	}

	//特能グループ全取得
	$abilityGroup = array();
	$sql = '
			SELECT ID,
			--NAME,
			CASE CATEGORY
				WHEN 0 THEN 1
				WHEN 1 THEN 1
				WHEN 2 THEN 1
				WHEN 3 THEN 1
				ELSE 0
			END BATTER_ABILITY,
			PAIR
			FROM ABILITY_HEADER
			ORDER BY ID';

	$sth = $dbh->query($sql);

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$abilityGroup[] = array(
			'id'=>(int)$row['ID'],
			//			'name'=>$row['NAME'],
			'flag'=>(int)$row['BATTER_ABILITY'],
			'pair'=>$row['PAIR']
		);
	}
	$sth = null;

	//ペア特能用一時保存配列
	$pairArray = array();

	for ($i = 0; $i <count($abilityGroup); $i++) {
		if($abilityGroup[$i]['flag'] === 0 || ($abilityGroup[$i]['id'] === 6 && $nonCatcher)) {
			continue;
		}

		//気分屋除外
		if($nonMoody && $abilityGroup[$i]['id'] === 38) {
			continue;
		}

		$sql = '
			SELECT D.ID,
			--D.NAME,
			D.POWER,
			D.SPEED,
			D.TECH,
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
				'mental'=>$row['MENTAL'],
				'assessment'=>$row['ASSESSMENT'],
				'upper'=>$row['UPPER'],
				'lower'=>$row['LOWER'],
				'type'=>$row['TYPE']
			);
		}



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
		$valueList = array(0, 0, 0, 0);
		$assessment = 0;

		//キャッチャー特能の場合、サブポジキャッチャー分の経験点も追加
		if($abilityGroup[$i]['id'] === 6) {
			for($j = 0; $j < count($catcherPoint); $j++) {
				$valueList[$j] += (int)($catcherPoint[$j] * $sense_per);
			}
		}

		//ファースト特能の場合、サブポジファースト分の経験点も追加
		if($abilityGroup[$i]['id'] === 147) {
			for($j = 0; $j < count($firstPoint); $j++) {
				$valueList[$j] += (int)($firstPoint[$j] * $sense_per);
			}
		}

		//セカンド特能の場合、サブポジセカンド分の経験点も追加
		if($abilityGroup[$i]['id'] === 150) {
			for($j = 0; $j < count($secondPoint); $j++) {
				$valueList[$j] += (int)($secondPoint[$j] * $sense_per);
			}
		}

		//サード特能の場合、サブポジサード分の経験点も追加
		if($abilityGroup[$i]['id'] === 152) {
			for($j = 0; $j < count($thirdPoint); $j++) {
				$valueList[$j] += (int)($thirdPoint[$j] * $sense_per);
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
						ASSESSMENT,
						TYPE
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
				$assessment -= (int)bcmul((double)$row['ASSESSMENT'], 100);
			}
		}

		while($tempId) {
			$ability = getAbility($abilityList, $tempId);

			//現在の特能が金特かつ金特のコツレベルが0の場合は終了
			if ((int)$ability['type'] === 1 && $nowState['StrickLevel'] === 0 && $nowState['RtrickLevel'] === 0) {
				break;
			}
			//現在の特能が虹特かつ虹特のコツレベルが0の場合は終了
			if ((int)$ability['type'] === 6 && $nowState['RtrickLevel'] === 0) {
				break;
			}
			

			$mag = (int)$ability['type'] === 1 ? $magArray[$nowState['StrickLevel']] : ((int)$ability['type'] === 6 ? $magArray[$nowState['RtrickLevel']] : $magArray[$nowState['trickLevel']]);
			$valueList[0] += (int)($ability['power'] * ($sense_per * $mag));
			$valueList[1] += (int)($ability['speed'] * ($sense_per * $mag));
			$valueList[2] += (int)($ability['tech'] * ($sense_per * $mag));
			$valueList[3] += (int)($ability['mental'] * ($sense_per * $mag));
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

	$baseNowAssessment = (int)bcmul(getAssessmentPointOfBaseAbilityRaw($dbh, $basePoint), 100);
	$abNowAssessment = (int)bcmul(getAssessmentPointOfAbility($dbh, getOwnAbilityList($abilityNow)),100);

	$data = array(
		'targetList'=>$targetList,
		'baseNowAssessment'=>$baseNowAssessment,
		'abNowAssessment'=>$abNowAssessment
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



?>
