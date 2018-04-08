<!DOCTYPE html>
<html lang="ja">

	<head>
		<?php
		$title = 'パワプロアプリ　イベキャラ強化計算機';
		$description = 'イベキャラ強化大成功が起こった時に、経験点溢れせずにきっちり使い切るように強化素材を選んでくれるツールです。';
		require_once './headInclude.php';
		?>
		<link rel="stylesheet" href="../css/calcCharaExpPoint.css">
		<script src="../js/calCharaExpPoint.js"></script>
	</head>

	<body>
		<?php include('../php/header.php'); ?>

		<main>
			<header class="pageHeader">
				<h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>イベキャラ強化計算機</h2>
			</header>
			<section class="dispArea">
				<p><i class="fa fa-cube"></i>機能概要</p>
				<div>
					イベキャラ強化大成功が起こった時に、経験点溢れせずにきっちり使い切るように強化素材を選んでくれるツールです。
				</div>
			</section>

			<section class="inputForm">
				<p><i class="fa fa-cube"></i>入力欄</p>
				<div>
					<label for="nowLv">現在Lv</label>
					<input type="number" id="nowLv" class="numInput" min="1" max="50">
				</div>
				<div>
					<label for="targetLv">目標Lv</label>
					<input type="number" id="targetLv" class="numInput" min="0" max="50">pt
				</div>
				<div>
					<label for="nowLv">次のLvまであと</label>
					<input type="number" id="restNextLv" class="numInput" min="1">
				</div>

				<div>
					<div>使用可能キャラ</div>
					<div class="checkForm">
						<input type="checkbox" id="canCheckN" class="canUseFlag" checked><label for="canCheckN">Nキャラ</label>
						<input type="checkbox" id="canCheckPN" class="canUseFlag" checked><label for="canCheckPN">PNキャラ</label>
						<input type="checkbox" id="canCheckNGedo" class="canUseFlag" checked><label for="canCheckNGedo">Nゲドー</label>
						<input type="checkbox" id="canCheckRGedo" class="canUseFlag" checked><label for="canCheckRGedo">Rゲドー</label>
						<input type="checkbox" id="canCheckSPGedo" class="canUseFlag" checked><label for="canCheckSPGedo">SRゲドー</label>
						<input type="checkbox" id="canCheckPSRGedo" class="canUseFlag" checked><label for="canCheckPSRGedo">PSRゲドー</label>
					</div>
				</div>

				<div>
					<div><input type="checkbox" id="doSuperExp" checked><label for="doSuperExp">強化大成功時として計算</label></div>
					<div clas="doSuperExpDisp">※通常強化で強化素材をいくつ使いか知りたい場合はチェックを外してください。</div>
				</div>
			</section>

			<section class="resultForm">
				<p><i class="fa fa-cube"></i>計算結果</p>

				<div>現在の総経験値<span id="nowExpPoint">0</span>pt</div>
				<div>目標Lvまで残りの経験値<span id="restExpPoint">0</span>pt</div>

				<div style="margin-top: 1em;">使用する素材</div>
				<div style="margin-bottom: 1em;">
					<table class="modern" id="itemList">
						<tr>
							<th>種別</th>
							<th>枚数</th>
						</tr>
						<tr>
							<td>Nキャラ</td>
							<td>0</td>
						</tr>
						<tr>
							<td>PNキャラ</td>
							<td>0</td>
						</tr>
						<tr>
							<td>Nゲドー</td>
							<td>0</td>
						</tr>
						<tr>
							<td>Rゲドー</td>
							<td>0</td>
						</tr>
						<tr>
							<td>SRゲドー</td>
							<td>0</td>
						</tr>
						<tr>
							<td>PSRゲドー</td>
							<td>0</td>
						</tr>
					</table>
				</div>

				<div>
					<div>取得経験値</div>
					<dl class="getExpList">
						<dt style="color:red;">強化大成功</dt>
						<dd style="color:red;"><span id="totalGetPoint">0</span>pt</dd>
						<dt>通常強化：</dt>
						<dd><span id="totalGetPointRow">0</span>pt</dd>
					</dl>
				</div>

			</section>

			<?php include('./adsense/responsive.php') ?>

			<hr class="abHr">

			<section class="refInfo">
				<p><i class="fa fa-cube"></i>参考情報</p>
				<div>
					<div>◆レベルごとの必要経験値</div>
					<table class="modern expList" id="expList">
						<tr>
							<th>Lv</th>
							<th>経験値</th>
							<th>総経験値</th>
						</tr>
						<?php
							require_once './logic/getCharaExpPointList.php';
							$data = getCharaExpPointList();
							$total = 0;
							foreach($data as $d) {
								$total += $d['EXP_POINT'];
						?>
						<tr>
							<th><?= $d['LV'] ?></th>
							<td><?= $d['EXP_POINT'] ?></td>
							<td><?= $total ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>

				<div>
					<div>◆強化素材の獲得経験値</div>
					<table class="modern" id="charaExpList">
						<tr>
							<th>種別</th>
							<th>経験値</th>
						</tr>
						<tr>
							<td>Nキャラ</td>
							<td>80</td>
						</tr>
						<tr>
							<td>PNキャラ</td>
							<td>160</td>
						</tr>
						<tr>
							<td>Nゲドー</td>
							<td>320</td>
						</tr>
						<tr>
							<td>Rゲドー</td>
							<td>1280</td>
						</tr>
						<tr>
							<td>SRゲドー</td>
							<td>5120</td>
						</tr>
						<tr>
							<td>PSRゲドー</td>
							<td>10240</td>
						</tr>
					</table>
				</div>
			</section>

		</main>

		<?php include('./optionMenu.php'); ?>

		<?php include('../html/footer.html'); ?>
	</body>

</html>
