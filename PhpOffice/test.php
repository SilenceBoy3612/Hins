<?php
foreach($objPHPExcel->getWorksheetIterator()as $sheet){//循环取sheet
    foreach($sheet->getRowIterator()as $row){//逐行读取
        if ($row->getRowIndex()<2){
            continue;
        }
        foreach($row->getCellIterator() as $cell){//逐列读取
            $data=$cell->getValue();
            echo $data;
        }
    }
}
