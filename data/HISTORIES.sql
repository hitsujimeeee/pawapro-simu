CREATE TABLE HISTORIES (
	ENTRY_DATE DATETIME PRIMARY KEY NOT NULL,
	DESCRIPTION VARCHAR(128)
);


TRUNCATE TABLE HISTORIES;

INSERT INTO HISTORIES VALUES ('2015-02-13', '野手シミュレーター設置');
INSERT INTO HISTORIES VALUES ('2015-02-17', '投手シミュレーター設置');
INSERT INTO HISTORIES VALUES ('2015-02-18', '特能「悪球打ち」対応');
INSERT INTO HISTORIES VALUES ('2015-02-20', 'ポータルページ設置');
INSERT INTO HISTORIES VALUES ('2015-03-11 12:00:00', '投手版で阿畑のオリ変に対応');
INSERT INTO HISTORIES VALUES ('2015-03-11 18:00:00', '金特「ストライク送球」対応');
INSERT INTO HISTORIES VALUES ('2015-03-11 22:00:00', 'フォークコツに対応(暫定)');
INSERT INTO HISTORIES VALUES ('2015-03-15', '「ノビ○」の誤数値修正');
INSERT INTO HISTORIES VALUES ('2015-03-26 12:00:00', '掲示板設置');
INSERT INTO HISTORIES VALUES ('2015-03-26 18:00:00', 'PWPRアプリSRレーティングのリンク');
INSERT INTO HISTORIES VALUES ('2015-03-27', '「走者釘付」の誤数値修正');
INSERT INTO HISTORIES VALUES ('2015-03-29', '特能数値関係のバグ修正');
INSERT INTO HISTORIES VALUES ('2015-07-25', '金特項目に「変幻自在」追加');
INSERT INTO HISTORIES VALUES ('2015-09-12 12:00:00', '球速のkm/s→km/hに修正');
INSERT INTO HISTORIES VALUES ('2015-09-12 18:00:00', '金特項目に「恐怖の満塁男」追加');
INSERT INTO HISTORIES VALUES ('2015-09-14 12:00:00', '変幻自在が選手データに出てこないバグ修正');
INSERT INTO HISTORIES VALUES ('2015-09-14 18:00:00', '野手査定値算出機能追加');
INSERT INTO HISTORIES VALUES ('2015-09-18', '金特項目に「大番狂わせ」追加');
INSERT INTO HISTORIES VALUES ('2015-09-21', 'レイアウト調整');
INSERT INTO HISTORIES VALUES ('2015-09-23 12:00:00', '特能「要所○」追加');
INSERT INTO HISTORIES VALUES ('2015-09-23 18:00:00', '特能「連打○」追加');
INSERT INTO HISTORIES VALUES ('2015-09-23 22:00:00', 'マイナス特能追加');
INSERT INTO HISTORIES VALUES ('2015-10-03 12:00:00', '特能、金特追加');
INSERT INTO HISTORIES VALUES ('2015-10-03 18:00:00', '範囲外の数値の入力ができないように修正');
INSERT INTO HISTORIES VALUES ('2015-10-04', '「火事場の馬鹿力」の経験点修正');
INSERT INTO HISTORIES VALUES ('2016-02-27 12:00:00', '走力を100にすると経験点が計算できないバグ修正');
INSERT INTO HISTORIES VALUES ('2016-02-27 18:00:00', '投手の特殊能力リセットボタンが利かないバグ修正');
INSERT INTO HISTORIES VALUES ('2016-02-27 22:00:00', 'クッキー保存機能お試し追加');
INSERT INTO HISTORIES VALUES ('2016-02-27 23:00:00', '特能、金特追加');
INSERT INTO HISTORIES VALUES ('2016-03-06', '選手データURL化機能追加');
INSERT INTO HISTORIES VALUES ('2016-04-10 12:00:00', 'ひらめきシミュレーター追加');
INSERT INTO HISTORIES VALUES ('2016-04-10 18:00:00', '金特追加');
INSERT INTO HISTORIES VALUES ('2016-04-11', 'ひらめきシミュレーター修正');
INSERT INTO HISTORIES VALUES ('2016-04-16', '「野手版 実査定計算ツール」リンク追加');
INSERT INTO HISTORIES VALUES ('2016-04-24', '野手版に査定最大化機能追加');
INSERT INTO HISTORIES VALUES ('2016-04-29 12:00:00', 'ひらめき一覧の一部データミス修正');
INSERT INTO HISTORIES VALUES ('2016-04-29 18:00:00', '金特「内角必打」追加');
INSERT INTO HISTORIES VALUES ('2016-05-15', '「ラッキーセブン」、「超ラッキーボーイ」追加');
INSERT INTO HISTORIES VALUES ('2016-06-15', '「追い打ち」、「競争心」、「司令塔」他追加');
INSERT INTO HISTORIES VALUES ('2016-07-14', '「打球ノビ」、「ささやき破り」、「つるべ打ち」追加');
INSERT INTO HISTORIES VALUES ('2016-07-31', '「広角砲」追加、「つるべ打ち」の査定値反映');
INSERT INTO HISTORIES VALUES ('2016-10-15', '特能追加、実査定値修正');
INSERT INTO HISTORIES VALUES ('2016-11-19', '特能、金特追加');
INSERT INTO HISTORIES VALUES ('2016-12-25 19:00', 'スマフォ向け新サイト開設');
INSERT INTO HISTORIES VALUES ('2016-12-28 22:00', '「使い方」ページ追加');
INSERT INTO HISTORIES VALUES ('2016-12-30 13:00', '金特「情熱エール」追加');
INSERT INTO HISTORIES VALUES ('2017-01-03 12:00', '「査定計算機」ページ追加');
INSERT INTO HISTORIES VALUES ('2017-01-03 13:00', '「このサイトについて」ページ追加');
INSERT INTO HISTORIES VALUES ('2017-01-03 14:00', '「データ一覧」ページ追加');
INSERT INTO HISTORIES VALUES ('2017-01-07 23:00', '特能「手応え」追加');
INSERT INTO HISTORIES VALUES ('2017-01-13 23:00', '金特「意気揚々」追加');
INSERT INTO HISTORIES VALUES ('2017-01-15 00:30', '選手画像投稿機能追加');
INSERT INTO HISTORIES VALUES ('2017-01-15 00:35', '選手ランクSS2以上に対応');
INSERT INTO HISTORIES VALUES ('2017-01-15 22:00', 'リンクに「<b>細かすぎて伝わらない 査定理論 (とその他いろいろ) の部屋</b>」追加');
INSERT INTO HISTORIES VALUES ('2017-01-15 23:00', '査定計算方式修正');
INSERT INTO HISTORIES VALUES ('2017-01-18 20:00', '特能リストの並び順変更');
INSERT INTO HISTORIES VALUES ('2017-01-27 20:00', '特能取得数表示機能追加');
INSERT INTO HISTORIES VALUES ('2017-01-27 21:00', '「査定値を表示しない」オプションの追加');
INSERT INTO HISTORIES VALUES ('2017-01-30 21:00', '「気分屋を取得しない」オプションの追加');
INSERT INTO HISTORIES VALUES ('2017-01-27 22:00', '特能テンプレート機能追加');
INSERT INTO HISTORIES VALUES ('2017-02-09 22:00', '特能追加(接戦○、形勢逆転など)');
INSERT INTO HISTORIES VALUES ('2017-03-04 20:30', 'デッキシェア機能追加');
INSERT INTO HISTORIES VALUES ('2017-03-09 22:30', 'デッキシェア機能に「ギャネンドラ」、「ナヌーク」追加');
INSERT INTO HISTORIES VALUES ('2017-03-16 21:00', '特能「順応」、「ジャストフィット」追加');
INSERT INTO HISTORIES VALUES ('2017-03-16 21:10', 'デッキシェア機能に「緒川未羽」、「鳴海悠斗」追加');
INSERT INTO HISTORIES VALUES ('2017-03-20 22:00', '作成選手一覧画面一部修正');
INSERT INTO HISTORIES VALUES ('2017-03-21 21:10', 'デッキシェア機能でレアリティ「PN」,「N」に対応');
INSERT INTO HISTORIES VALUES ('2017-03-23 20:25', 'デッキシェア機能に「堀杉等」追加');
INSERT INTO HISTORIES VALUES ('2017-03-30 21:45', '金特「エースキラー」追加');
INSERT INTO HISTORIES VALUES ('2017-03-30 21:46', 'デッキシェア機能に「[サンバ]新島早紀」追加');
INSERT INTO HISTORIES VALUES ('2017-04-13 21:00', '特能「荒れ球」、「アウトコース○」、「祝福」追加');
INSERT INTO HISTORIES VALUES ('2017-04-15 22:00', 'デッキシェア機能にモンストキャラ3種追加');
INSERT INTO HISTORIES VALUES ('2017-04-20 22:00', '特能「暴れ球」、デッキシェア機能に「[ユニ]エミリ」追加');
INSERT INTO HISTORIES VALUES ('2017-04-22 21:00', '「上限開放予報士くん」機能リリース');
INSERT INTO HISTORIES VALUES ('2017-05-02 22:00', '特能「切磋琢磨」追加');
INSERT INTO HISTORIES VALUES ('2017-05-08 22:00', 'デッキシェア機能に「[激闘]友沢亮」追加');
INSERT INTO HISTORIES VALUES ('2017-05-14 14:00', '特能「伝説の引っ張り屋」追加');
INSERT INTO HISTORIES VALUES ('2017-05-28 21:00', '特能「球速安定」、「みなぎる活力」追加');
INSERT INTO HISTORIES VALUES ('2017-06-25 22:30', '特能「かく乱」、「鼓舞」追加');
INSERT INTO HISTORIES VALUES ('2017-07-07 23:30', '特能「トリックスター」追加');
INSERT INTO HISTORIES VALUES ('2017-07-16 20:00', '特能「ミラクルボイス」追加');
INSERT INTO HISTORIES VALUES ('2017-07-16 20:30', '「課金予想額シミュレーター機能」リリース');
INSERT INTO HISTORIES VALUES ('2017-08-08 21:00', '特能「縛り」、「速球対抗心」等追加');
INSERT INTO HISTORIES VALUES ('2017-08-26 22:00', '投手査定最大化機能リリース');
INSERT INTO HISTORIES VALUES ('2017-09-02 23:00', '特能「挑発」追加');
INSERT INTO HISTORIES VALUES ('2017-09-09 20:00', '特能「一発逆転」、「変化球対抗心」等追加');
INSERT INTO HISTORIES VALUES ('2017-09-11 21:30', '「パワプロクイズ機能」リリース');
INSERT INTO HISTORIES VALUES ('2017-09-14 22:00', '基礎能力上限突破に対応');
INSERT INTO HISTORIES VALUES ('2017-09-17 20:00', 'トップページデザイン変更');
INSERT INTO HISTORIES VALUES ('2017-09-23 21:00', '守備上限突破対応、特能名一部修正');
INSERT INTO HISTORIES VALUES ('2017-09-29 21:00', '特能選択画面で特能を選びやすくなるよう調整');
INSERT INTO HISTORIES VALUES ('2017-09-30 20:00', '査定計算機で特能を選びやすくなるようデザイン調整');
INSERT INTO HISTORIES VALUES ('2017-10-03 23:00', '特能「一掃」追加');
INSERT INTO HISTORIES VALUES ('2017-10-06 20:00', '特能「スイープ」追加');
INSERT INTO HISTORIES VALUES ('2017-10-25 22:00', '特能「初撃」、「洗礼の一撃」、「勇猛果敢」追加');
INSERT INTO HISTORIES VALUES ('2017-10-30 19:00', '「その他ツールページ」設置、ブラッドゲージ管理ツール公開');
INSERT INTO HISTORIES VALUES ('2017-11-18 19:30', '特能「逆襲」追加');
INSERT INTO HISTORIES VALUES ('2017-11-18 20:00', '捕球上限突破に対応');
INSERT INTO HISTORIES VALUES ('2017-12-16 21:00', '特能「ハゲタカ」、「冷静」追加');
INSERT INTO HISTORIES VALUES ('2017-12-30 21:00', '特能「明鏡止水」、追加、守備上限を104に');
INSERT INTO HISTORIES VALUES ('2018-01-28 21:00', 'リンクページにレモネードさんのブログ追加');
INSERT INTO HISTORIES VALUES ('2018-01-30 22:00', '「円卓高校エピックメモ」機能追加');
INSERT INTO HISTORIES VALUES ('2018-02-12 21:00', 'ミート上限を104に変更');
INSERT INTO HISTORIES VALUES ('2018-02-17 20:00', '野手シミュ、投手査定最大化改修');
INSERT INTO HISTORIES VALUES ('2018-02-20 20:00', '特能「帰巣本能」追加');
INSERT INTO HISTORIES VALUES ('2018-03-06 20:00', '特能「外角必打」追加');
INSERT INTO HISTORIES VALUES ('2018-03-15 20:00', '特能「全開」追加');
INSERT INTO HISTORIES VALUES ('2018-03-30 20:00', '特能「完全燃焼」追加');
INSERT INTO HISTORIES VALUES ('2018-04-09 20:00', '特能「看破」、「原点投球」、その他追加');
INSERT INTO HISTORIES VALUES ('2018-05-30 20:00', '特能「鉄仮面」追加、コン上限を104に変更');
INSERT INTO HISTORIES VALUES ('2018-06-02 13:00', '投手査定計算式の最新化');
INSERT INTO HISTORIES VALUES ('2018-07-10 21:00', '特能「四番〇」、「孤高」追加');
INSERT INTO HISTORIES VALUES ('2018-07-11 20:00', '捕球上限を106に変更');
INSERT INTO HISTORIES VALUES ('2018-07-17 20:00', '特能「不動の四番」、「孤軍奮闘」追加。ミート、守備上限を106に変更');
INSERT INTO HISTORIES VALUES ('2018-08-25 20:00', '特能「走力ブースト」、「走力バースト」追加');
INSERT INTO HISTORIES VALUES ('2018-08-25 21:00', '走力上限102,ミート＆捕球上限108に変更');
INSERT INTO HISTORIES VALUES ('2018-09-19 19:00', '特能「投打躍動」、「二刀流」追加、コン上限を106に変更');
INSERT INTO HISTORIES VALUES ('2018-10-20 22:00', '特能「ファースト〇」、「守備移動〇」、「至高の一番手」、「牛若丸」追加');
INSERT INTO HISTORIES VALUES ('2018-10-20 23:00', '基礎能力上限をミート114、肩力102、守備力108、コン110に変更');
INSERT INTO HISTORIES VALUES ('2018-11-10 12:00', 'ファースト〇取得時にファースト適正があるかをチェックするよう修正');
INSERT INTO HISTORIES VALUES ('2018-11-22 21:00', '特能「痛打」、「大打撃」追加。コン上限を112に調整');
INSERT INTO HISTORIES VALUES ('2018-12-16 20:00', '特能「セカンド〇」他追加、コン上限を114、肩上限104に調整');
INSERT INTO HISTORIES VALUES ('2018-12-29 00:00', '特能「完全制圧」追加、スタミナ上限を102に調整');
INSERT INTO HISTORIES VALUES ('2019-02-03 20:00', '特能「サード〇」、「至高の三塁手」追加');
INSERT INTO HISTORIES VALUES ('2019-02-08 22:00', 'コン上限を116に調整');
INSERT INTO HISTORIES VALUES ('2019-02-17 20:00', '特能「ギアチェンジ」追加');