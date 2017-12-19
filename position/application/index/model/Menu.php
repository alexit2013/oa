<?php

namespace app\index\model;
use think\Model;
use think\Db;

class Menu extends Model{
    function menu(){
        $map = array();
        if(session('user.emp_no') !== 'admin'){
            $map['is_admin'] = 0;
        }
        $menu = array();
        $pri = Db::name('pos_pri')->where($map)->select();
         foreach ($pri as $k => $v){   
            if($v['pid'] == 0){   // 挑出顶级权限菜单
                $menu[$k] = $v;
            }
        }
        foreach ($menu as $k => $v){
            foreach($pri as $k1 => $v1){
                if($v['id'] == $v1['pid']){
                    $menu[$k]['sec'][$k1] = $v1;
                }
            }
        }
        return $menu;
    }
}
