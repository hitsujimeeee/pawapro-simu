
<?php
require_once 'global.php';
require_once 'userCommonModule.php';
require_once './ImageCreateFromBMP.php';

// 一時アップロード先ファイルパス
$charaId = $_POST['charaId'];
$userName = $_POST['userName'];
$password = $_POST['password'];
if($charaId === "") {
	header('Content-type: application/json');
	echo json_encode(array('status'=>-1, msg=>'選手情報が登録されていません。'));
	return;
}
$charaId = convertx64Tox16($charaId);
$dirName = substr($charaId, 0, 2);

$result = array('status'=>-1);
$resizeMinWidth = 320;
$resizeMinHeight = 320;

try {
	$dbh = DB::connect();
	$userId = getId($dbh, $userName, $password);
	//既に登録済みのユーザー
	if($userId !== null) {

		if(!isset($_FILES['sendFile']['error']) || !is_int($_FILES['sendFile']['error'])) {
			throw new RuntimeException('パラメータが不正です');
		}

		// $_FILES['upfile']['error'] の値を確認
		switch ($_FILES['sendFile']['error']) {
			case UPLOAD_ERR_OK: // OK
				break;
			case UPLOAD_ERR_NO_FILE:   // ファイル未選択
				throw new RuntimeException('ファイルが選択されていません');
			case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
			case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
				throw new RuntimeException('ファイルサイズが大きすぎます');
			default:
				throw new RuntimeException('その他のエラーが発生しました');
		}

		// ここで定義するサイズ上限のオーバーチェック
		// (必要がある場合のみ)
		if ($_FILES['sendFile']['size'] > 1000000) {
			throw new RuntimeException('ファイルサイズが大きすぎます');
		}


		$file_tmp  = $_FILES["sendFile"]["tmp_name"];


		if(exif_imagetype($file_tmp) == IMAGETYPE_JPEG || exif_imagetype($file_tmp) == IMAGETYPE_GIF || exif_imagetype($file_tmp) == IMAGETYPE_PNG) {

			$inImg = null;
			// $_FILES['upfile']['mime']の値はブラウザ側で偽装可能なので
			// MIMEタイプに対応する拡張子を自前で取得する
			switch(mime_content_type($file_tmp)){
				case "image/gif":
					$inImg = imagecreatefromgif($file_tmp);
					break;
				case "image/jpeg":
					$inImg = imagecreatefromjpeg($file_tmp);
					break;
				case "image/png":
					$inImg = imagecreatefrompng($file_tmp);
					break;
				case "image/bmp":
				case "image/x-bmp":
				case "image/x-ms-bmp":
					$inImg = ImageCreateFromBMP($file_tmp);
					break;
			}

			if(!$inImg) {
				throw new RuntimeException('ファイル形式が不正です');
			}
			$width = imagesx($inImg);
			$height = imagesy($inImg);

			$new_width = $width;
			$new_height = $height;

			//最大縦横比より大きい画像の場合
			if($width >= $resizeMinWidth || $height >= $resizeMinHeight){
				if ($width === $height) {
					$new_width = $resizeMinWidth;
					$new_height = $resizeMinHeight;
				} else if($width > $height) {//横長の場合
					$new_width = $resizeMinWidth;
					$new_height = $height * ($resizeMinWidth / $width);
				} else {//縦長の場合
					$new_width = $width * ($resizeMinHeight / $height);
					$new_height = $resizeMinHeight;
				}
			}
			$out = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($out, $inImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			if(!file_exists('../img/charaFace/' . $dirName)) {
				mkdir('../img/charaFace/' . $dirName);
			}
			imagejpeg($out, '../img/charaFace/' . $dirName . '/' . $charaId . '.jpg');

		}

		$result = array(
			'status'=>0,
			'dirName'=>$dirName,
			'charaId'=>$charaId
		);

	} else {
		$result = array(
			'status'=>-1,
			'msg'=>'ユーザー名またはパスワードが違います'
		);
	}




} catch (RuntimeException $e) {
	$result = array(
		'status'=>-1,
		'msg'=>$e->getMessage()
	);
}

header('Content-type: application/json');
echo json_encode($result);

?>
