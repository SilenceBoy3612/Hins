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

//获取sheet的文件
$data=$spreadsheet->getActiveSheet()->toArray();

//释放表格
$spreadsheet->disconnectWorksheets();
unset($spreadsheet);

$spreadsheet2=IOFactory::load($inputFileName2);

$objExcel = $spreadsheet2->getActiveSheet();

$objExcel->fromArray($data,null,"B8");
$write = new Xlsx($spreadsheet2);
$write->save("table.xlsx");




