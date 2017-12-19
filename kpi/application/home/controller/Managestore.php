<?php
/*--------------------------------------------------------------------

kpi-门店管理
 --------------------------------------------------------------*/

namespace app\home\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Managestore extends Base{

    function index(){
        $res=Db::name('dept')->where(array('pid'=>1,'is_del'=>0))->paginate(12);
        $page = $res->render();
        $this -> assign('depts',$res);
        $this->assign('page', $page);
        return view();
    }

    function update(){
        $data = input('param.');

        $map['ID']=$data['id'];
        $about['kpi_is_del']=$data['kpi_is_del'];
        $res=Db::name('dept')->where($map)->update($about);

        if(!empty($res)){
            $relute['status']='1';
            $relute['info']='更新成功';
        }else{
            $relute['status']='0';
            $relute['info']='更新失败';
        }
        return json($relute);
    }
}