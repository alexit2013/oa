<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
打卡方式-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendanceset\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;
class Schedulingset extends Base{

    function index(){
        $map['is_scheduling'] = 1;
        $userinfo = session('user');
        if($userinfo['id'] != 1){
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
            if(empty($com_data)){
                $map['u.com_id']=$userinfo['com_id'];
            }else{
                $map['u.com_id'] = ['IN',$com_data['com_ids']];
            }   
          
        }
        $data_list = Db::name('user')->alias('u')->field('u.id,u.name,u.emp_no,d.name as dept_name,p.name as position_name')
                ->join('think_position p','p.id=u.position_id','LEFT')
                ->join('think_dept d','d.id=u.dept_id','LEFT')
                ->where($map)->select();
        $this->assign('data_list',$data_list);
         return view();
    }

    function edit(){
        if(request()->isPost()){
            $data = input('param.');
            $emp_no = $data['emp_no'];
            foreach ($data['name'] as $v) {
                Db::name('pos_scheduling')->update($v);
            }
            $userinfo = Db::name('user')->where('emp_no',$emp_no)->find();
            $userinfo['is_scheduling'] = 0;
            $res = Db::name('user')->update($userinfo);
            if($res){
                $result['msg'] = "更新成功！";
                $result['stauts'] = 1;        
            }else{
                $result['msg'] = "更新失败！";
                $result['stauts'] = 0;        
            }
            return json($result);
        }
        $emp_no = input('param.emp_no');
        $map['year'] = date('Y');
        $map['emp_no']=$emp_no;
        $map['month'] = date('n');
        $data_list = Db::name('pos_scheduling')->where($map)->select();
        $week = ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
        $this->assign([
            'emp_no'=>$emp_no,
            'data_list'=>$data_list,
            'week'=>$week
                ]);
        return view();
    }
    function schedual(){
        $schedual_id = input('param.schedual_id');
        $id = input('param.id');
        $list = Db::name('pos_schedual')->select();
        $this->assign(['list'=>$list,
            'schedual_id'=>$schedual_id,
            'id'=>$id
            ]);
        return view();
    }
 }
