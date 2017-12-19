<?php
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\admin\controller;
use app\base\controller\Base;
use think\Db;
class Admin extends Base{
    /*数据列表*/
    function index() {
        $map = array();
        if(request()->isPost()){
            $name = input('param.name');
            $map['u.name|u.emp_no'] = ['like','%'.$name.'%'];
            $this->assign('name',$name);
        }
        $model = new \app\admin\model\Admin();
        $data_list = $model->admin($map);
        $this->assign('data_list', $data_list);
        return view();
    }
    /*添加页面数据查询*/
    function add() {
        if(request()->isAjax()){
            $result = $this->_add();
            return json($result);
        }
        $role_m = new \app\admin\model\Admin();
        $priData = $role_m->role_list();
        $this->assign('data_list', $priData);
        return view();
    }
    /*添加数据*/
    protected function _add() {
        $admin_m = new \app\admin\model\Admin();
        $res = $admin_m->add();
        return $res;
    }
    /*添加页面数据查询*/
    function save() {
        if(request()->isAjax()){
            $result = $this->_save();
            return json($result);
        }
        $admin_m = new \app\admin\model\Admin();
        $priData = $admin_m->role_list();
        $map['a.emp_no'] = input('param.emp_no');
        $admin = $admin_m->roleids($map);
        $this->assign([
            'data_list'=>$priData,
            'admin'=>$admin,
        ]);
        return view();
    }
    /*修改数据*/
    protected function _save() {
        $admin_m = new \app\admin\model\Admin();
        $res = $admin_m->saves();
        return $res;
    }
    function del(){
        $emp_no = input('param.emp_no');
        $res = Db::name('kpi_user_role')->where('emp_no',$emp_no)->delete();
        if($res){
            $data['status'] = 1;
            $data['msg'] = "删除成功！";
        }else{
            $data['status'] = 0;
            $data['msg'] = "删除失败！";
        }
        return $data;
    }
    /*管理员管理门店*/
    function control(){
        $emp_no = input('param.emp_no');
        $userinfo=Db::name('user')->where('emp_no',$emp_no)->find();
        $map['is_del'] = 0;
        $map['kpi_is_del']=0;
        $map['pid'] = 1;
        $map['id']= ['<>',2];
        $kpi_dept=Db::name('dept')->where($map)->select();
        $this->assign([
            'kpi_dept'=>$kpi_dept,
            'userinfo'=>$userinfo,
        ]);
        return view();
    }
    /*管理员管理门店(选中)*/
    function control_store(){
        $emp_no = input('param.emp_no');
        $res=Db::name('kpi_com')->where('emp_no',$emp_no)->find();
        if(!empty($res)){
            $map['is_del'] = 0;
            $map['kpi_is_del']=0;
            $map['pid'] = 1;
            $map['id']= ['<>',2];
            $map['id'] = ['IN',$res['com_ids']];
            $depts=Db::name('dept')->where($map)->select();
            return json($depts);
        }
    }
    /*管理员管理门店(提交)*/
    function control_save(){
        $data=input('param.');
        $kpi_dept=$data['kpi_dept'];
        $about['com_ids']=implode(',', $kpi_dept);
        $map['emp_no']=$data['emp_no'];
        $res=Db::name('kpi_com')->where($map)->find();
        if(empty($res)){//添加
            $about['emp_no']=$data['emp_no'];
            $insert=Db::name('kpi_com')->insert($about);
            if(!empty($insert)){
                $recoure['msg']='添加成功!';
                $recoure['status']='1';
            }else{
                $recoure['msg']='添加失败!';
                $recoure['status']='0';
            }
        }else{ //修改
            $up=Db::name('kpi_com')->where($map)->update($about);
            if(!empty($up)){
                $recoure['msg']='更新成功!';
                $recoure['status']='1';
            }else{
                $recoure['msg']='更新失败!';
                $recoure['status']='0';
            }
        }

        return json($recoure);
    }
}
