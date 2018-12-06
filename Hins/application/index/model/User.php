<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/12/1
 * Time: 8:58
 */

namespace app\index\model;

use traits\model\SoftDelete;
use think\Model;

class User extends Model
{
    /*
 * 导入软删除方法集
 */
    use SoftDelete;
    /*
     * 设置软删除字段
     * 只有该字段位null,该字段才会显示出来
     */
    protected $deleteTime = 'delete_time';

    //保存自动完成列表
    protected $auto = [
      'delete_time'=>null,
      'is_delete'=>1,//允许删除 0：禁止删除
    ];
    //更新自动完成列表
    protected $insert = [
      'login_time'=>null,//新增时登陆时间应该为null
      'login_count'=>0,  //新增时登陆次数为0
    ];

    //更新自动完成列表
    protected $update = [];

    //是否需要自动写入时间戳,如果设置为字符串，表示时间字段类型
    protected $autoWriteTimestamp = true;

    //创建时间字段
    protected $createTime = 'create_time';

    //更新时间字段
    protected $updateTime = 'update_time';

    //时间字段取出后的默认格式
    protected $dateFormat = 'Y年m月d日';

    //数据表中角色字段：role返回值处理
    public function getRoleAttr($value){
        $role = [
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
        return md5($value);
    }

    //登陆时间获取器
    public function getLoginTimeAttr($value){
        return date('Y/m/d H:i', $value);
    }
}