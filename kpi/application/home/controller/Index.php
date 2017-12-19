<?php
/*--------------------------------------------------------------------
 54校园兼职平台 - 让兼职变得更加快捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\home\controller;
use think\Controller;
class Index extends Controller{
    function index(){
        $menu = session('menu');
        if(empty($menu)){
            $url = request()->domain();
            header("Location:".$url);
            exit;
        }
        $this->assign([
            'menu'=>$menu
        ]);
        return view();
    }
    /*欢迎页面*/
    function welcome(){
        $this->assign('title','欢迎页面');
        return view();
    }
}
