<?php
namespace app\index\controller;

use app\index\controller\Bases;

class Index extends Base
{
    public function index()
    {
        $this->isLogin();//判断用户是否登陆
        $this->assign('title','明源勘测');
        return $this->view->fetch();
    }
}
