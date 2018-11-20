<?php
require dirname(__FILE__) . "/dbConfig.php";

class DB
{

    public $conn=null;

/*
 * 连接句柄
 */
public function __construct($config)
{
    $this->conn=mysqli_connect($config['host'],$config['username'],$config['password'],$config['dbname']) ;
    if ($this->conn->connect_error){
      die("连接数据库失败");
    }
    $this->conn->query("set names utf8");
    echo "连接数据库成功<br>";
}

/*
 * 获取结果 返回数组
 */
public function getResult($sql){
    $resource = $this->conn->query($sql)or die("失败原因是".$this->conn->error);
    $res=array();
    while (($row=mysqli_fetch_array($resource))!=false){
        $res[]=$row;
    }
    return $res;
}

/*
 * 获取结果 返回数值
 */
public function getResultValue($sql){
    $result = $this->conn->query($sql)or die("失败原因是".$this->conn->error);
    $num_row=mysqli_fetch_row($result);
    $res=$num_row[0];
    return $res;
}

/*
 * 统计镇的数量 返回数组
 */
public function getTownNum(){
    $sql = "select count (A) from da";
    $res=self::getResult($sql);
    return $res;
}

/*
 * 统计镇的数量 返回数值
 */
public function getTownNum2(){
    $sql = "select count (A) from da";
    $res=self::getResultValue($sql);
    return $res;
}

/*
 * 统计一个镇下面村的数量 返回村名数组
 */
public function getTownCountryNum($A){
    $sql="select count(distinct B)from da where A='{$A}'";
    $res = self::getResult($sql);
    return $res;
}

/*
 * 统计一个镇下面村的数量 返回数值
 */
public function getTownCountryNum2($A){
    $sql="select count(distinct B)from da where A='{$A}'";
    $res = self::getResultValue($sql);
    return $res;
}

/*
 * 统计村的数量 全局用
 * 不同镇有相同村会只查询到一条村
 */
public function getCountryNum(){
    $sql = "select distinct(B) from da ";
    $res=self::getResultValue($sql);
    return $res;
}

/*
 * 获取村有多少条数据 无重复村名
 */
public function getCount($B){
        $sql = "select count(*) from da where  B='{$B}'";
        $res=self::getResultValue($sql);
        return $res;
    }

/*
 * 获取村有多少条数据 有重复村名用该方法
 */
public function getCount2($A,$B){
    $sql = "select count(*) from da where A='{$A}'and B='{$B}'";
//    $res=mysqli_query($this->conn,$sql);
//    $data1=$this->conn->query($sql);
    $res=self::getResult($sql);
    return $res;
}

/*
 * 根据村名查询一条村的数据 有重复的村名需要传入镇名
 */
public function getSingleCountryInfo2($A,$B){
    $sql = "select * from da where A='{$A}'and B='{$B}'";
    $res=self::getResult($sql);
    return $res;
}

/*
 * 根据村名查询一条村的数据 不判断村名重复情况
 */
public function getSingleCountryInfo($B){
    $sql = "select * from da where  B='{$B}'";
    $res=self::getResult($sql);
    return $res;
    }

public function getNum($Field){
    $sql ="select count('{$Field}') from da";
    $result=$this->conn->query($sql);
//    $num_row = $result->num_rows
    $num_row=mysqli_fetch_row($result);
    $res=$num_row[0];
    return $res;
}


}