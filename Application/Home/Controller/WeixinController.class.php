<?php

namespace Home\Controller;
class WeixinController{	
        /*批量添加部门表*/
    function insertAll(){
        $map = array();
        $map['ID']  = array('neq',1);
        $numtotal = 1000;
        $list = M('dept')->where($map)->select();
        foreach ($list as $k => $v) {
            if(empty($v['sort'])){
                $rank = 0;
            }else{
                $rank = $numtotal-$v['sort'];
            }
            $this->createDepartment($v['id'], $v['name'], $v['pid'],$rank);
        }
        echo "ok";
    }
    /**
    * 根据部门ID获取该部门下的所有子部门
    * @param $id 部门ID，如果是获取顶级部门，则不需要
    */
    function getDepartmentList($id = FALSE) {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/department/list";
        $data = "access_token=". $this->tp_getAccess_Token();
        if (!empty($id)) {
                $data=$data."&id=".$id;
        }
        $urls = $url."?".$data;
        $result = tp_http($urls);
        dump($result);
    }
    /**
    * 创建部门
    * @param $name 部门名称
    * @param $parentid 父部门ID，默认为1
    * @param $order 排序，数字越小越靠前，如不指定，则依次排序
    * @param $id 指定部门ID，如不指定，则依次排序
    */
   function createDepartment($id,$name,$parentid = 1,$order = FALSE) {
           $token = $this->tp_getAccess_Token();
           $url = "https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token={$token}";
           $data = array('name'=>$name, 'parentid'=>$parentid);
           if (!empty($order)) {
                   $data['order'] = $order;
           }
           if (!empty($id)) {
                   $data['id'] = $id;
           }
           $datas = json_encode($data,JSON_UNESCAPED_UNICODE);
           $this->tp_http_post($url, $datas);
	}
	
	/**
	 * 更新部门
	 * @param $id 部门ID
	 * @param $name 部门名称，如不指定，名字不变
	 * @param $parentid 父部门ID，如不指定，父部门不变
	 * @param $order 排序，数字越小越靠前，如不指定，排序不变
	 */
	function updateDepartment($id,$name,$parentid = 1,$order = FALSE) {
            $token = $this->tp_getAccess_Token();
            $url = "https://qyapi.weixin.qq.com/cgi-bin/department/update?access_token={$token}";
            $data = array('id'=>$id);
            if (!empty($name)) {
                    $data['name'] = $name;
            }
            if (!empty($order)) {
                    $data['order'] = $order;
            }
            if (!empty($parentid)) {
                    $data['parentid'] = $parentid;
            }
            $datas = json_encode($data,JSON_UNESCAPED_UNICODE);
            $this->tp_http_post($url, $datas);
	}
	
	/**
	 * 删除部门
	 * @param $id 部门ID
	 */
	public function deleteDepartment($id) {
		$token = $this->tp_getAccess_Token();
		$url = "https://qyapi.weixin.qq.com/cgi-bin/department/delete?access_token=".$token."&id=".$id;
		tp_http($url);
	}
        
        
        
        
        /**
	 * 根据部门ID获取用户列表
	 * @param $department_id 部门ID
	 * @param $fetch_child 1/0：是否递归获取子部门下面的成员
	 * @param $status 0获取全部成员，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
	 */
	function getUserList($department_id = 1, $fetch_child = 0, $status = 0) {
            $token = $this->tp_getAccess_Token();
            
            $data = "?access_token=".$token."&department_id=".$department_id;
            if (intval($fetch_child) > -1) {
                    $data = $data."&fetch_child=".$fetch_child;
            }
            if (intval($status) > -1) {
                $data = $data."&status=".$status;
            }
            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist".$data;
            return tp_http($url);
	}
        /**
	 * 根据部门ID获取用户详细信息列表
	 * @param $department_id 部门ID
	 * @param $fetch_child 1/0：是否递归获取子部门下面的成员
	 */
	function getUserDetailList($department_id = 1, $fetch_child = 0) {
            $token = $this->tp_getAccess_Token();
            
            $data = "?access_token=".$token."&department_id=".$department_id;
            $data = $data."&fetch_child=".$fetch_child;
            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/list".$data;
            return tp_http($url);
	}
        /**
	 * 创建成员
	 * @param $userid 成员UserID。对应管理端的帐号，企业内必须唯一。长度为1~64个字节，必填
	 * @param $name 成员名称。长度为1~64个字节，必填
	 * @param $departmentid 成员所属部门id列表。注意，每个部门的直属成员上限为1000个
	 * @param $mobile 手机号码。企业内必须唯一，mobile/weixinid/email三者不能同时为空
	 * @param $email 邮箱。长度为0~64个字节。企业内必须唯一，mobile/weixinid/email三者不能同时为空
	 * @param $weixinid 微信号。企业内必须唯一。（注意：是微信号，不是微信的名字）
	 * @param $position 职位信息。长度为0~64个字节
	 * @param $gender 性别。1表示男性，2表示女性
	 * @param $avatar_mediaid 成员头像的mediaid，通过多媒体接口上传图片获得的mediaid
	 * @param $extattr 扩展属性。扩展属性需要在WEB管理端创建后才生效，否则忽略未知属性的赋值，以数组形式传入
	 */
	function createUser($userid, $name, $departmentid, $mobile = FALSE, $email = FALSE, $weixinid = FALSE, $position = FALSE, $gender = FALSE, $avatar_mediaid = FALSE, $extattr = array()) {
                $token = $this->tp_getAccess_Token();
		$url = "https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token={$token}";
		$data = array('userid'=>$userid, 'name'=>$name, 'department'=>$departmentid);
		if (!empty($mobile)) {
			$data['mobile'] = $mobile;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		if (!empty($weixinid)) {
			$data['weixinid'] = $weixinid;
		}
		if (!empty($position)) {
			$data['position'] = $position;
		}
		if (!empty($gender)) {
			$data['gender'] = $gender;
		}
		if (!empty($avatar_mediaid)) {
			$data['avatar_mediaid'] = $avatar_mediaid;
		}
		if (!empty($extattr) && is_array($extattr)) {
			$temp =  array();
			foreach ($extattr as $key => $value) {
				$temp[] = array('name'=>$key, 'value'=>$value);
			}
			$data['extattr'] = array('attrs'=>$temp);
		}
		$datas = json_encode($data,JSON_UNESCAPED_UNICODE);
		return $this->tp_http_post($url, $datas);
		
	}
	
	/**
	 * 更新成员
	 * @param $userid 成员UserID。对应管理端的帐号，企业内必须唯一。长度为1~64个字节，必填
	 * @param $name 成员名称。长度为1~64个字节，必填
	 * @param $departmentid 成员所属部门id列表。注意，每个部门的直属成员上限为1000个
	 * @param $position 职位信息。长度为0~64个字节
	 * @param $mobile 手机号码。企业内必须唯一，mobile/weixinid/email三者不能同时为空
	 * @param $gender 性别。1表示男性，2表示女性
	 * @param $email 邮箱。长度为0~64个字节。企业内必须唯一，mobile/weixinid/email三者不能同时为空
	 * @param $weixinid 微信号。企业内必须唯一。（注意：是微信号，不是微信的名字）
	 * @param $enable 启用/禁用成员。1表示启用成员，0表示禁用成员，默认为1
	 * @param $avatar_mediaid 成员头像的mediaid，通过多媒体接口上传图片获得的mediaid
	 * @param $extattr 扩展属性。扩展属性需要在WEB管理端创建后才生效，否则忽略未知属性的赋值，以数组形式传入
	 */
	public function updateUser($userid, $name = FALSE, $departmentid = FALSE, $position = FALSE, $mobile= FALSE, $gender = FALSE, $email = FALSE, $weixinid = FALSE, $enable = 1, $avatar_mediaid = FALSE, $extattr = array()) {
		if (empty($userid)) {
			return json_encode(array('success'=>FALSE, 'errmsg'=>'Userid is empty!', 'errcode'=>-2));
		}
		$token = $this->tp_getAccess_Token();
		$url = "https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token={$token}";
		$data = array('userid'=>$userid, 'enable'=>$enable);
		if (!empty($name)) {
			$data['name'] = $name;
		}
		if (!empty($departmentid)) {
			$data['department'] = $departmentid;
		}
		if (!empty($position)) {
			$data['position'] = $position;
		}
		if (!empty($mobile)) {
			$data['mobile'] = $mobile;
		}
		if (!empty($gender)) {
			$data['gender'] = $gender;
		}
		if (!empty($email)) {
			$data['email'] = $email;
		}
		if (!empty($weixinid)) {
			$data['weixinid'] = $weixinid;
		}
		if (!empty($avatar_mediaid)) {
			$data['avatar_mediaid'] = $avatar_mediaid;
		}
		if (!empty($extattr) && is_array($extattr)) {
			$temp =  array();
			foreach ($extattr as $key => $value) {
				$temp[] = array('name'=>$key, 'value'=>$value);
			}
			$data['extattr'] = array('attrs'=>$temp);
		}
		$datas = json_encode($data,JSON_UNESCAPED_UNICODE);
		return $this->tp_http_post($url, $datas);
	}
	
	/**
	 * 删除成员
	 * @param $userid 成员UserID。对应管理端的帐号，企业内必须唯一。长度为1~64个字节，必填
	 */
	public function deleteUser($userid) {
		$token = $this->tp_getAccess_Token();
		$url = "https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=".$token."&userid=".$userid;
		tp_http($url);
		
	}
        /*微信同步到OA数据*/
        function wxtoa(){
            $res = $this->getUserDetailList(1,1);
            $list = json_decode($res,TRUE);
            if(!empty($list['userlist'])){
                foreach ($list['userlist'] as $v) {
                    $map['emp_no'] = $v['userid'];
                    $userinfo = M('user')->where($map)->find();
                    if(!empty($userinfo)){
                        $userinfo['weixin'] = $v['userid'];
                        $userinfo['nickname'] = $v['userid'];
                        $userinfo['name'] = $v['name'];
                        $userinfo['name'] = $v['name'];
                        $userinfo['mobile_tel'] = $v['mobile'];
                        $userinfo['email'] = $v['email'];
                        $userinfo['pic'] = $v['avatar'];
                        $userinfo['update_time'] = time();
                        M('user')->save($userinfo);
                    }
                }
            }
             $result['msg'] = "同步成功！";
            $this->ajaxReturn($result);
        }
        /*oa批量添加员工*/
        function adduserAll(){
            $map['u.is_del'] = 0;
            $map['u.id'] = ['neq',1];
            $list = M('user')->alias('u')
                    ->field('u.emp_no,u.name,u.dept_id,u.mobile_tel,u.email,u.weixin,p.name as position,u.sex')
                    ->join('think_position p ON p.id=u.position_id','LEFT')->where($map)->select();
            $err_arr = array();
            foreach ($list as $k => $v){
                if($v['sex'] == 'male'){
                    $sex = 1;
                }else{
                    $sex = 2;
                }
                $res = $this->createUser($v['emp_no'], $v['name'], $v['dept_id'], $v['mobile_tel'], $v['email'], $v['weixin'], $v['position'], $sex);
                $result = json_decode($res,TRUE);
                if(!isset($result['errmsg']) || $result['errmsg'] != 'created'){
                    $err_arr[$k]['emp_no'] = $v['emp_no'];
                    $err_arr[$k]['name'] = $v['name'];
                    $err_arr[$k]['mobile_tel'] = $v['mobile_tel'];
                    $err_arr[$k]['email'] = $v['email'];
                    $err_arr[$k]['weixin'] = $v['weixin'];
                    $err_arr[$k]['position'] = $v['position'];
                    $err_arr[$k]['msg'] = $res;
                }
            }
            dump($err_arr);
        }

        /*
    * 获取管理组Access_Token
    * return access_token 微信token
    */
    function tp_getAccess_Token() {
        $access_token = tp_redis('access_token_manage');
        if(empty($access_token)){
            $corpid = C('corpid');
            $secret = "5lh6T0G46xZ9XqR233bXN1AgXxt_F-QTqe0wm280MdY";
            $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$corpid.'&corpsecret='.$secret;
            $info = tp_http($url);
            $data = json_decode($info,true);
            tp_redis('access_token_manage',$data['access_token'],6800);
            return $data['access_token'];  
        }else{
            return $access_token;
        }
    }
    
    
    /*post请求*/
    function tp_http_post($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt ($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        curl_close($ch);        
        return $temp;
    }
    protected function ajaxReturn($data,$json_option=0) {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,$json_option);
        exit;
    }
}
