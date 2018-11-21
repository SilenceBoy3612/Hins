<?php
require "DB.php";
set_time_limit(0);
//实例化DB类
$db = new DB($phpexcel);;

//获取镇的数量
$TownNum = $db->getTownNum();
echo $TownNum."<br>";

//获取镇的名字数组
$TownName = $db->getTownInfo();
echo "<pre>";
//var_dump($TownName);

//遍历镇名，取出每个镇
for ($i=1;$i<=$TownNum;) {
    foreach ($TownName as $t_k => $t_v) {
        echo $t_v['A'];

        //通过镇获取镇下面村的数量
        $TownCountryNum = $db->getTownCountryNum($t_v['A']);
        echo "<pre>";
        echo $TownCountryNum."<br>";

        //获取镇下面村名的信息 根据镇名查询到所有村的村名
        $TownCountryInfo = $db->getTownCountryInfo($t_v['A']);

//            var_dump($TownCountryInfo);
        //遍历村名数组遍历村名
        foreach ($TownCountryInfo as $key => $val) {//$val存放每一条村名
            echo "<pre>";
//               var_dump($val['B']) ;
            echo $val['B'];
            $CountryDate = $db->getCountryInfo($t_v['A'], $val['B']);

            var_dump($CountryDate);
//                根据村名查询村的信息情况
            for ($j = 1; $j <= $TownCountryNum; ) {
                foreach ($CountryDate as $c_d=>$c_v){

                    //打印起始位置
                    $Star = 8;
                    //一条村的所有信息
//                    $CountryDate = $db->getCountryInfo($t_v['A'],$val['B']);

                    //一条村的信息数量
                    $InfoCount = $db->getCountryNum($t_v['A'], $val['B']);
                    echo $InfoCount;
                    $db->setCell($Star, $InfoCount, $CountryDate);
                    $j++;

                }
            }
            $i++;
        }
    }
}
