<?php
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\admin\controller;
use app\base\controller\Base;
use think\Db;
class Role extends Base{
    /*列表页*/
   function index(){
       $map = array();
       if(request()->isPost()){
           $name = input('param.name');
            $map['name'] = ['like','%'.$name.'%'];
            $this->assign('name',$name);
       }
       $map['id'] = ['<>',1];
       $list = Db::name('kpi_role')->where($map)->select();
       $this->assign('data_list',$list);
       return view();
   }
    /*添加页面数据查询*/
    public function add() {
        if(request()->isAjax()){
            $data = input('param.');
            $res = Db::name('kpi_role')->insert($data);
            if($res){
                $result['status'] = 1;
                $result['message'] = "添加成功！";
            }else{
                $result['status'] = 0;
                $result['message'] = "添加失败1";
            }
            return json($result);
        }
        $map = array();
        $privilege = new \app\admin\model\Privilege();
        $priData = $privilege->priTree($map);
        $this->assign('data_list', $priData);
        return view();
    }
    /*修改页面数据查询*/
    public function save() {
        if(request()->isAjax()){
            $data = input('param.');
            $res = Db::name('kpi_role')->update($data);
            if($res){
                $result['status'] = 1;
                $result['message'] = "更新成功！";
            }else{
                $result['status'] = 0;
                $result['message'] = "更新失败！";
            }
            return json($result);
        }
        $id = input('param.id');
        $role = Db::name('kpi_role')->find($id);
        $map = array();
        $privilege = new \app\admin\model\Privilege();
        $priData = $privilege->priTree($map);
        $this->assign([
            'data_list'=> $priData,
            'role'=>$role
        ]);
        return view();
    }
    /*查看数据*/
    public function details() {
        $id = input('param.id');
        $role = Db::name('kpi_role')->find($id);
        $map = array();
        $privilege = new \app\admin\model\Privilege();
        $priData = $privilege->priTree($map);
        $this->assign([
            'data_list'=> $priData,
            'role'=>$role
        ]);
        return view();
    }
    /*删除*/
    function del(){
        if(request()->isAjax()){
            $id = input('param.id');
            Db::name('kpi_role')->delete($id);
            $result['message'] = 'ok';
            return json($result);
        }
    }
}
