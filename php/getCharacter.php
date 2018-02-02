<?php

require_once 'global.php';

$json = file_get_contents('php://input');
$post = json_decode($json, true);
$userId = $post['userId'];
$charaId = $post['charaId'];
$nodataFlag = false;
$data = null;

try{
	$dbh = DB::connect();
	//既に登録済みのユーザー
	if($userId !== null) {
		$sql = "SELECT ID, DATA FROM M_CHARACTER WHERE ID = :charaId AND USER_ID = :userId AND DELETE_FLAG = '0'";
		$stmt = $dbh->prepare($sql);
		$stmt -> bindParam('charaId', $charaId, PDO::PARAM_STR);
		$stmt -> bindParam('userId', $userId, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			$unzip = gzinflate($row['DATA']);
			$charaIdx16 = convertx64Tox16($row['ID']);

			$imgURL = '../img/charaFace/' . substr($charaIdx16, 0, 2) . '/' . $charaIdx16 . '.jpg';
			if (!file_exists($imgURL)) {
				$imgURL = '../img/noface.jpg';
			}
			$d = json_decode($unzip, true);
			$d['ability'] = convertSaveAbility($dbh, $d['ability']);
			$d['subPosition'] = convertSaveSubPosition($dbh, $d['subPosition']);


			$data = array(
				'charaId'=>$row['ID'],
				'imgURL'=>$imgURL,
				'data'=>$d
			);
		} else {
			$nodataFlag = true;
		}
	} else {
		$nodataFlag = true;
	}

}catch (PDOException $e){
	die();
}

if ($nodataFlag) {
	$data = array(
		'charaId'=>null,
		'data'=>null
	);
}

$dbh = null;
header('Content-type: application/json');
echo json_encode($data);

function convertSaveAbility($dbh, $ability) {
	try{
		$dbh = DB::connect();

		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		for ($i = 0; $i < count($ability); $i++) {
			for ($j = 0; $j < count($ability[$i]); $j++) {
				if ($ability[$i][$j]) {
					$sql = 'SELECT ID, NAME, TYPE
						FROM ABILITY_DETAIL
						WHERE ID = ?
						';
					$sth = $dbh->prepare($sql);

					$sth->bindParam(1, $ability[$i][$j], PDO::PARAM_INT);
					// SQL の実行
					$sth->execute();
					$row = $sth->fetch(PDO::FETCH_ASSOC);
					$ability[$i][$j] = array(
						'id'=>$row['ID'],
						'name'=>$row['NAME'],
						'type'=>$row['TYPE']
					);
				}
			}
		}

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	return $ability;
}

function convertSaveSubPosition($dbh, $subPosition) {
	try{
		$dbh = DB::connect();

		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		for ($i = 0; $i < count($subPosition); $i++) {
			for ($j = 0; $j < count($subPosition[$i]); $j++) {
				if ($subPosition[$i][$j]) {
					$sql = 'SELECT D.ID, D.NAME, H.COLOR
						FROM SUBPOSITION_HEADER H
						INNER JOIN SUBPOSITION_DETAIL D
						ON H.ID = D.HEADER_ID
						WHERE D.ID = ?
						';
					$sth = $dbh->prepare($sql);

					$sth->bindParam(1, $subPosition[$i][$j], PDO::PARAM_INT);
					// SQL の実行
					$sth->execute();
					$row = $sth->fetch(PDO::FETCH_ASSOC);
					$subPosition[$i][$j] = array(
						'id'=>$row['ID'],
						'name'=>$row['NAME'],
						'color'=>$row['COLOR']
					);
				}
			}
		}

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
	return $subPosition;
}
?>
