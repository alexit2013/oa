<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
生成排班-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\create\controller;
use think\Controller;
use think\Db;
class Arranges extends Controller{

    public function index(){
        $data=$this -> start();
        $this->sechuling($data); //考勤排班
       echo "ok";
        
    }
    //获取视图格式
    private function start() {
        $rule=Db::name('pos_rule')->order('priority')->select(); //所有考勤规则
        $comid_list = Db::name('dept')->field('id')->where('PID',1)->select();
        $comid_arr =array_column($comid_list,'id');//所有公司id
        $com_arr = array(); 
        $dept_arr = array();
        $com_empres=array();    //公司应用范围人员
        $dept_empres=array();   //部门应用范围人员
        $sin_emp=array();   //应用范围人员
        foreach ($rule as $key => $val) {
            
            $applied=explode('|',$val['range']); 
            // dump($applied);
            foreach ($applied as $value) {
                //公司或部门
                if (strpos("$value", "dept") !== false){
                        $temp = explode("_", $value);
                        $deptids = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',$deptids);
                        $deptres=Db::name('dept')->field('id,pid,name')->where($map)->select();
                        
                }
                // dump($deptres);
                if(!empty($deptres)){
                        foreach ($deptres as $ke => $vd) {
                            if($vd['pid']==1){   //应用范围内公司
                                $com_arr[] = $vd['id'];
                              
                            }
                             if(in_array($vd['pid'],$comid_arr)){    //判断是否为部门
                                 $dept_arr[]=$vd['id'];
                             }
                        }
                        if(!empty($com_arr)){
                            $com_empres=Db::name('user')->field('id,emp_no,name,dept_id,position_id')->where(array('is_del'=>0))->where('com_id','in',$com_arr)->select();
                            $com_arr = array();
                        }

                        if(!empty($dept_arr)){
                            $dept_empres=Db::name('user')->field('id,emp_no,name,dept_id,position_id')->where(array('is_del'=>0))->where('dept_id','in',$dept_arr)->select();
                            $dept_arr = array();
                        }
                }
                //应用范围内人员
                
                if (strpos("$value", "emp") !== false){
                        $temp = explode("_", $value);
                        $emps = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$emps");
                        $sin_emp=Db::name('user')->field('id,emp_no,name,dept_id,position_id')->where($map)->select();
                        // dump($res);
                }
                //获取全部范围内的人员
                $data_emp=array_merge($com_empres,$dept_empres,$sin_emp);
                $com_empres = array();
                $dept_empres = array();
                $sin_emp = array();
                $rule[$key]['data_uniemp']=$this -> array_unique_fb($data_emp); //去除重复
                $data_emp = array();
            }   //foreach结束(2)
                $short=Db::name('pos_schedual')->field('shift_name')->where('id='.$val['schedual_ids'])->find();//班次 
                $rule[$key]['short'] = $short['shift_name'];
                $rule[$key]['playday'] = Db::name('pos_playday')->where('id='.$val['playday_id'])->find();
                $holiday = Db::name('pos_holiday')->field('day,name')->where('playday_id='.$val['playday_id'])->select();
                $rule[$key]['playday']['holiday'] = array_column($holiday, 'day');
                $fillworkday = Db::name('pos_holiday')->field('day,name')->where('playday_id='.$val['playday_id'])->select();
                $rule[$key]['playday']['fillworkday'] = array_column($fillworkday,'day');
            // dump($rule[$key]['holiday']);
        }   //foreach结束(1)
        
            return $rule;
    }
    /*
     * 排班算法
     * $data 考勤规则数据
     */
    private function sechuling($data){
       $nextMd=date('Y-m-d',strtotime(date('Y-m-01') . '+1 month') );
//       $nextMd=date('Y-m-d');
        $days = $this ->get_day($nextMd,'2');   //下个月的天数列表
        $user_scheduling = array();
        
        foreach ($data as $v){
            $week_arr = explode(',',$v['playday']['daily']);
            foreach ($v['data_uniemp'] as $user){
                foreach ($days as $day) {
                    $user_scheduling[$user['emp_no']][$day]['emp_no'] = $user['emp_no'];
                    $user_scheduling[$user['emp_no']][$day]['user_name'] = $user['name'];
                    $user_scheduling[$user['emp_no']][$day]['dept_id'] = $user['dept_id'];
                    $user_scheduling[$user['emp_no']][$day]['dept_name'] = $user['dept_name'];
                    $user_scheduling[$user['emp_no']][$day]['position'] = $user['position_name'];
                    $user_scheduling[$user['emp_no']][$day]['way_ids'] = $v['way_ids'];
                    $user_scheduling[$user['emp_no']][$day]['playday_id'] = $v['playday']['id'];
                    $times = strtotime($day);   //转化时间戳
                    $Y = date('Y',$times);
                    $m = date('m',$times);
                    $d = date('d',$times);
                    $w = date('w',$times);
                    $user_scheduling[$user['emp_no']][$day]['year'] = $Y;
                    $user_scheduling[$user['emp_no']][$day]['month'] = $m;
                    $user_scheduling[$user['emp_no']][$day]['day'] = $d;
                    if(in_array($day, $v['playday']['fillworkday'])){   //补班日是否存在
                        $user_scheduling[$user['emp_no']][$day]['schedual_id'] = $v['schedual_ids'];
                        $user_scheduling[$user['emp_no']][$day]['schedual_name'] = $v['short'];
                    }else{
                        if((!in_array($day, $v['playday']['holiday'])) && (!in_array($w,$week_arr))){   //既不在休息日也不在日常休息日中
                            $user_scheduling[$user['emp_no']][$day]['schedual_id'] = $v['schedual_ids'];
                            $user_scheduling[$user['emp_no']][$day]['schedual_name'] = $v['short'];
                        }else{
                            $user_scheduling[$user['emp_no']][$day]['schedual_id'] = "";
                            $user_scheduling[$user['emp_no']][$day]['schedual_name'] = "";
                        }
                    }
                }
            } 
        }
        $i = 0;
        $insert = array();
        foreach ($user_scheduling as $user) {
            foreach($user as $v){
                $insert[$i] = $v;
                $i++;
                if($i == 3000){
                   Db::name('pos_scheduling')->insertAll($insert);
                   $i = 0;
                   $insert = array();
                }
            }
        }
       if(!empty($user_scheduling)){
           Db::name('pos_scheduling')->insertAll($insert);
           
       }
        return $user_scheduling;
    }

    //去除重复人员 (二维数组去掉重复值)
    function array_unique_fb($array2D){
        $temp = array();
        foreach ($array2D as $k=>$v){
            $v=join(',',$v); //降维
            $temp[$k]=$v;
        }
            $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组 
            $temp2 = array();
        foreach ($temp as $k => $v){
            $array=explode(',',$v); //再将拆开的数组重新组装
            $temp2[$k]['id'] =$array[0];
            $temp2[$k]['emp_no'] =$array[1];
            $temp2[$k]['name'] =$array[2];
            $temp2[$k]['dept_id'] =$array[3];
            $temp2[$k]['position_id'] =$array[4];
            $data_dept = Db::name('dept')->field('NAME as dept_name')->find($array[3]);
            $data_position = Db::name('position')->field('name as position_name')->find($array[4]);
            $temp2[$k]['dept_name'] = $data_dept['dept_name'];
            $temp2[$k]['position_name'] = $data_position['position_name'];
        }
            return $temp2;
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