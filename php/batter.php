<!DOCTYPE html>
<html lang="ja">

<head>
	<?php
	$title = 'パワプロアプリ | 野手シミュレーター';
	$description = 'パワプロアプリの育成シミュレーター(野手版)です。目標能力までに必要な経験点を計算できます。査定計算機能や、余った経験点から査定が最大になるように能力を振ってくれる査定最大化機能もあります。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/batter.css?ver20170930">
	<script src="../js/batter.js?ver20180224"></script>
	<script src="../js/calcMaxAssessment.js?ver20180217"></script>
	<script src="../js/commonModule.js?ver20180224"></script>
</head>

<body>
	<?php include('../php/header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2><img class="iconGraph" src="../img/icon/bat.png">野手シミュレーター</h2>
		</header>

		<div id="ui-tab">
			<ul class="tab_menu">
				<li><a class="tabMenu" href="#tab1">現在値</a></li>
				<li><a class="tabMenu" href="#tab2">目標値</a></li>
				<li><a class="tabMenu" href="#tab3">確認画面</a></li>
			</ul>
			<div id="tab1" class="tab_content">

				<section class="basePointSection">
					<p>■基礎能力<button class="exec" onclick="ga('send', 'event', 'action', 'click', 'batter/setRandomDefault');IndividModule.setRandomDefault();">ランダム</button><button class="exec" onclick="commonModule.openResetAbilityModal();">リセット</button></p>
					<table class="basePoint modern">
						<tr>
							<th>弾道</th>
							<th>ミート</th>
							<th>パワー</th>
							<th>走力</th>
							<th>肩力</th>
							<th>守備</th>
							<th>捕球</th>
						</tr>
						<tr class="baseRank">
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
						</tr>
						<tr>
							<td><input type="number" class="basePointInput" min="1" max="4" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="104" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="104" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="102" step="1"></td>
						</tr>
					</table>
				</section>

				<section class="abilitySection">
					<p>■特殊能力<button onclick="commonModule.openModalWindow(0);" class="addAbility">追加</button><span class="abilityCount">0個</span></p>
					<div class="displayAbility"></div>
				</section>

				<section class="abilitySection">
					<p>■サブポジ</p>
					<div class="displaySubPosition">
						<ul class="subPositionList">
							<?php
							require_once "getSubPositionList.php";
							getSubPositionList(0, 0);
							?>
						</ul>
					</div>
				</section>
			</div>



			<div id="tab2" class="tab_content">
				<section class="basePointSection">
					<p>■基礎能力<button class="exec" onclick="commonModule.openResetAbilityModal();">リセット</button></p>
					<table class="basePoint modern">
						<tr>
							<th>弾道</th>
							<th>ミート</th>
							<th>パワー</th>
							<th>走力</th>
							<th>肩力</th>
							<th>守備</th>
							<th>捕球</th>
						</tr>
						<tr class="baseRank">
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
							<td><div></div></td>
						</tr>
						<tr>
							<td><input type="number" class="basePointInput" min="1" max="4" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="104" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="100" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="104" step="1"></td>
							<td><input type="number" class="basePointInput" min="1" max="102" step="1"></td>
						</tr>
					</table>
				</section>

				<section class="abilitySection">
					<p>■特殊能力<button onclick="commonModule.openModalWindow(1);" class="addAbility">追加</button><span class="abilityCount">0個</span></p>
					<div class="displayAbility"></div>
				</section>

				<section class="abilitySection">
					<p>■サブポジ</p>
					<div class="displaySubPosition">
						<ul class="subPositionList">
							<?php
							require_once "getSubPositionList.php";
							getSubPositionList(0, 1);
							?>
						</ul>
					</div>
				</section>


			</div>


			<div id="tab3" class="tab_content">
				<section id="charaBaseData">
					<p>■選手情報</p>
					<input type="hidden" id="characterId" value="">
					<div>名前<input type="text" id="charaName" maxlength="20"></div>
					<div>
						ポジション
						<select id="mainPosition">
							<option value="0">捕手</option>
							<option value="1">一塁手</option>
							<option value="2">二塁手</option>
							<option value="3">三塁手</option>
							<option value="4">遊撃手</option>
							<option value="5" selected>外野手</option>
						</select>
					</div>
					<div>
						利き腕
						<select id="useHand">
							<option value="0">右投右打</option>
							<option value="1">右投左打</option>
							<option value="2">右投両打</option>
							<option value="3">左投右打</option>
							<option value="4">左投左打</option>
							<option value="5">左投両打</option>
						</select>
					</div>
				</section>

				<section>
					<p>■基礎コツ</p>
					<table class="baseTrickTable">
						<tr>
							<td class="baseTrickTitle">弾道</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
						<tr>
							<td class="baseTrickTitle">ミート</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
						<tr>
							<td class="baseTrickTitle">パワー</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
						<tr>
							<td class="baseTrickTitle">走力</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
						<tr>
							<td class="baseTrickTitle">肩力</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
						<tr>
							<td class="baseTrickTitle">守備</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
						<tr>
							<td class="baseTrickTitle">捕球</td>
							<td class="baseTrickBar">
								<div class="slider baseTrickSlider"></div>
							</td>
						</tr>
					</table>
				</section>

				<section class="baseLimitBreakArea">
					<p>■基礎上限突破</p>
					<div>
						ミート
						<select class="baseLimitBreak">
							<option value="100">100</option>
							<option value="102">102</option>
							<option value="102">104</option>
						</select>
					</div>
					<div>
						パワー
						<select class="baseLimitBreak">
							<option value="100">100</option>
						</select>
					</div>
					<div>
						走力
						<select class="baseLimitBreak">
							<option value="100">100</option>
						</select>
					</div>
					<div>
						肩力
						<select class="baseLimitBreak">
							<option value="100">100</option>
						</select>
					</div>
					<div>
						守備
						<select class="baseLimitBreak">
							<option value="100">100</option>
							<option value="102">102</option>
                            <option value="102">104</option>
                        </select>
					</div>
					<div>
						捕球
						<select class="baseLimitBreak">
							<option value="100">100</option>
							<option value="102">102</option>
						</select>
					</div>
				</section>

				<section>
					<p>■センス</p>
					<div>
						<ul class="senseButtonList">
							<li><label class="senseM"><input type="radio" name="senseGroup" value="1"><span>センス○</span></label></li>
							<li><label class="senseB"><input type="radio" name="senseGroup" value="-1"><span>センス×</span></label></li>
						</ul>
					</div>
				</section>
				<section>
					<p>■必要経験点<button class="exec calcExp" onclick="ga('send', 'event', 'action', 'click', 'batter/calcExpPoint');commonModule.calcExpPoint();">経験点算出</button></p>
					<table class="needExp modern">
						<tr>
							<th>筋力</th>
							<th>敏捷</th>
							<th>技術</th>
							<th>変化球</th>
							<th>精神</th>
							<th>合計</th>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>

					</table>
					<p class="optionChkArea"><input type="checkbox" id="nonAssessment">査定値を表示しない</p>
				</section>


				<section id="charaDataDisplay">
					<p>■選手データ-------</p>
					<div>
						<label id="faceLabel" for="sendFile" class="upLabel">
							<div class="imgBorder">
								<img id="charaImg" src="../img/noface.jpg" class="charaFace"><br clear="all">
							</div>
							<form id="sendForm" style="display:none;">
								<input type="file" id="sendFile" name="sendFile" accept="image/*" style="display:none;">
							</form>
						</label>
						<p>【登録名】<span id="entryNameCharaData"></span></p>
						<p>【ポジション】<span id="mainPositionCharaData"></span></p>
						<p>【サブポジ】<span id="subPositionCharaData"></span></p>
						<p>【投打】<span id="useHandCharaData"></span></p>
						<p>【基礎能力】<span id="baseAbilityCharaData"></span></p>
						<p>【特殊能力】</p>
						<div><ul id="abilityCharaData"></ul></div>
						<div class="assessmentArea">
							<div>【査定】<span id="assessmentPointCharaData"></span></div>
							<div class="meterFrame">
								<div class="meterGauge"></div>
							</div>
						</div>
					</div>

					<p>---------------------</p>
				</section>
				<section>
					<p>■査定最大化<button class="exec calcMax" onclick="ga('send', 'event', 'action', 'click', 'batter/calcMaxAssessment');calcMaxAssessmentModule.calcMaxAssessment();">実行</button></p>
					<table class="maxAssessment modern">
						<tr>
							<th>筋力</th>
							<th>敏捷</th>
							<th>技術</th>
							<th>変化球</th>
							<th>精神</th>
							<th>合計</th>
						</tr>
						<tr>
							<td><input type="number" class="pointInput" min="0" max="999"></td>
							<td><input type="number" class="pointInput" min="0" max="999"></td>
							<td><input type="number" class="pointInput" min="0" max="999"></td>
							<td><input type="number" class="pointInput" min="0" max="999" disabled></td>
							<td><input type="number" class="pointInput" min="0" max="999"></td>
							<td class="ownPointTotal"></td>
						</tr>
					</table>
					<p class="optionChkArea"><input type="checkbox" id="nonCatcher">キャッチャー○を取得しない<br><input type="checkbox" id="nonMoody">気分屋を取得しない</p>


				</section>
				<section>
					<p>■選手データ保存</p>
					<div class="userForm">
						<p>
							<button class="exec save" onclick="commonModule.saveCharaData(0)">保存</button>
<!--							<button class="exec"onclick="commonModule.screenShot()">画像出力</button>-->
						</p>
					</div>
					<div class="shareLinkHeader">▼共有用URL</div>
					<div class="shareLinkBody"></div>
				</section>
			</div>


		</div>



		<div id="abilityModal" class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking:false, closeOnCancel:false, closeOnConfirm:false, closeOnEscape:false">
			<button class="remodal-close" onclick="commonModule.ConfirmRemodal()"></button>
			<div id="abilityList">
				<div id="abSelectList" class="container-fluid">

					<div class="groupHeader"><img class="iconGraph" src="../img/icon/bat.png">特能</div>
					<hr class="abHr">
					<div class="abSelectHeader">
						<div></div>
						<div>特能名</div>
						<div></div>
						<div>青ｺﾂ</div>
						<div>金ｺﾂ</div>
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
							<div><button class="abTrickLevel"<?= !$d['abTrick'] ? ' disabled' : ''?>>0</button></div>
							<div><button class="SabTrickLevel"<?= !$d['SabTrick'] ? ' disabled' : ''?>>0</button></div>
						</li>
					<?php } ?>
					<?php } ?>
					</ul>

					<div class="groupHeader"><i class="fa fa-times iconGraph" aria-hidden="true"></i>マイナス特能</div>
					<hr class="abHr">

					<div class="abSelectHeader">
						<div></div>
						<div>特能名</div>
						<div></div>
						<div>青ｺﾂ</div>
						<div>金ｺﾂ</div>
					</div>

					<ul class="abilityButtonList">

						<?php
						require_once "getAbilityList.php";
						$data = getAbilityList(0);

						for ($i = 0; $i < count($data); $i++) {
							$d = $data[$i];
							if ($d['category'] === '9') { ?>

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
							<div><button class="abTrickLevel"<?= !$d['abTrick'] ? ' disabled' : ''?>>0</button></div>
							<div><button class="SabTrickLevel"<?= !$d['SabTrick'] ? ' disabled' : ''?>>0</button></div>
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

		<div id="resetAbilityModal" class="remodal" data-remodal-id="resetAbilityModal" data-remodal-options="hashTracking:false">
			<button data-remodal-action="cancel" class="remodal-close"></button>
			<div>
				<i class="fa fa-warning" style="color:#f00;"></i>入力した内容(基礎能力値、特殊能力、コツLv、サブポジ)を全てリセットします。
			</div>
			<div class="modalButton">
				<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
				<button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
			</div>
		</div>

		<div id="trickDropdown">
			<div class="trickLevelVal">0</div>
			<div class="trickLevelVal">1</div>
			<div class="trickLevelVal">2</div>
			<div class="trickLevelVal">3</div>
			<div class="trickLevelVal">4</div>
			<div class="trickLevelVal">5</div>
		</div>

		<input type="hidden" id="abilityTotalCount" value="<?php include('../php/getAbilityCount.php'); ?>" />
	</main>

	<?php include('./optionMenu.php'); ?>

	<?php include('../html/footer.html'); ?>
</body>

</html>
