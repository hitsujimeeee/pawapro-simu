<?php
require_once '../global.php';
require_once '../ImageCreateFromBMP.php';

$category = isset($_POST['category']) ? $_POST['category'] : null;
$content = isset($_POST['content']) ? urldecode($_POST['content']) : null;
$option1 = isset($_POST['option1']) ? urldecode($_POST['option1']) : null;
$option2 = isset($_POST['option2']) ? urldecode($_POST['option2']) : null;
$option3 = isset($_POST['option3']) ? urldecode($_POST['option3']) : null;
$option4 = isset($_POST['option4']) ? urldecode($_POST['option4']) : null;
$answer = isset($_POST['answer']) ? $_POST['answer'] : null;
$comment = isset($_POST['comment']) ? urldecode($_POST['comment']) : null;
$userName = isset($_POST['userName']) ? urldecode($_POST['userName']) : null;
$twitter = isset($_POST['twitter']) ? urldecode($_POST['twitter']) : null;


$result = array('status'=>-1);
$resizeMinWidth = 640;
$resizeMinHeight = 640;

try {
	$dbh = DB::connect();

	$dbh->beginTransaction();

	$sql = '
		INSERT INTO
			QUIZ
		(
			CATEGORY,
			CONTENT,
			OPTION1,
			OPTION2,
			OPTION3,
			OPTION4,
			ANSWER,
			COMMENTS,
			USER_NAME,
			TWITTER_ID,
			FIXED_FLAG
		)
		VALUES
		(
			:category,
			:content,
			:option1,
			:option2,
			:option3,
			:option4,
			:answer,
			:comment,
			:userName,
			:twitter,
			1
		)
	';

	$stmt = $dbh->prepare($sql);
	$stmt->bindValue('category', $category);
	$stmt->bindValue('content', $content);
	$stmt->bindValue('option1', $option1);
	$stmt->bindValue('option2', $option2);
	$stmt->bindValue('option3', $option3);
	$stmt->bindValue('option4', $option4);
	$stmt->bindValue('answer', $answer);
	$stmt->bindValue('comment', $comment);
	$stmt->bindValue('userName', $userName);
	$stmt->bindValue('twitter', $twitter);
	$stmt->execute();

	$sql = 'SELECT LAST_INSERT_ID() LAST_ID';

	$sth = $dbh->query($sql);
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	$id = $row['LAST_ID'];


	/*-----DB登録ここまで----------*/

	/*-----画像保存ここから--------*/


	if(!isset($_FILES['sendFile']['error']) || !is_int($_FILES['sendFile']['error'])) {
		throw new RuntimeException('パラメータが不正です');
	}

	$existFile = true;

	// $_FILES['upfile']['error'] の値を確認
	switch ($_FILES['sendFile']['error']) {
		case UPLOAD_ERR_OK: // OK
			break;
		case UPLOAD_ERR_NO_FILE:   // ファイル未選択
			$existFile = false;
			break;
		case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
		case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
			throw new RuntimeException('ファイルサイズが大きすぎます');
		default:
			throw new RuntimeException('その他のエラーが発生しました');
	}

	if ($existFile) {


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
			if(!file_exists('../../img/quiz/')) {
				mkdir('../../img/quiz/');
			}
			imagejpeg($out, '../../img/quiz/' . $id . '.jpg');

			$sql = '
				UPDATE
					QUIZ
				SET
					IMAGE = 1
				WHERE
					ID = :id
			';

			$stmt = $dbh->prepare($sql);
			$stmt->bindValue('id', $id);
			$stmt->execute();

		}

	}

	$dbh->commit();


	$result = array(
		'status'=>0
	);

}catch (PDOException $e) {
	$result = array(
		'status'=>-1,
		'msg'=>'エラーが発生しました！ページを再読み込みしてください。'
	);
	$dbh->rollBack();
	die();
} catch (RuntimeException $e) {
	$result = array(
		'status'=>-1,
		'msg'=>'エラーが発生しました！ページを再読み込みしてください。'
	);
	$dbh->rollBack();
	die();
}

header('Content-type: application/json');
echo json_encode($result);

?>
