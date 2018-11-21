<?php
require dirname(__FILE__) . "/dbConfig.php";
include "./vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//查询数据库，返回数据
class DB
{

    public $conn = null;

    /*
     * 连接句柄
     */
    public function __construct($config)
    {
        $this->conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname']);
        if ($this->conn->connect_error) {
            die("连接数据库失败");
        }
        $this->conn->query("set names utf8");
        echo "连接数据库成功<br>";
    }

    /*
     * 获取结果 返回数组
     */
    public function getResult($sql)
    {
        $resource = $this->conn->query($sql) or die("失败原因是" . $this->conn->error);
        $res = array();
        while (($row = mysqli_fetch_array($resource)) != false) {
            $res[] = $row;
        }
        return $res;
    }

    /*
     * 获取结果 返回数值
     */
    public function getResultValue($sql)
    {
        $result = $this->conn->query($sql) or die("失败原因是" . $this->conn->error);
        $num_row = mysqli_fetch_row($result);
        $res = $num_row[0];
        return $res;
    }

    /*
     * 统计镇的数量 返回数组
     */
    public function getTownInfo()
    {
        $sql = "select distinct A from da";
        $res = self::getResult($sql);
        return $res;
    }

    /*
     * 统计镇的数量 返回数值
     */
    public function getTownNum()
    {
        $sql = "select count(distinct A) from da";
        $res = self::getResultValue($sql);
        return $res;
    }

    /*
     * 统计一个镇下面村的数量 传入村名
     * 返回村名数组
     */
    public function getTownCountryInfo($CountryName)
    {
        $sql = "select distinct B from da where A='{$CountryName}'";
        $res = self::getResult($sql);
        return $res;
    }

    /*
     * 统计一个镇下面村的数量 传入村名
     *  返回村数量值
     */
    public function getTownCountryNum($TownName)
    {
        $sql = "select count(distinct B) from da where A='{$TownName}'";
        $res = self::getResultValue($sql);
        return $res;
    }

    /*
     * 统计镇下面村下面的信息
     * 返回信息内容
     */
    public function getCountryInfo($TownName,$CountryName){
        $sql="select * from da where A='{$TownName}' and  B='{$CountryName}'";
//        $res=self::getResult($sql);
        $res=$this->conn->query($sql);
        return $res;
    }

    /*
     * 统计镇下面村下面的信息
     * 返回信息内容
     */
    public function getCountryNum($TownName,$CountryName){
        $sql="select COUNT(B)  from da where A='{$TownName}'and B='{$CountryName}'";
        $res=self::getResultValue($sql);
//        $res=$this->conn->query($sql);
        return $res;
    }

    /*
     * 统计村的数量 全局用 返回村名数组
     * 不同镇有相同村会只查询到一条村
     */
    public function getAllCountryInfo()
    {
        $sql = "select distinct B from da ";
        $res = self::getResult($sql);
        return $res;
    }

    /*
     * 统计村的数量 全局用 返回数值
     * 不同镇有相同村会只计为一条村
     */
    public function getAllCountryNum()
    {
        $sql = "select count(distinct B) from da ";
        $res = self::getResultValue($sql);
        return $res;
    }

    /*
     * 获取村有多少条数据 无重复村名
     */
    public function getCount($CountryName)
    {
        $sql = "select count(*) from da where  B='{$CountryName}'";
        $res = self::getResultValue($sql);
        return $res;
    }

    /*
     * 获取村有多少条数据 有重复村名用该方法
     */
    public function getCount2($TownName, $CountryName)
    {
        $sql = "select count(*) from da where A='{$TownName}'and B='{$CountryName}'";
//    $res=mysqli_query($this->conn,$sql);
//    $data1=$this->conn->query($sql);
        $res = self::getResultValue($sql);
        return $res;
    }

    /*
     * 根据村名查询一条村的数据 不判断村名重复情况
     */
    public function getSingleCountryInfo($CountryName)
    {
        $sql = "select * from da where  B='{$CountryName}'";
        $res = self::getResult($sql);
        return $res;
    }

    /*
     * 根据村名查询一条村的数据 有重复的村名需要传入镇名
     */
    public function getSingleCountryInfo2($TownName, $CountryName)
    {
        $sql = "select * from da where A='{$TownName}'and B='{$CountryName}'";
        $res = self::getResult($sql);
        return $res;
    }

    public function getNum($Field)
    {
        $sql = "select count('{$Field}') from da";
        $result = $this->conn->query($sql);
//    $num_row = $result->num_rows
        $num_row = mysqli_fetch_row($result);
        $res = $num_row[0];
        return $res;
    }

    /*
     * 导出excel表格
     */
    public function setCell($Star,$InfoCount,$Data){
        //导入模板
        $inputFileName = './模板.xlsx';

        //判断文件类型
        $fileType = IOFactory::identify($inputFileName);

        //获取文件读取对象
        $objReader = IOFactory::createReader($fileType);

        //加载模板
        $spreadsheet=$objReader->load($inputFileName);

        //获取活动的sheet
        $objExcel = $spreadsheet->getActiveSheet();

        $Begin=$Star;
        $End = $Begin+$InfoCount-1;
        for($i=1;$Begin<=$End;) {
            foreach ($Data as $key=>$val){
                $TownName=$val['A'];
                $CountryName=$val['B'];
                $objExcel->setCellValue("L2", $val['A'])
                    ->setCellValue('A'.$Begin,$i)
                    ->setCellValue("B" . $Begin, $val['B'])
                    ->setCellValue("C" . $Begin, $val['C'])
                    ->setCellValue("D" . $Begin, $val['D'])
                    ->setCellValue("H" . $Begin, $val['E'])
                    ->setCellValue("I" . $Begin, $val['F'])
                    ->setCellValue("J" . $Begin, $val['G'])
                    ->setCellValue("K" . $Begin, $val['H'])
                    ->setCellValue("L" . $Begin, $val['I'])
                    ->setCellValue("M" . $Begin, $val['J'])
                    ->setCellValue("N" . $Begin, $val['K'])
                    ->setCellValue("O" . $Begin, $val['L'])
                    ->setCellValue("P" . $Begin, $val['M'])
                    ->setCellValue("C20", $val['N'])
                    ->setCellValue("F20", $val['O'])
                    ->setCellValue("L20", $val['P'])
                    ->setCellValue("O20", $val['Q']);
                $i++;
                $Begin++;
            }
        }
        $write = new Xlsx($spreadsheet);
        $write->save("$TownName$CountryName.xlsx");
    }
}