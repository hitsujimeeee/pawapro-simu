<?php
require_once '../global.php';
require_once '../userCommonModule.php';
$userName = '';
$password = '';
if(isset($_POST['userName'])) {
	$userName = $_POST['userName'];
}

if(isset($_POST['password'])) {
	$password = $_POST['password'];
}

$list = array();


$dbh = DB::connect();
try{
	$userId = getID($dbh, $userName, $password);
	if($userId !== null) {
		$sql = "
        SELECT
			D.ID,
			D.USER_ID,
			D.NAME,
			D.CHARA1_ID,
			D.CHARA2_ID,
			D.CHARA3_ID,
			D.CHARA4_ID,
			D.CHARA5_ID,
			D.CHARA6_ID,
			D.CHARA1_RARE,
			D.CHARA2_RARE,
			D.CHARA3_RARE,
			D.CHARA4_RARE,
			D.CHARA5_RARE,
			D.CHARA6_RARE,
			P.NAME TYPE,
			S.NAME SCHOOL,
			IFNULL(FAV_T.C, 0) FAV_COUNT
		FROM
			DECK D
		LEFT JOIN (
			SELECT
				DECK_USER_ID, DECK_ID, COUNT(*) C
			FROM
				DECK_FAVORITE
			WHERE
				DELETE_FLAG = 0
			GROUP BY
				DECK_USER_ID, DECK_ID
		) FAV_T
		ON
			D.ID = FAV_T.DECK_ID
		AND
			D.USER_ID = FAV_T.DECK_USER_ID
		LEFT JOIN
			SCHOOL S
		ON
			D.SCHOOL = S.ID
		LEFT JOIN
			DECK_PLAYER_TYPE P
		ON
			D.TYPE = P.ID
		WHERE
			USER_ID = :userId
		ORDER BY
			ENTRY_DATE DESC
		";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('userId', $userId);
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

			$list[] = array(
				'id'=>$row['ID'],
				'userId'=>$row['USER_ID'],
				'name'=>htmlspecialchars($row['NAME']),
				'chara'=>array(
					$row['CHARA1_ID'],
					$row['CHARA2_ID'],
					$row['CHARA3_ID'],
					$row['CHARA4_ID'],
					$row['CHARA5_ID'],
					$row['CHARA6_ID']
				),
				'rare'=>array(
					$row['CHARA1_RARE'],
					$row['CHARA2_RARE'],
					$row['CHARA3_RARE'],
					$row['CHARA4_RARE'],
					$row['CHARA5_RARE'],
					$row['CHARA6_RARE']
				),
				'targetType'=>$row['TYPE'],
				'school'=>$row['SCHOOL'],
				'favCount'=>$row['FAV_COUNT'],
				'training'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
			);
		}

		$stmt = null;

		for ($i = 0; $i < count($list); $i++) {
			foreach ($list[$i]['chara'] as $c) {
				if($c === null) continue;
				$sql = '
				SELECT
					*
				FROM
					EVENT_CHARACTER
				WHERE
					ID = :id';
				$stmt = $dbh->prepare($sql);
				$stmt -> bindParam('id', $c);
				$stmt->execute();

				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($row['TRAINING_TYPE'] !== null) {
					$trainingType = $row['TRAINING_TYPE'];
					if(strlen($trainingType) > 1) {
						$split = str_split($trainingType);
						foreach ($split as $s) {
							$list[$i]['training'][(int)$s]++;
						}
					} else {
						$list[$i]['training'][(int)$trainingType]++;
					}
				}
			}
		}
	}



}catch (PDOException $e){
	die();
}

$dbh = null;

header('Content-type: application/json');
echo json_encode($list);

?>
