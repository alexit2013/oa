<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
新增员工车生成排班-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\create\controller;
use think\Controller;
use think\Db;
class Userscheduling extends Controller{

    public function index(){
        $this->scheduling();
        echo 'ok';
    }
    
    private function scheduling(){
        $data = input('param.');
        $dept_id  = $data['dept_id'];
        $com_id = $data['com_id'];
        $rule_list = Db::name('pos_rule')->field('id,range')->order('priority')->select();
        $rule_id = "";
        foreach ($rule_list as $v){
            $applied=explode('|',$v['range']); 
            foreach ($applied as $vo) {
                if (strpos($vo, "dept") !== false){
                    $temp = explode("_", $vo);
                    $deptids = $temp[1];
                    $arr = explode(',',$deptids); 
                    foreach ($arr as $val) {
                        if(($val == $dept_id) || ($val == $com_id)){
                            $rule_id = $v['id'];
                        }
                    }  
                }
            }
        }
        if(!empty($rule_id)){
            $rule = Db::name('pos_rule')->find($rule_id);
            $nextMd=date('Y-m-d',strtotime(date('Y-m-01') . '+1 month')); 
            $Md=date('Y-m-01');
            $next_month_days = $this ->get_day($nextMd,'2');   //下个月的天数列表
            $month_days = $this ->get_day($Md,'2');   //本月的天数列表
            $user_scheduling = $this->day_data($month_days, $rule, $data);
            $user_scheduling_next = $this->day_data($next_month_days, $rule, $data);
            Db::name('pos_scheduling')->insertAll($user_scheduling);
            Db::name('pos_scheduling')->insertAll($user_scheduling_next);
        }
    }
    /*
     * 排班
     * $days 日期列表
     * $rule 考勤规则
     * $data 人员信息
     */
    function day_data($days,$rule,$data){
        $user = Db::name('user')->where('emp_no',$data['emp_no'])->find();
        $dept = Db::name('dept')->find($data['dept_id']);
        $short=Db::name('pos_schedual')->field('shift_name,short')->where('id='.$rule['schedual_ids'])->find();//班次 
        $position = Db::name('position')->find($user['position_id']);
        $playday = Db::name('pos_playday')->where('id='.$rule['playday_id'])->find();   //休息日
        $holiday = Db::name('pos_holiday')->field('day,name')->where('playday_id='.$rule['playday_id'])->select();  //节假日
        $playday['holiday'] = array_column($holiday, 'day');
        $fillworkday = Db::name('pos_holiday')->field('day,name')->where('playday_id='.$rule['playday_id'])->select();  //补班日
        $playday['fillworkday'] = array_column($fillworkday,'day');
        $week_arr = explode(',',$playday['daily']);
        $user_scheduling = array();
        foreach ($days as $day) {
            $user_scheduling[$day]['emp_no'] = $user['emp_no'];
            $user_scheduling[$day]['user_name'] = $user['name'];
            $user_scheduling[$day]['dept_id'] = $user['dept_id'];
            $user_scheduling[$day]['dept_name'] = $dept['NAME'];
            $user_scheduling[$day]['position'] = $position['name'];
            $user_scheduling[$day]['way_ids'] = $rule['way_ids'];
            $user_scheduling[$day]['playday_id'] = $rule['playday_id'];
            $times = strtotime($day);   //转化时间戳
            $Y = date('Y',$times);
            $m = date('m',$times);
            $d = date('d',$times);
            $w = date('w',$times);
            $user_scheduling[$day]['year'] = $Y;
            $user_scheduling[$day]['month'] = $m;
            $user_scheduling[$day]['day'] = $d;
            if(in_array($day, $playday['fillworkday'])){   //补班日是否存在
                $user_scheduling[$day]['schedual_id'] = $rule['schedual_ids'];
                $user_scheduling[$day]['schedual_name'] = $short['shift_name'];
            }else{
                if((!in_array($day, $playday['holiday'])) && (!in_array($w,$week_arr))){   //既不在休息日也不在日常休息日中
                    $user_scheduling[$day]['schedual_id'] = $rule['schedual_ids'];
                    $user_scheduling[$day]['schedual_name'] = $short['shift_name'];
                }else{
                    $user_scheduling[$day]['schedual_id'] = "";
                    $user_scheduling[$day]['schedual_name'] = "";
                }
            }
        }
        return $user_scheduling;
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
       
}