<?php
namespace app\index\controller;
use app\base\controller\Base;
class Index extends Base{
    function index(){
        $menu_m = new \app\index\model\Menu();
        $menu = $menu_m->menu();
  
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
