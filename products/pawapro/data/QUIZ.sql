CREATE TABLE QUIZ (
	ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	CATEGORY INT,
	CONTENT VARCHAR(200),
	OPTION1 VARCHAR(64),
	OPTION2 VARCHAR(64),
	OPTION3 VARCHAR(64),
	OPTION4 VARCHAR(64),
	ANSWER INT,
	COMMENTS VARCHAR(300),
	IMAGE INT DEFAULT 0,
	USER_NAME VARCHAR(32),
	TWITTER_ID VARCHAR(15),
	CORRECT INT DEFAULT 0,
	FAILED INT DEFAULT 0,
	VOTE_GOOD INT DEFAULT 0,
	VOTE_BAD INT DEFAULT 0,
	FIXED_FLAG INT DEFAULT 0,
	DELETE_FLAG INT DEFAULT 0,
	ENTRY_DATE TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

TRUNCATE TABLE QUIZ;

INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "橘みずきのオリジナル変化球は？", "マリンボール", "ミラージュナックル", "あばたボール7号", "クレッセントムーン", 4, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "【あかつき】猪狩進の得意練習は守備と何？", "打撃", "走塁", "肩", "精神", 1, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (2, "次の変化球のうち取得に必要な経験点が最も多いものは？", "スライダー", "ナックル", "サークルチェンジ", "Hシュート", 2, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG, IMAGE)
			VALUES (1, "次の4組のうち仲間外れは？", "①", "②", "③", "④", 4, "④以外は兄弟です。", '羊', 'hitsujiPawapro', 1, 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (2, "SR木場嵐のイベントで貰える野手金特のコツは？", "勝負師", "アーチスト", "気迫ヘッド", "一球入魂", 3, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG, IMAGE)
			VALUES (2, "このデッキのコンボ数はいくつ？", "3", "4", "5", "6", 3, 'ほむら＆ちーちゃん
					ほむら＆芽衣香
					ほむら＆明留
					ちーちゃん＆玲美
					玲美＆恋', '羊', 'hitsujiPawapro', 1, 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG, IMAGE)
			VALUES (1, "次のうちSRイベントで貰える金特が一人だけ違うキャラは？", "矢部明雄", "駒坂瞬", "坂本ゲン", "猫神優", 2, "駒坂瞬は「電光石火」、その他は「高速ベースラン」", '羊', 'hitsujiPawapro', 1, 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (2, "真黒綱寛の得意練習とイベ前後の正しい組み合わせは？", "スタミナ/前", "球速/後", "スタミナ＆球速/前", "スタミナ＆球速/後", 3, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (2, "ギャネンドラの得意練習とイベ前後の正しい組み合わせは？", "打撃＆精神/前", "走塁＆打撃/前", "守備＆精神/後", "走塁＆守備/後", 2, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG, IMAGE)
			VALUES (1, "次のうち広角打法を所持していないキャラは？", "才賀侑人", "一条一輝", "東條小次郎", "東雲翔也", 2, NULL, '羊', 'hitsujiPawapro', 1, 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (4, "称号【本格派モンスター】の達成条件、怪童・怪物球威・球速160km/hとあと一つは？", "驚異の切れ味", "ハイスピンジャイロ", "クロスキャノン", "ドクターK", 1, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "三角フラスコと言えば？", "橘みずき", "六道聖", "早川あおい", "小鷹美麗", 3, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG, IMAGE)
			VALUES (2, "次のうちコンボが発生しない組み合わせは？", "①", "②", "③", "④", 4, "④に「美藤千尋」と「太刀川広巳」が加われば「ソフトでハードなメモリー」が発生します。", '羊', 'hitsujiPawapro', 1, 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (3, "次の特能のうち実査定が一番高いものは？
					　①ケガしにくさ○
					　②流し打ち
					　③本塁生還
					　④ささやき破り", "①ケガしにくさ○", "②流し打ち", "③本塁生還", "④ささやき破り", 4, "①35.28、②27.44、③31.36、④39.2", '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (2, "[サンバ]新島早紀のイベント「祝！人気投票1位！」で貰える野手特能のコツは？", "チャンス○", "意外性", "いぶし銀", "チャンスメーカー", 3, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "エミリのフルネームは「エミリ＝○○＝クリスティン」", "山田", "里中", "田代", "池田", 4, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "アンヌのフルネームは「アンヌ・○○・アズナブル」", "安生", "亀山", "吉崎", "栗田", 1, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (2, "木場嵐の特能は全部でいくつ？（投手得能、野手得能、緑得能、赤得能すべて含む）", "7", "8", "9", "10", 3, NULL, 'japan 22', 'japan22a', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "川星ほむらのイベント「バイトっス！！」で、主人公がほむらに薦めることがない仕事は？", "ミニスカサンタ", "巫女さん", "水着でプール監視", "チア衣装で応援", 4, NULL, 'ポケ', 'pwpr_poke', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "全キャラLv45で比較した場合、守備練習における単独タッグの経験点トップなのは？", "銭形乱蔵", "小山雅", "六道聖", "振袖小山雅", 2, '詳細はGameWitさんの「タッグの強い野手ランキング」参照', '隆之@パワプロ垢', 'kazanagi_kun', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "支良州水産高校の練習試合でAランクの高校はどれ？", "ワールド高校", "駈杜高校", "帝王実業高校", "大筒高校", 1, NULL, '羊', 'hitsujiPawapro', 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG, IMAGE)
			VALUES (2, "支良州水産高校で以下のデッキを使う場合、エピローグ後に貰える金特のうち金特被りしないのはどの金特か", "変幻自在", "クロスキャノン", "驚異の切れ味", "不屈の魂", 3, '葵→変幻自在
					ブラックドロイド→クロスキャノン
					紺野→不屈の魂
					虹谷は驚異の切れ味を取得可能ですが、選択肢でドクターKを選べば金特被りは発生しません。
					', '羊', 'hitsujiPawapro', 1, 1);
INSERT INTO QUIZ (CATEGORY, CONTENT, OPTION1, OPTION2, OPTION3, OPTION4, ANSWER, COMMENTS, USER_NAME, TWITTER_ID, FIXED_FLAG)
			VALUES (1, "次のうちヴァンプ高校で入手できない金特はどれ？", "怪童", "本塁打厳禁", "アーチスト", "内野安打王", 2, '投手は「ハイスピンジャイロ」、「怪童」、「超尻上がり」、「走者釘付」、「精密機械」、野手は「伝説のサヨナラ男」、「安打製造機」、「恐怖の満塁男」、「アーチスト」、「内野安打王」を取得可能です。', '羊', 'hitsujiPawapro', 1)

