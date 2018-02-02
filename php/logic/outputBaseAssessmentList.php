<?php
require_once '../global.php';
require_once './getBaseAssessmentList.php';
require_once '../lib/PHPExcel/Classes/PHPExcel.php';
require_once '../lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once '../lib/PHPExcel/Classes/PHPExcel/RichText.php';

$dbh = DB::connect();
$type = isset($_GET['type']) ? (int)$_GET['type'] : 0;

$list = getBaseAssessmentList($dbh, $type);


//テンプレート読み込み
$template = ['templateBatterBase', 'templatePitcherBase'][$type];
$filepath = "../../data/" . $template . ".xlsm";
$reader = PHPExcel_IOFactory::createReader('Excel2007');
$objExcel = $reader->load($filepath);
//シート設定
$objExcel->setActiveSheetIndex(0);
$sheet = $objExcel->getActiveSheet();
$colorList = [['FF9CDFAC', 'FFD9FEED'], ['FF90B3D9', 'FFDCE6F2']];

$sheet->setCellValueByColumnAndRow(13, 2, '最終更新 ' . date("Y/m/d"));


foreach($list[0] as $idx=>$l) {
	$sheet->setCellValueByColumnAndRow(1, 5+$idx, $l['assessment']);
	$sheet->setCellValueByColumnAndRow(2, 5+$idx, round($l['assessment']/7.84));
	$sheet->setCellValueByColumnAndRow(3, 5+$idx, $l['eff'] === null ? '-' : $l['eff']);
	$c = $colorList[1][($idx)%2];
	$sheet->getStyleByColumnAndRow(1, 5+$idx)->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB($c);
	$sheet->getStyleByColumnAndRow(2, 5+$idx)->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB($c);
	$sheet->getStyleByColumnAndRow(3, 5+$idx)->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB($c);
}



for($i = 1; $i < count($list); $i++) {
	$l = $list[$i];

	$preAss = null;
	$colorIdx = 1;
//	$memberStart = null;
//	$count = count($l);
	foreach ($l as $idx=>$p) {
		$sheet->setCellValueByColumnAndRow(7+($i-1)*3, 5+$idx, $p['assessment']);
		$sheet->setCellValueByColumnAndRow(8+($i-1)*3, 5+$idx, round($p['assessment']/7.84));
		$sheet->setCellValueByColumnAndRow(9+($i-1)*3, 5+$idx, $p['eff'] === null ? '-' : $p['eff']);
//		$sheet->setCellValueByColumnAndRow(9+($i-1)*3, 5+$idx, $p['allEff'] === null ? '-' : $p['allEff']);
		if ($preAss === null || $preAss !== $p['assessment']) {
			$preAss = $p['assessment'];
			$colorIdx = ($colorIdx + 1) % 2;

//			if ($memberStart !== null && $memberStart !== $idx - 1) {
//				$sheet->mergeCellsByColumnAndRow( 7+($i-1)*3, 5+$memberStart, 7+($i-1)*3, 5+$idx-1 );
//				$sheet->mergeCellsByColumnAndRow( 8+($i-1)*3, 5+$memberStart, 8+($i-1)*3, 5+$idx-1 );
//			}
//			$memberStart = $idx;
		}
		$c = $colorList[$i%2][$colorIdx];
		for ($j = 0; $j < 3; $j++) {
			$sheet->getStyleByColumnAndRow(7+$j+($i-1)*3, 5+$idx)->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB($c);
		}

//		if($idx === $count - 1 && $idx > $memberStart) {
//			$sheet->mergeCellsByColumnAndRow( 7+($i-1)*3, 5+$memberStart, 7+($i-1)*3, 5+$idx);
//			$sheet->mergeCellsByColumnAndRow( 8+($i-1)*3, 5+$memberStart, 8+($i-1)*3, 5+$idx);
//		}
	}
}



$fname = ['sateiBatterBase.xlsm', 'sateiPitcherBase.xlsm'][$type];

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
