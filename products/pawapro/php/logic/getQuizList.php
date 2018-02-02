<?php
require_once '../global.php';


$pageNum = isset($_POST['pageNum']) ? (int)$_POST['pageNum'] : null;
$list = [];

try{
	$dbh = DB::connect();


	$sql = '
		SELECT
			Q.ID,
			CAT.NAME CATEGORY,
			Q.CONTENT,
			Q.OPTION1,
			Q.OPTION2,
			Q.OPTION3,
			Q.OPTION4,
			Q.VOTE_GOOD,
			Q.VOTE_BAD,
			Q.IMAGE,
			Q.USER_NAME,
			Q.TWITTER_ID,
			Q.FIXED_FLAG
		FROM
			QUIZ Q
		INNER JOIN
			QUIZ_CATEGORY CAT
		ON
			Q.CATEGORY = CAT.ID
		WHERE
			Q.DELETE_FLAG = 0
		ORDER BY
			Q.ID
		LIMIT
			' . $pageNum*50 . ', 50
	';



	$sth = $dbh->query($sql);
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$list[] = array(
			'ID'=>(int)$row['ID'],
			'CATEGORY'=>$row['CATEGORY'],
			'CONTENT'=>$row['CONTENT'],
			'OPTIONS'=>array($row['OPTION1'], $row['OPTION2'], $row['OPTION3'], $row['OPTION4']),
			'VOTE_GOOD'=>(int)$row['VOTE_GOOD'],
			'VOTE_BAD'=>(int)$row['VOTE_BAD'],
			'IMAGE'=>(int)$row['IMAGE'],
			'USER_NAME'=>$row['USER_NAME'],
			'TWITTER_ID'=>$row['TWITTER_ID'],
			'FIXED_FLAG'=>$row['FIXED_FLAG']
		);
	}

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	$dbh->rollback();
	die();

}

echo json_encode($list);

?>
