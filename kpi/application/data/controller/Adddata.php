<?php
/*--------------------------------------------------------------------
广汇KPI报表--返利计算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\data\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Adddata extends Base{
    //添加
    public function index(){
            $result = Db::name('kpi_pri')->where('ischart=1')->select();
            foreach ($result as $k => $v) {
                    $datalist[$k] = $v ;
            }
            $userinfo = session('user');
            $data_pris = Db::name('kpi_user_role')->alias('ur')->field('ur.emp_no,pri_ids')->join('think_kpi_role r','r.id=ur.role_id','LEFT')->where('ur.emp_no',$userinfo['emp_no'])->find();
            $where = array();
            if($data_pris['pri_ids'] != '*'){
               $where['id'] = ['IN',$data_pris['pri_ids']];
            }
            $where['isadd'] = 1;
            $pri = Db::name('kpi_pri')->where($where)->select();
            foreach ($datalist  as $key=>$value) {
                foreach ($pri as $k => $v) {
                    if($value['id']==$v['pid']){
                        $datalist[$key]['sec'][$k]['name'] = $v['name'];
                        $datalist[$key]['sec'][$k]['url'] = Url($v['module_name'].'/'.$v['controller_name'].'/'.$v['action_name']);
                    }
                }
            }
            $this->assign('datalist',$datalist);
            return view();
        }
    //装饰数据添加    
    public function decorateadd(){
        return view();
    }
    //销售数据添加
    public function salesadd(){
        return view();
    }
    //售后数据添加
    public function hdadd(){
        return view();
    }
    //市场数据添加
    public function marketadd(){
        return view();
    }
    //客服数据添加
    public function customserviceadd(){
        return view();
    }
    //金融数据添加
    public function financeadd(){
        return view();
    }
    //行政数据添加
    public function administrationadd(){
        return view();
    }
    //财务数据添加
    public function faadd(){
        return view();
    }
    //保险数据添加
    public function insuranceadd(){
        return view();
    }
} 
