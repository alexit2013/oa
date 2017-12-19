<?php
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\admin\controller;
use app\base\controller\Base;
use think\Db;
class Privilege extends Base{
    /*数据列表*/
    function index() {
        $map = array();
        if(request()->isPost()){
            $name = input('param.name');
            $map['name'] = ['like','%'.$name.'%'];
            $this->assign('name',$name);
            $data_list = Db::name('kpi_pri')->field('*,pid as level')->where($map)->select();
            $this->assign('data_list',$data_list);
            return view();
        }
        $privilege = new \app\admin\model\Privilege();
        $priData = $privilege->priTree($map);
        $this->assign('data_list', $priData);
        return view();
    }
    /*添加页面数据查询*/
    function add() {
        if(request()->isAjax()){
            $data = input('param.');
            $res = Db::name('kpi_pri')->insert($data);
            if($res){
                $result['status'] = 1;
                $result['message'] = "添加成功！";
            }else{
                $result['status'] = 0;
                $result['message'] = "添加失败！";
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
    function save() {
        if(request()->isAjax()){
            $datas = input('param.');
            $res = Db::name('kpi_pri')->update($datas);
            if($res){
                $result['status'] = 1;
                $result['message'] = "修改成功！";
            }else{
                $result['status'] = 0;
                $result['msg'] = "修改失败！";
            }
            return json($result);
        }
        $id = input('param.id');
        $data = Db::name('kpi_pri')->find($id);
        $map = array();
        $privilege = new \app\admin\model\Privilege();
        $priData = $privilege->priTree($map);
        $this->assign([
            'data_list'=> $priData,
            'data'=>$data
        ]);
        return view();
    }
    /*删除*/
    function del(){
        if(request()->isAjax()){
            $id = input('param.id');
            Db::name('kpi_pri')->delete($id);
            $result['message'] = 'ok';
            return json($result);
        }
    }
}
