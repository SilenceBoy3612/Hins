<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/30
 * Time: 0:23
 */

namespace app\index\controller;
use app\index\controller\Base;
use think\Model;
use think\Request;
use app\index\model\User as UserModel;
use think\Session;


class User extends Base
{

    /*
     * 渲染登陆模板
     */
    public function login(){
        $this->alreadyLogin();
        $this->view->assign('title','用户登陆');
        $this->view->assign('keywords','明源');
        $this->view->assign('desc','后台管理');

        $this->view->assign('copyRight','明源项目管理');
        return $this->view->fetch();
    }

    /*
     * 登陆验证
     */
    public function checkLogin(Request $request){
        //初始化返回参数
        $status=0;
        $result='验证失败';
        $data=$request->param();

        $rule = [
            'name|账号'=>'require',
            'password|密码'=>'require',
            'verify|验证码'=>'require|captcha',
        ];

        //自定义验证规则
        $msg=[
            'name'=>['require'=>'账号不能为空'],
            'password'=>['require'=>'密码不能为空'],
            'verify'=>[
                'require'=>'验证码不能为空',
                'captcha'=>'验证码错误'],
        ];

        //验证数据 $this->validate($data, $rule, $msg)
        $result = $this->validate($data,$rule,$msg);

        if ($result===true){

           //构造查询条件
            $map =[
              'name'=>$data['name'],
              'password'=>md5($data['password']),
            ];


           $user = UserModel::get($map);
//           var_dump($user);
            $user = UserModel::get($map);

            if ($user==null){
                return "该用户不存在";
            }else{
                $status = 1;
                $result = '验证通过，点击[确定]进入';
                Session::set('user_id',$user->id);
                Session::set('user_info',$user->getData());//获取用户所以信息
                $user->setInc('login_count');
            }
        }

        return ['status'=>$status,'message'=>$result,'data'=>$data];


    }

    /*
     * 退出登陆
     */
    public function logout(){
        //退出前先更新登录时间字段,下次登录时就知道上次登录时间
        UserModel::update(['login_time'=>date('Y-m-d H:i:s')],['id'=> Session::get('user_id')]);
//        UserModel::update(['login_time'=>date()],['id'=> Session::get('user_id')]);
        Session::delete('user_id');
        Session::set('user_info');
        $this->success('注销登陆，正在返回','user/login');
    }

    /*
     * 管理员列表
     */
    public function adminList(){
        $this->view->assign('title','员工列表');
        $this->view->assign('keywords','后台管理');
        $this->view->assign('desc','员工管理');

        $this->view->count=UserModel::count();

        //判断当前用户是不是admin用户
        //先通过session获取用户登录名
        $userName = Session::get('user_info.name');
        if($userName=='hins'){
            $list = UserModel::all();//hins可以查看所有数据
        }else{
            //为了共用列表模板,使用all()其实这里用get()符合逻辑
            //非hins用户只能查看自己的信息，数据要经过模型获取器处理
            $list = UserModel::all(['name'=>$userName]);
        }
        $this->view->assign('list',$list);
        //渲染管理员列表模板
        return $this->view->fetch('admin_list');

    }

    /*
     * 管理员状态变更
     */
    public function setStatus(Request $request){
        $user_id = $request->param('id');
        $result = UserModel::get($user_id);
        if ($result->getData('status')==1){
            UserModel::update(['status'=>0],['id'=>$user_id]);
        }else{
            UserModel::update(['status'=>1],['id'=>$user_id]);
        }

    }

    /*
     * 渲染编辑管理员界面
     */
    public function adminEdit(Request $request){
        $user_id = $request->param('id');
        $result = UserModel::get($user_id);
        $this->view->assign('title','编辑管理员信息');
        $this->view->assign('keywords','qq.com');
        $this->view->assign('title','明源');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('admin_edit');
    }

    /*
     * 更新数据操作
     */
    public function editUser(Request $request){
        //获取表单返回的数据
//        $data = $request -> param();
        $param = $request -> param();

        //去掉表单中为空的数据,即没有修改的内容
        foreach ($param as $key => $value ){
            if (!empty($value)){
                $data[$key] = $value;
            }
        }

        $condition = ['id'=>$data['id']] ;
        $result = UserModel::update($data, $condition);

        //如果是hins用户,更新当前session中用户信息user_info中的角色role,供页面调用
        if (Session::get('user_info.name') == 'hins') {
            Session::set('user_info.role', $data['role']);
        }


        if (true == $result) {
            return ['status'=>1, 'message'=>'更新成功'];
        } else {
            return ['status'=>0, 'message'=>'更新失败,请检查'];
        }
    }

    /*
     * 删除操作
     */
    public function deleteUser(Request $request){
        $user_id = $request->param('id');
        UserModel::update(['is_delete'=>1],['id'=>$user_id]);
        UserModel::destroy($user_id,true);
    }

    /*
     * 恢复删除操作
     */
    public function unDelete(){
        UserModel::update(['delete_time'=>null],['is_delete'=>1]);
    }

    /*
     * 添加操作界面
     */
    public function adminAdd(){
        $this->view->assign('title','添加管理员');
        $this->view->assign('keywords','qq.com');
        $this->view->assign('desc','明源后台管理');
        return $this->view->fetch('admin_add');
    }

    /*
     * 检测用户名是否可用
     */
    public function checkUserName(Request $request){
        $userName = trim($request->param('name'));
        $status = 1;
        $message = '用户名可用';
        if (UserModel::get(['name'=>$userName])){
            $status = 0;
            $message = '用户名重复，请重新输入';
        }
        return ['status'=>$status,'message'=>$message];
    }

    /*
     * 检测用户邮箱是否可用
     */
    public function checkUserEmail(Request $request){
        $userEmail = trim($request->param('email'));
        $status = 1;
        $message = '邮箱可用';
        if (UserModel::get(['eamil'=>$userEmail])){
            $status = 0;
            $message = '邮箱重复,请重新输入';
        }
        return ['status'=>$status, $message=>$message];
    }

    /*
     * 添加操作
     */
    public function addUser(Request $request)
    {
        $data = $request -> param();
        $status = 1;
        $message = '添加成功';

        $rule = [
            'name|用户名' => "require|min:3|max:10",
            'password|密码' => "require|min:3|max:10",
            'email|邮箱' => 'require|email'
        ];

        $result = $this -> validate($data, $rule);

        if ($result === true) {
            $UserModel = new UserModel();
//            $user = $UserModel->data($request->param);
            $user= UserModel::create($request->param());
//            $user= UserModel::create($data);

            if ($user === null) {
                $status = 0;
                $message = '添加失败~~';
            }
        }
        return ['status'=>$status, 'message'=>$message];
    }
}