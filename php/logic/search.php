<?php
require_once '../global.php';
require_once '../userCommonModule.php';

$deckName = $_POST['deckName'];
$targetType = (int)$_POST['targetType'];
$school = (int)$_POST['school'];
$evChara = $_POST['evChara'];
$author = $_POST['author'];
$twitter = $_POST['twitter'];
$sortOrder = (int)$_POST['sortOrder'];
$sortDir = (int)$_POST['sortDir'] === 0 ? 'DESC' : 'ASC';
$favCheck = json_decode($_POST['favCheck']);
$userName = $_POST['userName'];
$password = $_POST['password'];
$pageNumber = (int)$_POST['pageNum'];
$DISPLAY_COUNT = 10;
$offset = (int)($pageNumber*$DISPLAY_COUNT);

$list = array();
$count = 0;

try{

	$dbh = DB::connect();

	$userId = null;
	if($favCheck) {
		$userId = getId($dbh, $userName, $password);
		if(!$userId) {
			$userId = -1;
		}
	}

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
		D.AUTHOR,
		D.TWITTER_ID,
		IFNULL(FAV_T.C, 0) FAV_COUNT
	FROM
		DECK D
	INNER JOIN
		DECK_PLAYER_TYPE P
	ON
		D.TYPE = P.ID
	INNER JOIN
		SCHOOL S
	ON
		D.SCHOOL = S.ID
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
	";

	$condStr = '';

	if($favCheck) {
		$condStr .= "
		INNER JOIN (
			SELECT
				DECK_USER_ID,
				DECK_ID
			FROM
				DECK_FAVORITE
			WHERE
				FAV_USER_ID = :favUserId
		) F
		ON
			D.USER_ID = F.DECK_USER_ID
		AND
			D.ID = F.DECK_ID
		";
	}

	$condStr .= "
	WHERE
		PRIVATE_FLAG = 0";


	if (trim($deckName) !== "") {
		$condStr .= "
		AND
			D.NAME LIKE :deckName
		";
	}

	if ($targetType !== 0) {
		$condStr .= "
		AND
			D.TYPE = :targetType
		";
	}

	if ($school !== 0) {
		$condStr .= "
		AND
			D.SCHOOL = :school
		";
	}

	if ($evChara !== '') {
		$condStr .= "
		AND
			(
				D.CHARA1_ID = :evChara
			OR
				D.CHARA2_ID = :evChara
			OR
				D.CHARA3_ID = :evChara
			OR
				D.CHARA4_ID = :evChara
			OR
				D.CHARA5_ID = :evChara
			OR
				D.CHARA6_ID = :evChara
			)
		";
	}

	if (trim($author) !== "") {
		$condStr .= "
		AND
			D.AUTHOR = :author
		";
	}

	if (trim($twitter) !== "") {
		$condStr .= "
		AND
			D.TWITTER_ID = :twitter
		";
	}

	$sql .= $condStr;

	$sql .= "
	ORDER BY
		";
	switch($sortOrder) {
		case 1:
			$sql .= "IFNULL(D.RENEW_DATE, D.ENTRY_DATE) " . $sortDir;
			break;
		case 2:
			$sql .= "FAV_T.C " . $sortDir;
			break;
		default:
			$sql .= "D.ENTRY_DATE " . $sortDir;
			break;
	}
	$sql .= "
	LIMIT {$DISPLAY_COUNT}
	OFFSET {$offset}
	";

	$stmt = $dbh->prepare($sql);

	if(trim($deckName) !== "") {
		$serachDeckName = '%' . $deckName . '%';
		$stmt -> bindValue('deckName', $serachDeckName);
	}
	if($targetType !== 0) {
		$stmt -> bindValue('targetType', $targetType);
	}
	if($school !== 0) {
		$stmt -> bindValue('school', $school);
	}
	if($evChara !== '') {
		$stmt -> bindValue('evChara', $evChara);
	}
	if(trim($author) !== "") {
		$stmt -> bindValue('author', $author);
	}
	if(trim($twitter) !== "") {
		$stmt -> bindValue('twitter', $twitter);
	}
	if ($favCheck) {
		$stmt -> bindValue('favUserId', $userId);
	}

	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
			'author'=>htmlspecialchars($row['AUTHOR']),
			'twitterId'=>htmlspecialchars($row['TWITTER_ID']),
			'targetType'=>$row['TYPE'],
			'school'=>$row['SCHOOL'],
			'favCount'=>$row['FAV_COUNT'],
			'training'=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		);
	}


	$sql = '
	SELECT
		COUNT(*) C
	FROM
		DECK D
	';

	$sql .= $condStr;

	$stmt = $dbh->prepare($sql);

	if(trim($deckName) !== "") {
		$serachDeckName = '%' . $deckName . '%';
		$stmt -> bindValue('deckName', $serachDeckName);
	}
	if($targetType !== 0) {
		$stmt -> bindValue('targetType', $targetType);
	}
	if($school !== 0) {
		$stmt -> bindValue('school', $school);
	}
	if($evChara !== '') {
		$stmt -> bindValue('evChara', $evChara);
	}
	if(trim($author) !== "") {
		$stmt -> bindValue('author', $author);
	}
	if(trim($twitter) !== "") {
		$stmt -> bindValue('twitter', $twitter);
	}
	if ($favCheck) {
		$stmt -> bindValue('favUserId', $userId);
	}

	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$count = (int)$row['C'];


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
			$stmt -> bindValue('id', $c);
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

}catch (PDOException $e){
	die();
}

$data = array(
	'list'=>$list,
	'count'=>$count
);

$dbh = null;
header('Content-type: application/json');
echo json_encode($data,JSON_UNESCAPED_UNICODE);
