SET AUTOCOMMIT=0;

TRUNCATE TABLE ABILITY_HEADER;

INSERT INTO ABILITY_HEADER (ID, NAME, CATEGORY, PAIR, SORT_ORDER) VALUES
('0','チャンス','0',NULL,'1'),
('1','対左投手','0',NULL,'2'),
('2','盗塁','0',NULL,'3'),
('3','走塁','0',NULL,'4'),
('4','送球','0',NULL,'5'),
('5','ケガしにくさ','0',NULL,'6'),
('6','キャッチャー','0',NULL,'7'),
('7','アベレージヒッター','0',NULL,'8'),
('8','パワーヒッター','0',NULL,'9'),
('9','プルヒッター','0','10','10'),
('10','広角打法','0','9','11'),
('11','内野安打○','0',NULL,'12'),
('12','流し打ち','0',NULL,'13'),
('13','固め打ち','0',NULL,'14'),
('14','粘り打ち','0',NULL,'15'),
('15','悪球打ち','0',NULL,'16'),
('16','意外性','0',NULL,'17'),
('17','バント○','0',NULL,'18'),
('18','初球○','0',NULL,'19'),
('19','代打○','0',NULL,'20'),
('20','チャンスメーカー','0',NULL,'21'),
('21','ヘッドスライディング','0',NULL,'22'),
('22','ホーム突入','0',NULL,'23'),
('23','満塁男','0',NULL,'24'),
('24','サヨナラ男','0',NULL,'25'),
('25','逆境○','0',NULL,'26'),
('26','ハイボールヒッター','0','27','27'),
('27','ローボールヒッター','0','26','28'),
('28','対エース○','0',NULL,'29'),
('29','ムード○','0',NULL,'30'),
('30','威圧感','0',NULL,'31'),
('31','レーザービーム','0',NULL,'32'),
('32','守備職人','0',NULL,'33'),
('33','高速チャージ','0',NULL,'34'),
('34','ホーム死守','0',NULL,'35'),
('35','プレッシャーラン','0',NULL,'36'),
('36','いぶし銀','0',NULL,'37'),
('37','帳尻合わせ','0',NULL,'40'),
('38','気分屋','0',NULL,'41'),
('39','ラッキーボーイ','0',NULL,'42'),
('40','連打○','0',NULL,'43'),
('41','リベンジ','0',NULL,'44'),
('42','本塁生還','0',NULL,'48'),
('43','ささやき戦術','0',NULL,'38'),
('44','三振','9','49','201'),
('45','併殺','9',NULL,'203'),
('46','エラー','9',NULL,'204'),
('47','バズーカ','0',NULL,'50'),
('48','インコース○','0','122','45'),
('49','扇風機','9','44','202'),
('50','ラッキーセブン','0',NULL,'49'),
('51','追い打ち','0',NULL,'39'),
('52','競争心','0',NULL,'52'),
('53','司令塔','0',NULL,'51'),
('54','ささやき破り','0',NULL,'47'),
('55','打球ノビ','0',NULL,'53'),
('56','盗塁アシスト','0',NULL,'54'),
('57','アイコンタクト','0',NULL,'55'),
('58','窮地◯','0',NULL,'58'),
('59','上り調子','0',NULL,'57'),
('60','速攻○','0',NULL,'56'),
('61','ハードラック','9',NULL,'205'),
('62','打たれ強さ','4',NULL,'0'),
('63','対ピンチ','4',NULL,'1'),
('64','対左打者','4',NULL,'2'),
('65','ノビ','4',NULL,'3'),
('66','クイック','4',NULL,'4'),
('67','キレ○','4',NULL,'5'),
('68','打球反応○','4',NULL,'6'),
('69','牽制○','4',NULL,'7'),
('70','緩急○','4',NULL,'8'),
('71','ポーカーフェイス','4','131','9'),
('72','低め○','4',NULL,'11'),
('73','重い球','4',NULL,'12'),
('74','尻上がり','4',NULL,'13'),
('75','根性○','4',NULL,'14'),
('76','リリース○','4',NULL,'15'),
('77','球持ち○','4',NULL,'16'),
('78','奪三振','4',NULL,'17'),
('79','ジャイロボール','4',NULL,'18'),
('80','逃げ球','4',NULL,'19'),
('81','勝ち運','4',NULL,'20'),
('82','対強打者○','4',NULL,'21'),
('83','クロスファイヤー','4',NULL,'22'),
('84','要所○','4',NULL,'23'),
('85','緊急登板○','4',NULL,'24'),
('86','バント封じ','4',NULL,'27'),
('87','内角○','4',NULL,'28'),
('88','鉄腕','4',NULL,'30'),
('89','ミスターゼロ','4',NULL,'31'),
('90','復活','4',NULL,'32'),
('91','シュート回転','8',NULL,'201'),
('92','スロースターター','8',NULL,'202'),
('93','寸前×','8',NULL,'203'),
('94','四球','8',NULL,'204'),
('95','力配分','8',NULL,'205'),
('96','乱調','8',NULL,'206'),
('97','マインドブレイカー','4',NULL,'33'),
('98','打撃スタイル','5',NULL,'301'),
('99','打法','5',NULL,'302'),
('100','盗塁','5',NULL,'303'),
('101','走塁','5',NULL,'304'),
('102','積極守備','5',NULL,'305'),
('103','ﾁｰﾑﾌﾟﾚｲ','5',NULL,'306'),
('104','選球眼','5',NULL,'307'),
('105','投球スタイル','6',NULL,'308'),
('106','テンポ〇','6',NULL,'309'),
('107','投球位置','6',NULL,'310'),
('108','スタミナ限界','6',NULL,'311'),
('109','完投','6',NULL,'312'),
('110','人気者','7',NULL,'313'),
('111','調子','5',NULL,'314'),
('112','読心術','0',NULL,'59'),
('113','打開','0',NULL,'61'),
('114','先制ストライク','4',NULL,'34'),
('115','安全圏◯','4',NULL,'26'),
('116','情熱エール','0',NULL,'60'),
('117','手応え','4',NULL,'35'),
('118','接戦○','0',NULL,'62'),
('119','火消し','4',NULL,'36'),
('120','形勢逆転','4',NULL,'37'),
('121','順応','4',NULL,'38'),
('122','アウトコース○','0','48','46'),
('123','荒れ球','4',NULL,'39'),
('124','祝福','0',NULL,'63'),
('125','球速安定','4',NULL,'25'),
('126','みなぎる活力','4',NULL,'41'),
('127','鼓舞','0',NULL,'64'),
('128','かく乱','0',NULL,'65'),
('129','縛り','4',NULL,'40'),
('130','速球対抗心','4',NULL,'42'),
('131','闘志','4','71','10'),
('132','調子','6',NULL,'315'),
('133','威圧感','4',NULL,'29'),
('134','挑発','0',NULL,'66'),
('135','一発逆転','0',NULL,'67'),
('136','変化球対抗心','4',NULL,'43'),
('137','一掃','0',NULL,'68'),
('138','初撃','0',NULL,'69'),
('139','冷静','0',NULL,'70'),
('140','全開','4',NULL,'44'),
('141','サイン察知','0',NULL,'71'),
('142','アウトロー球威〇','4',NULL,'45'),
('143','四番〇','0',NULL,'72'),
('144','孤高','0',NULL,'73'),
('145','走力ブースト','0',NULL,'74'),
('146','投打躍動','4',NULL,'46'),
('147','ファースト〇','0',NULL,'75'),
('148','守備移動〇','0',NULL,'76'),
('149','痛打','0',NULL,'77'),
('150','セカンド〇','0',NULL,'78'),
('151','制圧','4',NULL,'47'),
('152','サード〇','0',NULL,'79'),
('153','ギアチェンジ','4',NULL,'48'),
('154','エースの風格','4',NULL,'49'),
('155','アームブレイカー','4',NULL,'50');

SET AUTOCOMMIT=1;
