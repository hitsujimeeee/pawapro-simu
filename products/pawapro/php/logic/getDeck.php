<?php

function getDeck($userId, $deckId) {
	$list = array();
	$dbh = DB::connect();
	$data = null;
	try{
		$sql = "
		SELECT
			D.NAME,
			D.TYPE,
			D.SCHOOL,
			D.SUMMARY,
			D.AUTHOR,
			D.GAME_ID,
			D.TWITTER_ID,
			D.CHARA1_ID,
			D.CHARA2_ID,
			D.CHARA3_ID,
			D.CHARA4_ID,
			D.CHARA5_ID,
			D.CHARA6_ID,
			D.CHARA1_LV,
			D.CHARA2_LV,
			D.CHARA3_LV,
			D.CHARA4_LV,
			D.CHARA5_LV,
			D.CHARA6_LV,
			D.CHARA1_RARE,
			D.CHARA2_RARE,
			D.CHARA3_RARE,
			D.CHARA4_RARE,
			D.CHARA5_RARE,
			D.CHARA6_RARE,
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
		WHERE
			D.ID = :deckId
		AND
			D.USER_ID = :userId
		";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('deckId', $deckId);
		$stmt -> bindParam('userId', $userId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row) {
			$data = array(
				'name'=>$row['NAME'],
				'chara'=>array(
				$row['CHARA1_ID'], $row['CHARA2_ID'], $row['CHARA3_ID'], $row['CHARA4_ID'], $row['CHARA5_ID'], $row['CHARA6_ID']
			),
			'lv'=>array(
				$row['CHARA1_LV'], $row['CHARA2_LV'], $row['CHARA3_LV'], $row['CHARA4_LV'], $row['CHARA5_LV'], $row['CHARA6_LV']
			),
			'rare'=>array(
				$row['CHARA1_RARE'], $row['CHARA2_RARE'], $row['CHARA3_RARE'], $row['CHARA4_RARE'], $row['CHARA5_RARE'], $row['CHARA6_RARE']
			),
			'makedChara'=>[],
			'type'=>$row['TYPE'],
			'school'=>$row['SCHOOL'],
			'summary'=>$row['SUMMARY'],
			'author'=>$row['AUTHOR'],
			'gameId'=>$row['GAME_ID'],
			'twitterId'=>$row['TWITTER_ID'],
			'favCount'=>$row['FAV_COUNT']
			);

			$stmt = null;

			$sql = '
			SELECT
				CHARA_ID
			FROM
				DECK_CHARACTER
			WHERE
				DECK_ID = :deckId
			AND
				USER_ID = :userId
			ORDER BY
				NO ASC
			';
		$stmt = $dbh->prepare($sql);
		$stmt -> bindValue('deckId', $deckId);
		$stmt -> bindValue('userId', $userId);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$data['makedChara'][] = $row['CHARA_ID'];
		}
	}



	}catch (PDOException $e){
		die();
	}

	$dbh = null;

	return $data;

}
?>
