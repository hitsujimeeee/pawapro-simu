SET AUTOCOMMIT=0;

TRUNCATE TABLE BASE_POINT_DETAIL;

INSERT INTO BASE_POINT_DETAIL (TYPE, POINT_FROM, POINT_TO, POWER, SPEED, TECH, SCREWBALL, MENTAL) VALUES
('0','2','2','10','0','10','0','10'),
('0','3','3','30','0','30','0','30'),
('0','4','4','50','0','50','0','50'),
('1','2','10','1','0','2','0','1'),
('1','11','20','1','0','4','0','3'),
('1','21','30','1','0','6','0','4'),
('1','31','40','2','0','8','0','6'),
('1','41','50','3','0','10','0','8'),
('1','51','60','3','0','12','0','9'),
('1','61','70','3','0','14','0','11'),
('1','71','80','4','0','16','0','12'),
('1','81','90','4','0','18','0','14'),
('1','91','100','5','0','20','0','15'),
('1','101','101','15','0','60','0','45'),
('1','102','105','5','0','20','0','15'),
('1','106','106','10','0','40','0','30'),
('2','2','10','3','0','1','0','0'),
('2','11','20','6','0','2','0','0'),
('2','21','30','9','0','3','0','0'),
('2','31','40','12','0','4','0','0'),
('2','41','50','15','0','5','0','0'),
('2','51','60','18','0','6','0','0'),
('2','61','70','21','0','7','0','0'),
('2','71','80','24','0','8','0','0'),
('2','81','90','27','0','9','0','0'),
('2','91','100','30','0','10','0','0'),
('3','2','10','1','5','0','0','0'),
('3','11','20','1','7','0','0','0'),
('3','21','30','1','9','0','0','0'),
('3','31','40','2','11','0','0','0'),
('3','41','50','2','13','0','0','0'),
('3','51','60','3','15','0','0','0'),
('3','61','70','3','17','0','0','0'),
('3','71','80','4','19','0','0','0'),
('3','81','90','4','21','0','0','0'),
('3','91','100','5','23','0','0','0'),
('4','2','10','1','1','1','0','0'),
('4','11','20','2','2','2','0','0'),
('4','21','30','3','3','3','0','0'),
('4','31','40','4','4','4','0','0'),
('4','41','50','5','5','5','0','0'),
('4','51','60','6','6','6','0','0'),
('4','61','70','7','7','7','0','0'),
('4','71','80','8','8','8','0','0'),
('4','81','90','9','9','9','0','0'),
('4','91','100','10','10','10','0','0'),
('5','2','10','0','1','1','0','1'),
('5','11','20','0','2','2','0','2'),
('5','21','30','0','3','3','0','3'),
('5','31','40','0','4','4','0','4'),
('5','41','50','0','5','5','0','5'),
('5','51','60','0','6','6','0','6'),
('5','61','70','0','7','7','0','7'),
('5','71','80','0','8','8','0','8'),
('5','81','90','0','9','9','0','9'),
('5','91','100','0','10','10','0','10'),
('5','101','101','0','30','30','0','30'),
('5','102','105','0','10','10','0','10'),
('5','106','106','0','20','20','0','20'),
('6','2','10','0','1','0','0','3'),
('6','11','20','0','1','0','0','4'),
('6','21','30','0','2','0','0','6'),
('6','31','40','0','2','0','0','7'),
('6','41','50','0','3','0','0','9'),
('6','51','60','0','3','0','0','10'),
('6','61','70','0','4','0','0','12'),
('6','71','80','0','4','0','0','13'),
('6','81','90','0','5','0','0','15'),
('6','91','100','0','5','0','0','16'),
('6','101','101','0','15','0','0','45'),
('6','102','105','0','5','0','0','16'),
('6','106','106','0','10','0','0','32'),
('7','121','130','25','0','12','0','3'),
('7','131','135','28','0','14','0','3'),
('7','136','140','31','0','14','0','3'),
('7','141','141','34','0','17','0','3'),
('7','142','142','37','0','18','0','4'),
('7','143','143','40','0','20','0','4'),
('7','144','144','43','0','21','0','4'),
('7','145','145','46','0','23','0','5'),
('7','146','146','49','0','24','0','5'),
('7','147','147','52','0','26','0','5'),
('7','148','148','55','0','27','0','5'),
('7','149','149','58','0','29','0','6'),
('7','150','150','61','0','30','0','6'),
('7','151','151','64','0','32','0','6'),
('7','152','152','67','0','33','0','7'),
('7','153','153','70','0','35','0','7'),
('7','154','154','73','0','36','0','7'),
('7','155','155','76','0','38','0','8'),
('7','156','156','79','0','39','0','8'),
('7','157','157','82','0','41','0','8'),
('7','158','158','85','0','42','0','9'),
('7','159','159','88','0','44','0','9'),
('7','160','160','91','0','45','0','9'),
('7','161','161','94','0','47','0','9'),
('7','162','162','97','0','48','0','10'),
('7','163','163','100','0','50','0','10'),
('7','164','164','103','0','51','0','10'),
('7','165','165','106','0','53','0','11'),
('7','166','166','109','0','54','0','11'),
('7','167','167','112','0','56','0','11'),
('7','168','168','115','0','57','0','12'),
('7','169','169','120','0','60','0','12'),
('7','170','170','144','0','72','0','14'),
('8','2','10','0','0','9','0','8'),
('8','11','20','0','0','10','0','9'),
('8','21','30','0','0','11','0','10'),
('8','31','40','0','0','12','0','11'),
('8','41','50','0','0','13','0','12'),
('8','51','60','0','0','14','0','13'),
('8','61','70','0','0','16','0','14'),
('8','71','80','0','0','18','0','16'),
('8','81','90','0','0','20','0','18'),
('8','91','100','0','0','22','0','20'),
('8','101','101','0','0','66','0','60'),
('8','102','104','0','0','22','0','20'),
('9','2','10','6','0','0','0','4'),
('9','11','20','7','0','0','0','5'),
('9','21','30','8','0','0','0','6'),
('9','31','40','9','0','0','0','6'),
('9','41','50','10','0','0','0','7'),
('9','51','60','11','0','0','0','8'),
('9','61','70','12','0','0','0','8'),
('9','71','80','13','0','0','0','9'),
('9','81','90','14','0','0','0','10'),
('9','91','100','15','0','0','0','11');

SET AUTOCOMMIT=1;
