<html lang="en">
<?php
require "DB.php";

$db = new DB($phpexcel);

$A=$_POST['town'];
$B=$_POST['country'];
$Begin=$_POST['row'];

//$A="大坝";
//$B="合水村";
//$Begin=8;

$T=$db->getTown($A);
if ($T>0){
    $num = $db->getCount2($A,$B);
    if ($num>0){
        echo "$A'镇'$B'有'$num'条数据'";
        $Data=$db->getSingleCountryInfo2($A,$B);
        $db->setCell($Begin,$num,$Data);
    }else{
        echo "你输入的村名有误，请换个村名试试";
        exit();
    }
}else{
    echo "你输入的镇名有误，换个镇名试试";
    exit();
}
?>
<a href="Print.html">重新打印</a>
</html>