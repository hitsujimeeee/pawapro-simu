SET AUTOCOMMIT=0;

TRUNCATE TABLE ABILITY_DETAIL;

INSERT INTO ABILITY_DETAIL (ID, HEADER_ID, NAME, POWER, SPEED, TECH, SCREWBALL, MENTAL, LOWER, UPPER, ASSESSMENT, TYPE) VALUES
('A001','0','チャンス○','0','15','30','0','105',NULL,'A002','39.2','0'),
('A002','0','チャンス◎','0','20','40','0','140','A001','S001','19.6','0'),
('A003','1','対左投手○','48','30','72','0','0',NULL,'A004','39.2','0'),
('A004','1','対左投手◎','64','40','96','0','0','A003','S002','19.6','0'),
('A005','2','盗塁○','0','108','48','0','42',NULL,'A006','23.52','0'),
('A006','2','盗塁◎','0','144','64','0','56','A005','S003','7.84','0'),
('A007','3','走塁○','0','72','48','0','30',NULL,'A008','14','0'),
('A008','3','走塁◎','0','96','64','0','40','A007','S004','1.68','0'),
('A009','4','送球○','48','48','48','0','0',NULL,'A010','14','0'),
('A010','4','送球◎','64','64','64','0','0','A009','S005','1.68','0'),
('A011','5','ケガしにくさ○','105','0','0','0','45',NULL,'A012','35.28','0'),
('A012','5','ケガしにくさ◎','140','0','0','0','60','A011','S006','23.52','0'),
('A013','6','キャッチャー○','9','27','75','0','75',NULL,'A014','58.8','0'),
('A014','6','キャッチャー◎','12','36','100','0','100','A013','S007','2.27','0'),
('A015','7','アベレージヒッター','13','25','150','0','63',NULL,'S008','58.8','0'),
('A016','8','パワーヒッター','188','13','50','0','0',NULL,'S009','58.8','0'),
('A017','9','プルヒッター','125','50','13','0','0',NULL,'S045','27.44','0'),
('A018','10','広角打法','119','0','119','0','13',NULL,'S032','58.8','0'),
('A019','11','内野安打○','6','63','38','0','19',NULL,'S024','27.44','0'),
('A020','12','流し打ち','38','25','88','0','38',NULL,'S010','27.44','0'),
('A021','13','固め打ち','50','0','50','0','25',NULL,'S034','15.68','0'),
('A022','14','粘り打ち','0','25','50','0','50',NULL,NULL,'15.68','0'),
('A023','15','悪球打ち','10','20','0','0','20',NULL,NULL,'10.11','4'),
('A024','16','意外性','50','0','25','0','50',NULL,'S011','15.68','0'),
('A025','17','バント○','0','25','63','0','38',NULL,'A026','15.68','0'),
('A026','17','バント職人','0','38','100','0','50','A025',NULL,'7.84','0'),
('A027','18','初球○','56','0','56','0','75',NULL,'S012','27.44','0'),
('A028','19','代打○','19','0','0','0','44',NULL,'S013','15.68','0'),
('A029','20','チャンスメーカー','31','31','63','0','63',NULL,'S014','19.6','0'),
('A030','21','ヘッドスライディング','0','25','19','0','19',NULL,'S015','7.84','0'),
('A031','22','ホーム突入','50','0','0','0','13',NULL,'S016','7.84','0'),
('A032','23','満塁男','31','0','31','0','63',NULL,'S017','27.44','0'),
('A033','24','サヨナラ男','31','0','63','0','31',NULL,'S018','27.44','0'),
('A034','25','逆境○','25','0','0','0','100',NULL,'S019','15.68','0'),
('A035','26','ハイボールヒッター','63','25','38','0','0',NULL,'S026','27.44','0'),
('A036','27','ローボールヒッター','63','25','38','0','0',NULL,'S036','27.44','0'),
('A037','28','対エース○','63','0','63','0','63',NULL,'S042','19.6','0'),
('A038','29','ムード○','0','25','0','0','38',NULL,'S027','0','0'),
('A039','30','威圧感','0','0','0','0','0',NULL,NULL,'58.8','0'),
('A040','31','レーザービーム','63','63','63','0','0',NULL,'S020','15.68','0'),
('A041','32','守備職人','0','19','94','0','13',NULL,'S021','15.68','0'),
('A042','33','高速チャージ','0','50','50','0','25',NULL,NULL,'15.68','0'),
('A043','34','ホーム死守','43','0','10','0','10',NULL,'S022','7.84','0'),
('A044','35','プレッシャーラン','0','44','19','0','0',NULL,NULL,'7.84','0'),
('A045','36','いぶし銀','31','0','69','0','88',NULL,NULL,'19.6','0'),
('A046','37','帳尻合わせ','25','0','50','0','50',NULL,NULL,'15.68','0'),
('A047','38','気分屋','0','0','13','0','50',NULL,NULL,'3.92','4'),
('A048','40','連打○','21','0','88','0','80',NULL,'S031','19.6','0'),
('A049','41','リベンジ','20','0','40','0','65',NULL,'S052','15.68','0'),
('A050','42','本塁生還','31','83','31','0','43',NULL,'S055','31.36','0'),
('A051','39','ラッキーボーイ','5','53','46','0','84',NULL,'S029','27.44','0'),
('A052','48','インコース○','38','25','63','0','0',NULL,'S028','27.44','0'),
('A053','50','ラッキーセブン','40','0','20','0','65',NULL,NULL,'15.68','0'),
('A054','51','追い打ち','46','25','35','0','20',NULL,'S053','15.68','0'),
('A055','52','競争心','20','0','20','0','86',NULL,'S044','15.68','0'),
('A056','54','ささやき破り','10','40','100','0','100',NULL,NULL,'39.2','0'),
('A057','55','打球ノビ○','18','18','138','0','12',NULL,'A058','39.2','0'),
('A058','55','打球ノビ◎','24','24','184','0','16','A057','S033','19.6','0'),
('A059','56','盗塁アシスト','0','0','32','0','32',NULL,NULL,'7.84','0'),
('A060','58','窮地◯','35','0','35','0','55',NULL,'S037','15.68','0'),
('A061','59','上り調子','56','0','38','0','94',NULL,'S038','19.6','0'),
('A062','60','速攻○','75','75','38','0','0',NULL,NULL,'19.6','0'),
('A063','113','打開','60','88','0','0','40',NULL,'S040','19.6','0'),
('A064','118','接戦○','70','0','35','0','20',NULL,NULL,'15.68','0'),
('A065','122','アウトコース○','38','25','63','0','0',NULL,'S056','27.44','0'),
('A066','127','鼓舞','40','0','40','0','108',NULL,'S047','15.68','0'),
('A067','128','かく乱','0','110','60','0','18',NULL,'S046','15.68','0'),
('A068','135','一発逆転','148','0','0','0','40',NULL,'S049','15.68','0'),
('A069','137','一掃','24','140','24','0','0',NULL,'S050','19.6','0'),
('A070','138','初撃','38','0','75','0','75',NULL,'S051','27.44','0'),
('A071','139','冷静','50','50','50','0','100',NULL,'S054','39.2','0'),
('A072','141','サイン察知','0','60','45','0','20',NULL,'S057','15.68','0'),
('A073','143','四番〇','158','0','30','0','0',NULL,'S058','39.2','0'),
('A074','144','孤高','50','28','50','0','60',NULL,'S059','15.68','0'),
('A075','145','走力ブースト','38','150','0','0','0',NULL,'S060','15.68','0'),
('A076','147','ファースト〇','0','50','38','0','100',NULL,'S061','7.84','0'),
('A077','148','守備移動〇','0','128','30','0','30',NULL,'S062','19.6','0'),
('A078','149','痛打','75','0','38','0','75',NULL,'S063','19.6','0'),
('A079','150','セカンド〇','0','40','88','0','60',NULL,'S064','7.84','0'),
('A080','152','サード〇','30','44','44','0','70',NULL,'S065','7.84','0'),
('A081','156','アウトフィールダー','48','70','50','0','20',NULL,'S066','7.84','0'),
('S001','0','勝負師','0','35','70','0','245','A002',NULL,'39.2','1'),
('S002','1','左キラー','112','70','168','0','0','A004',NULL,'39.2','1'),
('S003','2','電光石火','0','252','112','0','98','A006',NULL,'66.64','1'),
('S004','3','高速ベースラン','0','168','112','0','70','A008',NULL,'62.72','1'),
('S005','4','ストライク送球','112','112','112','0','0','A010',NULL,'62.72','1'),
('S006','5','鉄人','245','0','0','0','105','A012',NULL,'29.71','1'),
('S007','6','球界の頭脳','21','63','175','0','175','A014','R002','134.93','1'),
('S008','7','安打製造機','13','25','150','0','63','A015','R003','39.2','1'),
('S009','8','アーチスト','188','13','50','0','0','A016','R001','39.2','1'),
('S010','12','芸術的流し打ち','38','25','88','0','38','A020',NULL,'70.56','1'),
('S011','16','大番狂わせ','50','0','25','0','50','A024',NULL,'62.72','1'),
('S012','18','一球入魂','56','0','56','0','75','A027',NULL,'70.56','1'),
('S013','19','代打の神様','19','0','0','0','44','A028',NULL,'62.72','1'),
('S014','20','切り込み隊長','31','31','63','0','63','A029',NULL,'78.4','1'),
('S015','21','気迫ヘッド','0','25','19','0','19','A030',NULL,'70.56','1'),
('S016','22','重戦車','50','0','0','0','13','A031',NULL,'70.56','1'),
('S017','23','恐怖の満塁男','31','0','31','0','63','A032',NULL,'50.96','1'),
('S018','24','伝説のサヨナラ男','31','0','63','0','31','A033',NULL,'50.96','1'),
('S019','25','火事場の馬鹿力','38','0','0','0','150','A034',NULL,'62.72','1'),
('S020','31','高速レーザー','63','63','63','0','0','A040',NULL,'62.72','1'),
('S021','32','魔術師','0','19','94','0','13','A041',NULL,'62.72','1'),
('S022','34','鉄の壁','43','','10','0','10','A043',NULL,'70.56','1'),
('S023','43','ささやき戦術','21','63','175','0','175',NULL,NULL,'78.4','1'),
('S024','11','内野安打王','6','63','38','0','19','A019',NULL,'70.56','1'),
('S025','47','バズーカ','126','126','126','0','0',NULL,NULL,'78.4','1'),
('S026','26','高球必打','63','25','38','0','0','A035',NULL,'70.56','1'),
('S027','29','精神的支柱','0','50','0','0','76','A038',NULL,'78.4','1'),
('S028','48','内角必打','38','25','63','0','0','A052',NULL,'70.56','1'),
('S029','39','超ラッキーボーイ','5','53','46','0','84','A051',NULL,'70.56','1'),
('S030','53','司令塔','20','64','175','0','175',NULL,NULL,'78.4','1'),
('S031','40','つるべ打ち','21','0','88','0','80','A048',NULL,'78.4','1'),
('S032','10','広角砲','178','0','178','0','18','A018',NULL,'39.2','1'),
('S033','55','ローリング打法','24','24','184','0','16','A058',NULL,'39.2','1'),
('S034','13','メッタ打ち','50','0','50','0','25','A021',NULL,'62.72','1'),
('S035','57','アイコンタクト','0','65','125','0','186',NULL,NULL,'78.4','1'),
('S036','27','低球必打','63','25','38','0','0','A036',NULL,'70.56','1'),
('S037','58','ヒートアップ','35','0','35','0','55','A060',NULL,'62.72','1'),
('S038','59','昇り龍','56','0','38','0','94','A061',NULL,'78.4','1'),
('S039','112','読心術','100','100','100','0','200',NULL,NULL,'98','1'),
('S040','113','一番槍','60','88','0','0','40','A063',NULL,'78.4','1'),
('S041','116','情熱エール','0','0','116','0','260',NULL,NULL,'78.4','1'),
('S042','28','エースキラー','63','0','63','0','63','A037',NULL,'78.4','1'),
('S043','124','祝福','63','0','63','0','63',NULL,NULL,'78.4','1'),
('S044','52','切磋琢磨','20','0','20','0','86','A055',NULL,'62.72','1'),
('S045','9','伝説の引っ張り屋','125','50','13','0','0','A017',NULL,'70.56','1'),
('S046','128','トリックスター','0','110','60','0','18','A067',NULL,'62.72','1'),
('S047','127','ミラクルボイス','40','0','40','0','108','A066',NULL,'62.72','1'),
('S048','134','挑発','94','94','140','0','48',NULL,NULL,'78.4','1'),
('S049','135','一発逆転王','148','0','0','0','40','A068',NULL,'62.72','1'),
('S050','137','スイープ','24','140','24','0','0','A069',NULL,'78.4','1'),
('S051','138','洗礼の一撃','38','0','75','0','75','A070',NULL,'70.56','1'),
('S052','41','逆襲','20','0','40','0','65','A049',NULL,'62.72','1'),
('S053','51','ハゲタカ','46','25','35','0','20','A054',NULL,'62.72','1'),
('S054','139','明鏡止水','50','50','50','0','100','A071',NULL,'58.8','1'),
('S055','42','帰巣本能','31','83','31','0','43','A050',NULL,'66.64','1'),
('S056','122','外角必打','38','25','63','0','0','A065',NULL,'70.56','1'),
('S057','141','看破','0','60','45','0','20','A072',NULL,'62.72','1'),
('S058','143','不動の四番','158','0','30','0','0','A073',NULL,'58.8','1'),
('S059','144','孤軍奮闘','50','28','50','0','60','A074',NULL,'62.72','1'),
('S060','145','走力バースト','62','250','0','0','0','A075',NULL,'101.92','1'),
('S061','147','至高の一塁手','0','142','108','0','282','A076',NULL,'207.76','1'),
('S062','148','牛若丸','0','484','114','0','114','A077',NULL,'98','1'),
('S063','149','大打撃','284','0','144','0','284','A078',NULL,'98','1'),
('S064','150','至高の二塁手','0','112','250','0','170','A079',NULL,'207.76','1'),
('S065','152','至高の三塁手','84','125','125','0','198','A080',NULL,'207.76','1'),
('S066','156','至高の外野手','136','198','142','0','56','A081',NULL,'207.76','1'),
('R001','8','真・アーチスト','500','35','135','0','0','S009',NULL,'156.8','6'),
('R002','6','真・球界の頭脳','15','45','122','0','122','S007',NULL,'156.8','6'),
('R003','7','真・安打製造機','39','75','450','0','189','S008',NULL,'176.4','6'),
('B001','0','チャンス△','0','10','20','0','70','B002',NULL,'0','2'),
('B002','0','チャンス×','0','5','10','0','35',NULL,'B001','0','2'),
('B003','1','対左投手△','32','20','48','0','0','B004',NULL,'0','2'),
('B004','1','対左投手×','16','10','24','0','0',NULL,'B003','0','2'),
('B005','2','盗塁△','0','72','32','0','28','B006',NULL,'0','2'),
('B006','2','盗塁×','0','36','16','0','14',NULL,'B005','0','2'),
('B007','3','走塁△','0','48','32','0','20','B008',NULL,'0','2'),
('B008','3','走塁×','0','24','16','0','10',NULL,'B007','0','2'),
('B009','4','送球△','32','32','32','0','0','B010',NULL,'0','2'),
('B010','4','送球×','16','16','16','0','0',NULL,'B009','0','2'),
('B011','5','ケガしにくさ△','70','0','0','0','30','B012',NULL,'0','2'),
('B012','5','ケガしにくさ×','35','0','0','0','15',NULL,'B011','0','2'),
('B013','6','キャッチャー△','6','18','50','0','50','B014',NULL,'0','2'),
('B014','6','キャッチャー×','3','9','25','0','25',NULL,'B013','0','2'),
('B015','29','ムード×','0','13','0','0','50',NULL,NULL,'0','2'),
('B016','44','三振','0','0','31','0','0',NULL,NULL,'0','2'),
('B017','45','併殺','6','0','13','0','13',NULL,NULL,'0','2'),
('B018','46','エラー','0','0','6','0','25',NULL,NULL,'0','2'),
('B019','61','ハードラック','0','0','0','0','0',NULL,NULL,'0','2'),
('P001','49','扇風機','0','0','100','0','0',NULL,NULL,'0','3'),
('A201','62','打たれ強さ○','0','0','15','0','75',NULL,'A202','55','0'),
('A202','62','打たれ強さ◎','0','0','20','0','100','A201','S201','7','0'),
('A203','63','対ピンチ○','0','0','45','0','105',NULL,'A204','55','0'),
('A204','63','対ピンチ◎','0','0','60','0','140','A203','S202','7','0'),
('A205','64','対左打者○','36','0','78','0','36',NULL,'A206','62','0'),
('A206','64','対左打者◎','48','0','104','0','48','A205','S203','9','0'),
('A207','65','ノビ○','123','0','93','0','33',NULL,'A208','69','0'),
('A208','65','ノビ◎','164','0','124','0','44','A207','S204','83','0'),
('A209','66','クイック○','0','45','30','0','0',NULL,'A210','16','0'),
('A210','66','クイック◎','0','60','40','0','0','A209','S205','7','0'),
('A211','67','キレ○','0','13','43','95','38',NULL,'S206','62','0'),
('A212','68','打球反応○','0','38','25','0','0',NULL,NULL,'9','0'),
('A213','69','牽制○','0','25','38','0','0',NULL,NULL,'9','0'),
('A214','70','緩急○','38','0','56','81','13',NULL,'S207','41','0'),
('A215','71','ポーカーフェイス','0','6','25','0','31',NULL,'S236','0','4'),
('A216','131','闘志','0','0','0','0','188',NULL,'S238','48','0'),
('A217','72','低め○','0','0','88','13','25',NULL,'S208','39','0'),
('A218','73','重い球','81','0','44','0','0',NULL,'S209','48','0'),
('A219','74','尻上がり','56','0','38','0','94',NULL,'S217','55','0'),
('A220','75','根性○','25','0','0','0','163',NULL,'S215','23','0'),
('A221','76','リリース○','0','0','31','31','0',NULL,NULL,'30','0'),
('A222','77','球持ち○','69','0','69','69','44',NULL,'S221','76','0'),
('A223','78','奪三振','44','0','100','63','44',NULL,'S210','90','0'),
('A224','79','ジャイロボール','88','0','50','50','0',NULL,'S211','55','0'),
('A225','80','逃げ球','38','0','94','50','6',NULL,'S212','48','0'),
('A226','81','勝ち運','16','0','16','16','16',NULL,'S213','16','0'),
('A227','82','対強打者○','50','0','50','38','50',NULL,'S233','41','0'),
('A228','83','クロスファイヤー','50','0','88','50','0',NULL,'S219','48','0'),
('A229','84','要所○','24','0','42','24','99',NULL,NULL,'39','0'),
('A230','86','バント封じ','0','5','31','0','26',NULL,NULL,'58','0'),
('A231','85','緊急登板○','0','0','35','0','90',NULL,NULL,'39','0'),
('A232','87','内角○','0','0','48','13','65',NULL,'S220','39','0'),
('A233','114','先制ストライク','37','0','37','0','50',NULL,'S223','39','0'),
('A234','115','安全圏◯','30','0','40','0','55',NULL,NULL,'48','0'),
('A235','117','手応え','0','8','20','110','50',NULL,'S224','55','0'),
('A236','119','火消し','50','0','35','30','10',NULL,'S225','39','0'),
('A237','121','順応','40','0','80','0','68',NULL,'S227','62','0'),
('A238','123','荒れ球','40','0','80','0','68',NULL,'S228','15','4'),
('A239','125','球速安定','60','5','30','30','0',NULL,NULL,'48','0'),
('A240','129','縛り','0','25','110','0','115',NULL,'S230','48','0'),
('A241','130','速球対抗心','110','0','18','0','60',NULL,'S231','41','0'),
('A242','133','威圧感','0','0','0','0','0',NULL,NULL,'0','0'),
('A243','136','変化球対抗心','0','18','0','60','110',NULL,'S232','41','0'),
('A244','140','全開','113','0','0','0','75',NULL,'S234','16','4'),
('A245','142','アウトロー球威〇','65','0','60','0','0',NULL,'S235','39','0'),
('A246','146','投打躍動','110','30','110','0','0',NULL,'S237','92','0'),
('A247','151','制圧','20','0','40','0','65',NULL,'S239','48','0'),
('S201','62','不屈の魂','0','0','35','0','175','A202',NULL,'203','1'),
('S202','63','強心臓','0','0','105','0','245','A204','R202','203','1'),
('S203','64','左キラー','84','0','182','0','84','A206',NULL,'194','1'),
('S204','65','怪童','287','0','217','','77','A208','R201','113','1'),
('S205','66','走者釘付','0','30','110','0','35','A210',NULL,'166','1'),
('S206','67','驚異の切れ味','0','13','43','95','38','A211',NULL,'203','1'),
('S207','70','変幻自在','38','0','56','81','13','A214',NULL,'148','1'),
('S208','72','精密機械','0','0','88','13','25','A217',NULL,'150','1'),
('S209','73','怪物球威','81','0','44','0','0','A218',NULL,'141','1'),
('S210','78','ドクターK','44','0','100','63','44','A223',NULL,'175','1'),
('S211','79','ハイスピンジャイロ','88','0','50','50','0','A224',NULL,'210','1'),
('S212','80','本塁打厳禁','38','0','94','50','6','A225',NULL,'141','1'),
('S213','81','勝利の星','48','0','48','48','48','A226',NULL,'173','1'),
('S214','88','鉄腕','0','0','20','0','30',NULL,NULL,'148','1'),
('S215','75','ド根性','25','0','0','0','163','A220',NULL,'166','1'),
('S216','89','ミスターゼロ','108','0','72','20','176',NULL,NULL,'189','1'),
('S217','74','超尻上がり','56','0','38','0','94','A219',NULL,'210','1'),
('S218','90','復活','132','0','94','94','182',NULL,NULL,'265','1'),
('S219','83','クロスキャノン','50','0','88','50','0','A228',NULL,'141','1'),
('S220','87','内無双','0','0','48','13','65','A232',NULL,'150','1'),
('S221','77','ディレイドアーム','69','0','69','69','44','A222',NULL,'189','1'),
('S222','97','マインドブレイカー','60','25','25','60','80',NULL,NULL,'265','1'),
('S223','114','先手必奪','37','0','37','0','50','A233',NULL,'150','1'),
('S224','117','意気揚々','0','8','20','110','50','A235',NULL,'210','1'),
('S225','119','必殺火消し人','50','0','35','30','10','A236',NULL,'150','1'),
('S226','120','形勢逆転','126','0','92','0','32',NULL,NULL,'189','1'),
('S227','121','ジャストフィット','54','0','80','0','54','A237',NULL,'203','1'),
('S228','123','暴れ球','54','0','80','0','54','A238',NULL,'174','1'),
('S229','126','みなぎる活力','150','0','0','0','225',NULL,NULL,'189','1'),
('S230','129','金縛り','0','25','110','0','115','A240',NULL,'141','1'),
('S231','130','速球プライド','110','0','18','0','60','A241',NULL,'148','1'),
('S232','136','変化球プライド','0','18','0','60','110','A243',NULL,'148','1'),
('S233','82','勇猛果敢','50','0','50','38','50','A227',NULL,'148','1'),
('S234','140','完全燃焼','113','0','0','0','75','A244',NULL,'173','1'),
('S235','142','原点投球','65','0','60','0','0','A245',NULL,'150','1'),
('S236','71','鉄仮面','0','18','75','0','94','A215',NULL,'189','1'),
('S237','146','二刀流','110','30','110','0','0','A246',NULL,'228','1'),
('S238','131','闘魂','0','0','0','0','312','A216',NULL,'217','1'),
('S239','151','完全制圧','60','0','120','0','195','A247',NULL,'217','1'),
('S240','153','ギアチェンジ','90','0','120','0','292',NULL,NULL,'265','1'),
('S241','154','エースの風格','130','18','130','64','160',NULL,NULL,'265','1'),
('S242','155','アームブレイカー','300','0','52','0','150',NULL,NULL,'265','1'),
('R201','65','真・怪童','164','0','124','0','44','S204',NULL,'493','6'),
('R202','63','真・強心臓','0','0','105','0','245','S202',NULL,'343','6'),
('B100','62','打たれ強さ△','0','0','10','0','50','B101',NULL,'0','2'),
('B101','62','打たれ強さ×','0','0','5','0','25','P100','B100','0','2'),
('B102','63','対ピンチ△','0','0','30','0','70','B103',NULL,'0','2'),
('B103','63','対ピンチ×','0','0','15','0','35','P101','B102','0','2'),
('B104','64','対左打者△','24','0','52','0','24','B105',NULL,'0','2'),
('B105','64','対左打者×','12','0','26','0','12',NULL,'B104','0','2'),
('B106','65','ノビ△','82','0','62','0','22','B107',NULL,'0','2'),
('B107','65','ノビ×','41','0','31','0','11',NULL,'B106','0','2'),
('B108','66','クイック△','0','30','20','0','0','B109',NULL,'0','2'),
('B109','66','クイック×','0','15','10','0','0',NULL,'B108','0','2'),
('B110','71','短気','0','0','0','0','31',NULL,NULL,'0','2'),
('B111','73','軽い球','40','0','23','0','0',NULL,NULL,'0','2'),
('B112','80','一発','13','0','31','16','3',NULL,NULL,'0','2'),
('B113','81','負け運','9','0','9','9','0',NULL,NULL,'0','2'),
('B114','91','シュート回転','13','0','44','38','0',NULL,NULL,'0','2'),
('B115','92','スロースターター','0','13','25','0','25',NULL,NULL,'0','2'),
('B116','93','寸前×','0','0','6','0','25',NULL,NULL,'0','2'),
('B117','94','四球','0','0','13','0','19',NULL,NULL,'0','2'),
('B118','95','力配分','13','0','13','13','25',NULL,NULL,'0','2'),
('B119','96','乱調','0','0','19','0','75',NULL,NULL,'0','2'),
('P100','62','ガラスのハート','0','0','20','0','100',NULL,'B101','0','3'),
('P101','63','ノミの心臓','0','0','60','0','140',NULL,'B103','0','3'),
('G0','98','強振多用','0','0','0','0','0',NULL,NULL,'0','5'),
('G1','98','ミート多用','0','0','0','0','0',NULL,NULL,'0','5'),
('G2','99','積極打法','0','0','0','0','0',NULL,NULL,'0','5'),
('G3','99','慎重打法','0','0','0','0','0',NULL,NULL,'0','5'),
('G4','100','積極盗塁','0','0','0','0','0',NULL,NULL,'0','5'),
('G5','100','慎重盗塁','0','0','0','0','0',NULL,NULL,'0','5'),
('G6','101','積極走塁','0','0','0','0','0',NULL,NULL,'0','5'),
('G7','101','慎重走塁','0','0','0','0','0',NULL,NULL,'0','5'),
('G8','102','積極守備','0','0','0','0','0',NULL,NULL,'0','5'),
('G9','103','チームプレイ〇','0','0','0','0','0',NULL,NULL,'0','5'),
('G10','103','チームプレイ×','0','0','0','0','0',NULL,NULL,'0','5'),
('G11','104','選球眼','0','0','0','0','0',NULL,NULL,'11.76','5'),
('G12','105','速球中心','0','0','0','0','0',NULL,NULL,'0','5'),
('G13','105','変化球中心','0','0','0','0','0',NULL,NULL,'0','5'),
('G14','106','テンポ〇','0','0','0','0','0',NULL,NULL,'16','5'),
('G15','107','投球位置左','0','0','0','0','0',NULL,NULL,'0','5'),
('G16','107','投球位置右','0','0','0','0','0',NULL,NULL,'0','5'),
('G17','108','スタミナ限界','0','0','0','0','0',NULL,NULL,'0','5'),
('G18','109','完投','0','0','0','0','0',NULL,NULL,'0','5'),
('G19','110','人気者','0','0','0','0','0',NULL,NULL,'0','5'),
('G20','111','調子安定','0','0','0','0','0',NULL,NULL,'15.68','5'),
('G21','111','調子極端','0','0','0','0','0',NULL,NULL,'-15.68','5'),
('G22','132','調子安定','0','0','0','0','0',NULL,NULL,'41','5'),
('G23','132','調子極端','0','0','0','0','0',NULL,NULL,'0','5');

SET AUTOCOMMIT=1;
