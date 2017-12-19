<?php 
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷
 oa考勤 -休息日
 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\attendanceset\model;
use think\Model;
use think\Db;
class Closed extends Model{
    //列表
    public function playlist(){
        $playres=Db::name('pos_playday')->select();
        foreach ($playres as $key => $value) {
                $h_list=Db::name('pos_holiday')->where('playday_id='.$value['id'])->select();
                $playres[$key]['holiday']=$h_list;
                $f_list=Db::name('pos_fillworkday')->where('playday_id='.$value['id'])->select();
                $playres[$key]['fillworkday']=$f_list;
        }
        return $playres;

    }

    //通过playday表ID获取关联表id
    public function GetHolidayIdByplayID($play_id){
        if(empty($play_id)){
            return false;
        }
        return Db::name('pos_holiday')->where('playday_id='.$play_id)->column("id");
    }

    //通过playday表ID获取关联表id
    public function GetFillWorkIdByplayID($play_id){
        if(empty($play_id)){
            return false;
        }
        return Db::name('pos_fillworkday')->where('playday_id='.$play_id)->column("id");
    }

       //通过playday表ID获取关联表信息
    public function GetHolidayInfoByplayID($play_id){
        if(empty($play_id)){
            return false;
        }
        return Db::name('pos_holiday')->where('playday_id='.$play_id)->select();
    }

    //通过playday表ID获取关联表信息
    public function GetFillWorkInfoByplayID($play_id){
        if(empty($play_id)){
            return false;
        }
        return Db::name('pos_fillworkday')->where('playday_id='.$play_id)->select();
    }

    //通过playday表ID获取单条信息
    public function GetPlayInfoById($id){
        if(empty($id)){
            return false;
        }
        return Db::name('pos_playday')->where('id='.$id)->find();
    }
}