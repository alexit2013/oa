<?php
/*--------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
 --------------------------------------------------------------*/

namespace Home\Controller;

class StaffController extends HomeController {
	//过滤查询字段
	protected $config = array('app_type' => 'common');
	private $position;
	private $rank;
	private $dept;

	function _search_filter(&$map) {
		$map['name'] = array('like', "%" . $_POST['name'] . "%");
		$map['letter'] = array('like', "%" . $_POST['letter'] . "%");
		$map['is_del'] = array('eq', '0');
		if (!empty($_POST['tag'])) {
			$map['group'] = $_POST['tag'];
		}
		$map['user_id'] = array('eq', get_user_id());
	}

	function index() {
		$this -> assign("title", '职员查询');
		$node = D("Dept");
		$menu = array();
                if(session('com_id') !== '0'){  //超级管理员和店面管理员分别查看部门组织架构
                    $map['_string']= "(id=1 OR id=".session('com_id')." OR pid=".session('com_id').") AND is_del=0";
                    $menu = $node -> where($map) -> field('id,pid,name') -> order('sort asc') -> select();
                } else {
                    $menu = $node -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') ->select();
                }
//		$menu = $node -> field('id,pid,name') -> where("is_del=0") -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$list = tree_to_list($tree);
		$this -> assign('menu', popup_tree_menu($tree));
		$this -> display();
	}
        function read($id) {
		if (!empty($id)) {
			$model = M("Dept");
			$dept = tree_to_list(list_to_tree( M("Dept") -> where('is_del=0') -> select(), $id));
			$dept = rotate($dept);
			$dept = implode(",", $dept['id']) . ",$id";
			$where['is_del'] = array('eq', '0');
			$where['dept_id'] = array('in', $dept);
		}
		$keyword = I('keyword');
		if (!empty($keyword)) {
			$where['name'] = array('like', "%$keyword%");
			$where['emp_no'] = array('like', "%$keyword%");
			$where['_logic'] = "OR";
		}

		$model = D("UserView");
		$data = $model -> where($where) -> order('emp_no asc') -> select();
		//echo($model->getLastSql());
		$return['data'] = $data;
		$return['status'] = 1;
		$this -> ajaxReturn($return);
	}
        
}
