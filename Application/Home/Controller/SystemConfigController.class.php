<?php
/*--------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
 --------------------------------------------------------------*/

namespace Home\Controller;
class SystemConfigController extends HomeController {

	protected $config = array('app_type' => 'master');

	public function index() {
        //显示菜单
		$where_system['data_type'] = array('eq', 'system');
		$system_data = M('SystemConfig') -> where($where_system) -> getField('code,val');
		$this -> assign('system_data', $system_data);
        
	
		//其他部分
		if (!empty($_POST['eq_pid'])) {
			$eq_pid = $_POST['eq_pid'];
		} else {
			$eq_pid = "#";
		}
		$this -> assign('eq_pid', $eq_pid);

		$node = M("SystemConfig");
		$where_system_group['data_type'] = array('eq', 'common');
		$where_system_group['pid'] = array('eq', 0);

		$list = $node -> where($where_system_group) -> order('sort asc') -> getField('id,name');
		$this -> assign('group_list', $list);

		$menu = array();
		$where_common['data_type'] = array('eq', 'common');
		$menu = M("SystemConfig") -> where($where_common) -> field('id,pid,name,is_del') -> order('sort ASC') -> select();

		if ($eq_pid != "#") {
			$tree = list_to_tree($menu, $eq_pid);
		} else {
			$tree = list_to_tree($menu);
		}

		$this -> assign('menu', popup_tree_menu($tree));

		$model = M("SystemConfig");
		$where_system_config['data_type'] = array('eq', 'common');
		$list = $model -> where($where_system_config) -> order('sort asc') -> getField('id,name');
		$this -> assign('system_config_list', $list);
		//推送设置
		$where_push['data_type'] = array('eq', 'push');
			$push_data = M('SystemConfig') -> where($where_push) -> getField('code,val');
			$this -> assign('push_data', $push_data);

		$this -> display();
	}

	function save() {
		//data_type 划分：
		$data_type = I('data_type');
		if ($data_type == 'system') {
			$this -> set_val('system_name', 'system');
			$this -> set_val('upload_file_ext', 'system');
			$this -> set_val('system_name', 'system');
			$this -> set_val('login_verify_code', 'system');
			$this -> success('保存成功');
			die ;
		}
		

		if ($data_type == 'system_push') {
			$this -> set_val('ws_push_config', 'push');
			$this -> success('保存成功');
			die ;

		}

		$this -> _save();
	}

	function set_val($key, $type) {
		$data['val'] = I($key);
		$data['data_type'] = $type;

		$where_system['code'] = $key;
		$vo = M('SystemConfig') -> where($where_system) -> find();
		if (!empty($vo)) {
			$data['id'] = $vo['id'];
			$list = M('SystemConfig') -> save($data);
		} else {
			$data['code'] = $key;
			$list = M('SystemConfig') -> add($data);
		}

		if ($list !== false) {
			return true;
		} else {
			return false;
		}
	}

	public function del($id) {
		$this -> _destory($id);
	}

	public function del_menu($id) {
		$model = M("WeixinMenu");
		$where['id'] = $id;
		$result = $model -> where($where) -> delete();
		if ($result) {
			$this -> success('删除成功！');
		}
	}

	//读取
	function edit($id) {
		$model = M("weixin_menu");
		$vo = $model -> find($id);
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

	public function winpop() {
		$node = M("SystemConfig");
		$menu = array();
		$where['data_type'] = array('eq', 'common');
		$where['is_del'] = array('eq', 0);
		$menu = $node -> where($where) -> field('id,pid,name') -> order('sort asc') -> select();

		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));

		$this -> display();
	}

	public function winpop2() {
		$this -> winpop();
	}



}
?>