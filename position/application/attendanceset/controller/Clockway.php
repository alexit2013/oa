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
class Clockway extends Base{

    function index(){
        $waylist=Db::name('pos_way')->select();
        $this ->assign('list',$waylist);
        return view();
    }
    //添加
    function add(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $data['add_time']=time();
            $res=Db::name('pos_way')->insert($data);
            if(!empty($res)){
                $reslut['status']='1';
                $reslut['msg']='操作成功';
            }else{
                $reslut['status']='0';
                $reslut['msg']='操作失败';
            }
            return json($reslut);
        }else{
            return view();
        }
    }
    //修改
    function edit(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $map['id']=$data['id'];
            $res=Db::name('pos_way')->where($map)->update($data);
            if($res){
                $reslut['status']='1';
                $reslut['msg']='操作成功';
            }else{
                $reslut['status']='0';
                $reslut['msg']='操作失败';
            } 
            return json($reslut);
        }else{
            $id=input('param.id');
            $way=Db::name('pos_way')->where('id='.$id)->find();
            $this->assign('list',$way);
            return view();
        }  
    }
    //删除
    function del(){
        if(Request::instance()->isAjax()){
            $id =input('param.id');
            $res=Db::name('pos_way')->delete($id);
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
