<!-- フロートメニュー -->
<div class="floatMenu" onclick="$.remodal.lookup[$('[data-remodal-id=optionModal]').data('remodal')].open();">
	<i class="fa fa-cog fa-3x" aria-hidden="true"></i>
</div>

<!--オプション用モーダルウインドウ-->
<div id="optionModal" class="remodal" data-remodal-id="optionModal" data-remodal-options="hashTracking:false">
	<button data-remodal-action="close" class="remodal-close"></button>


	<section id="userInfo" class="remodalSection">
		<header>
			<h4><i class="fa fa-user"></i>ユーザー情報<i class="fa fa-question-circle" style="color:#0000ff; margin-left:1em;"></i></h4>
			<p class="arrow_box">
				ユーザー情報は、選手やデッキの保存機能、デッキお気に入り機能に使用されます。<br>
				ユーザー名、パスワードは半角英数字で8文字以上20文字以内にしてください。<br>
				TwitterIdは@を入れずに半角英数字(記号)で入力してください。
			</p>
		</header>
		<hr class="optionHr">
		<div class="templateOption">
			<dl id="userInfoForm">
				<dt>ユーザー名</dt>
				<dd><input type="text" id="loginUserName" data-minlength="8" data-maxlength="20"></dd>
				<dt>パスワード</dt>
				<dd>
					<input type="password" id="loginPassword" data-minlength="8" data-maxlength="20">
					<input type="text" id="confirmPassword" style="display:none;" readonly>
				</dd>
				<dt>パワプロID</dt>
				<dd><input type="text" id="loginPawaproId" data-maxlength="10"></dd>
				<dt>TwitterID</dt>
				<dd><input type="text" id="loginTwitterId" data-maxlength="15"></dd>
			</dl>
		</div>
		<div><span id="passWatch"><i class="fa fa-wifi"></i>パスワード表示</span></div>
	</section>

	<?php if (basename($_SERVER['PHP_SELF']) === 'batter.php' || basename($_SERVER['PHP_SELF']) === 'pitcher.php') { ?>
	<section class="remodalSection">
		<header>
			<h4><i class="fa fa-wrench"></i>テンプレート設定<i class="fa fa-question-circle" style="color:#0000ff; margin-left:1em;"></i></h4>
			<p class="arrow_box">
				毎回必ず取得する特能を保存しておき、ワンタッチで画面に反映する機能です。<br>
				「テンプレートを画面に反映」ボタンで「現在値」タブで取得済みの特能をブラウザに保存します。<br>
				「入力内容をテンプレートに設定」ボタンで保存した特能情報を「現在値」タブと「目標値」タブに反映します。
			</p>
		</header>
		<hr class="optionHr">
		<div class="templateOption">
			<div>
				<button onclick="commonModule.setAbilityTemplate();">テンプレートを画面に反映</button>
			</div>
			<div>
				<button onclick="$.remodal.lookup[$('[data-remodal-id=confirmTamplateModal]').data('remodal')].open();">入力内容をテンプレートに設定</button>
			</div>
		</div>
	</section>
	<?php } ?>

	<div class="modalButton">
		<button data-remodal-action="confirm" class="remodal-confirm">ClOSE</button>
	</div>
</div>

<?php if (basename($_SERVER['PHP_SELF']) === 'batter.php' || basename($_SERVER['PHP_SELF']) === 'pitcher.php') { ?>

<div id="confirmTamplateModal" class="remodal" data-remodal-id="confirmTamplateModal" data-remodal-options="hashTracking:false">
	<p><i class="fa fa-info-circle" aria-hidden="true" style="color:#0ff"></i>現在値タブの特能設定値を<br>テンプレートに保存します。</p>
	<div class="modalButton">
		<button class="remodal-confirm" onclick="commonModule.saveAbilityTemplate();">OK</button>
		<button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
	</div>
</div>

<div id="doneTemplateModal" class="remodal" data-remodal-id="doneTemplateModal" data-remodal-options="hashTracking:false">
	<p>テンプレートを保存しました。</p>
	<div class="modalButton">
		<button data-remodal-action="confirm" class="remodal-confirm">OK</button>
	</div>
</div>

<?php } ?>

