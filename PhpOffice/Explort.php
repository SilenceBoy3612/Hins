<?php
require "DB.php";
require "dbConfig.php";
include "./vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inputFileName = './模板.xlsx';

$db = new DB($phpexcel);;

$B="龙陂村";

//echo $B;
$Num = $db->getCount($B);
$Data = $db->getSingleCountryInfo($B);
$spreadsheet=IOFactory::load($inputFileName);

$objExcel = $spreadsheet->getActiveSheet();
//echo "<pre>";
////var_dump($Data);
//echo "<pre>";
////print_r($Num);
//foreach ($Num as $key=>$val){
//    $num=$val[0];
//}
//print_r($Num) ;
//
$filed="电光村";
$num = $db->getCount($filed);
echo $num;

//$res=$db->getNum($filed);
//echo $res;
$C="贝墩";
$D = $db->getTownCountryNum($C);
echo $D;
//$j=8;
//$count=$j+$num-1;
//for (;$j<=$count;){
//foreach ($Data as $key=>$val){
//    $A=$val['A'];
//    $objExcel->setCellValue("L2",$val['A'])
//        ->setCellValue("B".$j,$val['B'])
//        ->setCellValue("C".$j,$val['C'])
//
//        ->setCellValue("D".$j,$val['D'])
//
//        ->setCellValue("H".$j,$val['E'])
//        ->setCellValue("I".$j,$val['F'])
//        ->setCellValue("J".$j,$val['G'])
//        ->setCellValue("K".$j,$val['H'])
//        ->setCellValue("L".$j,$val['I'])
//        ->setCellValue("M".$j,$val['J'])
//        ->setCellValue("N".$j,$val['K'])
//        ->setCellValue("O".$j,$val['L'])
//        ->setCellValue("P".$j,$val['M'])
//
//        ->setCellValue("C20",$val['N'])
//        ->setCellValue("F20",$val['O'])
//        ->setCellValue("L20",$val['P'])
//        ->setCellValue("O20",$val['Q']);
//
//    $j++;
//    }
//}
//
//$write = new Xlsx($spreadsheet);
//$write->save("$A$B.xlsx");
