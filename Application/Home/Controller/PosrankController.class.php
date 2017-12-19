<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\View;

class PosrankController{
    
    function index(){
        
        if(IS_GET){
            
            $map['day'] = date("d");
            $map['month'] = date("m");
            $map['year'] = date("Y");
            $map['emp_no'] = array('eq', $_GET['emp_no']);
            $map['sign_in'] = array('exp','is not null');
            $pos_list = M('pos_form')->where($map)->field('*')->find();
        }
        $y = date("Y");
        $where['pf.day'] = date("d");
        $where['pf.year'] = $y;
        $where['pf.month'] = date("m");
        $where['pf.posid_start'] = ['NEQ','0'];
        $post_m = M('pos_form')->alias('pf')
                ->join("think_pos_position_{$y} as pp ON pp.id=pf.posid_start",'LEFT')
                ->field('pf.emp_no,pf.user_name,pf.dept_name,pf.sign_in')
                ->where($where)
                ->order('pp.time')
                ->limit(99)
                ->select();
        $view = new View;
        $view->assign(['data_list'=>$post_m]);
        $view->assign(['user_list'=>$pos_list]);
        $view->display();
    }
   
}
