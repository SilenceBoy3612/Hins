<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/29
 * Time: 23:43
 */

namespace app\index\controller;
use think\Controller;
use think\Session;

class Base extends Controller
{
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        define('USER_ID',Session::get('user_id')?
        Session::get('user_id'):null);
    }

//    protected function isLogin()
//    {
//        $user_id=Session::get('user_id','think');
//        if (empty($user_id)){
//            $this->error('用户未登陆，无权访问',url('user/login'));
//        }
//    }
//    //防止用户重复登陆 user/login
//    protected function alreadyLogin(){
//        $user_id=Session::get('user_id','think');
//        if (!empty( $user_id)){
//            $this->error('用户已经登陆，请勿重复登陆',url('index/index'));
//        }
//    }

    //判断用户是否登陆,放在系统后台入口前面: index/index
    protected function isLogin()
    {
        if (is_null(USER_ID)) {
            $this -> error('用户未登陆,无权访问',url('user/login'));
        }
    }

    //防止用户重复登陆,放在登陆操作前面:user/login
    protected function alreadyLogin(){
        if (USER_ID) {
            $this -> error('用户已经登陆,请勿重复登陆',url('index/index'));
        }
    }
}