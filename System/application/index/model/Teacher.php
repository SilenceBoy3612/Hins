<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/17
 * Time: 14:58
 */

namespace app\index\model;
use traits\model\SoftDelete;
use think\Model;

class Teacher extends Model
{
    use SoftDelete;
    protected $dateFormat="Y年m月d日";

    protected $autoWriteTimestamp = true;

    protected $createTime = "create_time";

    protected $updateTime = "update_time";

    protected $deleteTime = "delete_time";

    protected $type = [
        'hiredate'=>'timestamp'
    ];

    protected $insert = ['status'=>1];

    //设置与grade表的反关联
    public function grade(){
        return $this->belongsTo('Grade');
    }

    public function getDegreeAttr($value){
        $degree = [
          1=>'专科',
          2=>'本科',
          3=>'研究生',
        ];
        return $degree[$value];
    }
}