<?php
/**
 * Created by PhpStorm.
 * User: Hins
 * Date: 2018/11/17
 * Time: 15:08
 */

namespace app\index\controller;
use app\index\model\Grade as GradeModel;
use app\index\model\Teacher;
use think\Request;


class Grade extends Base
{
    //班级列表
    public function gradeList(){
        //获取记录数量
        $grade = GradeModel::all();

        //获取记录数量
        $count = GradeModel::count();

        foreach ($grade as $value){
            $data=[
              'id'=>$value->id,
              'name'=>$value->name,
              'length'=>$value->length,
              'price'=>$value->price,
              'status'=>$value->status,
              'create_time'=>$value-> create_time,
              'teacher'=>isset($value->teacher()->name)?$value->teacher()->name:'<span style="color:red;">未分配</span>',
            ];
            //每次关联查询的结果，保存到数组$gradeList中
            $gradeList[] = $data;
        }
        $this->view->assign('gradeList',$gradeList);
        $this->view->assign('count',$count);
        return $this->view->fetch('grade_list');

    }

    //班级状态变更
    public function setStatus(Request $request){

    }

    //渲染班级编辑界面
    public function gradeEdit(Request $request){
    $grade_id = $request->param('id');
    $result = GradeModel::get($grade_id);
    $result->teacher= $result->techer->name;

    $this->view->assign('title','编辑班级');
    $this->view->assign('keywords','qq.com');
    $this->view->assign('desc','明源后台管理');

    $this->view->assign('grade_info',$result);
    return $this->view->fetch('grade_edit');
    }

    //班级更新
    public function doEdit(Request $request){
        $data = $request->except('teacher');
        //设置更新条件
        $condition = ['id'=>$data['id']];

        //更新当前记录
        $result = GradeModel::update($data,$condition);

        //设置返回数据
        $status =0;
        $message = '更新失败，请检查';

        //检测更新结果，将结果返回grade_edit模板中的ajax提交回调处理
        if(true==$result){
            $status=1;
            $message='更新成功';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //渲染班级添加界面
    public function gradeAdd(){
        $this->view->assign('title','编辑班级');
        $this->view->assign('keywords','qq.com');
        $this->view->assign('desc','明源后台管理');

        return $this->view->fetch('grade_add');
    }

    //添加班级
    public function doAdd(Request $request){
    //从提交的表单中获取数据
        $data = $request->param();
        //更新当前记录
        $result=GradeModel::create($data);

        //设置返回数据
        $status = 0;
        $message='添加失败,请检查';
        if (true==$result){
        $status=1;
        $message='添加成功';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //软删除操作
    public function deleteGrade(Request $request){}

    //恢复删除操作
    public function unDelete(){
        GradeModel::update(['delete_time'=>null],['is_delete'=>1]);
    }
}