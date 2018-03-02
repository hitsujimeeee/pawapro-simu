<?php
require_once 'global.php';

$idList = isset($_GET['idList']) ? $_GET['idList'] : null;
$result = isset($_GET['result']) ? $_GET['result'] : null;
$str = implode(',', $idList);
$correctCount = 0;



try{
	$dbh = DB::connect();


	$sql = '
	SELECT
		ID,
		CONTENT,
		OPTION1,
		OPTION2,
		OPTION3,
		OPTION4,
		IMAGE
	FROM
		QUIZ
	WHERE
		ID IN (' . $str . ')
	ORDER BY
		FIELD(ID, ' . $str . ')
	';

	$sth = $dbh->query($sql);

	$i = 0;

	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$data[] = array(
			'ID'=>(int)$row['ID'],
			'CONTENT'=>$row['CONTENT'],
			'OPTIONS'=>array($row['OPTION1'], $row['OPTION2'], $row['OPTION3'], $row['OPTION4']),
			'IMAGE'=>(int)$row['IMAGE'],
			'RESULT'=>(int)$result[$i]
		);
		$correctCount += (int)$result[$i];
		$i++;
	}
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


$userTitle = [
	'パワプロ初心者',
	'パワプロ初心者',
	'パワプロ初心者',
	'パワプロ初心者',
	'パワプロ初心者',
	'パワプロ初心者',
	'パワプロ中級者',
	'パワプロ中級者',
	'パワプロ達人',
	'パワプロ博士',
	'パワプロ神'
];

$resultComment = [
	'4択でここまで外せるのは逆に凄いです。',
	'4択でここまで外せるのは逆に凄いです。',
	'もう少し頑張りましょう。',
	'もう少し頑張りましょう。',
	'もう少し頑張りましょう。',
	'もう少し頑張りましょう。',
	'ようやくパワプロのスタートラインに立てたところです。',
	'ようやくパワプロのスタートラインに立てたところです。',
	'豊富なパワプロ知識を持っています。さらなる高みを目指しまして頑張りましょう。',
	'歩くパワプロ辞典ですね。',
	'パワプロの事なら何でもお任せ。'
];

$titleIndex = (int)($correctCount*10/count($data));

$urlText = count($data) . '問中' . $correctCount . '問正解しました。%0a' .
	'あなたは『' . $userTitle[$titleIndex] . '』です。' . $resultComment[$titleIndex] . '%0a%0a' .
	'【パワプロアプリ育成シミュレーター パワプロクイズ】';

$url = 'http://studiowool.webcrow.jp/products/pawapro/php/quizResult.php?'. urlencode($_SERVER['QUERY_STRING']);
$url = str_replace('&', '%26', $url);


?>


<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　パワプロクイズ';
		$description = 'パワプロの4択クイズができます。また、クイズを作って他のユーザーに出題することもできます。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/quiz.css">
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>パワプロクイズ</h2>
			</header>

			<section class="resultSummary">
				<p><?= count($data) ?>問中<?= $correctCount ?>問正解しました。</p>
				<p>あなたは『<?= $userTitle[$titleIndex] ?>』です。<?= $resultComment[$titleIndex] ?></p>
			</section>

			<section class="shareRetryArea">
				<div>
					<a class="shareButton" href="http://twitter.com/share?url=<?= $url ?>&text=<?= $urlText ?>" target="_blank">Twitterに投稿する</a>
				</div>
				<div>
					<a class="retryButton" href="./quizMain.php">クイズに挑戦する</a>
				</div>
			</section>

			<?php include('./adsense/responsive.php') ?>

			<hr class="abHr">

			<section>
				<h3>出題された問題</h3>
				<?php for($i = 0; $i < count($data); $i++) { ?>
				<div class="contentContainer">
					<div>
						<span class="resultMark <?= $data[$i]['RESULT'] === 1 ? 'correct' : 'faild' ?>"></span>問<?= ($i+1) ?>. <?= nl2br(htmlspecialchars($data[$i]['CONTENT'])) ?>
					</div>
					<?php if ($data[$i]['IMAGE'] === 1) { ?>
					<div class="contentImageArea">
						<img src="../img/quiz/<?= $data[$i]['ID'] ?>.jpg">
					</div>
					<?php } ?>
					<?php for($j = 0; $j < count($data[$i]['OPTIONS']); $j++) { ?>
					<p><?= ($j+1) ?>.<?= $data[$i]['OPTIONS'][$j] ?></p>
					<?php } ?>

				</div>
				<?php } ?>
			</section>

			<hr>

			<section class="shareRetryArea">
				<div>
					<a class="shareButton" href="http://twitter.com/share?url=<?= $url ?>&text=<?= $urlText ?>" target="_blank">Twitterに投稿する</a>
				</div>
				<div>
					<a class="retryButton" href="./quizMain.php">クイズに挑戦する</a>
				</div>
			</section>

		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
