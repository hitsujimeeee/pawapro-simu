
<?php

function getEveCharaList($dbh) {
	try{

		$sql = "
			SELECT
			ID,
			NAME,
			NAME_READ,
			PARENT_ID,
			CHARA_TYPE,
			TRAINING_TYPE,
			EVENT_TYPE
			FROM
			EVENT_CHARACTER
			";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$list = array();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$list[] = array(
				'id'=>$row['ID'],
				'name'=>$row['NAME'],
				'yomi'=>$row['NAME_READ'],
				'parent'=>$row['PARENT_ID'],
				'charaType'=>$row['CHARA_TYPE'],
				'trainingType'=>$row['TRAINING_TYPE'],
				'eventType'=>$row['EVENT_TYPE']
			);
		}

	}catch (PDOException $e){
		die();
	}
	$dbh = null;
	return $list;
}

?>
