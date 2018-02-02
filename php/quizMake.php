<?php
require_once 'global.php';

$category = [];

try {
	$dbh = DB::connect();


	$sql = '
	SELECT
		ID,
		NAME
	FROM
		QUIZ_CATEGORY
	ORDER BY
		ID
	';

	$sth = $dbh->query($sql);

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$category[] = array(
			'ID'=>(int)$row['ID'],
			'NAME'=>$row['NAME']
		);
	}

}catch (PDOException $e) {
	print('Error:'.$e->getMessage());
	die();
}
?>


<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　パワプロクイズ問題作成';
		$description = 'パワプロの4択クイズができます。また、クイズを作って他のユーザーに出題することもできます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/quiz.css">
		<script src="../js/quizMake.js"></script>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main class="quizMake">
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>パワプロクイズ　問題作成</h2>
			</header>
			<section>
				<div><i class="fa fa-cube" aria-hidden="true"></i>問題文(200文字まで)</div>
				<div class="secMain"><textarea id="makeContents" maxlength="200"></textarea></div>
			</section>

			<section>
				<p><i class="fa fa-cube" aria-hidden="true"></i>画像(必要な場合のみ)</p>
				<div class="secMain">
					<form id="sendForm">
						<input type="file" id="sendFile" name="sendFile" accept="image/*">
					</form>
				</div>
				<div class="contentImageArea">
					<img id="contentImage" src=""><br clear="all">
				</div>
			</section>

			<section>
				<div><i class="fa fa-cube" aria-hidden="true"></i>選択肢</div>
				<div class="secMain">
				<?php for ($i = 0; $i < 4; $i++) { ?>
					<p><?= ($i+1) ?>：<input type="text" class="makeOption" maxlength="30"></p>
				<?php } ?>
				</div>
			</section>

			<section>
				<div><i class="fa fa-cube" aria-hidden="true"></i>正解</div>
				<div class="secMain">
					<select id="makeAnswer">
						<option value="1">選択肢1</option>
						<option value="2">選択肢2</option>
						<option value="3">選択肢3</option>
						<option value="4">選択肢4</option>
					</select>
				</div>
			</section>

			<section>
				<div><i class="fa fa-cube" aria-hidden="true"></i>カテゴリ</div>
				<div class="secMain">
					<select id="makeCategory">
						<?php foreach($category as $c) { ?>
						<option value="<?= $c['ID'] ?>"><?= $c['NAME'] ?></option>
						<?php } ?>
					</select>
				</div>
			</section>

			<section>
				<div><i class="fa fa-cube" aria-hidden="true"></i>解説(300文字まで、任意)</div>
				<div class="secMain"><textarea id="makeComment" maxlength="300"></textarea></div>
			</section>

			<section>
				<div><i class="fa fa-cube" aria-hidden="true"></i>作者(任意)</div>
				<div class="secMain">名前：<input type="text" id="makeUserName" maxlength="40"></div>
				<div class="secMain">TwitterID：<input type="text" id="makeTwitter" maxlength="15"></div>
			</section>

			<section>
				<button onclick="quizMake.confirmSubmit();">登録する</button>
			</section>

			<div id="show_dialog" title="送信確認">作成した問題を登録します。よろしいですか？</div>

		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
