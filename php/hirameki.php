<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="author" content="Yukihiro Hitsujikai">
	<meta name="description" content="">
	<meta name="viewport" content="width=520,user-scalable=no" />
	<title>パワプロアプリ育成シミュレーター　ひらめきシミュレーター</title>
	<link rel="stylesheet" href="../css/lib/jquery-ui.min.css">
	<link rel="stylesheet" href="../css/lib/jquery.ui.labeledslider.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/common.css">
	<link rel="stylesheet" href="../css/hirameki.css">
	<link rel="stylesheet" href="../css/bootstrap_custom.css">
	<script src="../js/plugin/jquery-3.1.1.min.js"></script>
	<script src="../js/plugin/jquery-ui.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../js/plugin/remodal.min.js"></script>
	<script src="../js/plugin/jquery.blockUI.js"></script>
	<script src="../js/hirameki.js"></script>
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main id="contents">
		<header class="pageHeader">
			<h2><i class="fa fa-lightbulb-o"></i>ひらめきシミュレーター</h2>
			<div class="left_align" style="width:140px;">
				<img src="../img/bibi_face.png" class="bibiFace">
			</div>
		</header>

		<br>
		<a href="./hirameki_Manual.php" target="_blank">使い方</a><br>
		<br>
		■選手タイプ:<select id="myType">
		<option value="0">野手</option>
		<option value="1">投手</option>
		</select>
		<br><br>

		■イベキャラ<br>
		<table border="1" class="hiramekiChara modern">
			<tr>
				<td><button class="EventCharaType EventCharaBatter" value="0">野手</button></td>
				<td><button class="EventCharaType EventCharaBatter" value="0">野手</button></td>
				<td><button class="EventCharaType EventCharaBatter" value="0">野手</button></td>
				<td><button class="EventCharaType EventCharaBatter" value="0">野手</button></td>
				<td><button class="EventCharaType EventCharaBatter" value="0">野手</button></td>
				<td><button class="EventCharaType EventCharaBatter" value="0">野手</button></td>
			</tr>
			<tr>
				<td><div class="imgContainer"><img src="../img/practice0.jpg" class="SpecialtyTraining" idx="0", typ="0"><div class="lockLayer noneSelect"><img src="../img/lock.png" class="lock"></div></div></td>
				<td><div class="imgContainer"><img src="../img/practice0.jpg" class="SpecialtyTraining" idx="0", typ="0"><div class="lockLayer noneSelect"><img src="../img/lock.png" class="lock"></div></div></td>
				<td><div class="imgContainer"><img src="../img/practice0.jpg" class="SpecialtyTraining" idx="0", typ="0"><div class="lockLayer noneSelect"><img src="../img/lock.png" class="lock"></div></div></td>
				<td><div class="imgContainer"><img src="../img/practice0.jpg" class="SpecialtyTraining" idx="0", typ="0"><div class="lockLayer noneSelect"><img src="../img/lock.png" class="lock"></div></div></td>
				<td><div class="imgContainer"><img src="../img/practice0.jpg" class="SpecialtyTraining" idx="0", typ="0"><div class="lockLayer noneSelect"><img src="../img/lock.png" class="lock"></div></div></td>
				<td><div class="imgContainer"><img src="../img/practice0.jpg" class="SpecialtyTraining" idx="0", typ="0"><div class="lockLayer noneSelect"><img src="../img/lock.png" class="lock"></div></div></td>
			</tr>
			<tr>
				<td><button class="lockButton radius" value="0">ロック</button></td>
				<td><button class="lockButton radius" value="0">ロック</button></td>
				<td><button class="lockButton radius" value="0">ロック</button></td>
				<td><button class="lockButton radius" value="0">ロック</button></td>
				<td><button class="lockButton radius" value="0">ロック</button></td>
				<td><button class="lockButton radius" value="0">ロック</button></td>
			</tr>
		</table>
		<br><br>
		<button class="brainShaffule radius" onclick="BrainShaffule(9)"><i class="fa fa-battery-three-quarters" style="color:#00aa00"></i>ブレインシャッフル</button>
		<button class="calc radius" onclick="doCalc()">確率計算</button><br>
		<div class="atLeastArea"><table class="modern"><tr><td style="background-color:#000000;color:#ffffff">最低１つ揃う確率</td><td style="width:60px;"><span id="atLeastPer"></span></td></tr></table></div>


		<br>
		<div class="aling_line" style="width:500px;margin-bottom:5px;">
			<div class="right_align">
				フィルター
				<select onChange="FilterHiramekiList()" id="filterType">
					<option value="0"></option>
					<option value="1">筋力</option>
					<option value="2">技術</option>
					<option value="3">敏捷</option>
					<option value="4">変化球</option>
					<option value="5">精神</option>
					<option value="6">コツ</option>
				</select>≧
				<select onChange="FilterHiramekiList()" id="filterNum">
					<option value="0"></option>
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
					<option value="60">60</option>
				</select>
			</div>
			<div class="left_align">■ひらめき特訓一覧</div>
		</div>
		<div id="hiramekiListArea">
			<script type="text/javascript">document.write(makeList());</script>
		</div>
	</main>

	<?php include('../html/footer.html'); ?>
</body>

</html>

<!-- https://jsfiddle.net/dpgjx1ca/ -->
