<!DOCTYPE html>
<?php
require_once 'global.php';
$dbh = DB::connect();
?>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ育成シミュレーター | 査定計算機';
	$description = 'パワプロアプリの査定計算ツールです。選手能力を入れると査定値(実査定値、表示査定値)を計算します。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/assessment.css?ver20170930">
	<script src="../js/commonModule.js?ver20171001"></script>
	<script src="../js/assessment.js?ver20170930"></script>
	<script>
		var baseAbilityList = <?php
			$str = '';
			$list = array();
			for($i = 0; $i < 7; $i++) {
				$innerList = array();
				$str .= '[';
				$sql = 'SELECT
							ASSESSMENT
						FROM BASE_POINT_HEADER H
						WHERE TYPE = ' . $i . '
						ORDER BY POINT ASC';
				foreach ($dbh->query($sql) as $row) {
					$innerList[] = (double)$row['ASSESSMENT'];
				}
				$list[] = $innerList;
			}
			echo json_encode($list);
			?>,
			rankData = <?php
				$sql = 'SELECT
							POINT_FROM,
							POINT_TO,
							RANK_STR
						FROM
							ASSESSMENT_RANK
						';
				$list = array();
				foreach ($dbh->query($sql) as $row) {
					$list[] = array(
						'pointFrom'=>(int)$row['POINT_FROM'],
						'pointTo'=>(int)$row['POINT_TO'],
						'rankStr'=>$row['RANK_STR']
					);
				}
				echo json_encode($list);
				?>
	</script>
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2><i class="fa fa-calculator"></i>査定計算機</h2>
		</header>
		<section class="basePointSection">
			<p><i class="fa fa-cube"></i>基礎能力</p>
			<table class="basePoint modern">
				<tr>
					<th>弾道</th>
					<td><input type="number" class="basePointInput" min="1" max="4" step="1"></td>
				</tr>
				<tr>
					<th>ミート</th>
					<td><input type="number" class="basePointInput" min="1" max="102" step="1"></td>
				</tr>
				<tr>
					<th>パワー</th>
					<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
				</tr>
				<tr>
					<th>走力</th>
					<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
				</tr>
				<tr>
					<th>肩力</th>
					<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
				</tr>
				<tr>
					<th>守備</th>
					<td><input type="number" class="basePointInput" min="1" max="104" step="1"></td>
				</tr>
				<tr>
					<th>捕球</th>
					<td><input type="number" class="basePointInput" min="1" max="102" step="1"></td>
				</tr>
			</table>


		</section>


		<section class="abilitySection">
			<p><i class="fa fa-cube"></i>特殊能力<button onclick="commonModule.openModalWindow(0);" class="addAbility">追加</button><span class="abilityCount">0個</span></p>
			<div class="displayAbility"></div>
		</section>


		<section>
			<p><i class="fa fa-cube"></i>査定</p>
			<div id="assessmentDisplay">
				<div class="displayRankArea">
					<div>ランク：</div>
					<div class="rankImgArea">
						<div id="displayRank"></div>
						<div id="displayRankNum">2</div>
					</div>
					<div class="meterFrame">
						<div class="meterGauge"></div>
					</div>
				</div>
				<div>表示査定：<span id="displayShowAssessment">0</span></div>
				<div>実査定：<span id="displayRealAssessment"></span></div>

			</div>
		</section>

		<input type="hidden" id="abilityTotalCount" value="<?php include('../php/getAbilityCount.php'); ?>" />
	</main>

	<div id="abilityModal" class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking:false, closeOnCancel:false, closeOnConfirm:false, closeOnEscape:false">
		<button class="remodal-close" onclick="assessment.ConfirmRemodal()"></button>
		<div id="abilityList">
			<div id="abSelectList" class="container-fluid">

				<div class="groupHeader"><img class="iconGraph" src="../img/icon/bat.png">特能</div>
				<hr class="abHr">
				<div class="abSelectHeader">
					<div></div>
					<div>特能名</div>
					<div></div>
				</div>

				<ul class="abilityButtonList">
					<?php
					require_once "getAbilityList.php";
					$data = getAbilityList(0);

					for ($i = 0; $i < count($data); $i++) {
						$d = $data[$i];
						if ($d['category'] === '0') { ?>

					<li idx="<?= $d['id'] ?>">
						<div class="plusButtonArea">
							<a class="buttonAct">
								<div class="pmButton plusButton"></div>
							</a>
						</div>
						<div class="abName" data-defname="<?= $d['name'] ?>"><?= $d['name'] ?></div>
						<div class="minusButtonArea">
							<a class="buttonAct">
								<div class="pmButton minusButton"></div>
							</a>
						</div>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>

				<div class="groupHeader"><i class="fa fa-user iconGraph" aria-hidden="true"></i>その他特能</div>
				<hr class="abHr">

				<div class="abSelectHeader">
					<div></div>
					<div>特能名</div>
					<div></div>
					<div></div>
					<div></div>
				</div>

				<ul class="otherAbilityList">
					<?php
					require_once "getAbilityList.php";
					$data = getAbilityList(0);

					for ($i = 0; $i < count($data); $i++) {
						$d = $data[$i];
						if ($d['category'] === '5' || $d['category'] === '7') { ?>

					<li idx="<?= $d['id'] ?>">
						<div></div>
						<div class="abName" data-defname="<?= $d['name'] ?>" onclick="commonModule.changeGAbility(<?= $d['id'] ?>, this);"><?= $d['name'] ?></div>
						<div></div>
						<div></div>
						<div></div>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>

			</div>
		</div>

		<div class="modalButton">
			<button data-remodal-action="confirm" class="remodal-confirm">Close</button>
		</div>
	</div>

	<?php include('../html/footer.html'); ?>
</body>

</html>
