<?php
namespace app\index\controller;

use think\view;
class Index extends Base
{
    public function index()
    {
//        $this->isLogin();
        $this->view->assign('title','明源后台管理');
        return $this->view->fetch();
    }
}
