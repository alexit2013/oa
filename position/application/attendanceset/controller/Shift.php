<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
班次-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendanceset\controller;
use app\index\controller\Index;
use think\Db;
use think\Request;
class Shift extends Index{
    //列表
    function index(){
        $list=Db::name('pos_schedual')->select();
        $this -> assign('list',$list);
        return view();
    }
    //添加
    function add(){
        if(Request::instance()->isAjax()){
            $data =input('param.'); 
            $data['work_start_hour']=date('H',strtotime($data['work_start_time'])); //上班时
            $data['work_start_minute']=date('i',strtotime($data['work_start_time'])); //上班分
            $data['work_end_hour']=date('H',strtotime($data['work_end_time'])); //下班时
            $data['work_end_minute']=date('i',strtotime($data['work_end_time'])); //下班分
            $data['rest_start_hour']=date('H',strtotime($data['rest_start_time'])); //开始休息时
            $data['rest_start_minute']=date('i',strtotime($data['rest_start_time'])); //开始休息分
            $data['rest_end_hour']=date('H',strtotime($data['rest_end_time'])); //结束休息时
            $data['rest_end_minute']=date('i',strtotime($data['rest_end_time'])); //结束休息分
            $data['clockin_start_hour']=date('H',strtotime($data['clockin_start_time'])); //开始打卡时
            $data['clockin_start_minute']=date('i',strtotime($data['clockin_start_time'])); //开始打卡分
            $data['clockin_end_hour']=date('H',strtotime($data['clockin_end_time'])); //结束打卡时
            $data['clockin_end_minute']=date('i',strtotime($data['clockin_end_time'])); //结束打卡分
            $data['add_time']=time();
            $res=Db::name('pos_schedual')->insert($data);
            if($res){
                $reslut['status']='1';
                $reslut['msg']="添加成功";
            }else{
                $reslut['status']='0';
                $reslut['msg']="添加失败";
            }
            return json($reslut);
        }else{
            return view();
        }
    }
 
    //修改
    function edit(){
        if(Request::instance()->isAjax()){
            $data =input('param.'); 
            $map['id']=$data['id'];
            $data['work_start_hour']=date('H',strtotime($data['work_start_time'])); //上班时
            $data['work_start_minute']=date('i',strtotime($data['work_start_time'])); //上班分
            $data['work_end_hour']=date('H',strtotime($data['work_end_time'])); //下班时
            $data['work_end_minute']=date('i',strtotime($data['work_end_time'])); //下班分
            $data['rest_start_hour']=date('H',strtotime($data['rest_start_time'])); //开始休息时
            $data['rest_start_minute']=date('i',strtotime($data['rest_start_time'])); //开始休息分
            $data['rest_end_hour']=date('H',strtotime($data['rest_end_time'])); //结束休息时
            $data['rest_end_minute']=date('i',strtotime($data['rest_end_time'])); //结束休息分
            $data['clockin_start_hour']=date('H',strtotime($data['clockin_start_time'])); //开始打卡时
            $data['clockin_start_minute']=date('i',strtotime($data['clockin_start_time'])); //开始打卡分
            $data['clockin_end_hour']=date('H',strtotime($data['clockin_end_time'])); //结束打卡时
            $data['clockin_end_minute']=date('i',strtotime($data['clockin_end_time'])); //结束打卡分
            $data['add_time']=time();
            $res=Db::name('pos_schedual')->where($map)->update($data);
            if($res){
                $reslut['status']='1';
                $reslut['msg']="修改成功";
            }else{
                $reslut['status']='0';
                $reslut['msg']="修改失败";
            }
            return json($reslut);
        }else{
            $id =input('param.id'); 
            $list=Db::name('pos_schedual')->where('id='.$id)->find();
            $this ->assign('list',$list);
            return view();
        }   
        
    }
    
    //删除
    function del(){
        if(Request::instance()->isAjax()){
            
            $id =input('param.id');
            $res=Db::name('pos_schedual')->delete($id);
            if($res){
                $reslut['status']='1';
                $reslut['msg']="删除成功";
            }else{
                $reslut['status']='0';
                $reslut['msg']="删除失败";
            }
            return json($reslut);
        }
    }
    
    
}