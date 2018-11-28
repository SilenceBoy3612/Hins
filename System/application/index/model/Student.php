<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/17
 * Time: 13:18
 */

namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;

class Student extends Model
{
    use SoftDelete;
    protected $dateFormat="Y年m月d日";

    protected $autoWriteTimestamp = true;

    protected $createTime = "create_time";

    protected $updateTime = "update_time";

    protected $deleteTime = "delete_time";

    protected $type = [
        'start_time'=>'timestamp'
    ];

    public function getSexAttr($value){
        $sex = [
          0=>'女',
          1=>'男',
        ];
    }


    //定义与学生表student的一对多关联
    public function grade(){
        return $this->belongsTo('grade');
    }
}