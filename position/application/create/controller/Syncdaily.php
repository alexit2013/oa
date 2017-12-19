<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
更新(异常)-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\create\controller;
use think\Controller;
use think\Db;
class Syncdaily extends Controller{

    function start(){
        $year = date('Y');
        $m =  (int)date('m');
        $d = (int)date('d');
        Db::execute("delete from think_pos_abnormal where year=".$year." and month=".$m." and day=".$d);
        set_time_limit(0);
        $map_arr['a.year'] = $year;
        $map_arr['a.month'] = $m;
        $map_arr['a.schedual_id'] = ['neq',0];
        $map_arr['a.day'] = $d;
        $map_arr['b.is_del'] = 0;
        $Datascheduling=Db::name('pos_scheduling')->alias('a')
                ->field('a.*,b.com_id')
                ->join('think_user b','a.emp_no=b.emp_no','LEFT')
                ->where($map_arr)
                ->group('a.emp_no,a.month,a.day')
                ->select();
         //获取排班数据
        $abnormal = $this->check_form($Datascheduling, $year, $m, $d);
        $i = 0;
        $j = 0;
        foreach($abnormal as $v){  //拆分为二维数组
            $abnormal_sec[$i][$j]=$v;
            $j++;
            if($j == 3000){
                $j = 0;
                $i++;
            }
        }
        foreach ($abnormal_sec as $v) {
            $res =Db::name('pos_abnormal')->insertAll($v);
            dump($res);
        }
         
       
        $this->ycql("late_time");
        $this->ycql("late_times");
        $this->ycql("leave_early_time");
        $this->ycql("leave_early_times");
        $this->qckg();
        echo 'ok';
       
    }
    
    /*日报表数据核对*/
    function check_form($scheduling,$year,$month,$day){
        $map['year'] = $year;
        $map['month'] = $month;
//        $map['day'] = ['<=',$day];
        $map['day'] = $day;
        $form = Db::name('pos_form')->where($map)->select();
        $form_list = array();
        $schedual_list = Db::name('pos_schedual')->field('id,shift_name,work_start_time,work_end_time')->select();
        foreach ($schedual_list as $v){
            $schedual[$v['id']] = $v;   //班次
        }
        foreach ($form as $v) {
            $emp_no = $v['emp_no'];
            $day = $v['day'];
            $form_list[$emp_no][$day] = $v;
        }
        $i=0;
        foreach ($scheduling as $val) {
            if(empty($form_list[$val['emp_no']][$val['day']])){
                $absent =array();
                $absent['absent_times']=1;
                $absent['absent_time']=8;
                $absent['salary_time'] = 8;
                $absent['emp_no']=$val['emp_no'];
                $absent['user_name']=$val['user_name'];
                $absent['dept_name']=$val['dept_name']; 
                $absent['position']=$val['position'];
                $absent['year']=$val['year']; 
                $absent['month']=$val['month'];
                $absent['day']=$val['day'];  
                $absent['schedule'] = $val['schedual_name'];
                $absent['com_id']=$val['com_id'];
                $absent['type'] = '工作日';
                $absent['on_work_time']=$schedual[$val['schedual_id']]['work_start_time']; 
                $absent['out_work_time']=$schedual[$val['schedual_id']]['work_end_time'];
                
                Db::name('pos_form')->insert($absent);
                $abnormal[$i] = $this->ab_arr($val,$schedual);
                $i++;
                $abnormal[$i] = $this->ab_arr($val,$schedual,2);
                $i++;
            }else{
                if($form_list[$val['emp_no']][$val['day']]['adjust_times']<=0 &&        //调休次数
                   $form_list[$val['emp_no']][$val['day']]['out_times']<=0 &&   //外出次数
                    $form_list[$val['emp_no']][$val['day']]['marriage_time']<=0 &&  //婚假 -
                    $form_list[$val['emp_no']][$val['day']]['leave_times']<=0 &&    //请假次数
                    $form_list[$val['emp_no']][$val['day']]['sick_time']<=0 &&  //病假 -
                    $form_list[$val['emp_no']][$val['day']]['maternity_time']<=0 && //产假 -
                    $form_list[$val['emp_no']][$val['day']]['death_time']<=0 && //丧假 -
                    $form_list[$val['emp_no']][$val['day']]['thing_time']<=0 && //事假 -
                    $form_list[$val['emp_no']][$val['day']]['business_time']<=0 &&  //出差 -
                    $form_list[$val['emp_no']][$val['day']]['other_time']<=0){  //其他假期 -
                
                    if(empty($form_list[$val['emp_no']][$val['day']]['sign_in'])){  //签到数据不存在
                        $abnormal[$i] = $this->ab_arr($val,$schedual,1,$form_list[$val['emp_no']][$val['day']]);                        
                        $i++;
                    $this->absent($form_list[$val['emp_no']][$val['day']]);
                    }
                    if(empty($form_list[$val['emp_no']][$val['day']]['sign_out'])){ //签退数据不存在
                        $abnormal[$i] = $this->ab_arr($val,$schedual,2,$form_list[$val['emp_no']][$val['day']]);                        
                        $i++;
                    }
                    $this->absent($form_list[$val['emp_no']][$val['day']]);
                }
            }            
        }
        return $abnormal;
    }
    /*
     * 异常数组
     * @param $scheduling 排班
     * @param $schedual 班次
     * @param $form 日报数据
     * @param $type 类型 1未签到 2未签退
     */ 
    private function ab_arr($scheduling,$schedual,$type=1,$form=array()){
        $adata['emp_no']=$scheduling['emp_no'];
        $adata['user_name']=$scheduling['user_name'];
        $adata['dept_id']=$scheduling['dept_id'];
        $adata['dept_name']=$scheduling['dept_name']; 
        $adata['position']=$scheduling['position'];
        $adata['year']=$scheduling['year']; 
        $adata['month']=$scheduling['month']; 
        $adata['schedual'] = $scheduling['schedual_name'];
        $adata['com_id']=$scheduling['com_id'];
        $adata['day']=$scheduling['day'];  
        $adata['punch_time'] = "";
        if($type == 1){
            $adata['status']='未签到';
            if(!empty($form)){
                $adata['punch_time']='-'.$form['sign_out'];
            }
        }
        if($type == 2){
            $adata['status']='未签退';
            if(!empty($form)){
                $adata['punch_time']=$form['sign_in'].'-';
            }
        }
        $adata['time']=$schedual[$scheduling['schedual_id']]['work_start_time'].'-'.$schedual[$scheduling['schedual_id']]['work_end_time'];
        return $adata;
    }
    private function absent($data){
        $data['absent_time'] = 8;
        $data['absent_times'] = 1;
        Db::name('pos_form')->update($data);
    }

    //schedulID获取相关信息
    function GetschedulNameByschedulID($schedulid){
        if(empty($schedulid)){
            return false;
        }
        return Db::name('pos_schedual')->field('id,shift_name,work_start_time,work_end_time')->where('id',$schedulid)->find();
    }

    /**
        * 求两个日期之间相差的天数
        * (针对1970年1月1日之后，求之前可以采用泰勒公式)
        * @param string $day1
        * @param string $day2
        * @return number
        */
       function diffBetweenTwoDays ($day1, $day2){
         $second1 = strtotime($day1);
         $second2 = strtotime($day2);

         if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
         }
         return ($second1 - $second2) / 86400;
       }
       
       function ycql($data){
           $sql = "UPDATE think_pos_form set ".$data."=0
                WHERE (
		adjust_time > 0
		OR over_time > 0
		OR out_time > 0
		OR sick_time > 0
		OR marriage_time > 0
		OR maternity_time > 0
		OR death_time > 0
		OR thing_time > 0
		OR other_time > 0
		OR business_time > 0
            ) AND ".$data." > 0";
           Db::execute($sql);
       }
       function qckg(){
           $sql = "update think_pos_form set absent_times = 0 WHERE LENGTH(sign_in)>0 and LENGTH(sign_out)>0 AND absent_times > 0";
           Db::execute($sql);
           $sql2 = "update think_pos_form set absent_time = 0 WHERE LENGTH(sign_in)>0 and LENGTH(sign_out)>0 AND absent_time > 0";
           Db::execute($sql2);
           $sql3 = "delete from think_pos_form where length(emp_no)=0 or com_id=0";
           Db::execute($sql3);
           $sql4 = "update think_pos_form set absent_time=8  where (LENGTH(sign_in)=0 or LENGTH(sign_out)=0) and over_times>0";
            Db::execute($sql4);
            $sql5 = "update think_pos_form set absent_times=1  where (LENGTH(sign_in)=0 or LENGTH(sign_out)=0) and over_times>0";
            Db::execute($sql5);
       }

}
