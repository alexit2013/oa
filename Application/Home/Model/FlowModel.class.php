<?php
/*---------------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
 -------------------------------------------------------------------------*/

namespace Home\Model;
use Think\Model;

class  FlowModel extends CommonModel {
	// 自动验证设置
	protected $_validate = array( array('name', 'require', '标题必须', 1), array('content', 'require', '内容必须'), );

	function _before_insert(&$data, $options) {
		$type = $data["type"];
		$dept_id = get_dept_id();
		$data['dept_id'] = $dept_id;
		$data['dept_name'] = get_dept_name();
		$data['emp_no'] = get_emp_no();

		$doc_no_format = M("FlowType")->where("id=$type") -> getField("doc_no_format");

		$short_dept = M("Dept") -> where("id=$dept_id") -> getField('short');
		$short_flow = M("FlowType") -> where("id=$type") -> getField('short');

		$sql = "SELECT count(*) count FROM `" . $this -> tablePrefix . "flow` WHERE type=$type ";
		$sql .= " and year(FROM_UNIXTIME(create_time))>=year(now())";

		if (strpos($doc_no_format, "{DEPT}") !== false) {
			$sql .= " and dept_id=" . get_dept_id();
		}
		$rs = $this -> db -> query($sql);
		$count = $rs[0]['count'] + 1;

		if (strpos($doc_no_format, "{DEPT}") !== false) {
			$doc_no_format = str_replace("{DEPT}", $short_dept, $doc_no_format);
		}

		if (strpos($doc_no_format, "{SHORT}") !== false) {
			$doc_no_format = str_replace("{SHORT}", $short_flow, $doc_no_format);
		}

		if (strpos($doc_no_format, "{YYYY}") !== false) {
			$doc_no_format = str_replace("{YYYY}", date('Y', mktime()), $doc_no_format);
		}

		if (strpos($doc_no_format, "{YY}") !== false) {
			$doc_no_format = str_replace("{YY}", date('y', mktime()), $doc_no_format);
		}

		if (strpos($doc_no_format, "{M}") !== false) {
			$doc_no_format = str_replace("{M}", date('m', mktime()), $doc_no_format);
		}
		if (strpos($doc_no_format, "{D}") !== false) {
			$doc_no_format = str_replace("{D}", date('d', mktime()), $doc_no_format);
		}
		if (strpos($doc_no_format, "{#}") !== false) {
			$doc_no_format = str_replace("{#}", str_pad($count, 1, "0", STR_PAD_LEFT), $doc_no_format);
		}
		if (strpos($doc_no_format, "{##}") !== false) {
			$doc_no_format = str_replace("{##}", str_pad($count, 2, "0", STR_PAD_LEFT), $doc_no_format);
		}
		if (strpos($doc_no_format, "{###}") !== false) {
			$doc_no_format = str_replace("{###}", str_pad($count, 3, "0", STR_PAD_LEFT), $doc_no_format);
		}
		if (strpos($doc_no_format, "{####}") !== false) {
			$doc_no_format = str_replace("{####}", str_pad($count, 4, "0", STR_PAD_LEFT), $doc_no_format);
		}
		if (strpos($doc_no_format, "{#####}") !== false) {
			$doc_no_format = str_replace("{#####}", str_pad($count, 5, "0", STR_PAD_LEFT), $doc_no_format);
		}
		if (strpos($doc_no_format, "{######}") !== false) {
			$doc_no_format = str_replace("{######}", str_pad($count, 6, "0", STR_PAD_LEFT), $doc_no_format);
		}
		// $data['doc_no'] = $doc_no_format;
		$data['doc_no'] = time().rand(0,100).rand(100,10000);
               
                
	}

	function _after_insert($data, $options) {
		$id = $data['id'];
		if ($data['step'] == 20) {

			$model = M("Flow");

			$where['id'] = array('eq', $id);
			$str_confirm = $this -> _conv_auditor($data['confirm']);
			//$str_consult = $this -> _conv_auditor($data['consult']);
			$str_refer = $this -> _conv_auditor($data['refer']);
			$model -> where($where) -> setField('confirm', $str_confirm);
			//$model -> where($where) -> setField('consult', $str_consult);
			$model -> where($where) -> setField('refer', $str_refer);

			$this -> next_step($data['id'], 20);
		}
	}

	function _before_update(&$data, $options) {
		$flow_type = M("FlowType") -> find($data['type']);
		if (($flow_type['is_lock'])&&($data['step']>20)) {
			unset($data['confirm']);
			//unset($data['consult']);
			unset($data['refer']);
		}
	}

	function _after_update($data, $options) {
		$id = $data['id'];
		$step = $data['step'];

		if ($data['step'] == 20) {
			$model = M("Flow");
			$where['id'] = array('eq', $id);

			$str_confirm = $this -> _conv_auditor($data['confirm']);
			if (!empty($str_confirm)) {
				$model -> where($where) -> setField('confirm', $str_confirm);
			}

			$str_refer = $this -> _conv_auditor($data['refer']);
			if (!empty($str_refer)) {
				$model -> where($where) -> setField('refer', $str_refer);
			}

			$this -> next_step($data['id'], $step);
		}
	}

	function _get_dept($dept_id, $dept_grade) {
		$model = M("Dept");
		$dept = $model -> find($dept_id);
		if ($dept['dept_grade_id'] == $dept_grade) {
			return $dept_id;
		} else {
			if ($dept['pid'] != 0) {
				return $this -> _get_dept($dept['pid'], $dept_grade);
			}
		}
		return false;
	}

	function _conv_auditor($val) {
		$arr_auditor = array_filter(explode("|", $val));
		$str_auditor = '';
		foreach ($arr_auditor as $auditor) {
			if (strpos($auditor, "dgp") !== false) {   //部门级别对应职位
				$temp = explode("_", $auditor);
				$dept_grade = $temp[1];
				$position = $temp[2];
				$dept_id = session('dept_id');
                                $model = M('user');
                                if($dept_grade == '16'){
                                    $where = array();
                                    $where['dept_id'] = $dept_id;
                                    $where['DEPT_GRADE_ID'] = $dept_grade;
                                    $where['position_id'] = $position;
                                    $where['is_del'] = 0;
                                    $emp_list = $model->where($where)->select();
                                }
                                if($dept_grade == '18'){
                                    $where = array();
                                    $where['com_id'] = session('com_id');                                    
                                    $where['position_id'] = $position;
                                    $where['is_del'] = 0;
                                    $emp_list = $model->where($where)->select();
                                }
                                if($dept_grade == '19'){
                                    $where = array();
                                    $where['dept_id'] = $dept_id;
                                    $where['position_id'] = $position;
                                    $where['is_del'] = 0;
                                    $emp_list = $model->where($where)->select();
                                    if(empty($emp_list)){
                                        $where = array();
                                        $where['com_id'] = session('com_id');
                                        $where['position_id'] = $position;
                                        $where['is_del'] = 0;
                                        $emp_list = $model->where($where)->select();
                                    }
                                }
				$emp_list = rotate($emp_list);

				if (!empty($emp_list)) {
					$str_auditor .= implode(",", $emp_list['emp_no']) . "|";
				}
				
			}
			if (strpos($auditor, "dp") !== false) { //部门对应职位
				$temp = explode("_", $auditor);
				$dept = $temp[1];
				$position = $temp[2];

				$model = M("User");
				$where = array();
				$where['dept_id'] = $dept;
				$where['position_id'] = $position;
				$where['is_del'] = 0;
				$emp_list = $model -> where($where) -> select();

				$emp_list = rotate($emp_list);

				if (!empty($emp_list)) {
					$str_auditor .= implode(",", $emp_list['emp_no']) . "|";
				}
			}

			if (strpos($auditor, "dept") !== false) {    //部门
				$temp = explode("_", $auditor);
				$dept = $temp[1];

				$model = M("User");
				$where = array();
				$where['dept_id'] = $dept;
				$where['is_del'] = 0;
				$emp_list = $model -> where($where) -> select();
				$emp_list = rotate($emp_list);
				if (!empty($emp_list)) {
					$str_auditor .= implode(",", $emp_list['emp_no']) . "|";
				}
			}
                        if (strpos($auditor,"dsp") !==false){   //多部门对应职位
                                $temp =explode("_", $auditor);
                                $deptStr =$temp[1];
                                $position=$temp[2]; 
                                $dept_id = session('dept_id');
                                $deptArr =explode(",",$deptStr);
                                $model =M();
                                writerLogs($dept_id);
                                $sql="M.dept_id={$dept_id} AND U.position_id={$position}";
                                $resD=$model->table('think_user_dept AS M')
                                                        ->field('U.emp_no')
                                                        ->join('LEFT JOIN think_user AS U ON U.emp_no=M.em_no')
                                                        ->where($sql)
                                                        ->group("M.em_no") 
                                                        ->select();
                                $emp_list = rotate($resD);
                            if (!empty($emp_list)) {
                                $str_auditor .= implode(",", $emp_list['emp_no']) . "|";
                            }
			}
                        if (strpos($auditor,"csp") !==false){   //多公司对应职位
                                $temp =explode("_", $auditor);
                                $comStr =$temp[1];
                                $position=$temp[2]; 
                                $comArr =explode(",",$comStr);
                                $model =M();
                                $com_id = session('com_id');
                                $sql="M.com_id={$com_id} AND U.position_id={$position}";

                                $resD=$model->table('think_user_com AS M')
                                                        ->field('U.emp_no')
                                                        ->join('LEFT JOIN think_user AS U ON U.emp_no=M.em_no')
                                                        ->where($sql)
                                                        ->group("M.em_no") 
                                                        ->select();
                                $emp_list = rotate($resD);
                            if (!empty($emp_list)) {
                                $str_auditor .= implode(",", $emp_list['emp_no']) . "|";
                            }
			}
			if (strpos($auditor, "emp") !== false) {    //账号
				$temp = explode("_", $auditor);
				$emp = $temp[1];
				$str_auditor .= $emp . "|";
			}

			if (strpos($auditor, "_") == false) {
				$str_auditor .= $auditor . "|";
			}
		}
		return $str_auditor;
	}
	//退回
	public function back_to($flow_id, $emp_no) {

		$model = D("FlowLog");
		$where['flow_id'] = $flow_id;
		$where['emp_no'] = $emp_no;
		$data['step'] = D("FlowLog") -> where($where) -> getField('step');
		if (empty($data['step'])) {
			$data['step'] = 20;
		}

		$data['flow_id'] = $flow_id;
		$data['emp_no'] = $emp_no;

		$model -> create($data);
		$model -> add();

		$flow = M("Flow") -> find($flow_id);

		$push_data['type'] = '审批';
		$push_data['action'] = '被退回';
		$push_data['title'] = $flow['name'];
		$push_data['content'] = '审核人：' . get_dept_name() . "-" . get_user_name();
		$push_data['url'] = U('Flow/read',"id={$flow_id}&return_url=Flow/index");
		$push_data['flow_id']=$flow_id;
		$push_data['biao']=21;
		$user_id = M("User") -> where(array('emp_no' => $emp_no)) -> getField("id");
		send_push($push_data, $user_id);
	}

	public function next_step($flow_id, $step) {
		//$confirm = M("Flow") -> where(array('id' => $flow_id)) -> getField("confirm");             
		
//		if (!empty($confirm)&&($step == 20)){
//			$confirm_list = array_filter(explode("|", $confirm));
//			$is_include_presenter = array_search(get_emp_no(), $confirm_list);
//			if ($is_include_presenter != false) {
//				$step = $step + $is_include_presenter + 1;
//			}
//		}              
		
		$model = D("Flow");
		if (substr($step, 0, 1) == 2) {
			if ($this -> is_last_confirm($flow_id)) {
				$model -> where(array('id' => $flow_id)) -> setField('step', 40);
				$step = 40;
			} else {
				$step++;
			}
		}
		//审核通过
		if ($step == 40 || $step == '40') {
			$model -> where(array('id' => $flow_id)) -> setField('step', 40);
			$flow = M("Flow") -> find($flow_id);
			$push_data['type'] = '审批';
			$push_data['action'] = '审核通过';
			$push_data['title'] = $flow['name'];
			$push_data['content'] = '审核人：' . get_dept_name() . "-" . get_user_name();
			$push_data['url'] = U('Flow/read',"id={$flow_id}&return_url=Flow/index");
			$push_data['flow_id']=$flow_id;
			$push_data['biao']=21;
                        //执行考勤功能
                        $this->pos($flow);
                        
			send_push($push_data, $flow['user_id']);
                        //抄送
                        if(!empty($flow['refer'])){
                            $refer = $flow['refer'];
                            $refer = substr($refer,0,-1);
                            $refer_arr = explode('|',$refer);
                            $flow_log_m = M('flow_log');
                            foreach ($refer_arr as  $v) {
                                $refer_data['flow_id'] = $flow_id;
                                $refer_data['emp_no'] = $v;
                                $refer_data['refer'] = 1;
                                $refer_data['result'] = 9;
                                $refer_data['create_time'] = time();
                                $refer_data['update_time'] = time();
                                $flow_log_m -> add($refer_data);
                            }
                            $url = "https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Public&a=wxlogin&biao=23&danju_id=".$push_data['flow_id'];
                            Pushmessage($push_data['title'],$push_data['action'].'(抄送)',$url,$refer_arr);
                        }
		} else {
			$data['flow_id'] = $flow_id;
			$data['step'] = $step;
			$data['emp_no'] = $this -> duty_emp_no($flow_id, $step);

			if (strpos($data['emp_no'], ",") !== false) {
				$emp_list = explode(",", $data['emp_no']);
				foreach ($emp_list as $emp) {
					$data['emp_no'] = $emp;
					$model = D("FlowLog");
					$model -> create($data);
					$model -> add();
				}
			} else {
				$model = D("FlowLog");
				$model -> create($data);
				$model -> add();
			}
		}
            
	}

	function is_last_confirm($flow_id) {
		$confirm = M("Flow") -> where(array('id' => $flow_id)) -> getField("confirm");
                $count = count(explode('|', $confirm));
                $flow_log_step = M("flow_log") -> where(array('flow_id' => $flow_id,'emp_no'=>  get_emp_no()))->order('id desc') -> getField("step");
                $flow_log_step = fmod($flow_log_step,20)+1;
                $flow_log_step = (int)$flow_log_step;   //对比结束
               
		if (empty($confirm)) {
			return true;
		}
		$confirm_list = array_filter(explode("|", $confirm));
		$last_confirm_emp_no = end($confirm_list);
		if (strpos($last_confirm_emp_no, get_emp_no()) !== false  && ($flow_log_step == $count) ) {
			return true;
		}
		return false;
	}


	function duty_emp_no($flow_id, $step) {
		if (substr($step, 0, 1) == 2 || substr($step, 0, 1) == 3) {
			$confirm = M("Flow") -> where(array('id' => $flow_id)) -> getField("confirm");
			$arr_confirm = array_filter(explode("|", $confirm));
			return $arr_confirm[fmod($step, 20) - 1];
		}

	}
	//发送打审批
	function send_to_refer($flow_id, $emp_list) {

		$data['flow_id'] = $flow_id;
		$data['result'] = 1;
		$data['step'] = 100;
		$data['create_time'] = time();
		$data['from'] = get_user_name();

		foreach ($emp_list as $key => $val) {
			$data['emp_no'] = $val;
			$where_flow_log['flow_id'] = array('eq', $flow_id);
			$where_flow_log['emp_no'] = array('eq', $val);

			$flow_log = M("FlowLog") -> where($where_flow_log) -> select();
			if (!$flow_log) {
				D("FlowLog") ->fetchSql(true)-> add($data);

			} else {
				unset($emp_list[$key]);
			}
		}

		$flow = M("Flow") -> find($flow_id);
		$push_data['type'] = '审批';
		$push_data['action'] = '需要您参阅';
		$push_data['title'] = $flow['name'];
		$push_data['content'] = '转发人：' . get_dept_name() . "-" . get_user_name();
		$push_data['url'] = U('Flow/read',"id={$flow_id}&return_url=Flow/index");
		$push_data['flow_id']=$flow_id;
		$push_data['biao']=21;
		$where_user_list['emp_no'] = array('in', $emp_list);
		$user_list = M("User") -> where($where_user_list) -> getField("id", true);
		send_push($push_data, $user_list);
	}
        /*
         * 考勤功能
         */
        function pos($data){
            switch ($data['pos_type']) {
                case '1':   //1.异常考勤；
                    $this->abnormal($data); //异常数据
                    break;  
                case '2':   //2.加班申请；
                    $this->huixie($data,'over_time',1);
                    break;
                case '3':   //3.调休申请；
                    $this->huixie($data,'adjust_time',2);
                    break;
                case '4':   //4.请假申请；
                    $this->qinjia($data);
                    break;
                case '5':   //5.外出出申请；
                    $this->qinjia($data,'out_time');
                    break;
                case '6':   //6.出差申请；
                    $this->qinjia($data,'business_time');
                    break;
            }
        }
        /*异常申请*/
        function abnormal($data){
            $udf = json_decode($data['udf_data'],true);
            $time = current($udf);
            $time_arr = explode('T', $time);    
            $Ymd_arr = explode('-', $time_arr[0]);
            $sign = $time_arr[1];   //时分秒
            $userinfo = M('user')->where(['emp_no'=>$data['emp_no']])->find();
            $dept_data = M('dept')->find($userinfo['dept_id']);
            $position_data = M('position')->find($userinfo['position_id']);
            $map['emp_no'] = $userinfo['emp_no'];
            $map['year'] = $Ymd_arr[0];
            $map['month'] = (int)$Ymd_arr[1];
            $map['day'] = (int)$Ymd_arr[2];
            $time_zhong = mktime(13, 0, 0, $Ymd_arr[1], $Ymd_arr[2], $Ymd_arr[0]);  //中午13：00时间戳
            $in_time = strtotime($time_arr[0]." ".$time_arr[1]);
            $form = M('pos_form')->where($map)->find();
            $scheduling = M('pos_scheduling')->where($map)->find();
            $schedual = M('pos_schedual')->field('work_start_time as on_work_time,work_end_time as out_work_time')->find($scheduling['schedual_id']);
            if(empty($form)){ //是否签退或签到过
                $insert = $schedual;
                $insert['emp_no'] = $userinfo['emp_no'];
                $insert['year'] = $Ymd_arr[0];
                $insert['month'] = (int)$Ymd_arr[1];
                $insert['day'] = (int)$Ymd_arr[2];
                $insert['user_name'] = $userinfo['name'];
                $insert['dept_name'] = $dept_data['name'];
                $insert['com_id'] = $userinfo['com_id'];
                $insert['position'] = $position_data['name'];
                $insert['type'] = '工作日';
                if($time_zhong > $in_time){   //签到
                    $insert['sign_in'] = $time_arr[1];
                    $map['status'] = '未签到';
                }else{ //签退
                    $insert['sign_out'] = $time_arr[1];
                    $map['status'] = '未签退';
                }
                $insert['salary_time'] = 8;
                M('pos_form')->add($insert);
            }else{
                if($time_zhong > $in_time){   //签到
                    $map['status'] = '未签到';
                    $up['sign_in'] = $sign;
                    $up['salary_time'] = 8;
                    $up['late_time'] = 0;   //迟到归零
                    $up['late_times'] = 0;
                    $up['type'] = '工作日';
                    if(!empty($form['sign_out'])){  //签退已存在  
                        $out_time_arr = explode(':', $form['sign_out']);
                        $out_time = mktime($out_time_arr[0], $out_time_arr[1], 0, $Ymd_arr[1], $Ymd_arr[2]);
                        $up['work_time'] = round(($out_time-$in_time)/3600,3);
                        if($up['work_time'] >= 8){
                            $up['work_time'] = 8;
                        }
                        if($up['work_time'] < 0){
                            $up['work_time'] = 0;
                        }
                        $up['absent_time'] = 0; //旷工清零
                        $up['absent_times'] = 0;
                    }                    
                    
                }else{ //签退
                    $map['status'] = '未签退';
                    $up['salary_time'] = 8;
                    $up['leave_early_time'] = 0;    //早退归零
                    $up['leave_early_times'] = 0;
                    $up['sign_out'] = $sign;
                    $up['type'] = '工作日';
                    if(!empty($form['sign_in'])){ //签到已存在
                        $ins_time_arr = explode(':', $form['sign_in']);
                        $ins_time = mktime($ins_time_arr[0], $ins_time_arr[1], 0, $Ymd_arr[1], $Ymd_arr[2]);
                        $up['work_time'] = round(($in_time-$ins_time)/3600,3);
                        if($up['work_time'] >= 8){
                            $up['work_time'] = 8;
                        }
                        if($up['work_time'] < 0){
                            $up['work_time'] = 0;
                        }
                        $up['absent_time'] = 0; //旷工清零
                        $up['absent_times'] = 0;
                    }
                }     
                M('pos_form')->where('id='.$form['id'])->save($up);
            }
            //删除异常表数据
            $ab = M('pos_abnormal')->where($map)->find();
            if(!empty($ab)){
                M('pos_abnormal')->where('id='.$ab['id'])->delete();
            }
        }
        /*
         * 申请回写
         * @param $data 单据信息
         * @param $field 回写字段
         * @param $type 1加班 2调休
         */
        function huixie($data,$field,$type){
            $udf = json_decode($data['udf_data'],true);
            $time_start = current($udf);
            $time_end = next($udf);
            $time_start_arr = explode('T', $time_start); 
            $time_end_arr = explode('T', $time_end);
            $start_time = strtotime($time_start_arr[0]." ".$time_start_arr[1]);
            $end_time = strtotime($time_end_arr[0]." ".$time_end_arr[1]);
            $time = round(($end_time-$start_time)/3600,3);  //加班时间
            if($time>=8){
                $time = 8;
            }
            $Ymd_arr = explode('-', $time_start_arr[0]);    
            $userinfo = M('user')->where(['emp_no'=>$data['emp_no']])->find();
            $dept_data = M('dept')->find($userinfo['dept_id']);
            $position_data = M('position')->find($userinfo['position_id']);
            $map['emp_no'] = $userinfo['emp_no'];
            $map['year'] = $Ymd_arr[0];
            $map['month'] = (int)$Ymd_arr[1];
            $map['day'] = (int)$Ymd_arr[2];
            if($type == 1){ //加班
                $schedual_id = end($udf);
                $scheduling_add = $this->addscheduling($schedual_id, $map);  //添加排班
            }
            if($type == 2){ //调休
                $this->delscheduling($map);
            }
            $form = M('pos_form')->where($map)->find();
            $scheduling = M('pos_scheduling')->where($map)->find();
            $schedual = M('pos_schedual')->field('work_start_time as on_work_time,work_end_time as out_work_time')->find($scheduling['schedual_id']);
            if(empty($form)){ //是否签退或签到过
                $insert = $schedual;
                $insert['emp_no'] = $userinfo['emp_no'];
                $insert['year'] = $Ymd_arr[0];
                $insert['month'] = (int)$Ymd_arr[1];
                $insert['day'] = (int)$Ymd_arr[2];
                $insert['user_name'] = $userinfo['name'];
                $insert['dept_name'] = $dept_data['name'];
                $insert['com_id'] = $userinfo['com_id'];
                $insert['position'] = $position_data['name'];
                if($type == 1){
                    $insert['schedule'] = $scheduling_add['schedual_name'];
                }
                $insert['type'] = '工作日';
                $insert[$field] = $time;
                $insert[$field.'s'] = 1;
                $insert['salary_time'] = 8;
                M('pos_form')->add($insert);
            }else{
                if($type == 1){
                    $up['schedule'] = $scheduling_add['schedual_name'];
                    $up['on_work_time'] = $scheduling_add['on_work_time'];
                    $up['out_work_time'] = $scheduling_add['out_work_time'];
                }
                $up[$field] = $time;
                $up[$field.'s'] = 1;
                $up['salary_time'] = 8;
                if($type == 1){ //加班
                    $up['adjust_time'] = 0;
                    $up['adjust_times'] = 0;
                }
                $up['absent_time'] = 0;
                $up['absent_times'] = 0;
                M('pos_form')->where('id='.$form['id'])->save($up);
            }
        }
    /*修改并添加排班*/
    private function addscheduling($schedual_id,$map){
        $schedual=M('pos_schedual')->field('id,shift_name')->where('id='.$schedual_id)->find();//班次 
        $scheduling = M('pos_scheduling')->field('id')->where($map)->find();
        $scheduling['schedual_id'] = $schedual['id'];
        $scheduling['schedual_name'] = $schedual['shift_name'];
        M('pos_scheduling')->save($scheduling);
        $scheduling['on_work_time'] = $schedual['work_start_time'];
        $scheduling['out_work_time'] = $schedual['work_end_time'];   
        return $scheduling;
    }  
    /*修改并删除排班*/
    private function delscheduling($map){
        $scheduling = M('pos_scheduling')->field('id')->where($map)->find();
        $scheduling['schedual_id'] = 0;
        $scheduling['schedual_name'] = "";
        M('pos_scheduling')->save($scheduling);
    }
        /*请假、公出、出差申请*/
        function qinjia($data,$field =""){
            $udf = json_decode($data['udf_data'],true);
            $start = current($udf);
            $end = next($udf);
            $type = end($udf);
            $start_arr = explode("T", $start);
            $end_arr = explode("T", $end);
            $Ymd = $start_arr[0];
            $days = $this->diffBetweenTwoDays($end_arr[0],$start_arr[0]);
            if($days>=0){
                $userinfo = M('user')->where(['emp_no'=>$data['emp_no']])->find();
                $dept_data = M('dept')->find($userinfo['dept_id']);
                $position_data = M('position')->find($userinfo['position_id']);
                $start_time = strtotime($start_arr[0]." ".$start_arr[1]);   //开始时间的时间戳
                $end_time = strtotime($end_arr[0]." ".$end_arr[1]); //结束时间的时间戳
                if($days == 0){ //当天请假
                    $save_hours = round(($end_time-$start_time)/3600,3);
                    if($save_hours>=8){
                        $save_hours = 8;
                    }
                    $Ymdday = explode('-', $start_arr[0]);
                    $maps['year'] = $Ymdday[0];
                    $maps['month'] = (int)$Ymdday[1];
                    $maps['day'] = $Ymdday[2];
                    $maps['emp_no'] = $data['emp_no'];
                    $scheduling = M('pos_scheduling')->where($maps)->find();
                    $pos_form = M('pos_form')->where($maps)->find();
                    $schedual = M('pos_schedual')->field('work_start_time as on_work_time,work_end_time as out_work_time,workhours as work_time')->find($scheduling['schedual_id']);
                    if(empty($pos_form)){
                        $insert = $schedual;
                        $insert['emp_no'] = $userinfo['emp_no'];
                        $insert['year'] = $Ymdday[0];
                        $insert['month'] = (int)$Ymdday[1];
                        $insert['day'] = (int)$Ymdday[2];
                        $insert['user_name'] = $userinfo['name'];
                        $insert['dept_name'] = $dept_data['name'];
                        $insert['com_id'] = $userinfo['com_id'];
                        $insert['position'] = $position_data['name'];
                        $insert['salary_time'] = 8;
                        $insert['type'] = '工作日';
                        if(empty($field)){
                            $field = $this->qinjia_type($type);
                            $insert[$field] = $save_hours;
                        }else{
                            $insert[$field] = $save_hours;
                            $insert[$field.'s'] = 1;
                        }
                        M('pos_form')->add($insert);
                    }else{
                        if(empty($field)){
                            $field = $this->qinjia_type($type);
                            $up[$field] = $save_hours;
                        }else{
                            $up[$field] = $save_hours;
                            $up[$field.'s'] = 1;
                        }
                        $up['salary_time'] = 8;
                        $up['absent_time'] = 0;
                        $up['absent_times'] = 0;
                        M('pos_form')->where('id='.$pos_form['id'])->save($up);
                    }
                }else{  //多天请假
                    for($i=0;$i<=$days;$i++){
                        $Ymd_arr = explode('-', $Ymd);
                        $map['year'] = $Ymd_arr[0];
                        $map['month'] = $Ymd_arr[1];
                        $map['day'] = $Ymd_arr[2];
                        $map['emp_no'] = $data['emp_no'];
                        $scheduling = M('pos_scheduling')->where($map)->find();
                        $pos_form = M('pos_form')->where($map)->find();
                        $schedual = M('pos_schedual')->field('work_start_time as on_work_time,work_end_time as out_work_time,workhours as work_time')->find($scheduling['schedual_id']);
                        $insert = array();
                        if($scheduling['schedual_id'] != 0){    //工作日第一天
                            if($i == 0){    //第一天
                                $schedual_end_time = strtotime($Ymd." ".$schedual['out_work_time']);
                                if($start_time>$schedual_end_time){ //开始时间大于下班时间
                                    $save_hours = 0;
                                }else{
                                    $save_hours = round(($schedual_end_time-$start_time)/3600,3);
                                    if($save_hours>=8){
                                        $save_hours = 8;
                                    }
                                }
                                if(empty($pos_form)){
                                    $insert = $schedual;
                                    $insert['emp_no'] = $userinfo['emp_no'];
                                    $insert['year'] = $Ymd_arr[0];
                                    $insert['month'] = (int)$Ymd_arr[1];
                                    $insert['day'] = (int)$Ymd_arr[2];
                                    $insert['user_name'] = $userinfo['name'];
                                    $insert['dept_name'] = $dept_data['name'];
                                    $insert['com_id'] = $userinfo['com_id'];
                                    $insert['position'] = $position_data['name'];
                                    $insert['salary_time'] = 8;
                                    $insert['type'] = '工作日';
                                    if(empty($field)){
                                        $field = $this->qinjia_type($type);
                                        $insert[$field] = $save_hours;
                                    }else{
                                        $insert[$field] = $save_hours;
                                        $insert[$field.'s'] = 1;
                                    }
                                    M('pos_form')->add($insert);
                                }else{
                                    if(empty($field)){
                                        $field = $this->qinjia_type($type);
                                        $up[$field] = $save_hours;
                                    }else{
                                        $up[$field] = $save_hours;
                                        $up[$field.'s'] = 1;
                                    }
                                    $up['salary_time'] = 8;
                                    $up['absent_time'] = 0;
                                    $up['absent_times'] = 0;
                                    M('pos_form')->where('id='.$pos_form['id'])->save($up);
                                }
                            }elseif($i == $days){   //工作日最后一天
                                $schedual_start_time = strtotime($Ymd." ".$schedual['on_work_time']);
                                if($end_time<$schedual_start_time){ 
                                    $save_hours = 0;
                                }else{
                                    $save_hours = round(($end_time-$schedual_start_time)/3600,3);
                                    if($save_hours>=8){
                                        $save_hours = 8;
                                    }
                                }

                                if(empty($pos_form)){
                                    $insert = $schedual;
                                    $insert['emp_no'] = $userinfo['emp_no'];
                                    $insert['year'] = $Ymd_arr[0];
                                    $insert['month'] = (int)$Ymd_arr[1];
                                    $insert['day'] = (int)$Ymd_arr[2];
                                    $insert['user_name'] = $userinfo['name'];
                                    $insert['dept_name'] = $dept_data['name'];
                                    $insert['com_id'] = $userinfo['com_id'];
                                    $insert['position'] = $position_data['name'];
                                    $insert['salary_time'] = 8;
                                    $insert['type'] = '工作日';
                                    if(empty($field)){
                                        $field = $this->qinjia_type($type);
                                        $insert[$field] = $save_hours;
                                    }else{
                                        $insert[$field] = $save_hours;
                                        $insert[$field.'s'] = 1;
                                    }
                                    M('pos_form')->add($insert);
                                }else{
                                    if(empty($field)){
                                        $field = $this->qinjia_type($type);
                                        $up[$field] = $save_hours;
                                    }else{
                                        $up[$field] = $save_hours;
                                        $up[$field.'s'] = 1;
                                    }
                                    $up['salary_time'] = 8;
                                    $up['absent_time'] = 0;
                                    $up['absent_times'] = 0;
                                    M('pos_form')->where('id='.$pos_form['id'])->save($up);
                                }
                            }else{  //工作日中间日期
                                if(empty($pos_form)){
                                    $insert = $schedual;
                                    $insert['emp_no'] = $userinfo['emp_no'];
                                    $insert['year'] = $Ymd_arr[0];
                                    $insert['month'] = (int)$Ymd_arr[1];
                                    $insert['day'] = (int)$Ymd_arr[2];
                                    $insert['user_name'] = $userinfo['name'];
                                    $insert['dept_name'] = $dept_data['name'];
                                    $insert['com_id'] = $userinfo['com_id'];
                                    $insert['position'] = $position_data['name'];
                                    $insert['salary_time'] = 8;
                                    $insert['type'] = '工作日';
                                    if(empty($field)){
                                        $field = $this->qinjia_type($type);
                                        $insert[$field] = 8;
                                    }else{
                                        $insert[$field] = 8;
                                        $insert[$field.'s'] = 1;
                                    }
                                    M('pos_form')->add($insert);
                                }else{
                                    if(empty($field)){
                                        $field = $this->qinjia_type($type);
                                        $up[$field] = 8;
                                    }else{
                                        $up[$field] = 8;
                                        $up[$field.'s'] = 1;
                                    }
                                    $up['salary_time'] = 8;
                                    $up['absent_time'] = 0;
                                    $up['absent_times'] = 0;
                                    M('pos_form')->where('id='.$pos_form['id'])->save($up);
                                }
                            }
                        }
                        $Ymd = date('Y-m-d',strtotime($Ymd." + 1 day"));
                    }
                }
            }
            
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
            return FALSE;
        }
         return ($second1 - $second2) / 86400;
       }
       /*请假类型字段处理*/
       function qinjia_type($data){
           switch ($data) {
               case '病假':
                   $res = 'sick_time';
                   break;
               case '事假': 
                   $res = 'thing_time';
                   break;
               case '婚假':
                   $res = 'marriage_time';
                   break;
               case '丧假':
                   $res = 'death_time';
                   break;
               case '产假':
                   $res = 'maternity_time';
                   break;
               case '其它假期':
                   $res = 'other_time';
                   break;
           }
           return $res;
       }
}