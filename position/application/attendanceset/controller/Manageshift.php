<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
班次-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendanceset\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;
class Manageshift extends Base{
  public function index(){
    if(Request::instance()->isAjax()){
            $data= input('param.');
            $store_id=$data['store_id'];
            Db::startTrans();
            $res=Db::name('pos_com_schedual')->where('com_id='.$store_id)->column('com_id'); //本店是否有管理相关班次
            if(!empty($res)){
                $dels=Db::name('pos_com_schedual')->delete($res); //删除本店面管理班次
                if(empty($dels)){
                    Db::rollback();
                }
            }
            $shiftIDs=implode(',', $data['shift_ids']);
            $about['com_id']=$store_id;
            $about['schedual_id']=$shiftIDs;
            $com_schedual=Db::name('pos_com_schedual')->insert($about);
                if(empty($com_schedual)){
                    Db::rollback();
                    $result['msg']='操作失败';
                    $result['status']='0';
                    return json($result);
                }else{
                    Db::commit();
                }
                $result['msg']='操作成功';
                $result['status']='1';
                return json($result);
        }else{
            $shift=Db::name('pos_schedual')->field('id,shift_name,short,work_start_time,work_end_time')->select();
            $store=get_comlist();  //所属门店
            $this -> assign('stores',$store);
            $this -> assign('shift',$shift);
            return view();
        }
        
        
    }

    public  function com_schedual(){
        $store_id= input('param.store_id');
        $res=Db::name('pos_com_schedual')->where('com_id='.$store_id)->find();
        $check=explode(',', $res['schedual_id']);
        return json($check);
    }
}