<?php
/*--------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
 --------------------------------------------------------------*/

// 后台用户模块
namespace Home\Controller;

class UserController extends HomeController {
	protected $config = array('app_type' => 'master');

	function _search_filter(&$map) {
		$keyword = I('keyword');
		if (!empty($keyword)) {
			$map['name|emp_no'] = array('like', "%" . $keyword . "%");
                        $this->assign('keyword',$keyword);
		}
	}

	public function index() {
		$plugin['date'] = true;
		$this -> assign("plugin", $plugin);
                
		$model = M("Position");
		$list = $model -> where('is_del=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('position_list', $list);

		$model = M("Dept");
		$list = $model -> where('is_del=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_list', $list);

		if (isset($_POST['eq_is_del'])) {
			$eq_is_del = $_POST['eq_is_del'];
		} else {
			$eq_is_del = "0";
		}
		//die;
		$this -> assign('eq_is_del', $eq_is_del);

		$map = $this -> _search();
		if (method_exists($this, '_search_filter')) {
			$this -> _search_filter($map);
		}
		$map['is_del'] = array('eq', $eq_is_del);

		$model = D("User");

		if (!empty($model)) {
			$this -> _list($model, $map, "emp_no");
		}
		$Alltree=M('dept');
		
		$listright = array();
		$listright = $Alltree-> where('is_del=0') -> field('id,pid,name') -> order('sort asc') -> select();
		$listright = list_to_tree($listright);
		//所有公司
		if(session('com_id') !== '0'){ 
			$listcom = $Alltree-> where("is_del=0 AND id=".session('com_id') ) -> field('id,pid,name') -> order('sort asc') -> select();

                } else {
                 $listcom = $Alltree-> where("is_del=0 AND PID=1" ) -> field('id,pid,name') -> order('sort asc') -> select();
                }
		$this -> assign('com_list', $listcom);
		$this->assign('treeright',$listright);
		$this -> display();
	}

	public function add() {
		$plugin['date'] = true;
		$this -> assign("plugin", $plugin);

		$model = M("Position");
		$list = $model -> where('is_del=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('position_list', $list);

		$model = M("Dept");
		$list = $model -> where('is_del=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_list', $list);
                
		$this -> display();
	}
        /*
         * 读取用户信息
         */
        public function read($id) {
            $model = M('user');
            $vo = $model->alias('a')
            			->field('a.*,b.name as dept_name')
            			->join('LEFT JOIN think_dept AS b ON a.dept_id=b.id')
            			->where("a.id={$id}")
            			->find();

            $user_dept_m = M('user_dept');
            $user_dept = $user_dept_m->alias('a')
            				->join('LEFT JOIN think_dept b ON a.dept_id = b.id')
           			 		->where("em_no='".$vo['emp_no']."'")
           			 		->field('a.em_no,a.dept_id,b.name')
           			 		->select();
             $user_com_m = M('user_com');

            $user_com = $user_com_m->field('em_no,com_id')->where("em_no='".$vo['emp_no']."'")->select();
            if(!empty($user_dept)){
                $vo['depts'] = $user_dept;
            }
            if(!empty($user_com)){
                $vo['coms']=$user_com;
            }
		if (IS_AJAX) {
			if ($vo !== false) {// 读取成功
				$return['data'] = $vo;
				$return['status'] = 1;
				$return['info'] = "读取成功";
				$this -> ajaxReturn($return);
			} else {
				$return['status'] = 0;
				$return['info'] = "读取错误";
				$this -> ajaxReturn($return);
			}
		}
		$this -> assign('vo', $vo);
		$this -> display();
		return $vo;
        }
	// 检查帐号
	public function check_account() {
		if (!preg_match('/^[a-z]\w{4,}$/i', $_POST['emp_no'])) {
			$this -> error('用户名必须是字母，且5位以上！');
		}
		$User = M("User");
		// 检测用户名是否冲突
		$name = I('emp_no'); ;
		$result = $User -> getByAccount($name);
		if ($result) {
			$this -> error('该编码已经存在！');
		} else {
			$this -> assign('jumpUrl', get_return_url());
			$this -> success('该编码可以使用！');
		}
	}

	// 插入数据
	protected function _insert($name='user') {
            // 写入帐号数据
            $data = I('post.');
            $check_emp = M('user')->where("emp_no='".$data['emp_no']."'")->find();
            if(!empty($check_emp)){
                $result['msg'] = '账号存在！';
                $result['status'] = 0;
                $this ->ajaxReturn($result);
            }
            $check_tel = M('user')->where("mobile_tel='".$data['mobile_tel']."'")->find();
            if(!empty($check_tel)){
                $result['msg'] = '手机号存在！';
                $result['status'] = 0;
                $this ->ajaxReturn($result);
            }
            $check_email = M('user')->where("email='".$data['email']."'")->find();
            if(!empty($check_email)){
                $result['msg'] = '邮箱存在！';
                $result['status'] = 0;
                $this ->ajaxReturn($result);
            }
            
            $user_add = D('user') -> useradd($data);
                /*添加员工到微信企业号*/
                if ($user_add) {
                    $osex = $data['sex']; //微信企业号性别 1男性，2女性
                    if($osex == 'male'){
                        $sex = 1;
                    }else{
                        $sex = 2;
                    }
                    $position_id = $data['position_id'];
                    $position_name = M('position')->where("id={$position_id}")->getField('name');   //获取职位名称
                    A('Weixin')->createUser($data['emp_no'], $data['name'], $data['dept_id'], $data['mobile_tel'],$data['email'], $data['weixin'],$position_name, $sex);
                    /*考勤排班*/
                    $ru['user_id'] = $user_add;
                    if(session('com_id') == '2'){ //集团
                        $ru['role_id'] = 9;
                        M('role_user')->add($ru);
                    }elseif(session('com_id') != '0'){  //店面
                        $ru['role_id'] = 7;
                        M('role_user')->add($ru);
                    }
                    $url = "https://".$_SERVER['SERVER_NAME']."/position/index.php/create/userscheduling/index/emp_no/".$data['emp_no']."/dept_id/".$data['dept_id']."/com_id/".$data['com_id'];
                    tp_http($url);
                    $result['msg'] = '用户添加成功！';
                    $result['status'] = 1;
                    $this ->ajaxReturn($result);
                } else {
                    $result['msg'] = '用户添加失败！';
                    $result['status'] = 0;
                    $this ->ajaxReturn($result);
                }
	}

    protected function _update($name = "User") {

        //添加新增管理部门		

        $data = I('post.');
        $userinfo = M('user')->where("emp_no='".$data['emp_no']."'")->find();
        if($userinfo['mobile_tel'] != $data['mobile_tel']){
            $check_tel = M('user')->where("mobile_tel='".$data['mobile_tel']."'")->find();
            if(!empty($check_tel)){
                $result['msg'] = '手机号存在！';
                $result['status'] = 0;
                $this ->ajaxReturn($result);
            }
        }
        if($userinfo['email'] != $data['email']){
            $check_email = M('user')->where("email='".$data['email']."'")->find();
            if(!empty($check_email)){
                $result['msg'] = '邮箱存在！';
                $result['status'] = 0;
                $this ->ajaxReturn($result);
            }
        }    
        $res = D('user') -> usersave($data,$userinfo);
        
            if ($res !== false) {
                /*微信同步*/
                $osex = $data['sex']; 
                if($osex == 'male'){
                    $sex = 1;
                }else{
                    $sex = 2;
                }
                $position_name = M('position')->where("id={$data['posi_id']}")->getField('name');   //获取职位名称
                if($data['is_del'] == 0 || $data['is_del'] == '0'){
                    $enable = 1;    //启用微信用户
                }else{
                    $enable = 0;    //禁用微信用户
                }
                A('Weixin')->updateUser($data['emp_no'], $data['name'], $data['dept_id'],$position_name, $data['mobile_tel'], $sex, $data['email'], $data['weixin'],$enable);
                $url = "https://".$_SERVER['SERVER_NAME']."/position/index.php/create/usersupcheduling/index/emp_no/".$data['emp_no']."/dept_id/".$data['dept_id']."/com_id/".$data['com_id'];
                tp_http($url);
                $result['msg'] = '修改成功！';
                $result['status'] = 1;
                $this ->ajaxReturn($result);
            } else {
                $result['msg'] = '修改失败！';
                $result['status'] = 0;
                $this ->ajaxReturn($result);
            }
    }
	

	protected function add_default_role($user_id) {
		//新增用户自动加入相应权限组
		$RoleUser = M("RoleUser");
		$RoleUser -> user_id = $user_id;
		// 默认加入网站编辑组
		$RoleUser -> role_id = 3;
		$RoleUser -> add();
	}

	//重置密码
	public function reset_pwd() {
		$id = $_POST['user_id'];
		$password = $_POST['password'];
		if ('' == trim($password)) {
			$this -> error('密码不能为空!');
		}
		$User = M('User');
		$User -> password = md5($password);
		$User -> id = $id;
		$result = $User -> save();
		if (false !== $result) {
			$this -> assign('jumpUrl', get_return_url());
			$this -> success("密码修改成功");
		} else {
			$this -> error('重置密码失败！');
		}
	}

	function del_pwd() {
		$id = $_POST['user_id'];
		$User = M('User');
		$where['id'] = array('in', $id);
		$data['pay_pwd'] = '';
		$result = $User -> where($where) -> save($data);
		if (false !== $result) {
			$this -> assign('jumpUrl', get_return_url());
			$this -> success("密码清除成功");
		} else {
			$this -> error('清除密码失败！');
		}
	}

	public function password() {
		$this -> assign("id", I('id'));
		$this -> display();
	}

	function json() {
		header("Content-Type:text/html; charset=utf-8");
		$key = $_REQUEST['key'];

		$model = M("User");
		$where['name'] = array('like', "%" . $key . "%");
		$where['emp_no'] = array('like', "%" . $key . "%");
		$where['_logic'] = 'or';
		$map['_complex'] = $where;
		$list = $model -> where($map) -> field('id,name') -> select();
		exit(json_encode($list));
	}

	function del() {
		$user_id = I('post.user_id');
                foreach ($user_id as $v) {
                    $emp_no = M('user')->where("id={$v}")->getField('emp_no');
                    A('Weixin')->deleteUser($emp_no);
                }
		$this -> _destory($user_id);
	}

	

	function add_role($user_id, $role_list) {
		$role_list = explode(",", $role_list);
		$role_list = array_filter($role_list);
		$RoleUser = M("RoleUser");
		$RoleUser -> user_id = $user_id;
		foreach ($role_list as $role_id) {
			$RoleUser -> role_id = $role_id;
			$RoleUser -> add();
		}
	}

    function save() {
        	parent::save();	
          
            

    }
 }
       