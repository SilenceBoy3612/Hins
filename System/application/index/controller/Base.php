<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/9
 * Time: 18:57
 */

namespace app\index\controller;
use think\Session;

use think\Controller;


class Base extends Controller
{
    protected function  _initialize()
{
    parent::_initialize();

   }
   //判断用户是否登陆，放在后台的入口 index/index
    protected function isLogin()
    {
        $user_name=Session::get('user_name','think');
        if (empty($user_name)){
          $this->error('用户未登陆，无权访问',url('user/login'));
        }
    }
    //防止用户重复登陆 user/login
    protected function alreadyLogin(){
        $user_name=Session::get('user_name','think');
        if (!empty( $user_name)){
            $this->error('用户已经登陆，请勿重复登陆',url('index/index'));
        }
    }
}