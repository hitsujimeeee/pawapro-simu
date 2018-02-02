<!DOCTYPE html>
<html lang="ja">
<head>
	<?php
	$title = 'パワプロアプリ育成シミュレーター | 使い方';
	$description = 'パワプロアプリの育成シミュレーターです。目標選手の育成に必要な経験点を計算してくれます。';
	require_once './headInclude.php';
	?>
	<link rel="stylesheet" href="../css/manual.css">
</head>
<body>
	<?php include('./header.php'); ?>

	<main>
		<header class="pageHeader">
			<h2 id="title"><i class="fa fa-book"></i>パワプロアプリ育成シミュレーター 使い方</h2>
		</header>

		<section>
			<h3 class="contentHeader">■目次</h3>
			<ul>
				<li><a href="#idx1">育成シミュレーターの使い方</a>
					<ul>
						<li><a href="#idx1-1">各タブの役割</a></li>
						<li><a href="#idx1-2">能力の入力方法</a></li>
						<li><a href="#idx1-3">特殊能力の選択方法</a></li>
						<li><a href="#idx1-4">経験点の算出方法</a></li>
						<li><a href="#idx1-5">査定最大化機能</a></li>
						<li><a href="#idx1-6">保存機能</a></li>
						<li><a href="#idx1-7">選手画像のアップロード</a></li>
						<li><a href="#idx1-8">選手情報の共有</a></li>
						<li><a href="#idx1-9">投手査定最大化の注意事項</a></li>
					</ul>
				</li>
				<li><a href="#idx2">デッキシェア機能の使い方</a>
					<ul>
						<li><a href="#idx2-1">機能説明</a></li>
						<li><a href="#idx2-2">デッキを作る</a></li>
						<li><a href="#idx2-3">デッキを登録する</a></li>
						<li><a href="#idx2-4">作成済みデッキを編集する</a></li>
						<li><a href="#idx2-5">デッキを探す</a></li>
						<li><a href="#idx2-6">デッキをお気に入り登録する</a></li>
						<li><a href="#idx2-7">デッキを共有する</a></li>
					</ul>
				</li>
				<li><a href="#idx3">上限開放予報士くんの使い方</a>
					<ul>
						<li><a href="#idx3-1">機能説明</a></li>
						<li><a href="#idx3-2">使い方</a></li>
						<li><a href="#idx3-3">素材合成を有効にする</a></li>
						<li><a href="#idx3-4">注意事項</a></li>
					</ul>
				</li>
				<li><a href="#idx4">課金額予想シミュレーターの使い方</a>
					<ul>
						<li><a href="#idx4-1">機能説明</a></li>
						<li><a href="#idx4-2">使い方</a></li>
						<li><a href="#idx4-3">素材合成を有効にする</a></li>
						<li><a href="#idx4-4">注意事項</a></li>
					</ul>
				</li>
				<li><a href="#idx5">パワプロクイズの使い方</a>
					<ul>
						<li><a href="#idx5-1">機能説明</a></li>
						<li><a href="#idx5-2">クイズに挑戦する</a></li>
						<li><a href="#idx5-3">問題を作る</a></li>
						<li><a href="#idx5-4">問題作成に関して注意事項</a></li>
					</ul>
				</li>
			</ul>
			<hr class="abHr">
		</section>



		<section>
			<h3 class="contentHeader" id="idx1">■育成シミュレーターの使い方</h3>

			<section>
				<div>
					<img src="../img/manual/01-01-01.jpg">
				</div>
				<h3 id="idx1-1" class="sectionHeader"><i class="fa fa-pencil"></i>各タブの役割</h3>
				<dl class="descDefList">
					<dt>①現在値</dt>
					<dd>選手の現在のステータスを入力する部分です。</dd>
					<dt>②目標値</dt>
					<dd>目標とするステータスを入力する部分です。</dd>
					<dt>③確認画面</dt>
					<dd>選手名やポジション、基礎コツ、センス有無などの情報を入力する部分です。<br>計算した経験点はこのタブに表示されます。</dd>
				</dl>
			</section>

			<section>
				<h3 id="idx1-2" class="sectionHeader"><i class="fa fa-mouse-pointer"></i>各能力の入力方法</h3>
				<dl class="descDefList">
					<dt>・基礎能力</dt>
					<dd>
						キーボードから入力します<br>
						<div>野手：弾道、ミート、パワー、走力、肩力、守備、捕球</div>
						<div>投手：球速、コントロール、スタミナ</div>
					</dd>
					<dt>・変化球(投手のみ)</dt>
					<dd>
						球種、変化量をリストから選択します。
					</dd>
					<dt>・特殊能力</dt>
					<dd>
						「追加」ボタンを押すと、特殊能力リストが表示されます。
					</dd>
					<dt>・サブポジ</dt>
					<dd>
						取得したいサブポジをクリックすると、選択ウインドウが表示されます。
					</dd>
				</dl>
			</section>

			<section>
				<h3 id="idx1-3" class="sectionHeader"><i class="fa fa-hand-pointer-o"></i>特殊能力の選択方法</h3>
				<div><img src="../img/manual/01-03-01.jpg"></div>
				<p>現在値タブ、目標値タブで特殊能力の「追加」ボタンを押すと、特殊能力リストが表示されます。</p>
				<div><img src="../img/manual/01-03-02.jpg"></div>
				<p>特殊能力リスト上で習得したい特殊能力をクリックすると、特能選択ウインドウが表示されます。</p>
				<div><img src="../img/manual/01-03-03.jpg"></div>
				<p>特殊能力、コツを設定してOKボタンを押します。</p>
				<div><img src="../img/manual/01-03-04.jpg"></div>
				<p>特殊能力リストに選択した内容が反映されます。</p>
				<div><img src="../img/manual/01-03-05.jpg"></div>
				<p>
					特殊能力リスト左上の×ボタン、もしくは下部のOKボタンをクリックすると、特殊能力リスト画面を閉じます。<br>
					選択した特殊能力の一覧が特殊能力欄に、表示されます。
				</p>
			</section>

			<section>
				<h3 id="idx1-4" class="sectionHeader"><i class="fa fa-calculator"></i>経験点の算出方法</h3>
				<div><img src="../img/manual/01-04-01.jpg"></div>
				<div><img src="../img/manual/01-04-02.jpg"></div>
				<p>現在値と目標値を設定したら、確認画面タブに移動します。</p>
				<div><img src="../img/manual/01-04-03.jpg"></div>
				<p>経験点算出ボタンをクリックします。</p>
				<div><img src="../img/manual/01-04-04.jpg"></div>
				<p>現在値から目標値に達するまでに必要な経験点が表示されます。</p>
			</section>

			<section id="idx1-5">
				<h3 class="sectionHeader"><img class="iconGraph" src="../img/icon/muscle.png">査定最大化機能</h3>
				<div><img src="../img/manual/01-05-01.jpg"></div>
				<p>現在値タブで現在の能力、各習得済みコツを設定します。</p>
				<div><img src="../img/manual/01-05-02.jpg"></div>
				<p>確認画面タブの査定最大化欄に所持経験点を入力し、「実行」ボタンをクリックします。</p>
				<div><img src="../img/manual/01-05-03.jpg"></div>
				<p>
					査定最大化処理が行われ、目標値タブに査定を最大化した場合のステータスが表示されます。<br>
					※入力内容によっては、処理に時間がかかる場合があります。
				</p>
			</section>
			<section id="saveSection">
				<h3 id="idx1-6" class="sectionHeader"><i class="fa fa-floppy-o"></i>保存機能</h3>
				<h4>●入力した選手情報を保存する</h4>
				<p>
					画面右下の「<i class="fa fa-gear"></i>設定」ボタンをクリックし、設定ウインドウを開きます。<br>
				</p>
				<div><img src="../img/manual/01-06-01.jpg"></div>
				<p>
					ユーザー名、パスワードを入力し「OK」ボタンをクリックします。<br>
					<span style="color:#ff0000;">※ユーザー登録の必要はありません。ユーザー名とパスワードの組み合わせに紐づけて選手データが保存されます。<br>　他の人と被る事が無いようなる複雑なパスワードを設定してください。</span><br>
					ユーザー名、パスワードはともに半角英数字で8～20文字にしてください。<br>
				</p>
				<div><img src="../img/manual/01-06-02.jpg"></div>
				<p>
					確認画面タブ最下部の「保存」ボタンをクリックします。
				</p>
				<div><img src="../img/manual/01-06-03.jpg"></div>
				<p>作成した選手のデータが保存されます。</p>
				<div><img src="../img/manual/01-06-04.jpg"></div>
				<h4>●保存した選手情報を表示する</h4>
				<p>トップ画面で「作成選手一覧」リンクをクリックします。</p>
				<div><img src="../img/manual/01-06-05.jpg"></div>
				<div><img src="../img/manual/01-06-06.jpg"></div>
				<p>
					「<i class="fa fa-gear"></i>設定」ウインドウに入力済みのユーザー名、パスワードで登録した選手情報の一覧で表示されます。<br>
					編集ボタンを押すと選手情報の編集画面へと遷移します。
				</p>
			</section>

			<section>
				<h3 id="idx1-7" class="sectionHeader"><i class="fa fa-link"></i>選手画像のアップロード</h3>
				<p>
					登録した選手にお好みの画像を設定できます。<br><br>
					「確認画面」タブ内の選手情報にある画像の部分をクリックします。
				</p>
				<div><img src="../img/manual/01-07-01.jpg"></div>
				<p>
					PC(スマフォ)内の画像を選択します
				</p>
				<div><img src="../img/manual/01-07-02.jpg"></div>
				<p>
					選択した画像が選手の画像として使用されます。<br>
					「保存」ボタンを押すと登録が完了し、次回以降も選択した画像で表示されます。
				</p>
				<div><img src="../img/manual/01-07-03.jpg"></div>
			</section>

			<section>
				<h3 id="idx1-8" class="sectionHeader"><i class="fa fa-link"></i>選手情報の共有</h3>
				<div><img src="../img/manual/01-08-01.jpg"></div>
				<p>
					作成選手一覧画面から選手情報の編集を押して表示される画面のURLを使用することで、他のユーザーに選手情報を共有できます。<br>
					他のユーザーが共有URLから選手情報を参照し、選手情報を変更した場合でも、共有元の選手情報が更新されることはありません。<br>
					共有されたユーザーの新しい選手情報として新規作成されます。
				</p>
			</section>
			<section>
				<h3 id="idx1-9" class="sectionHeader"><i class="fa fa-warning"></i>投手査定最大化の注意事項</h3>
				<p>
					・投手査定最大化は、<span style="color:red">球速コンスタと投手特殊能力のみ</span>振り分けを行います。変化球に振りたい場合は先に振っておいてください。
				</p>
				<p>
					・<span style="color:blue">バント封じ</span>は査定が特殊なので取得しません。取りたい場合は先に取ってからお願いします。
				</p>
				<p>
					・この査定最大化ツールは<span style="color:red">先発用</span>の査定表を基に査定を最大化しています。もし中継ぎや抑えを作りたい場合、<span style="color:red">「スタミナを上げない」</span>にチェックを入れて最大化を行った方が良いかもしれません。
				</p>
				<p>
					・シミュレーターに入力した現在値が以下の能力を満たしている場合のみ球速コンスタと投手特殊能力の査定最大化が可能です。<br>
				</p>
				<ol style="font-weight:bold">
					<li>基礎能力(球速コンスタ変化球)の査定が以下の査定表で101ポイント以上の選手</li>
					<li>変化球が2方向、総変量12～14の選手</li>
					<li>ナックルカーブ、ナックル、チェンジアップ、サークルチェンジ、オリジナル変化球を覚えていない選手</li>
				</ol>
				<p>
					育成選手がこれらの条件を満たしていな場合は<span style="color:red">「特殊能力のみ振り分け」</span>が行われます。
				</p>
				<div><a href="../img/manual/01-09-01.jpg" target="_blank"><img src="../img/manual/01-09-01.jpg"></a></div>


			</section>
		</section>

		<section>
			<h3 class="contentHeader" id="idx2">■デッキシェア機能の使い方</h3>
			<section>
				<h3 id="idx2-1" class="sectionHeader"><i class="fa fa-info-circle"></i>機能説明</h3>
				<div><img src="../img/manual/02-01-01.jpg"></div>
				<p>
					デッキシェア機能では、自分の考えたデッキを他のユーザーに公開したり、他のユーザーが考えたデッキを見たりすることができます。<br>
					検索機能を使って様々な条件でデッキを検索したり、お気に入り機能で興味のあるデッキをブックマークする事ができます。
				</p>
			</section>

			<section>
				<h3 id="idx2-2" class="sectionHeader"><i class="fa fa-wrench"></i>デッキを作る</h3>
				<p>
					<a href="./deckShare.php">デッキシェアページ</a>から、<i class="fa fa-wrench"></i>作るボタンをクリックします。<br>
				</p>
				<div><img src="../img/manual/02-02-01.jpg"></div>
				<p>
					新規作成ボタンをクリックします。<br>
				</p>
				<div><img src="../img/manual/02-02-02.jpg"></div>
				<p>
					デッキ作成画面へ移動します。<br>
					画面上の入力可能項目を入力していきます。
				</p>
				<div><img src="../img/manual/02-02-03.jpg"></div>
				<p class="dlTitle">▼入力可能項目</p>
				<dl class="defList">
					<dt>デッキ名</dt>
					<dd>30文字以内</dd>
					<dt>イベキャラ</dt>
					<dd>
						編集ボタンからイベキャラ一覧ウインドウを開き、デッキにセットしたいイベキャラを選択します。<br>
						Lvとレアリティも入力できます。
					</dd>
					<dt>育成タイプ</dt>
					<dd>このデッキを使って育成する選手のタイプを設定します。</dd>
					<dt>対象高校</dt>
					<dd>どの高校での育成に適しているかを設定します。</dd>
					<dt>特徴・コンセプト</dt>
					<dd>このデッキの特徴、長所や注意点などを500文字以内で自由に記述できます。</dd>
					<dt>作成選手一覧</dt>
					<dd>
						このデッキを使用して作成した選手を設定できます。<br>
						選手の登録の方法は<a href="#idx1-6">入力した選手情報を保存する</a>を参照してください。
					</dd>
					<dt>作者情報</dt>
					<dd>
						作者名、パワプロID,TwitterID等を入力できます。<br>
						画面右下の<i class="fa fa-gear"></i>設定ボタンから入力できるユーザー情報にすでにパワプロID,TwitterIDを入力済みの場合、その情報が自動で反映されます。<br>
						TwitterIDは@を抜いたものを記入して下さい。
					</dd>
				</dl>
			</section>

			<section>
				<h3 id="idx2-3" class="sectionHeader"><i class="fa fa-wrench"></i>デッキを登録する</h3>
				<p>
					デッキ作成画面下部の保存ボタンをクリックします。
					※保存機能を利用するには、ユーザー名とパスワードが入力済みでなければなりません。<br>
					ユーザー登録は不要です。画面右下の<i class="fa fa-gear"></i>設定ボタンを開き、ユーザー名、パスワード欄に好きな値を設定してください。<br>
				</p>
				<div><img src="../img/manual/02-03-01.jpg"></div>
				<p>
					「デッキを新規登録しました」と表示されれば登録は完了です。
				</p>
				<div><img src="../img/manual/02-03-02.jpg"></div>
			</section>

			<section>
				<h3 id="idx2-4" class="sectionHeader"><i class="fa fa-wrench"></i>作成済みデッキを編集する</h3>
				<p>
					デッキを登録した後にデッキ一覧画面を開くと、登録したデッキの一覧が表示されます。<br>
					編集したいデッキをクリックすると、デッキ編集画面に移動します。<br>
					編集画面での操作方法は、デッキ作成画面と同じです。
				</p>
				<div><img src="../img/manual/02-04-01.jpg"></div>
				<p>
					デッキの編集が終わったら、保存ボタンをクリックします。<br>
					「デッキを更新しました」と表示されれば、編集は完了です。
				</p>
			</section>
			<section>
				<h3 id="idx2-5" class="sectionHeader"><i class="fa fa-search"></i>デッキを探す</h3>
				<p>
					<a href="./deckShare.php">デッキシェアページ</a>から、<i class="fa fa-search"></i>探すボタンをクリックします。<br>
				</p>
				<div><img src="../img/manual/02-05-01.jpg"></div>
				<p>
					検索画面に移動したら、検索項目の設定を行います。<br>
				</p>
				<div><img src="../img/manual/02-05-02.jpg"></div>
				<p class="dlTitle">▼検索項目</p>
				<dl class="defList">
					<dt>デッキ名</dt>
					<dd>検索ワードがデッキ名に含まれるデッキがヒットします。空欄の場合は条件から除外されます。</dd>
					<dt>育成タイプ</dt>
					<dd>「指定なし」の場合、条件から除外されます。</dd>
					<dt>対象高校</dt>
					<dd>「指定なし」の場合、条件から除外されます。</dd>
					<dt>イベキャラ</dt>
					<dd>
						選択したイベキャラを使用しているデッキがヒットします。空欄の場合は条件から除外されます。<br>
						※Ver違いを指定する場合、そのVerを指定しないと検索にヒットしません。
					</dd>
					<dt>作者名</dt>
					<dd>空欄の場合は条件から除外されます。</dd>
					<dt>Twitter</dt>
					<dd>空欄の場合は条件から除外されます。</dd>
					<dt>お気に入りのみ</dt>
					<dd>このチェックを入れると、自分がお気に入り登録したデッキのみが画面に表示されます。</dd>
				</dl>
				<p>検索で表示されるデッキは、検索条件に入力した全ての条件を満たすデッキになります。</p>
				<p>条件を設定せずに検索した場合、登録されている全てのデッキを表示します。</p>
				<p>「リセット」ボタンを押すことで、入力した条件をリセットします。</p>

				<div><img src="../img/manual/02-05-03.jpg"></div>

				<p>
					設定が完了したら「検索」ボタンを押すと検索が行われます。<br>
					検索条件に合致した検索条件フォーム下に表示されます。
				</p>
				<div><img src="../img/manual/02-05-04.jpg"></div>
				<p>
					詳細を見たいデッキをクリックすると、詳細ページに移動します。
				</p>
				<div><img src="../img/manual/02-05-05.jpg"></div>
			</section>

			<section>
				<h3 id="idx2-6" class="sectionHeader"><i class="fa fa-search"></i>デッキをお気に入り登録する</h3>
				<p>
					デッキ詳細画面下部の「お気に入り」ボタンを押すことで、閲覧しているデッキをお気に入り登録できます。
				</p>
				<div><img src="../img/manual/02-06-01.jpg"></div>
				<p>
					「お気に入り登録しました」と表示されれば完了です。
				</p>
				<div><img src="../img/manual/02-06-02.jpg"></div>
				<p>
					お気に入り済みのデッキは、お気に入りボタンが黄色くなります。<br>
					お気に入りボタンをもう一度押すと、お気に入り解除できます。<br>
					※お気に入り機能を使うには、ユーザー名、パスワードの入力が必要です。
				</p>

			</section>

			<section>
				<h3 id="idx2-7" class="sectionHeader"><i class="fa fa-search"></i>デッキを共有する</h3>
				<p>
					デッキ作成(編集)画面下の公開用URLを使用して、作成したデッキを他サイトで公開することができます。
				</p>
				<div><img src="../img/manual/02-07-01.jpg"></div>
				<p>
					また、デッキ詳細画面のURLを使用して公開することもできます。
				</p>
				<div><img src="../img/manual/02-07-02.jpg"></div>
			</section>

		</section>


		<section>
			<h3 class="contentHeader" id="idx3">■上限開放予報士くんの使い方</h3>
			<section>
				<h3 id="idx3-1" class="sectionHeader"><i class="fa fa-info-circle"></i>機能説明</h3>
				<div><a href="../img/manual/03-01-01.jpg" target="_blank"><img src="../img/manual/03-01-01.jpg"></a></div>
				<p>
					上限開放予報士くんは、手持ちの合成素材でどれぐらい上限開放出来るか、開放数毎の確率を計算してくれるツールです。
				</p>
			</section>
			<section>
				<h3 id="idx3-2" class="sectionHeader"><i class="fa fa-bar-chart"></i>使い方</h3>
				<div><a href="../img/manual/03-02-01.jpg" target="_blank"><img src="../img/manual/03-02-01.jpg"></a></div>
				<p>
					<b>上限開放を行いたいイベキャラ</b>のレアリティ、現在の開放数を入力します。
				</p>
				<div><a href="../img/manual/03-02-02.jpg" target="_blank"><img src="../img/manual/03-02-02.jpg"></a></div>
				<p>
					手持ちの合成素材を入力します。合成素材はR～PSRの各レアリティ毎に「同ver,別ver,+5開放済み」の枚数を入力できます。<br>
					<span style="color:#f00;">※開放数+1～+4には対応していません。開放数+1～+4は開放0として入力してください。</span><br><br>
				</p>
				<div><a href="../img/manual/03-02-03.jpg" target="_blank"><img src="../img/manual/03-02-03.jpg"></a></div>
				<p>
					「実行」ボタンを押下します。
				</p>
				<div><a href="../img/manual/03-02-04.jpg" target="_blank"><img src="../img/manual/03-02-04.jpg"></a></div>
				<p>
					計算された上限開放率が表示されます。最も確率の高い開放数は赤色で表示されます。<br>
					<span style="color:#f00;">
						※表示される開放数は、<b>現在の状態からどれくらい開放出来るか</b>を表しています。<br>
						　現在の状態が+1の場合、表示される最大開放数は+4になります。
					</span><br>
				</p>
			</section>
			<section>
				<h3 id="idx3-3" class="sectionHeader"><i class="fa fa-cube"></i>素材合成を有効にする</h3>
				<p>
					素材合成は、下位レアリティの素材を上位レアリティの素材に合成する事で、開放を効率的に行う機能です。<br>
					例えば、SRにPRを合成する場合、RだけでPR+5を作るぐらい素材があれば、まずはPR+5を作ってからその上でSRに合成するといったようにします。<br>
					素材合成は同じレアリティ同士で行いません(PRをPRに合成してPR+5を作るような事はありません)。常に一つ上のレアリティに対して合成します。
				</p>
				<div><a href="../img/manual/03-03-01.jpg" target="_blank"><img src="../img/manual/03-03-01.jpg"></a></div>
				<p>
					素材合成を行うには、「素材合成を行う」にチェックを入れ、閾値を入力します。(閾値のデフォルトは70%)<br>
					素材合成時に使用する下位素材の数は、閾値によって決定されます。<br><br>

					例えば、RをPRに合成する場合、PRが+5になる確率はRが10枚の場合は15%、Rが15枚の場合は48%,Rが18枚の場合は67%,Rが19枚の場合は72%です。<br>
					閾値を70%に設定した場合、PR+5になる確率が70%以上になる枚数のRを使用して素材合成を行います。+5開放率が70%を超すのはRを19枚使用した時からのため、PR1枚とR19枚を消費してPR+5を1枚作ります。
				</p>
				<div><a href="../img/manual/03-03-02.jpg" target="_blank"><img src="../img/manual/03-03-02.jpg"></a></div>
				<p>
					素材合成を行った場合、合成後の素材の数が表示されます。<br>
					図の例では、PR1枚とR19枚を使用してPR+5を作り、そのPR+5を1枚とPR14枚でSR+5を1枚作っています。<br>
					素材合成をしなかった場合と比べると、+1は0%になるため出現しなくなり、また最大開放の確率が上がっています。<br>
				</p>
			</section>
			<section>
				<h3 id="idx3-4" class="sectionHeader"><i class="fa fa-warning"></i>注意事項</h3>
				<ul>
					<li>素材の枚数が多いなど処理に時間がかかる場合は処理を行わない事があります。その際は素材の枚数を減らすか、素材合成を行う等してください。</li>
					<li>ご利用は自己責任でお願いします。</li>
				</ul>
			</section>
		</section>

		<section>
			<h3 class="contentHeader" id="idx4">■課金額予想シミュレーターの使い方</h3>
			<section>
				<h3 id="idx4-1" class="sectionHeader"><i class="fa fa-info-circle"></i>機能説明</h3>
				<div><a href="../img/manual/04-01-01.jpg" target="_blank"><img src="../img/manual/04-01-01.jpg"></a></div>
				<p>
					課金額予想シミュレーターは、ガチャでお目当てのイベキャラをPSR50、またはSR45にするために大体幾らかかるを計算してくれるツールです。<br>
					画面から入力された内容で10連ガチャと合成を繰り返し、目標を達成するまでに何回かかったかを表示します。そのため毎回結果にバラツキがあります。<br>
					オプションの「1万回やって統計を取る」を有効にすると、バラツキを抑えつつ結果を統計的に見ることができます。<br>
					入力するガチャ情報は6回目以降(それ以上SR率、確定枠が変化しない回以降)を入力してください。
				</p>
			</section>

			<section>
				<h3 id="idx4-2" class="sectionHeader"><i class="fa fa-bar-chart"></i>使い方</h3>
				<p>
					まず初めに目標とするイベキャラのレアリティを設定します。<br>「PSR50」と「SR45」から選択できます。
				</p>
				<div><a href="../img/manual/04-02-01.jpg" target="_blank"><img src="../img/manual/04-02-01.jpg"></a></div>
				<p>
					次に目標キャラを既に取得済みの場合は現在所持している開放数を設定します。<br>
				</p>
				<div><a href="../img/manual/04-02-02.jpg" target="_blank"><img src="../img/manual/04-02-02.jpg"></a></div>
				<p>
					ガチャの出現割合を設定します。各レアリティ毎の出現率を入力してください。<br>
					デフォルトでは通常ガチャの確率が入力されています。
				</p>
				<div><a href="../img/manual/04-02-03.jpg" target="_blank"><img src="../img/manual/04-02-03.jpg"></a></div>
				<p>
					出現するイベキャラの種類を設定します。ピックアップキャラの数、ピックアップキャラ以外の数、ピックアップキャラの出現率を入力してください。<br>
					大ピックアップ、小ピックアップ両方あるガチャの場合は、自分の目標とするイベキャラの含まれるピックアップの設定を入力してください。<br>
					ピックアップ無しの場合、「ピックアップキャラ数」に「0」、「上記以外のキャラ数」に出現する全イベキャラの数を入力してください。<br>
				</p>
				<div><a href="../img/manual/04-02-04.jpg" target="_blank"><img src="../img/manual/04-02-04.jpg"></a></div>
				<p>
					「PR1枚確定」等の確定枠がある場合はその情報を設定します。<br>
				</p>
				<div><a href="../img/manual/04-02-05.jpg" target="_blank"><img src="../img/manual/04-02-05.jpg"></a></div>
				<p>
					シミュレーションのオプションを入力します。<br>
				</p>
				<dl class="defList">
					<dt>PSRをSRの素材にする</dt>
					<dd>目標が「SR45」の時、この項目にチェックを入れた場合に手に入ったPSRをSRに合成するようにします。</dd>
					<dt>素材合成をON</dt>
					<dd>この項目にチェックを入れた場合、PRやRをPSRに直接合成せずに、PR+5やSR+5等を作って効率的に合成するようになります。</dd>
					<dt>1万回やって統計を取る</dt>
					<dd>この項目にチェックを入れた場合、「目標を達成するまで10連ガチャと合成を繰り返す」処理1万回行って、その統計を表示します。<br></dd>
				</dl>
				<div><a href="../img/manual/04-02-06.jpg" target="_blank"><img src="../img/manual/04-02-06.jpg"></a></div>
				<p>
					「計算開始」ボタンを押して処理を実行します。<br>
				</p>
				<div><a href="../img/manual/04-02-07.jpg" target="_blank"><img src="../img/manual/04-02-07.jpg"></a></div>
				<p>
					画面に結果が表示されます。<br>
				</p>
				<div><a href="../img/manual/04-02-08.jpg" target="_blank"><img src="../img/manual/04-02-08.jpg"></a></div>
			</section>
			<section>
				<h3 id="idx4-3" class="sectionHeader"><i class="fa fa-warning"></i>注意事項</h3>
				<p>
					このツールで表示された結果は、その金額かければ必ず目標を達成できると保証するものではありません。運が悪いと表示結果の十倍の金額かけても目標達成できないことがあります。あくまで課金額の目安を図るツールとしてお使いください。<br>
					ご利用は自己責任でお願いします。
				</p>
			</section>
		</section>
		<section>
			<h3 class="contentHeader" id="idx5">■パワプロクイズの使い方</h3>
			<section>
				<h3 id="idx5-1" class="sectionHeader"><i class="fa fa-graduation-cap"></i>機能説明</h3>
				<div><a href="../img/manual/05-01-01.jpg" target="_blank"><img src="../img/manual/05-01-01.jpg"></a></div>
				<p>
					パワプロの四択クイズに挑戦できます。全部で10問、沢山のクイズの中からランダムで出題されます。<br>
					また、クイズを作成して他のプレイヤーに出題する事もできます。
				</p>
			</section>
			<section>
				<h3 id="idx5-2" class="sectionHeader"><i class="fa fa-info-circle"></i>クイズに挑戦する</h3>
				<p>
					パワプロクイズのメイン画面で「挑戦する」ボタンをクリックします。
				</p>
				<div><a href="../img/manual/05-02-01.jpg" target="_blank"><img src="../img/manual/05-02-01.jpg"></a></div>
				<p>
					画面上に問題が出題されます。青い枠で表示される４つの選択肢の中から正解だと思うものをクリックしてください。
				</p>
				<div><a href="../img/manual/05-02-02.jpg" target="_blank"><img src="../img/manual/05-02-02.jpg"></a></div>
				<p>
					正解した場合、選んだ選択肢が緑色に表示されます。不正解の場合は選んだ選択肢が赤く表示され、正解の選択肢が緑色に表示されます。<br>
				</p>
				<div><a href="../img/manual/05-02-03.jpg" target="_blank"><img src="../img/manual/05-02-03.jpg"></a></div>
				<p>
					解説欄右下のGOODボタンとBADボタンで、問題に対しての評価を行えます。
					良い問題だと思ったらGOODを。不快な問題、解答が間違ってる場合はBADで投票してください。<br>
					画面左下の「次へ」ボタンを押すことで次の問題が出題されます。10問答えると結果確認画面へ移動します。
				</p>
			</section>
			<section>
				<h3 id="idx5-3" class="sectionHeader"><i class="fa fa-info-circle"></i>問題を作る</h3>
				<p>
					パワプロクイズのメイン画面で「問題を作る」をクリックします。
				</p>
				<div><a href="../img/manual/05-03-01.jpg" target="_blank"><img src="../img/manual/05-03-01.jpg"></a></div>
				<p>
					問題作成画面に移動したら、必要事項を記入します。
				</p>
				<ul>
					<li>問題文……問題の本文。200文字まで。<span style="color:#f00">必須</span></li>
					<li>画像……問題に添付する画像。必要な場合のみ貼り付けてください。<span style="color:#f00">4つ全て必須</span></li>
					<li>選択肢……4択の選択肢。正解はどの位置でも構いません。</li>
					<li>正解……選択肢で正解を記入した番号を指定してください。</li>
					<li>カテゴリ……問題のカテゴリ(ジャンル)を選択して下さい。迷った場合はそれっぽいと思うものを選択してください。</li>
					<li>解説……問題の解説を行って下さい。未記入でも問題ありません。もし難しい問題で答えの理由がない場合BADが付く原因にもなるので出来れば記入しておいた方が良いです。</li>
					<li>作者……名前とTwitterのIDを入力してください。未記入でも問題ありません。</li>
				</ul>
				<div><a href="../img/manual/05-03-02.jpg" target="_blank"><img src="../img/manual/05-03-02.jpg"></a></div>
				<p>
					入力が完了したら、「登録する」ボタンをクリックします。
				</p>
				<div><a href="../img/manual/05-03-03.jpg" target="_blank"><img src="../img/manual/05-03-03.jpg"></a></div>
				<p>
					最終確認のポップアップが表示されます。内容に間違いが無ければOKをクリックしてください。
				</p>
				<div><a href="../img/manual/05-03-04.jpg" target="_blank"><img src="../img/manual/05-03-04.jpg"></a></div>
				<p>
					以上で登録は完了です。
				</p>
				<div><a href="../img/manual/05-03-05.jpg" target="_blank"><img src="../img/manual/05-03-05.jpg"></a></div>
			</section>
			<section>
				<h3 id="idx5-4" class="sectionHeader"><i class="fa fa-info-circle"></i>問題作成に関して注意事項</h3>
				<p>
					問題を作る上で、以下の注意次項を必ず守ってください。
				</p>
				<ul>
					<li>特定の個人を中傷する内容、他者が不快になるような内容を記載するのはお控えください。</li>
					<li>問題の内容は明確に答えがあるものを使用してください。個人の予想や想像、不明瞭な情報での出題はお控えください。</li>
					<li>将来的に答えが変わる可能性の高いものはなるべく出題をお控え下さい(例えば「現在実装されてるイベキャラは何種類か？」等)。また、もしそういった問題を出題する場合は出題日時を問題文に記載してください。</li>
					<li>一度投稿したクイズの内容を自分で変更、削除する事は出来ません。もし削除したい場合は管理者のツイッター(<a href="https://twitter.com/hitsujiPawapro">@hitsujiPawapro</a>)か、本ホームページの<a href="http://jbbs.shitaraba.net/game/58946/">掲示板</a>に削除依頼を申請してください。</li>
				</ul>
			</section>
		</section>
	</main>
	<?php include('../html/footer.html'); ?>
</body>

</html>
