<?php

/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
 基础类

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\base\controller;
use think\Controller;
use think\Db;
use think\Session;
class Base extends Controller{
    function __construct() {
        parent::__construct();
        if(!Session::get('user')){
            $this->error('必须先登录！','https://'. request()->domain());
        }
        $request = \think\Request::instance();
        // 欢迎页面和公共方法页可以访问
        if(($request->module() == 'index' && $request->controller() == 'Index') || $request->module()=='func'){
            return TRUE;
        }
        // 验证权限
        $privilege = Session::get('privilege');
            $module = $request->module();
        if($privilege != '*' && !in_array($module.'/'. lcfirst($request->controller()).'/'. $request->action(), $privilege)){
            $this->error('无权访问!');
        }
    }

    //品牌菜单
    public function carbrand(){
        
        if(request()->isAjax()){
            
            $store_id = input('param.store_id');
            
            return Db::name('kpi_store_carbrand')->alias('sc')->field('c.id,c.carbrand_name')
                    ->join('think_kpi_carbrand c','sc.carbrand_id=c.id','LEFT')
                    ->where('sc.store_id',$store_id)->select();
        }
    }


    //车系菜单
    public function carseries(){
        
        if(request()->isAjax()){
            
            $data = input('param.carbrand_id');
            return Db::name('kpi_carseries')->field('id,carseries_name')->where('carbrand_id',$data)->select();
        }
    }
    
    //车型菜单
    public function carsize(){
        if(request()->isAjax()){
            
            $data = input('param.carseries_id');
            return Db::name('kpi_carsize')->field('id,carsize_name')->where('carseries_id',$data)->select();
        }
    }
}
