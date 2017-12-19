<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\View;
class PosController{
    function index(){
        $user = tp_wxcallback();
        $loginname = $user["UserId"];
        if(empty($loginname)){
            $url = "https://".$_SERVER['SERVER_NAME']."/index.php?m=home&c=pos&a=wx";
            header("Location:".$url);
            exit;
        }
        $view = new View;
        $userinfo = D('User')->get_user_info($loginname);
        if(empty($userinfo)){
            $is_del=1;
        }else{
            $is_del=0;
        }
        
        $view->assign([
            'is_del' => $is_del,
            'emp_no' => $loginname,
            'userinfo'=>$userinfo,
            'time'=> time()
            ]);
        $view->display();
    }
    
    /*
     * 微信回调登录
     */
    public function wx() {
        $appid = C('corpid');
        $url_str="https://".$_SERVER['SERVER_NAME']."/index.php?m=home&c=pos&a=index";
        $redirect_url = urlencode($url_str);
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_url.'&response_type=code&scope=snsapi_base&state=oa#wechat_redirect';
	header("Location:".$url);
        exit;
    }
    /*
     * 提交打卡数据
     */
    function commit(){
        $data = I('post.');
        $schedual_id = $data['schedual_id'];
        unset($data['schedual_id']);
        $time = time();
        $m = date('m',$time);
        $Y = date('Y',$time);
        $d = date('d',$time);
        $data['month'] = $m;
        $data['time'] = $time;
        $data['year'] = $Y;
        $data['day'] = $d;
        $map['emp_no'] = $data['emp_no'];
        $map['year'] = $Y;
        $map['month'] = (int)$m;
        $map['day'] = (int)$d;
        $count = M('pos_position_'.date('Y'))->where($map)->count();
        $schedual_data = M('pos_schedual')->find($schedual_id);
        if($count == 0){    //签到、签退
            $posid_start = M('pos_position_'.date('Y'))->add($data);
            $start_time = mktime($schedual_data['work_start_hour'],$schedual_data['work_start_minute'],0,$m,$d,$Y);     //上班时间转时间戳
            $insert['emp_no'] = $data['emp_no'];
            $insert['user_name'] = $data['user_name'];
            $insert['dept_name'] = $data['dept_name'];
            $insert['position'] = $data['position'];
            $insert['schedule'] = $schedual_data['shift_name'];
            $insert['type'] = "工作日";
            $insert['year'] = $Y;
            $insert['month'] = $m;
            $insert['day'] = $d;
            $insert['schedual'] = $schedual_data['shift_name']; //班次名称
            $insert['on_work_time'] = $schedual_data['work_start_time'];    //上班时间
            $insert['out_work_time'] = $schedual_data['work_end_time'];     //下班时间
            $insert['com_id'] = $data['com_id'];
            $insert['salary_time'] = $schedual_data['workhours']; //计薪时长
            $work_end_hour = sprintf('%02s', $schedual_data['work_end_hour']);
            $work_end_minute = sprintf('%02s', $schedual_data['work_end_minute']);
            $work_end_time = mktime($work_end_hour,$work_end_minute,0,$m,$d,$Y);
            if(($work_end_time - $time) < 10800){    //签退
                $form = M('pos_form')->where($map)->find();
                if(empty($form)){   //是否填写过请假
                    $insert['posid_end'] = $posid_start;    //签退id
                    $insert['sign_out'] = date('H:i',$time);    //签退时间
                    $type = 3; //签退
                    $insert['absent_time'] = 8; //旷工时长
                    $insert['absent_times'] = 1;    //旷工次数
                    if($work_end_time >= $time){ //早退
                        $leave_early_time = round(($work_end_time-$time)/60,0); //早退时间
                        $insert['leave_early_time'] = $leave_early_time;
                        $insert['leave_early_times'] = 1;
                        $type = 4; //早退
                    }
                    M('pos_form')->add($insert);
                }else{
                    $form['posid_end'] = $posid_start;    //签退id
                    $form['sign_out'] = date('H:i',$time);    //签退时间
                    $type = 3; //签退
                    if($work_end_time >= $time){ //早退
                        $leave_early_time = round(($work_end_time-$time)/60,0); //早退时间
                        $form['leave_early_time'] = $leave_early_time;
                        $form['leave_early_times'] = 1;
                        $type = 4; //早退
                    }
                    if(!empty($form['sign_in'])){
                        $form['work_time'] = 8;
                    }
                    M('pos_form')->save($form);
                }
            }else{  //签到
                $form = M('pos_form')->where($map)->find();
                if(empty($form)){   //是否填写过请假
                    $type = 1;  //正常
                    $insert['sign_in'] = date('H:i',$time);     //签到时间
                    $insert['posid_start'] = $posid_start;
                    if($start_time <= $time){   //迟到
                        $later_time = round(($time-$start_time)/60,0);    //迟到分钟数
                        $insert['late_time']  = $later_time;
                        $insert['late_times'] = 1;
                        $type = 2; //迟到
                    }
                    M('pos_form')->add($insert);
                }else{
                    $type = 1;  //正常
                    $form['sign_in'] = date('H:i',$time);     //签到时间
                    $form['posid_start'] = $posid_start;
                    if($start_time <= $time){   //迟到
                        $later_time = round(($time-$start_time)/60,0);    //迟到分钟数
                        $form['late_time']  = $later_time;
                        $form['late_times'] = 1;
                        $type = 2; //迟到
                    }
                    if(!empty($form['sign_out'])){
                        $form['work_time'] = 8;
                    }
                    M('pos_form')->save($form);
                }
            }
                
            header('Location:https://'.$_SERVER['SERVER_NAME'].U('successful',['type'=>$type,'time'=>$time,'emp_no'=>$data['emp_no']]));
            exit;
        }
        if($count == 1){    //签退
            $update = M('pos_form')->where($map)->find();
            if(!empty($update['posid_end'])){
                header('Location:https://'.$_SERVER['SERVER_NAME'].U('ban')); //重复打卡
                exit;
            }
            $posid_end = M('pos_position_'.date('Y'))->add($data);  //添加打卡记录
            $pos = M('pos_position_'.$update['year'])->find($update['posid_start']);
            $update['sign_out'] = date('H:i',$time);
            $update['posid_end'] = $posid_end;
            $update['work_time'] = round(($time-$pos['time'])/3600,3);  //工作时长
            if($update['work_time']>=8){
                $update['work_time'] = 8;
            }
            $end_time = mktime($schedual_data['work_end_hour'],$schedual_data['work_end_minute'],0,$m,$d,$Y);
            $type = 3; //签退
            if($end_time >= $time){ //早退
                $leave_early_time = round(($end_time-$time)/60,0);
                $update['leave_early_time'] = $leave_early_time;
                $update['leave_early_times'] = 1;
                $type = 4; //早退
            }
            M('pos_form')->save($update);   //签退
            header('Location:https://'.$_SERVER['SERVER_NAME'].U('successful',['type'=>$type,'time'=>$time,'emp_no'=>$data['emp_no']]));
            exit;
        }
        header('Location:https://'.$_SERVER['SERVER_NAME'].U('ban')); //重复打卡
        exit;
    }
    /*打卡成功*/
    function successful(){
        $type = I('type');
        $time = I('time');
        $emp_no = I('emp_no');
        $view = new View;
        $view->assign([
            'emp_no'=>$emp_no,
            'type'=>$type,
            'time'=>$time
        ]);
        $view->display();
    }
    /*提示信息*/
    function ban(){
        $view = new View;
        $view->display();
    }
    /*检查是否能进行打卡*/
    function check(){
        $emp_no = I('post.emp_no');
        $lat1 = I('post.lat');
        $lng1 = I('post.lng');
        $time = time();
        $map['emp_no'] = $emp_no;
        $map['year'] = date('Y');
        $map['month'] = (int)date('m');
        $map['day'] = (int)date('d');
        $scheduling = M('pos_scheduling')->where($map)->find();
        $form = M('pos_form')->where($map)->find();
        if(empty($scheduling)){
            $result['status'] = 0;
            $result['content'] = "不在打卡范围内";
            $this->ajaxReturn($result);
        }
        if($scheduling['schedual_id'] == 0){
            $result['status'] = 0;
            $result['content'] = "不在打卡时间范围内";
            $this->ajaxReturn($result);
        }
        $schedual = M('pos_schedual')->find($scheduling['schedual_id']);
        $starttime = mktime($schedual['clockin_start_hour'],$schedual['clockin_start_minute'],0,date('m'),date('d'),date('Y'));  //(时, 分, 秒, 月, 日, 年)
        $endtime = mktime($schedual['clockin_end_hour'],$schedual['clockin_end_minute'],0,date('m'),date('d'),date('Y'));
        if(($time < $starttime) || ($time > $endtime)){
            $result['status'] = 0;
            $result['content'] = "不在打卡时间范围内";
            $this->ajaxReturn($result);
        }
        $map['id']  = array('in',$scheduling['way_ids']);
        $way_arr = M('pos_way')->field('range,lat,lng')->where($map)->select();
        foreach ($way_arr as $v) {
            $distance = get_distance([$lat1, $lng1],[$v['lat'], $v['lng']],FALSE,0);    //计算坐标点距离
            if($distance <= $v['range']){
                if(!empty($form['sign_in'])){
                    $result['msg'] = "<h3>是否进行<span style='color:red;font-size:3rem'>签退</span></h3>";
                }
                $result['schedual_id'] = $scheduling['schedual_id'];
                $result['status'] = 1;
                $result['content'] = "已在打卡范围内";
                $this->ajaxReturn($result);
            }
        }
        $result['status'] = 0;
        $result['content'] = "不在打卡范围内";
        $this->ajaxReturn($result);
    }
    
    protected function ajaxReturn($data,$json_option=0) {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,$json_option);
        exit;
    }
    
//    测试定位功能页面
    function showposition(){
        $view = new View;
        $view->display();            
    }      
}