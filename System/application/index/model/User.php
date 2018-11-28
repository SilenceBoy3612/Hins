<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/12
 * Time: 17:22
 */

namespace app\index\model;
use traits\model\SoftDelete;
use think\Model;
class user extends  Model
{
    //导入软删除方法集
    use SoftDelete;
    //设置软删除字段
    //只有改字段为NULL，该字段才会显示出来
    protected $deleteTime = 'delete_time';

    //保存自动完成列表
    protected $auto=[
        'delete_time'=>null,
        'is_delete'=>1,
    ];

    //新增自动完成列表
    protected $insert=[
       'login_time'=>null,
        'login_count'=>0,
    ];

    //更新自动完成列表
    protected $update=[];

    //是否需要自动写入时间戳，如果设置为字符串，则表示时间字段的类型
    protected $autoWriteTimestamp=true;

    //创建时间字段
    protected $createTime='create_time';

    //更新时间字段
    protected $updateTime='update_time';

    //时间字段取出后的默认时间格式
    protected $dateFormat='Y年m月d日';

    //数据表中角色字段:Role返回值处理
    public function getRoleAttr($value){
        $role=[
            0=>'管理员',
            1=>'超级管理员',

        ];
        return $role[$value];
    }

    //状态字段：status返回值处理
    public function getStatusAttr($value){
        $status = [
            0=>'已停用',
            1=>'已启用',
        ];
        return $status[$value];
    }

    //密码修改器
    public function setPasswordAttr($value){

    }
}