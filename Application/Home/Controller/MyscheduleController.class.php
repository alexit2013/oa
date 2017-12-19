<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\View;

class MyscheduleController{

    function index(){

        //当前月
        $month = date("m");
        $map['emp_no'] = array('eq', $_GET['emp_no']);
        $map['month'] = array('eq',$month);
        $post_m = M("pos_scheduling a")
                ->join('think_pos_schedual b ON a.schedual_id = b.id','LEFT')
                ->where($map)
                ->field('a.id,a.emp_no,a.user_name,a.dept_name,a.year,a.month,a.day,b.shift_name,b.short,b.work_start_time,b.work_end_time')
                ->select();

        $res = json_encode($post_m);
//        $month_list = $this->Other_month();
        $view = new View;
        $view->assign(['data_list'=>$res]);
//        $view->assign(['month_list'=>$month_list]);
        $view->display();
    }

    public function Other_month(){
        //其他月份
        if (IS_AJAX) {
            $other = I('param.');

            $where['month'] = $other['month'];
            $where['emp_no'] = $other['emp_no'];
            $other_m = M("pos_scheduling a")
                ->join('think_pos_schedual b ON a.schedual_id = b.id','LEFT')
                ->where($where)
                ->field('a.id,a.emp_no,a.user_name,a.dept_name,a.year,a.month,a.day,b.shift_name,b.short,b.work_start_time,b.work_end_time')
                ->select();
        $months = json_encode($other_m);
        echo $months;
        return $months;
        }

    }

}

