<?php
require_once '../global.php';
require_once './getAssessmentList.php';
require_once '../lib/PHPExcel/Classes/PHPExcel.php';
require_once '../lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/PHPExcel/Classes/PHPExcel/RichText.php';

$dbh = DB::connect();
$type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
$spFlag = isset($_GET['spFlag']) ? (int)$_GET['spFlag'] : 0;

$list = getAssessmentList($dbh, $type, $spFlag);

//テンプレート読み込み
$template = [['templateBatter', 'templateBatterS'], ['templatePitcher', 'templatePitcherS']][$type][$spFlag];
$filepath = "../../data/" . $template . ".xlsx";
$reader = PHPExcel_IOFactory::createReader('Excel2007');
$objExcel = $reader->load($filepath);

//シート設定
$objExcel->setActiveSheetIndex(0);
$sheet = $objExcel->getActiveSheet();

$i = 0;
$color = [
	['FFE3ECF5', 'FFBDD7EE'], ['FFFFFCDB', 'FFFEF991']];
$gColor = ['FFCBF8CD', 'FFDEFBDF'];

$sheet->setCellValueByColumnAndRow(6, 2, '最終更新 ' . date("Y/m/d"));

$rankStrList = ['G', 'F', 'E', 'D', 'C', 'B', 'A'];
$rankColorList = ['FF555555', 'FF009DBF', 'FF006600', 'FFEADD36', 'ffff9933', 'ffff0000', 'ffff33cc', 'FFC9A700'];

foreach($list as $l) {

	//名前書き出し
	if ($l['id'] !== 'A013X') {
		$sheet->setCellValueByColumnAndRow(1, 5+$i, $l['name']);
	} else {
		//+サブ捕対策
		$objRichText = new PHPExcel_RichText();
		$objRichText->createText($l['name']);
		$cText = $objRichText->createTextRun('+サブ補');
		$cText->getFont()->setSize(7);
		$cText->getFont()->setName('メイリオ');
		$sheet->setCellValueByColumnAndRow(1, 5+$i, $objRichText);

	}
	$sheet->setCellValueByColumnAndRow(2, 5+$i, $l['totalPoint']);


	//査定値書き出し
	if ($l['id'] === 'A230') {
		//バント封じ対策
		$sheet->setCellValueByColumnAndRow(3, 5+$i, '-');
		$sheet->setCellValueByColumnAndRow(4, 5+$i, '-');
	} else {
		$sheet->setCellValueByColumnAndRow(3, 5+$i, $l['totalAssessment']);
		$sheet->setCellValueByColumnAndRow(4, 5+$i, $l['assessment']);
	}

	$eff = $l['eff'][0];
	if ($eff >= 100 && $l['type'] === 5) {
		$sheet->setCellValueByColumnAndRow(0, 5+$i, '-');
		$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->setName('HG創英角ｺﾞｼｯｸUB');
	} else if ($eff >= 100) {
		$sheet->setCellValueByColumnAndRow(0, 5+$i, $type === 0 ? '∞' : '-');
		$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->setName('HG創英角ｺﾞｼｯｸUB');
	} else if ($l['id'] === 'A230') {
		$sheet->setCellValueByColumnAndRow(0, 5+$i, '-');
		$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->setName('HG創英角ｺﾞｼｯｸUB');
	} else {

		//ランク文字入力
		$rankStr = $eff >= 0.51 ? 'SS' : ($eff >= 0.21 ? 'S' : $rankStrList[(int)($eff / 0.03)]);
		$sheet->setCellValueByColumnAndRow(0, 5+$i, $rankStr);

		if ($eff >= 0.78) {
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('SS');
			if ((int)(($eff-0.84)/0.06+1)  > 0) {
				$objNum = $objRichText->createTextRun((int)(($eff-0.84)/0.6+1));
				$objNum->getFont()->setSize(10);
				$objNum->getFont()->getColor()->setARGB('FFe6b422');
			}
			$sheet->setCellValueByColumnAndRow(0, 5+$i, $objRichText);
			$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->setName('Arial');
			$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->getColor()->setARGB('FFe6b422');
		} else if ($eff >= 0.24) {
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('S');
			$objNum = $objRichText->createTextRun((int)(($eff-0.24)/0.06+1));
			$objNum->getFont()->setSize(10);
			$objNum->getFont()->getColor()->setARGB('FFe6b422');
			$sheet->setCellValueByColumnAndRow(0, 5+$i, $objRichText);
			$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->setName('Arial');
			$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->getColor()->setARGB('FFe6b422');
		} else {
			$sheet->getStyleByColumnAndRow(0, 5+$i)->getFont()->getColor()->setARGB($rankColorList[(int)($eff / 0.03)]);
		}
	}

	//セルに色付け
	$c = $l['type'] !== 5 ? $color[$spFlag][$i%2] : $gColor[$i%2];
	for ($j = 0; $j <= 10; $j++) {
		$sheet->getStyleByColumnAndRow($j, 5+$i)->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB($c);
	}


	//査定効率書き出し
	if ($l['totalPoint'] != 0 && $l['id'] !== 'A230') {
		foreach($l['eff'] as$key=>$value) {
			$sheet->setCellValueByColumnAndRow(5+$key, 5+$i, $value);
		}
	} else {
		foreach($l['eff'] as$key=>$value) {
			$sheet->setCellValueByColumnAndRow(5+$key, 5+$i, '-');
			$sheet->getStyleByColumnAndRow(5+$key, 5+$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
	}
	$i++;

}

$fname = [['sateiBatter.xlsx', 'sateiBatterS.xlsx'], ['sateiPitcher.xlsx', 'sateiPitcherS.xlsx']][$type][$spFlag];

$sheet->setSelectedCell('A1');

// Excelファイルのダウンロード
$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $fname . '"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');



$objExcel->disconnectWorksheets();
unset($objWriter);
unset($sheet);
unset($objExcel);

?>
