<?php
namespace app\index\controller;
use think\Request;
use app\index\model\User as UserModel;
use think\Session;
header("Content-Type: text/html; charset=UTF-8");

class User extends Base
{
    public function login()
    {

        $this->alreadyLogin();//防止重复登陆
      //登陆界面
        return $this->view->fetch();
    }

    //登陆验证 $this->validate($data,$rule,$msg)
    public function checkLogin(Request $request)
    {
        //初始化返回的参数
        $status = 0;
        $result = '';
        $data = $request->param();
        //创建验证规则
            $rule=[
                'name|用户名'=>'require',
                'password|密码'=>'require',
                'verify|验证码'=>'require|captcha',
            ];

            //自定义验证失败的提示信息
        $msg = [
            'name.require'=>'用户名不能为空,请检查',
            'password.require'=>'密码不能为空,请检查',
            'verify.require'=>'验证码不能为空,请检查',
            'verify.captcha'=>'验证码错误',
        ];
//            进行简单验证
        $result=$this->validate($data,$rule,$msg);

       //如果验证通过则执行
        if($result===true){

            //构造查询条件
            $map = [
                'name'=>$data['name'],
                'password'=>md5($data['password']),
            ];
            //查询用户信息
            $user=UserModel::get($map);
            if ($user==null){
                $status = 1;
                $result='没有查询到此用户';
            }else {
                $status = 1;
                $result = '验证通过，点击[确定]进入';
                Session::set('user_name',$user->name,'think');//用户名
                Session::set('user_info',$user->getData(),'think');

                //更新用户登陆次数：自增长1
//                $user->setInc('login_count');

            }
        }

        return ['status'=>$status,'message'=>$result,'data'=>$data];

    }

    //安全退出
    public function Logout(){

        //注销session
        Session::delete('user_name');
        Session::delete('user_info');
        $this->success('注销登陆，正在返回','user/login');
    }

    //管理员列表
    public function adminList(){
        $this->view->assign('title','管理员列表');
        $this->view->assign('keywords','明源后台管理');
        $this->view->assign('desc','教学案列');

        $this->view->count=UserModel::count();

        //判断当前是不是admin用户
        //通过session获取到用户签名
        $userName = Session::get('user_info.name');
        if ($userName=='admin'){
            $list = UserModel::all();//admin用户可以查看所以记录，要经过模型获取处理
        }else{
            //为了公用列表模板，使用all(),其实这里要用get()符合逻辑
            //非admin用户只能查看自己的信息，要经过模型获取器处理
            $list=UserModel::all(['name'=>$userName]);
        }
        $this->view->assign('list',$list);
        //喧嚷管理器模板
        return $this->view->fetch('admin_list');
    }

    //管理员状态变更
    public function setStatus(Request $request){
        $user_id = $request->param('id');
        $result = UserModel::get($user_id);
        if($result->getData('status')==1){
            UserModel::update(['status'=>0],['id'=>$user_id]);
        }else{
            UserModel::update(['status'=>1],['id'=>$user_id]);
        }
    }

    //渲染编辑管理界面
    public function adminEdit(Request $request){
        $user_id=$request->param('id');
        $result=UserModel::get($user_id);
        $this->view->assign('title','编辑管理员信息');
        $this->view->assign('keywords','qq.com');
        $this->view->assign('title','明源管理后台');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('admin_edit');
    }

    //更新数据操作
    public function editUser(Request $request){}

    //删除操作
    public function deleteUser(Request $request){
        $user_id = $request->param('id');
        UserModel::update(['is_delete'=>1],['id'=>$user_id]);
        UserModel::destroy($user_id);
    }

    //恢复删除操作
    public function unDelete(){
        UserModel::update(['delete_time'=>null,['is_delete']]);
    }

    //添加操作界面
    public function adminAdd(Request $request){
        $this->view->assign('title','添加管理员');
        $this->view->assign('keywords','my.cn');
        $this->view->assign('desc','明源后台管理');
        return $this->fetch('admin_add');
    }

    //检测用户名是否可用
    public function checkUserName(Request $request){
        $userName = trim($request->param('name'));
        $status = 1;
        $message = '用户名可用';
        if (UserModel::get(['name'=>$userName])){
            //如果在表中查询到改用户名
            $status=0;
            $message='用户名已被注册，请换个名字';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //检测用户邮箱是否可用
    public function checkUserEmail(Request $request){
        $userEmail = trim($request->param('email'));
        $status = 1;
        $message = '邮箱可用';
        if (UserModel::get(['email'=>$userEmail])){
            //查询表中找到的邮箱，修改返回值
            $status=0;
            $message='邮箱重复，请换个邮箱';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //添加操作
    public function addUser(Request $request){
        $data=$request->param();
        $status=1;
        $message='添加成功';

        $rule=[
            'name|用户名'=>'require|min:3|max:10',
            'password|密码'=>'require|min:3|max:10',
            'email|邮箱'=>'require|email',
        ];
        $result = $this->validate($data,$rule);
        if ($result===true){
            $user=UserModel::create($request->param());
            if ($user===null){
                $status=0;
                $message='添加失败';
            }
        }
        return ['status'=>$status,'message'=>$message];
    }
}
