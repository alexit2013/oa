<?php
/*---------------------------------------------------------------------------
  小微OA系统 - 让工作更轻松快乐 

  Copyright (c) 2013 https://www.smeoa.com All rights reserved.                                             


  Author:  jinzhu.yin<smeoa@qq.com>                         

  Support: https://git.oschina.net/smeoa/xiaowei               
 -------------------------------------------------------------------------*/


// 用户模型
namespace Home\Model;
use Think\Model;

class  UserModel extends CommonModel {
	public $_validate	=	array(
		array('emp_no','','编号已存在！',0,'unique',1),
		array('password','require','密码必须'),
		array('nickname','require','昵称必须'),
		array('repassword','require','确认密码必须'),
		);
        function get_user_list_limit($map){
            $map['u.is_del'] = 0;
            $userlist = M('user')->alias('u')
                    ->field('u.id,u.emp_no,u.name,u.nickname,u.weixin,u.dept_id,u.position_id,u.email,u.duty,u.office_tel,u.mobile_tel,u.pic,u.birthday,u.sex,u.is_del,p.name as position_name,d.name as dept_name')
                    ->join('think_position p ON p.id = u.position_id','LEFT')
                    ->join('think_dept d ON d.id = u.dept_id','LEFT')
                    ->where($map)->limit(200)->select();
            return $userlist;
        }
	function get_user_list($keyword=''){		
		$sql= " SELECT user .* , dept.name AS dept_name, position.name AS position_name";
		$sql.= " FROM ".$this->tablePrefix."user AS user";
		$sql.= " LEFT JOIN ".$this->tablePrefix."position AS position ON user.position_id = position.id";		
		$sql.= " LEFT JOIN ".$this->tablePrefix."dept dept ON user.dept_id = dept.id";
		$sql.= " WHERE user.is_del=0 ";
		if(!empty($keyword)){
			$sql.= " and (user.emp_no like '%$keyword%' or user.name like '%$keyword%') ";
		}
		$rs = $this->db->query($sql);
		return $rs;
	}
        function get_user_info($emp_no){
            $map['u.emp_no'] = $emp_no;
            $map['u.is_del'] = 0;
            $userinfo = M('user')->alias('u')
                ->field('u.id as user_id,u.emp_no,u.name as user_name,u.dept_id,d.name as dept_name,u.com_id,p.name as position')
                ->join('think_dept d on u.dept_id=d.id','LEFT')
                ->join('think_position p on p.id = u.position_id')
                ->where($map)->find();
            return $userinfo;
        }
        function useradd($data){
            $insert['emp_no'] = $data['emp_no'];
            $insert['weixin'] = $data['emp_no'];
            $insert['nickname'] = $data['emp_no'];
            $insert['password'] = md5($data['emp_no'].date('md'));
            $insert['dept_id'] = $data['dept_id'];
            $insert['com_id'] = $data['com_id'];
            $insert['name'] = $data['name'];
            $insert['position_id'] = $data['position_id'];
            $insert['mobile_tel'] =$data['mobile_tel'];
            $insert['sex'] =$data['sex'];
            $insert['birthday'] = $data['birthday'];
            $insert['duty'] =$data['duty'];
            $insert['office_tel'] =$data['office_tel'];
            $insert['email'] =$data['email'];
            $insert['is_scheduling'] =1;
            $insert['is_del'] =0;
            //添加新增管理部门		
            if(!empty($data['dept_ids'])){
                $user_dept_m = M('user_dept');
                $dept_ids=$data['dept_ids'];
                foreach ($dept_ids as $v) {
                    $data['em_no'] = $data['emp_no'];
                    $data['dept_id'] = $v;
                    $user_dept_m->add($data);
                }
            }
            //添加新增管理公司
            if(empty($data['company_names'])){
                $user_com_m = M('user_com');
                $com_ids=$data['company_names'];
                foreach ($com_ids as $v) {
                    $data=array();
                    $data['em_no'] = $data['emp_no'];
                    $data['com_id'] = $v;
                    $user_com_m->add($data);	                
                }
            }
            $res = M('user') -> add($insert);
            return $res;
        }
        function usersave($data,$userinfo){
            $up['dept_id'] = $data['dept_id'];
            $up['com_id'] = $data['com_id'];
            $up['name'] = $data['name'];
            if(!empty($data['position_id'])){
                $up['position_id'] = $data['position_id'];
            }
            $up['mobile_tel'] =$data['mobile_tel'];
            $up['sex'] =$data['sex'];
            $up['birthday'] = $data['birthday'];
            $up['duty'] =$data['duty'];
            $up['office_tel'] =$data['office_tel'];
            $up['email'] =$data['email'];
            $up['is_del'] =$data['is_del'];

            if(!empty($data['dsp_data'])){
                $user_dept_m = M('user_dept');
            //清空管理的所有部门
                $user_dept_m->where("em_no='".$data['emp_no']."'")->delete();
                $dept_ids_arr=explode(',', $data['dsp_data']);
                foreach ($dept_ids_arr as $v) {
                    $datas['em_no'] = $data['emp_no'];
                    $datas['dept_id'] = $v;
                    $user_dept_m->add($datas);//添加管理部门
                }
            }
            //添加新增管理公司		
            if(!empty($data['coms_data'])){
                $user_com_m = M('user_com');
                //清空管理的所有部门
                $user_com_m->where("em_no='".$data['emp_no']."'")->delete();
                $com_ids_arr=explode(',', $data['coms_data']);
                foreach ($com_ids_arr as $v) {
                    $datas = array();
                    $datas['em_no'] = $data['emp_no'];
                    $datas['com_id'] = $v;
                    $user_com_m->add($datas);//添加公司

                }
            }
            if($userinfo['com_id'] != $data['com_id']){
            $up['is_scheduling'] = 1;
            }
            $up['id'] = $userinfo['id'];
            $res = M('user')->save($up);
            return $res;
        }

}
?>