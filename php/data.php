<!DOCTYPE html>
<?php
require_once 'global.php';
$dbh = DB::connect();
?>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ育成シミュレーター | データ一覧';
		$description = 'パワプロアプリ育成シミュレーターで使用しているデータ一覧です。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/data.css?ver20180216">
		<script src="../js/data.js"></script>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<h2 class="pageHeader">データ一覧</h2>
			<div class="pageSummary">
				このサイトで使用しているデータをまとめています。<br>
				実際の値と違うところがございましたら、<a href="./about.php#contact">連絡先</a>までご連絡ください。
			</div>
			<div id="ui-tab">
				<ul class="tab_menu">
					<li><a class="tabMenu" href="#tabTrajectory">弾道</a></li>
					<li><a class="tabMenu" href="#tabMeet">ミート</a></li>
					<li><a class="tabMenu" href="#tabPower">パワー</a></li>
					<li><a class="tabMenu" href="#tabSpeed">走力</a></li>
					<li><a class="tabMenu" href="#tabShoulder">肩力</a></li>
					<li><a class="tabMenu" href="#tabDefense">守備</a></li>
					<li><a class="tabMenu" href="#tabCatch">捕球</a></li>
					<li><a class="tabMenu" href="#tabAbilityBatter">野手特能</a></li>
					<li><a class="tabMenu" href="#tabSabilityBatter">野手金特</a></li>
					<li><a class="tabMenu" href="#tabAbilityPitcher">投手特能</a></li>
					<li><a class="tabMenu" href="#tabSabilityPitcher">投手金特</a></li>
					<li><a class="tabMenu" href="#tabChangeBallPoint">変化球</a></li>
				</ul>

				<?php
				$divId = array('Trajectory', 'Meet', 'Power', 'Speed', 'Shoulder', 'Defense', 'Catch');
				$count = count($divId);
				for ($i = 0; $i < $count; $i++) {
					echo '<div id="tab' . $divId[$i] . '" class="tab_content">
						<table class="modern">
							<tr>
								<th></th>
								<th>筋力</th>
								<th>敏捷</th>
								<th>技術</th>
								<th>変化球</th>
								<th>精神</th>
								<th>査定値</th>
							</tr>
						' ;
						$sql = 'SELECT * FROM BASE_POINT_VIEW WHERE TYPE = ' . $i;
						foreach ($dbh->query($sql) as $row) {
							echo '<tr><td>' . $row['POINT'] . '</td><td>' .
								$row['POWER'] . '</td><td>' .
								$row['SPEED'] . '</td><td>' .
								$row['TECH'] . '</td><td>' .
								$row['SCREWBALL'] . '</td><td>' .
								$row['MENTAL'] . '</td><td>' .
								$row['ASSESSMENT'] .     '</td></tr>';
						}

						echo '</table></div>';
				}
				?>


				<div id="tabAbilityBatter" class="tab_content">
					<div class="table-responsive">
						<table class="modern">
							<tr>
								<th>名前</th>
								<th>筋力</th>
								<th>敏捷</th>
								<th>技術</th>
								<th>変化球</th>
								<th>精神</th>
								<th>査定値</th>
							</tr>
						<?php
							$sql = 'SELECT D.NAME, D.POWER, D.SPEED, D.TECH, D.SCREWBALL, D.MENTAL, D.ASSESSMENT
									FROM ABILITY_HEADER H
									INNER JOIN ABILITY_DETAIL D
									ON H.ID = D.HEADER_ID
									WHERE CATEGORY IN (\'0\', \'1\', \'2\', \'5\', \'7\')
									AND D.TYPE IN(\'0\', \'4\', \'5\')
									ORDER BY H.SORT_ORDER, D.ID
									';
							foreach ($dbh->query($sql) as $row) {
								echo '<tr><td>' . $row['NAME'] . '</td><td>' .
									$row['POWER'] . '</td><td>' .
									$row['SPEED'] . '</td><td>' .
									$row['TECH'] . '</td><td>' .
									$row['SCREWBALL'] . '</td><td>' .
									$row['MENTAL'] . '</td><td>' .
									$row['ASSESSMENT'] .     '</td></tr>';
							}
						?>
						</table>
					</div>
				</div>
				<div id="tabSabilityBatter" class="tab_content">
					<div class="table-responsive">
						<table class="modern">
							<tr>
								<th>名前</th>
								<th>筋力</th>
								<th>敏捷</th>
								<th>技術</th>
								<th>変化球</th>
								<th>精神</th>
								<th>査定値</th>
							</tr>
							<?php
							$sql = 'SELECT D.NAME, D.POWER, D.SPEED, D.TECH, D.SCREWBALL, D.MENTAL, D.ASSESSMENT
									FROM ABILITY_HEADER H
									INNER JOIN ABILITY_DETAIL D
									ON H.ID = D.HEADER_ID
									WHERE CATEGORY IN (\'0\', \'1\', \'2\')
									AND D.TYPE IN(\'1\')
									ORDER BY H.SORT_ORDER, D.ID
									';
							foreach ($dbh->query($sql) as $row) {
								echo '<tr><td>' . $row['NAME'] . '</td><td>' .
									$row['POWER'] . '</td><td>' .
									$row['SPEED'] . '</td><td>' .
									$row['TECH'] . '</td><td>' .
									$row['SCREWBALL'] . '</td><td>' .
									$row['MENTAL'] . '</td><td>' .
									$row['ASSESSMENT'] .     '</td></tr>';
							}
							?>
						</table>
					</div>
				</div>
				<div id="tabAbilityPitcher" class="tab_content">
					<div class="table-responsive">
						<table class="modern">
							<tr>
								<th>名前</th>
								<th>筋力</th>
								<th>敏捷</th>
								<th>技術</th>
								<th>変化球</th>
								<th>精神</th>
								<th>査定値</th>
							</tr>
							<?php
							$sql = 'SELECT D.NAME, D.POWER, D.SPEED, D.TECH, D.SCREWBALL, D.MENTAL, D.ASSESSMENT
								FROM ABILITY_HEADER H
								INNER JOIN ABILITY_DETAIL D
								ON H.ID = D.HEADER_ID
								WHERE CATEGORY IN (\'4\', \'6\', \'7\')
								AND D.TYPE IN(\'0\', \'4\', \'5\')
								ORDER BY H.SORT_ORDER, D.ID
								';
							foreach ($dbh->query($sql) as $row) {
								echo '<tr><td>' . $row['NAME'] . '</td><td>' .
									$row['POWER'] . '</td><td>' .
									$row['SPEED'] . '</td><td>' .
									$row['TECH'] . '</td><td>' .
									$row['SCREWBALL'] . '</td><td>' .
									$row['MENTAL'] . '</td><td>' .
									$row['ASSESSMENT'] .     '</td></tr>';
							}
							?>
						</table>
					</div>
				</div>
				<div id="tabSabilityPitcher" class="tab_content">
					<div class="table-responsive">
						<table class="modern">
							<tr>
								<th>名前</th>
								<th>筋力</th>
								<th>敏捷</th>
								<th>技術</th>
								<th>変化球</th>
								<th>精神</th>
								<th>査定値</th>
							</tr>
							<?php
							$sql = 'SELECT D.NAME, D.POWER, D.SPEED, D.TECH, D.SCREWBALL, D.MENTAL, D.ASSESSMENT
								FROM ABILITY_HEADER H
								INNER JOIN ABILITY_DETAIL D
								ON H.ID = D.HEADER_ID
								WHERE CATEGORY IN (\'4\')
								AND D.TYPE IN(\'1\')
								ORDER BY H.SORT_ORDER, D.ID
								';
							foreach ($dbh->query($sql) as $row) {
								echo '<tr><td>' . $row['NAME'] . '</td><td>' .
									$row['POWER'] . '</td><td>' .
									$row['SPEED'] . '</td><td>' .
									$row['TECH'] . '</td><td>' .
									$row['SCREWBALL'] . '</td><td>' .
									$row['MENTAL'] . '</td><td>' .
									$row['ASSESSMENT'] .     '</td></tr>';
							}
							?>
						</table>
					</div>

				</div>

				<div id="tabChangeBallPoint" class="tab_content">
					<p>■変化球の査定分類</p>
					<div class="changePattern">
						<a href="../img/changePatternDisp.png">
							<img src="../img/changePatternDisp.png" alt="変化球の査定分類">
						</a>
					</div>

					<p>■査定パターンと査定ポイント</p>
					<div class="table-responsive">
						<table class="modern">
							<tr>
								<th>パターン</th>
								<th>総変量</th>
								<th>査定ポイント</th>
							</tr>
							<?php
							$sql = 'SELECT ITEM, TOTAL, POINT FROM CHANGE_BALL_POINT ORDER BY CHAR_LENGTH(ITEM) ASC, ITEM ASC';
							foreach ($dbh->query($sql) as $row) {
								echo '<tr><td>' . $row['ITEM'] . '</td><td>' .
									$row['TOTAL'] . '</td><td>' .
									$row['POINT'] . '</td></tr>';
							}
							?>
						</table>
					</div>

				</div>
			</div>
		</main>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
<?php
$dbh = null;
?>

<!-- https://jsfiddle.net/dpgjx1ca/ -->
