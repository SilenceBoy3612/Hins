<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/17
 * Time: 12:59
 */

namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;

class Grade extends Model
{
    //引用软删除方法集
    use SoftDelete;

    //设置当前默认日期时间的格式
    protected $dateFormat="Y年m月d日";

    //定义表中的删除时间字段，来记录删除时间
    protected $deleteTime = 'delete_time';

    //开启自动写入时间戳
    protected $autoWriteTimestamp=true;

    protected $createTime="create_time";

    protected $updateTime="update_time";



    //定义自动完成的属性
    protected $insert = ['status'=>1];

    //定义关联的方法
    public function teacher()
    {
        //班级表与教师表一对一关联
        return $this->hasOne("Teacher");
    }

    public function student(){
        return $this->hasMany("student");
    }
}