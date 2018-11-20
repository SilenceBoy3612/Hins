<?php
include "./vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//获取文件路径
$inputFileName = './数据.xlsx';
$inputFileName2='./模板.xlsx';

//判断文件类型
$fileType = IOFactory::identify($inputFileName);
//获取文件读取对象
$objReader = IOFactory::createReader($fileType);
//加载文件
$spreadsheet=$objReader->load($inputFileName);

$sheet = $spreadsheet->getSheet(0);
$highestRow = $sheet->getHighestRow();           //取得总行数
$highestColumn = $sheet->getHighestColumn(); //取得总列数



for($j=2;$j<=$highestRow;$j++) {
    $spreadsheet->getActiveSheet();
    //获取镇名
    $a = $spreadsheet->getActiveSheet()->getCell("A" . $j)->getValue();

    //获取管护主体村和编码
    $b = $spreadsheet->getActiveSheet()->getCell("B" . $j)->getValue();
    $c = $spreadsheet->getActiveSheet()->getCell("C" . $j)->getValue();

    //获取四至范围的值
    $d = $spreadsheet->getActiveSheet()->getCell("D" . $j)->getValue();
    $e = $spreadsheet->getActiveSheet()->getCell("E" . $j)->getValue();
    $f = $spreadsheet->getActiveSheet()->getCell("F" . $j)->getValue();
    $g = $spreadsheet->getActiveSheet()->getCell("G" . $j)->getValue();

//获取面积-填表日期
    $h = $spreadsheet->getActiveSheet()->getCell("H" . $j)->getValue();
    $i = $spreadsheet->getActiveSheet()->getCell("I" . $j)->getValue();
    $j = $spreadsheet->getActiveSheet()->getCell("J" . $j)->getValue();
    $k = $spreadsheet->getActiveSheet()->getCell("K" . $j)->getValue();
    $l = $spreadsheet->getActiveSheet()->getCell("L" . $j)->getValue();
    $m = $spreadsheet->getActiveSheet()->getCell("M" . $j)->getValue();
    $n = $spreadsheet->getActiveSheet()->getCell("N" . $j)->getValue();
    $o = $spreadsheet->getActiveSheet()->getCell("0" . $j)->getValue();
    $p = $spreadsheet->getActiveSheet()->getCell("P" . $j)->getValue();
    $q = $spreadsheet->getActiveSheet()->getCell("Q" . $j)->getValue();
    $r = $spreadsheet->getActiveSheet()->getCell("R" . $j)->getValue();
    $s = $spreadsheet->getActiveSheet()->getCell("S" . $j)->getValue();
    $t = $spreadsheet->getActiveSheet()->getCell("T" . $j)->getValue();

}

//释放表格
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);


$spreadsheet2=IOFactory::load($inputFileName2);

$objExcel = $spreadsheet2->getActiveSheet();


//设置镇名
$objExcel->setCellValue("L2",$a);

for($j=8;$j<=$highestRow;$j++) {

    //设置行政区域和编码
    $objExcel->setCellValue("B",$b)->setCellValue("C",$c);

    //设置四至范围
    $e=$j+1;
    $objExcel->setCellValue("E" . $j, $d)->setCellValue("G" . $j, '$e')
        ->setCellValue("E" . $e, $f)->setCellValue("G" . $e, $g);

    //设置面积到 责任起始时间
    $objExcel->setCellValue("H", $h)->setCellValue("I", '$i')
        ->setCellValue("K", $k)->setCellValue("L", $l)
        ->setCellValue("M", $m)->setCellValue("N", '$n')
        ->setCellValue("O", $o)->setCellValue("P", $p);

    //设置审核人 审核日期 填表人 填表日期

    $objExcel->setCellValue("B30",$q)->setCellValue("D30",$r)
        ->setCellValue("L30",$s)->setCellValue("N30",$t);

}


$write = new Xlsx($spreadsheet2);
$write->save('$a.$b.xlsx');




