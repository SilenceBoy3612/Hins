<?php
/**
 * 导出Excel
 * @param  object $spreadsheet  数据
 * @param  string $format       格式:excel2003 = xls, excel2007 = xlsx
 * @param  string $savename     保存的文件名
 * @return filedownload         浏览器下载
 */
function exportExcel($spreadsheet, $format = 'xls', $savename = 'export') {
    if (!$spreadsheet) return false;
    if ($format == 'xls') {
        //输出Excel03版本
        header('Content-Type:application/vnd.ms-excel');
        $class = "\PhpOffice\PhpSpreadsheet\Writer\Xls";
    } elseif ($format == 'xlsx') {
        //输出07Excel版本
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $class = "\PhpOffice\PhpSpreadsheet\Writer\Xlsx";
    }
    //输出名称
    header('Content-Disposition: attachment;filename="'.$savename.'.'.$format.'"');
    //禁止缓存
    header('Cache-Control: max-age=0');
    $writer = new $class($spreadsheet);
    $filePath = env('runtime_path')."temp/".time().microtime(true).".tmp";
    $writer->save($filePath);
    readfile($filePath);
    unlink($filePath);
}