<?php

function getID($dbh, $name, $password) {

	$userList = array();
	$sql = "SELECT ID, NAME, PASSWORD FROM M_USER WHERE NAME = :name";
	$stmt = $dbh->prepare($sql);
	$stmt -> bindParam('name', $name);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$userList[] = array(
			'id'=>$row['ID'],
			'name'=>$row['NAME'],
			'password'=>$row['PASSWORD']
		);
	}

	$id = null;
	foreach($userList as $row) {
		if (password_verify($password, $row['password'])) {
			$id = (int)$row['id'];
			break;
		}
	}
	return $id;
}


function makeNewUser ($dbh, $name, $password) {

	$hashpass = password_hash($password, PASSWORD_DEFAULT);
	$sql = 'INSERT INTO M_USER (NAME, PASSWORD) VALUES (:name, :password)';
	$stmt = $dbh->prepare($sql);
	$stmt -> bindParam('name', $name);
	$stmt -> bindParam('password', $hashpass);
	$stmt->execute();

	return getID($dbh, $name, $password);
}

function validateUserInfo($name, $password) {
	if (strlen($name) === 0 || strlen($password) === 0) {
		return array('status'=>-1, 'msg'=>'ユーザー名、パスワードを入力してください。※画面右下の設定ボタンから入力できます。');
	} else if (strlen($name) < 8 || strlen($password) < 8) {
		return array('status'=>-1, 'msg'=>'ユーザー名、パスワードは8文字以上にしてください。');
	} else if (!ctype_alnum($name) || !ctype_alnum($password)){
		return array('status'=>-1, 'msg'=>'ユーザー名、パスワードは半角英数字で入力してください。');
	} else if (strlen($name) > 20 || strlen($password) > 20){
		return array('status'=>-1, 'msg'=>'ユーザー名、パスワードは20文字以内にしてください。');
	}
	return null;
}


function makeUniqueId() {
	//乱数3桁+uniqid13桁の計15桁の文字列を作成
	$str = substr(str_pad(mt_rand(), 3, 0) . uniqid(), -16);

	return $str;
}

?>
