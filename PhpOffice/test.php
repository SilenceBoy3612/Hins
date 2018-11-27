<?php
include "./vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$data=array(
    'name'=>'hins',
    'id'=>'12345678910111213',
    'age'=>'23'
);
$spreadshett = new Spreadsheet();
$inputFileName = './模板.xlsx';

//判断文件类型
$fileType = IOFactory::identify($inputFileName);

//获取文件读取对象
$objReader = IOFactory::createReader($fileType);

//加载模板
$spreadsheet=$objReader->load($inputFileName);

//获取活动的sheet
$objExcel = $spreadsheet->getActiveSheet();

$objExcel->setCellValue("A8",$data['name'])->setCellValue("B8",$data['id'])->setCellValue("C8",$data['age']);

$writer =new Xlsx($objExcel);
$writer->save('hins.xlsx');

