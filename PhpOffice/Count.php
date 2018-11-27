<?php
require 'DB.php';
/*
 * 统计每个镇下面每个村有多少条数据
 */
$db  = new DB($phpexcel);

//获取镇的数量
$TownNum = $db->getTownNum();
echo $TownNum."<br>";

//获取镇的名字数组
$TownName = $db->getTownInfo();

for ($i=1;$i<=$TownNum;){
    foreach ($TownName as $t_k => $t_v){
        //通过镇获取镇下面村的数量
        $TownCountryNum = $db->getTownCountryNum($t_v['A']);
        echo "<pre>";
        echo $TownCountryNum."<br>";
        //获取镇下面村名的信息 根据镇名查询到所有村的村名
        $TownCountryInfo = $db->getTownCountryInfo($t_v['A']);

        foreach ($TownCountryInfo as $key => $val) {
            $Num = $db->getCount2($t_v['A'], $val['B']);
            echo $t_v['A'].$val['B'].$Num."<br>";
        }
        $i++;
    }
}