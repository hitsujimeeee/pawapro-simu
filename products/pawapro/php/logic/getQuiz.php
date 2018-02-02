<?php
require_once '../global.php';

$data = [];


try{
	$dbh = DB::connect();


	$sql = '
	SELECT
		ID
	FROM
		QUIZ
	WHERE
		FIXED_FLAG = 1
	AND
		DELETE_FLAG = 0
	';

	$sth = $dbh->query($sql);
	$idList = [];

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		array_push($idList, (int)$row['ID']);
	}

	$count = (int)$row['C'];

	$i = 10;
	$list = [];

	while ($i > 0 && count($idList) > 0) {
		$rand = mt_rand(0, count($idList)-1);
		array_push($list, array_splice($idList, $rand, 1)[0]);
		$i--;
	}

	$str = implode(',', $list);

	$sql = '
		SELECT
			Q.ID,
			CAT.NAME CATEGORY,
			Q.CONTENT,
			Q.OPTION1,
			Q.OPTION2,
			Q.OPTION3,
			Q.OPTION4,
			Q.ANSWER,
			Q.COMMENTS,
			Q.VOTE_GOOD,
			Q.VOTE_BAD,
			Q.IMAGE,
			Q.USER_NAME,
			Q.TWITTER_ID,
			Q.CORRECT*100/(Q.CORRECT+Q.FAILED) PERCENT
		FROM
			QUIZ Q
		INNER JOIN
			QUIZ_CATEGORY CAT
		ON
			Q.CATEGORY = CAT.ID
		WHERE
			Q.FIXED_FLAG = 1
		AND
			Q.DELETE_FLAG = 0
		AND
			Q.ID IN (' . $str . ')
		ORDER BY
			FIELD(Q.ID, ' . $str . ')
		';

	$sth = $dbh->query($sql);


	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

		$data[] = array(
			'ID'=>(int)$row['ID'],
			'CATEGORY'=>$row['CATEGORY'],
			'CONTENT'=>$row['CONTENT'],
			'OPTIONS'=>array($row['OPTION1'], $row['OPTION2'], $row['OPTION3'], $row['OPTION4']),
			'ANSWER'=>(int)$row['ANSWER'],
			'COMMENTS'=>$row['COMMENTS'],
			'VOTE_GOOD'=>(int)$row['VOTE_GOOD'],
			'VOTE_BAD'=>(int)$row['VOTE_BAD'],
			'IMAGE'=>(int)$row['IMAGE'],
			'USER_NAME'=>$row['USER_NAME'],
			'TWITTER_ID'=>$row['TWITTER_ID'],
			'PERCENT'=>(double)$row['PERCENT']
		);
	}
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

echo json_encode($data);

?>
