<!DOCTYPE html>
<html lang="ja">
<head>
	<?php
	$title = 'パワプロアプリ育成シミュレーター　マニュアル';
	$description = 'パワプロアプリの育成シミュレーターです。目標選手の育成に必要な経験点を計算してくれます。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/hirameki.css">
</head>
<body>
	<?php include('./header.php'); ?>

	<main id="contents" class="manual">
			<div class="aling_line" style="width:520px;margin-bottom:5px;">
				<div class="right_align" style="width:360px;text-align:left;font-size:1.8em;">
					パワプロアプリひらめきシミュレーター</div>
				<div class="left_align" style="width:140px;">
					<img src="../img/bibi_face.png" style="width:130px;">
				</div>
			</div>
			<br>
			<b>■操作マニュアル</b><br>
			<b>１．選手タイプを選択</b><br>
			「野手」、「投手」から選択できます。<br>
			選択したタイプのひらめき特訓一覧に変更されます。<br><br>
			<b>２．イベキャラ状態設定<br></b>
			・上部のボタンで、イベキャラの種類を変更。<br>
			→「野手」、「投手」、「彼女」から選択。<br>
			・練習画像をクリックし、現在の得意練習を設定。<br>
			→クリックする毎に順番に切り替わります。<br>
			・ロックボタンで得意練習をロック/解除する。<br>
			→ロック中の得意練習はブレインシャッフル時に変更されません。<br><br>
			<b>３．ブレインシャッフルを実行</b><br>
			→ロックされていない練習がランダムに切り替わります。<br><br>
			<b>４．確率計算<br>
				→現在のイベキャラ状況から、ブレインシャッフルを行った時に</b><br>
			ひらめき特訓が発動する確率を計算します。<br>
			未取得状態で、リストに表示されているひらめき特訓のどれか<br>
			一つでも揃う確率を「最低１つ揃う確率」欄に表示します。<br><br>
			<b>５．ひらめき特訓操作</b><br>
			・ひらめき特訓一覧の　フィルターを使用して表示制限を行えます。<br>
			・ひらめき特訓をクリックすると、取得済みに設定できます。<br>
			→取得済みの特訓はリストの最後部に表示されるようになります。<br>
			・ひらめき特訓の右端をクリックすると、ターゲット指定できます。<br>
			→ターゲット指定された特訓はリスト上部に表示されます。<br><br>
			<b>６．取得経験点</b><br>
			取得済みのひらめき特訓の経験点の合計を表示します。<br><br>
			<b>■注意事項</b><br>
			・ブレインシャッフルは全ての練習が同確率で出る前提で計算されています。<br>
			・確率計算は完了までに時間がかかります。<br>
			「得意練習をロックする」、「不要なひらめき特訓を、取得済みにする」、<br>
			「フィルターで特訓を絞る」等で処理時間を軽減できます。<br>
	</main>
	<?php include('../html/footer.html'); ?>
	</body>

</html>
