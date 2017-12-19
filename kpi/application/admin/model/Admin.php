<?php
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\admin\model;
use think\Model;
use think\Db;

class Admin extends Model{
    /*管理员和对应角色*/
    function admin($map) {
        $res = Db::name('kpi_user_role')->alias('kur')
                ->field('u.name,kur.emp_no,kr.name as role_name,kur.is_del')
                ->join('think_user u','u.emp_no=kur.emp_no','LEFT')
                ->join('think_kpi_role kr','kr.id=kur.role_id','LEFT')
                ->where($map)
                ->select();
        return $res;
    }
    /*管理员和对应角色id*/
    function roleids($map) {
        $res = Db::name('kpi_user_role')->alias('a')
                ->field('a.emp_no,role_id,a.is_del')
                ->where($map)
                ->find();
        return $res;
    }
    /*角色列表*/    
    function role_list(){
        $res = Db::name('kpi_role')->field('id,name')->order('rank')->select();
        return $res;
    }
    /*添加管理员*/
    function add(){
        $data = input('param.');
        $user = Db::name('user')->where("emp_no",$data['emp_no'])->select();
        if(empty($user)){
            $result['status'] = 0;
            $result['msg'] = '账号不在OA系统中';
        }else{
            $kpi_user = Db::name('kpi_user_role')->where("emp_no",$data['emp_no'])->select();
            if(empty($kpi_user)){
                $res = Db::name('kpi_user_role')->insert($data);
                if($res){
                    $result['status'] = 1;
                    $result['msg'] = '添加成功'; 
                }else{
                   $result['status'] = 0;
                    $result['msg'] = '添加失败'; 
                }
            }else{
                $result['status'] = 0;
                $result['msg'] = '账号在KPI系统中已存在';
            }
        }
        return $result;
    }
    /*修改管理员*/
    function saves(){
        $data = input('param.');
        $up['role_id'] = $data['role_id'];
        $up['is_del'] = $data['is_del'];
        $res = Db::name('kpi_user_role')->where('emp_no',$data['emp_no'])->update($up);
        if($res){
            $data['status'] = 1;
            $data['msg'] = "修改成功！";
        }else{
            $data['status'] = 0;
            $data['msg'] = "修改失败！";
        }
        return $data;
    }
}
