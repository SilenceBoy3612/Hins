<?php
require "DB.php";

$db = new DB($phpexcel);

$A="东水";
$B="大坝村";
$Begin=8;
$num = $db->getCount2($A,$B);
$Data=$db->getSingleCountryInfo2($A,$B);
echo $num;

$db->setCell($Begin,$num,$Data);