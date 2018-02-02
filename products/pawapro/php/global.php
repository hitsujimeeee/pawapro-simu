<?php

class DB {
	public static $dsn = 'mysql:dbname=db1hitsujimeeee;host=localhost';
	public static $user = 'hitsujimeeee';
	public static $password = 'Yandere00';
	public static function connect() {
		return new PDO(self::$dsn, self::$user, self::$password);
	}

}




//2桁毎に64進数→3桁16進数に変換
function convertx64Tox16($str) {
	$x16Array = '0123456789abcdef';
	$x64Array = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/';
	$result = '';

	for($i = 0; $i < strlen($str) / 2; $i++) {
		$partStr = substr($str, $i * 2, 2);
		$num = 0;
		for ($j = 0; $j < strlen($partStr); $j++) {
			$num += strpos($x64Array, $partStr[$j]) * pow(64, strlen($partStr)-1-$j);
		}
		$result .= $x16Array[(int)($num/(16*16))] . $x16Array[(int)($num%(16*16)/16)] . $x16Array[(int)($num)%16];
	}
	return $result;
}



?>
