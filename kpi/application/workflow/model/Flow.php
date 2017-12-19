<?php

/*--------------------------------------------------------------------
广汇KPI报表--审批配置关联报表

 --------------------------------------------------------------*/
namespace app\workflow\model;
use think\Model;
use think\Db;
class Flow extends Model{
        /*
         * 添加流程后的操作
         * @param arr $data flow数据
         */
	function add($data) {
            $insert['confirm'] = $this -> _conv_auditor($data['confirm']);    //流程节点转为审批人
            if(empty($insert['confirm'])){
                $result['msg'] = '没有审批人';
                $result['status'] = 0;
                return $result;
            }
            $insert['refer'] = $this -> _conv_auditor($data['refer']);    //抄送节点转为审批人
            $insert['flow_name'] = $data['flow_name'];
            $insert['emp_no'] = $data['emp_no'];
            $insert['user_name'] = $data['user_name'];
            if(!empty($data['content'])){
                $insert['content'] = $data['content'];
            }
            $insert['flow_type'] = $data['flow_type'];  //flow_type表id
            $insert['store_id'] = $data['store_id'];
            $insert['dept_id'] = $data['dept_id'];
            $insert['steps'] = $this->step_count($insert['confirm']);   //流程节点数
            $insert['status'] = 0;
            $insert['chart'] = $data['chart'];
            $insert['chart_type_id'] = $data['chart_type_id'];
            $insert['createtime'] = time();
            $flow_id = Db::name("kpi_flow")->insertGetId($insert);
            $insert['id'] = $flow_id;
            $this->chart_status($insert,0); //添加报表状态
            $this -> next_step($flow_id,0,0);     //寻找下一审批节点
            if ($flow_id){
                $result['msg'] = '提交成功！';
                $result['status'] = 1;
                return $result;
            }else{
                $result['msg'] = '提交失败！';
                $result['status'] = 0;
                return $result;
            }
	}


        /*
         * 审批
         * @param arr $data 数据，$data['status'] 1为同意 2退回
         */
	function savedata($data) {
            $up['id'] = $data['flow_log_id'];
            $up['content'] = $data['content'];
            $up['status'] = $data['status'];
            $up['updatetime'] = time();
            Db::name('kpi_flow_log')->update($up);
            
            $flow_log = Db::name('kpi_flow_log')->where('id',$data['flow_log_id'])->find();
            $count = Db::name('kpi_flow_log')->where(['flow_id'=>$flow_log['flow_id'],'step'=>$flow_log['step']])->count();
            if($count>1){
                //删除同一节点其他审批人
                Db::execute("update think_kpi_flow_log set is_del=1 where flow_id=".$flow_log['flow_id']." and step=".$flow_log['step']." and id!=".$data['flow_log_id']);
            }
            if($data['status'] == 1){
                $up_flow['id'] = $flow_log['flow_id'];
                $up_flow['status'] = 0;
                Db::name('kpi_flow')->update($up_flow,0);
                
                $this -> next_step($flow_log['flow_id'],$flow_log['step'],$flow_log['step_pos']);
            }
            if($data['status'] == 2){
                $flow['id'] = $flow_log['flow_id'];
                $this->chart_status($flow,2,2); //更新报表状态为退回状态
                $this->back_to($flow_log['flow_id'],$data['flow_log_id'],$data['emp_no']);
            }
            $result['msg'] = '提交成功！';
            $result['status'] = 1;
            return $result;
	}

	function _get_dept($dept_id, $dept_grade) {
		$dept = Db::name("dept") -> find($dept_id);
		if ($dept['DEPT_GRADE_ID'] == $dept_grade) {
			return $dept_id;
		} else {
			if ($dept['PID'] != 0) {
				return $this -> _get_dept($dept['PID'], $dept_grade);
			}
		}
		return false;
	}
        /*
         * 节点转为字符串
         * @param string $val 审批节点
         */
	function _conv_auditor($val) {
		$arr_auditor = array_filter(explode("|", $val));    //审批节点转为数组
		$str_auditor = '';  //初始化审批人
		foreach ($arr_auditor as $auditor) {
                    if (strpos($auditor, "dgp") !== false) {   //部门级别对应职位
                            $temp = explode("_", $auditor);
                            $dept_grade = $temp[1];
                            $position = $temp[2];
                            $dept_id = get_dept_id();
                            $user_m = Db::name('user');
                            if($dept_grade == '16'){    //部门
                                $where = array();
                                $where['dept_id'] = $dept_id;
                                $where['position_id'] = $position;
                                $where['is_del'] = 0;
                                $emp_list = $user_m->where($where)->select();
                            }
                            if($dept_grade == '18'){    //公司
                                $where = array();
                                $where['com_id'] = get_com_id();                                    
                                $where['position_id'] = $position;
                                $where['is_del'] = 0;
                                $emp_list = $user_m->where($where)->select();
                            }
                            if($dept_grade == '19'){    //集团
                                $where = array();
                                $where['dept_id'] = $dept_id;
                                $where['position_id'] = $position;
                                $where['is_del'] = 0;
                                $emp_list = $user_m->where($where)->select();
                                if(empty($emp_list)){
                                    $where = array();
                                    $where['com_id'] = get_com_id();
                                    $where['position_id'] = $position;
                                    $where['is_del'] = 0;
                                    $emp_list = $user_m->where($where)->select();
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

                            $user_m = Db::name("user");
                            $where = array();
                            $where['dept_id'] = $dept;
                            $where['position_id'] = $position;
                            $where['is_del'] = 0;
                            $list = $user_m -> where($where) -> select();
                            $emp_list = rotate($list);

                            if (!empty($emp_list)) {
                                    $str_auditor .= implode(",", $emp_list['emp_no']) . "|";
                            }
                    }

                    if (strpos($auditor, "dept") !== false) {    //部门
                            $temp = explode("_", $auditor);
                            $dept = $temp[1];
                            $user_m = Db::name("user");
                            $where = array();
                            $where['dept_id'] = $dept;
                            $where['is_del'] = 0;
                            $list = $user_m -> where($where) -> select();
                            $emp_list = rotate($list);
                            if (!empty($emp_list)) {
                                    $str_auditor .= implode(",", $emp_list['emp_no']) . "|";
                            }
                    }
                    if (strpos($auditor,"dsp") !==false){   //多部门对应职位
                            $temp =explode("_", $auditor);
                            $position=$temp[2]; 
                            $dept_id = get_dept_id();
                            $where = array();
                            $where['M.dept_id'] = get_dept_id();
                            $where['U.position_id'] = $position;
                            $resD=Db::name('user_dept')->alias('M')
                                    ->field('U.emp_no')
                                    ->join('think_user U','U.emp_no=M.em_no','LEFT')
                                    ->where($where)
                                    ->group("M.em_no") 
                                    ->select();
                            $emp_list = rotate($resD);
                        if (!empty($emp_list)) {
                            $str_auditor .= implode(",", $emp_list['emp_no']) . "|";
                        }
                    }
                    if (strpos($auditor,"csp") !==false){   //多公司对应职位
                            $temp =explode("_", $auditor);
                            $position=$temp[2]; 
                            $where = array();
                            $where['M.com_id'] = get_com_id();
                            $where['U.position_id'] = $position;
                            $resD=Db::name('user_com')->alias('M')
                                                    ->field('U.emp_no')
                                                    ->join('think_user U','U.emp_no=M.em_no','LEFT')
                                                    ->where($where)
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
        /*流程节点数量*/
        function step_count($confirm){
            $count = count(explode('|', $confirm))-1;
            return $count;
        }
	/*
         * 流程退回
         * @param int $flow_id 流程id
         * @param int $flow_log_id 当前审批人flow_log_id
         * @param string $emp_no 发起人账号
         */
	public function back_to($flow_id,$flow_log_id,$emp_no) {
            $model = Db::name("kpi_flow_log");
            $user = Db::name('user')->where('emp_no',$emp_no)->find();
            $flow_log = Db::name("kpi_flow_log") -> where('id',$flow_log_id) -> find();
            $data['step_pos'] = 0;
            $data['step'] = $flow_log['step']+1;
            $data['flow_id'] = $flow_id;
            $data['emp_no'] = $emp_no;
            $data['name'] = $user['name'];
            $data['status'] = 3;    //待提交
            $model -> insert($data);
            $flow = Db::name("kpi_flow") ->where('id',$flow_id)->find();
            $seps = $this->step_count($flow['confirm']);
            $flow['steps'] = $seps+$flow_log['step']+1;   //总共审批节点
            $flow['status'] = 2;    //审批为退回状态
            $model->update($flow);//总共审批节点总数
            $push_data['title'] = $flow['flow_name'].'（被退回）';
            $push_data['action'] = '审批人：'.$flow_log['name'];
            $push_data['url'] = Url('Flow/read',"id={$flow_id}&return_url=Flow/index");
            $push_data['emp_no'][] = $flow['emp_no'];
            Pushmessage($push_data['title'],$push_data['action'],$push_data['url'],$push_data['emp_no']);
	}
        /*
         * 判断下一审批节点
         * @param int $flow_id 流程id
         * @param int $step 审批步骤
         * @param int $step_pos 审批节点
         */
	public function next_step($flow_id, $step,$step_pos) {
            if ($this -> is_last_confirm($flow_id)) {   //判断是否为最后一个审批节点
                Db::name("kpi_flow") -> where('id',$flow_id) -> update(['status'=>1]);    //审批完成
                $status = 1;
            } else {
                $status = 0;
                $step++;
                $step_pos++;
            }
            //审核通过
            $flow = Db::name("kpi_flow") ->where('id',$flow_id)->find();
            $push_data['title'] = $flow['flow_name'];
            if ($status == 1 || $status == '1') {
                $flow = Db::name("kpi_flow") ->where('id',$flow_id)->find();
                $flow_up['id'] = $flow_id;
                $flow_up['status'] = 1;
                Db::name("kpi_flow")->update($flow_up);
                $push_data['action'] = '审核通过';
                $push_data['url'] = "https://".$_SERVER['SERVER_NAME']."/kpi/index.php/login/weixin/wxlogin/biao/5/danju_id/".$flow['id'];
                $push_data['emp_no'][] = $flow['emp_no'];
                Pushmessage($push_data['title'],$push_data['action'],$push_data['url'],$push_data['emp_no']);
                //抄送
                if(!empty($flow['refer'])){
                    $this->refer($flow, $push_data);    //抄送方法
                }
            } else {
                $data['flow_id'] = $flow_id;
                $data['step'] = $step;
                $data['step_pos'] = $step_pos;
                $data['emp_no'] = $this -> duty_emp_no($flow_id, $step_pos);    //获取审批人账号
                $userinfo = Db::name('user')->where('emp_no',$data['emp_no'])->find();
                $data['name'] = $userinfo['name'];
                $push_data['action'] = '待处理';
                $this->chart_status($flow,0,2);
                if (strpos($data['emp_no'], ",") !== false) {
                    $emp_list = explode(",", $data['emp_no']);
                    foreach ($emp_list as $emp) {
                        $log_id = Db::name("kpi_flow_log")->insertGetId($data);
                        $push_data['url'] = "https://".$_SERVER['SERVER_NAME']."/kpi/index.php/login/weixin/wxlogin/biao/4/danju_id/".$flow['id']."/flow_log_id/".$log_id;
                        Pushmessage($push_data['title'],$push_data['action'],$push_data['url'],$emp);
                    }
                } else {
                    $push_data['emp_no'][] = $data['emp_no'];
                    $log_id = Db::name("kpi_flow_log")->insertGetId($data);
                    $push_data['url'] = "https://".$_SERVER['SERVER_NAME']."/kpi/index.php/login/weixin/wxlogin/biao/4/danju_id/".$flow['id']."/flow_log_id/".$log_id;
                    Pushmessage($push_data['title'],$push_data['action'],$push_data['url'],$data['emp_no']);
                }
            }
	}
        /*
         * 抄送方法
         * @param arr $flow 流程
         * @param arr $push_data 发送信息
         */
        function refer($flow,$push_data){
            $refer = $flow['refer'];
            $refer_arr = explode('|',$refer);
            unset($refer_arr[count($refer_arr)-1]);
            $refer_list = array();
            $i=0;
            $refer_data = array();
            foreach($refer_arr as $v){
                $ren = array();
                $ren = explode(',',$v);
                foreach ($ren as $vo){
                    $refer_list[$i] = $vo;
                    $refer_data[$i]['flow_id'] = $flow['id'];
                    $user = Db::name('user')->where('emp_no',$vo)->find();
                    $refer_data[$i]['emp_no'] = $vo;
                    $refer_data[$i]['name'] = $user['name'];
                    $i++;
                }
            }
            Db::name('kpi_flow_refer')->insertAll($refer_data);
            $url = "https://".$_SERVER['SERVER_NAME']."/kpi/index.php/login/weixin/wxlogin/biao/5/danju_id/".$flow['id'];
            Pushmessage($push_data['title'],$push_data['action'].'(抄送)',$url,$refer_list);
        }
        /*
         * 判断流程是否为最后一个审批节点
         * @param int $flow_id 流程id
         */
	function is_last_confirm($flow_id) {
            $flow = Db::name("kpi_flow")->field('id,confirm,steps') -> where('id',$flow_id) -> find();
            $confirm = $flow['confirm'];
            $flow_log = Db::name("kpi_flow_log")->field('step')->where(['flow_id' => $flow_id,'emp_no'=>  get_emp_no()])->order('id desc') -> find();
            $flow_log_step = $flow_log['step'];
            if (empty($confirm)) {
                $this->chart_status($flow,1,2);    //更新报表状态
                return true;
            }
            $confirm_list = array_filter(explode("|", $confirm));
            $last_confirm_emp_no = end($confirm_list);
            if (strpos($last_confirm_emp_no, get_emp_no()) !== false  && ($flow_log_step == $flow['steps']) ) {
                $this->chart_status($flow,1,2);    //更新报表状态
                return true;
            }
            return false;
	}

        /*
         * 获取下一审批人账号
         * @param int $flow_id 流程id
         * @param int $step 审批步骤id
         */
	function duty_emp_no($flow_id, $step) {
            $flow = Db::name("kpi_flow") -> where(array('id' => $flow_id)) -> find();
            $confirm = $flow['confirm'];
            $arr_confirm = array_filter(explode("|", $confirm));
            return $arr_confirm[$step-1];
	}
        /*
         * 各部门报表审批情况
         * @param arr $flow 流程信息
         * @param int $status 状态 0正在审批 1成功 2退回
         * @param int $caozuo 操作 1添加 2更新
         */
        function chart_status($flow,$status,$caozuo=1){
            if($caozuo == 1){
                $data['flow_id'] = $flow['id'];
                $data['dept_id'] = $flow['dept_id'];
                $data['store_id'] = $flow['store_id'];
                $data['chart_type_id'] = $flow['chart_type_id'];
                $data['emp_no'] = $flow['emp_no'];
                $deptclass = Db::name('kpi_chart_deptclass')->where('chart_type_id',$flow['chart_type_id'])->find();
                $data['chart_deptclass_id'] = $deptclass['id'];
                $data['year'] = date('Y');
                $data['month'] = date('n');
                $data['status'] = $status;
                Db::name('kpi_chart_deptstatus')->insert($data);
            }
            if($caozuo == 2){
                $chart_status = Db::name('kpi_chart_deptstatus')->where('flow_id',$flow['id'])->find();
                $chart_status['status'] = $status;
                Db::name('kpi_chart_deptstatus')->update($chart_status);
                if($status == 1){   //审批成功后判断其他部门报表是否审批完
                    $chart_deptclass = Db::name('kpi_chart_deptclass')->where('id',$chart_status['chart_deptclass_id'])->find();
                    $chart_dept = Db::name('kpi_chart_deptclass')->where('pid',$chart_deptclass['pid'])->select();    //找出各部门报表
                    $map['year'] = $chart_status['year'];
                    $map['month'] = $chart_status['month'];
                    $map['store_id'] = $chart_status['store_id'];
                    $map['status'] = 1;
                    $status_list = Db::name('kpi_chart_deptstatus')->field('chart_deptclass_id')->where($map)->select();
                    $status = array();
                    foreach ($status_list as $v){
                        $status[]=$v['chart_deptclass_id'];
                    }
                    $ok = 1;
                    foreach ($chart_dept as $v){
                        if(!in_array($v['id'], $status)){
                            $ok = 0;
                            break;
                        }
                    }
                    if($ok == 1){    //改变报表状态
                        $manage['store_id'] = $chart_status['store_id'];
                        $manage['chart_deptclass_id'] = $chart_deptclass['pid'];
                        $manage['year'] = $chart_status['year'];
                        $manage['month'] = $chart_status['month'];
                        $manage['status'] = 1;
                        
                        Db::name('kpi_chart_status')->insert($manage);
                        if($chart_deptclass['pid'] == 1){
                            $manage['chart_deptclass_id'] = 16;
                            $res = Db::name('kpi_chart_status')->where($manage)->find();
                            if(!empty($res)){
                                $this->pushmsg('1',$manage['store_id']);
                            }
                        }else if($chart_deptclass['pid'] == 16){
                            $manage['chart_deptclass_id'] = 1;
                            $res = Db::name('kpi_chart_status')->where($manage)->find();
                            if(!empty($res)){
                                $this->pushmsg($manage['chart_deptclass_id'],$manage['store_id']);
                            }
                        }else{
                            $this->pushmsg($manage['chart_deptclass_id'],$manage['store_id']);
                        }
                    }
                }
            }
        }
        
        private function pushmsg($deptclass_id,$store_id){
            $deptclass = Db::name('kpi_chart_deptclass')->where('id',$deptclass_id)->find();
            $dept = Db::name('dept')->where('ID',$store_id)->find();
            $push_data['title'] = $deptclass['name'].'-'.$dept['NAME'];
            $push_data['action'] = '审批完成';
            $push_data['url'] = "https://".$_SERVER['SERVER_NAME']."/kpi/index.php/login/weixin/wxlogin/biao/".$deptclass['biao']."/store_id/".$store_id;
            $refer_type = Db::name('kpi_refer_type')->where('deptclass_id',$deptclass_id)->find();
            $refer = $this -> _conv_auditor($refer_type['refer']);
            $refer_arr = explode('|', $refer);
            $count = count($refer_arr)-1;
            unset($refer_arr[$count]);
            $emp_arr = array();
            foreach ($refer_arr as $v) {
                $emp = explode(',', $v);
                foreach ($emp as $vo){
                    $emp_arr[]=$vo;
                }
            }
            Pushmessage($push_data['title'],$push_data['action'],$push_data['url'],$emp_arr);
        }
}

