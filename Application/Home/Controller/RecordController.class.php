<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.daimayouwentibielaizhaowoqwy
 */

namespace Home\Controller;
use Think\View;

class RecordController {

    function index(){

        $emp_no = I('param.emp_no');
        $map['emp_no'] = $emp_no;
        $year = date('Y');
        $month = (int)date('m');
        $day = (int)date('d');
        $map['month'] = $month;
        $map['year'] = $year;
        $list = $this->status_list($emp_no, $year, $month, $day);

        $data_list = json_encode($list['status_arr']);  //考勤状态列表
        $times_list = json_encode($list['data_count']); //考勤合计
        //当天信息
        $data['a.year'] = $year;
        $data['a.month'] = $month;
        $data['a.day'] = $day;
        $data['a.emp_no'] = $emp_no;

        $sigle_in = M('pos_form a')
                ->join('think_pos_position_'.$year.' n ON a.posid_start = n.id','LEFT')
                ->where($data)
                ->field('a.posid_start,n.address as in_address')
                ->find();

        $sigle_out = M('pos_form a')
                ->join('think_pos_position_'.$year.' n ON a.posid_end = n.id','LEFT')
                ->where($data)
                ->field('a.sign_in,a.sign_out,a.emp_no,a.year,a.month,a.day,a.posid_end,n.address as out_address')
                ->find();
        $sum_sign = array_merge($sigle_in,$sigle_out);


        //模板输出
        $view = new View;
        $view->assign([
            'data_list'=>$data_list,    //考勤记录
            'times_list'=>$times_list,
            'sum_sign'=>$sum_sign,
            'emp_no'=>$emp_no
                ]);
        $view->display();

    }

    /*考勤状态数据处理*/
    private function status_list($emp_no,$year,$month,$day){
        $map['month'] = $month;
        $map['emp_no'] = $emp_no;
        $map['year'] = $year;
        $form = M('pos_form')->where($map)->select();
        $scheduling = M("pos_scheduling")->where($map)->select();
        $status_arr = array();
        $form_arr = array();
        $data_count['late_times'] = 0;
        $data_count['leave_early_times'] = 0;
        $data_count['business_times'] = 0;
        $data_count['adjust_times'] = 0;
        $data_count['out_times'] = 0;
        $data_count['over_times'] = 0;
        $data_count['leave_times'] = 0;
        foreach($form as $v){
            $form_arr[$v['day']]=$v;
        }
        foreach ($scheduling as $vs) {
            if($vs['day'] < $day){
                if($vs['schedual_id']>0) {       //有排班
                        if(empty($form_arr[$vs['day']])){   //考勤记录不存在
                            $status_arr[$vs['day']]['mon']['type'] = 3; //漏刷
                            $status_arr[$vs['day']]['aft']['type'] = 3; //漏刷
                        }else{
                            if(empty($form_arr[$vs['day']]['sign_in'])){
                                $status_arr[$vs['day']]['mon']['type'] = 3; //漏刷
                            }else{
                                $status_arr[$vs['day']]['mon']['type'] = 0; //正常
                            }
                            if(empty($form_arr[$vs['day']]['sign_out'])){
                                $status_arr[$vs['day']]['aft']['type'] = 3; //漏刷
                            }else{
                                $status_arr[$vs['day']]['aft']['type'] = 0; //正常
                            }
                            if($form_arr[$vs['day']]['late_time'] > 0){    //迟到
                                $status_arr[$vs['day']]['mon']['type'] = 1;
                                $data_count['late_times'] += 1;
                            }
                            if($form_arr[$vs['day']]['leave_early_time'] > 0){    //早退
                                $status_arr[$vs['day']]['aft']['type'] = 2;
                                $data_count['leave_early_times'] += 1;
                            }

                            if($form_arr[$vs['day']]['business_time'] > 0){    //出差
                                if(empty($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 4;
                                }else if(!empty($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 4;
                                }
                                if(empty($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 4;
                                }else if(!empty($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 4;
                                }
                                $data_count['business_times'] += 1;
                            }
                            if($form_arr[$vs['day']]['out_time'] > 0){    //外出
                                if(empty($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 6;
                                 }else if(!empty($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 6;
                                 }
                                if(empty($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 6;
                                }else if(!empty ($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 6;
                                }
                                $data_count['out_times'] += 1;
                            }
                            if($form_arr[$vs['day']]['over_time'] > 0){    //加班
                                if(empty($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 3; //漏刷
                                }else{
                                    $status_arr[$vs['day']]['mon']['type'] = 7;
                                }
                                if(empty($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 3; //漏刷
                                }else{
                                    $status_arr[$vs['day']]['aft']['type'] = 7;
                                }
                                $data_count['over_times'] += 1;
                            }
                            if(($form_arr[$vs['day']]['marriage_time'] > 0)||
                                    ($form_arr[$vs['day']]['sick_time'] > 0)||
                                    ($form_arr[$vs['day']]['maternity_time'] > 0)||
                                    ($form_arr[$vs['day']]['death_time'] > 0)||
                                    ($form_arr[$vs['day']]['thing_time'] > 0)||
                                    ($form_arr[$vs['day']]['other_time'] > 0)){    //请假
                                if(empty($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 8;
                                }else if(!empty ($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['mon']['type'] = 8;
                                }
                                if(empty($form_arr[$vs['day']]['sign_out'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 8;
                                }else if(!empty($form_arr[$vs['day']]['sign_in'])){
                                    $status_arr[$vs['day']]['aft']['type'] = 8;
                                }
                                $data_count['leave_times'] += 1;
                            }
                    }
                }
                if($form_arr[$vs['day']]['adjust_time'] > 0){ //调休
                    $status_arr[$vs['day']]['mon']['type'] = 5;
                    $status_arr[$vs['day']]['aft']['type'] = 5;
                    $data_count['adjust_times'] += 1;
                }
            }
        }
        $result['status_arr'] = $status_arr;
        $result['data_count'] = $data_count;
        return $result;
    }

    //每天打卡记录
    public function Other_day(){

        if (IS_AJAX) {
            $other = I('post.');
            $where['a.emp_no'] = $other['emp_no'];
            $where['a.day'] = substr($other['time'],-2);
            $where['a.year'] = substr($other['time'],0,4);
            $where['a.month'] = substr($other['time'],4,-2);

            $sigle_in = M('pos_form a')
                ->join('think_pos_position_'.date('Y').' n ON a.posid_start = n.id','LEFT')
                ->where($where)

                ->field('a.posid_start,n.address as in_address,a.out_times,a.adjust_times,a.business_times')->find();

            $sigle_out = M('pos_form a')
                ->join('think_pos_position_'.date('Y').' n ON a.posid_end = n.id','LEFT')
                ->where($where)
                ->field('a.*,n.address as out_address')
                ->find();
            $sum_signs = array_merge($sigle_in,$sigle_out);

            $sum_sign = json_encode($sum_signs);
            echo $sum_sign;
        }

    }

    //月份打卡记录
    public function Other_month(){

        if (IS_AJAX) {
            $months = I('post.time');
            $emp_no = I('post.emp_no');
            $map['emp_no'] = $emp_no;
            $year = date('Y');
            $month = (int)$months;

            $time = $year.'-'.$month.'-1';
            if($month == (int)date('m')){
                $days = (int)date('d');
            }else{
                $days = $this->get_day($time)+1;
            }

            $map['month'] = $month;
            $map['year'] = $year;
            $list = $this->status_list($emp_no, $year, $month, $days);
            $lists['data_list'] = $list['status_arr'];
            $lists['times_list'] = $list['data_count'];
            $this->ajaxReturn($lists);
        }
    }
    /**
    * 获取当月天数
    * @param $date
    * @param $rtype 1天数 2具体日期数组
    * @return
    */
    function get_day( $date ,$rtype = '1'){
        $tem = explode('-' , $date);    //切割日期 得到年份和月份
        $year = $tem['0'];
        $month = $tem['1'];
        if( in_array($month , array( 1 , 3 , 5 , 7 , 8 , 01 , 03 , 05 , 07 , 08 , 10 , 12))){
          // $text = $year.'年的'.$month.'月有31天';
          $text = '31';
        }elseif( $month == 2 ){
          if ( $year%400 == 0 || ($year%4 == 0 && $year%100 !== 0) )  {   //判断是否是闰年
            // $text = $year.'年的'.$month.'月有29天';
            $text = '29';
          }
          else{
            // $text = $year.'年的'.$month.'月有28天';
            $text = '28';
          }
        }
        else{
          // $text = $year.'年的'.$month.'月有30天';
          $text = '30';
        }
        if ($rtype == '2') {
          for ($i = 1; $i <= $text ; $i ++ ) {
              if($i<=9){
                  $r[] = $year."-".$month."-0".$i;
              }else{
                  $r[] = $year."-".$month."-".$i;
              }

          }
        } else {
          $r = $text;
        }
        return $r;
    }
    protected function ajaxReturn($data,$json_option=0) {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,$json_option);
        exit;
    }
}


