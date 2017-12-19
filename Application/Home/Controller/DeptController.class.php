<?php
/*--------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
 --------------------------------------------------------------*/

namespace Home\Controller;

class DeptController extends HomeController {

	protected $config = array('app_type' => 'master');

	public function index() {
                
		$node = M("Dept");
		$menu = array();
                $map=array();
                if(session('com_id') !== '0'){  //超级管理员和店面管理员分别查看部门组织架构
                    $map['_string']= "(id=1 OR id=".session('com_id')." OR pid=".session('com_id').") AND is_del=0";
                } 
                $menu = $node -> where($map) -> field('id,pid,name,is_del') -> order('sort asc') -> select();
//		$menu = $node -> field('id,pid,name,is_del') -> order('sort asc') -> select();
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));

		$model = M("Dept");
		$list = $model -> order('sort asc') -> getField('id,name');
		// echo "<pre>";
		// print_r($list);
		$this -> assign('dept_list', $list);

		$model = M("DeptGrade");
		$list = $model -> where('is_del=0') -> order('sort asc') -> getField('id,name');
		// echo "<pre>";
		// print_r($list);
		$this -> assign('dept_grade_list', $list);

		$this -> display();
	}

	public function add() {
		$model = M("DeptGrade");
		$list = $model -> where('is_del=0') -> order('sort asc') -> getField('id,name');
		$this -> assign('dept_grade_list', $list);

		$this -> display();
	}

	public function del($id) {
            A('Weixin')->deleteDepartment($id);
            $this -> _destory($id);
	}

	/** 插入新新数据  **/
	protected function _insert($name = CONTROLLER_NAME) {
		$model = D($name);
		$data['DEPT_GRADE_ID']=I('post.dept_grade_id');
		$data['NAME']=I('post.name');
		$data['SHORT']=I('post.short');
		$data['SORT']=I('post.sort');
		$data['IS_DEL']=I('post.is_del');
		$data['PID']=I('post.pid');
		if (false === $model -> create($data)) {
			$this -> error($model -> getError());
		}

		/*保存当前数据对象 */
		$list = $model->add();
		// echo $model->getlastSql();
		if ($list !== false) {//保存成功
                    if(empty($data['SORT'])){
                        $rank = 0;
                    }else{
                        $rank = 1000-$data['SORT'];
                    }
                    A('Weixin')->createDepartment($list,$data['NAME'],$data['PID'],$rank);  //同步部门到微信
			$this -> assign('jumpUrl', get_return_url());
			$this -> success('新增成功!');			
		} else {
			$this -> error('新增失败!');
			//失败提示
		}
	}

	/* 更新数据  */
	protected function _update($name = CONTROLLER_NAME) {
		// echo "<pre>";
		// print_r($_POST);

		$model = D($name);
		$data['ID']=I('post.id');
		$data['DEPT_NO']=I('post.dept_no');
		$data['DEPT_GRADE_ID']=I('post.dept_grade_id');
		$data['NAME']=I('post.name');
		$data['SHORT']=I('post.short');
		$data['SORT']=I('post.sort');
		$data['REMARK']=I('post.remark');
		$data['IS_DEL']=I('post.is_del');
		$data['PID']=I('post.pid');
		if (false === $model -> create($data)) {
			$this -> error($model -> getError());
		}
		$list = $model -> save();
		// // echo $model->getlastSql();
		

		if (false !== $list) {
                    if(empty($data['SORT'])){
                        $rank = 0;
                    }else{
                        $rank = 1000-$data['SORT'];
                    }
                    A('Weixin')->updateDepartment($data['ID'],$data['NAME'],$data['PID'],$rank);  //同步部门到微信
                    $this -> assign('jumpUrl', get_return_url());
                    $this -> success('编辑成功!');
                    //成功提示
		} else {
			$this -> error('编辑失败!');
			//错误提示
		}
	}

	public function winpop() {
		$node = M("Dept");
		$menu = array();
                if(session('com_id') !== '0'){  //超级管理员和店面管理员分别查看部门组织架构
                    $map['_string']= "(id=1 OR id=".session('com_id')." OR pid=".session('com_id').") AND is_del=0";
                    $menu = $node -> where($map) -> field('id,pid,name') -> order('sort asc') -> select();
                } else {
                    $menu = $node -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') ->select();
                }
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$pid = array();
		$this -> assign('pid', $pid);
		$this -> display();
	}

	public function winpop2() {
		$this -> winpop();
	}
        public function winpop3() {
		$this -> winpop();
	}
	public function winpop4(){
		$node = M("Dept");
		$menu = array();
                if(session('com_id') !== '0'){  //超级管理员和店面管理员分别查看部门组织架构
                    $map['_string']= "(id=1 OR id=".session('com_id')." OR pid=".session('com_id').") AND is_del=0";
                    $menu = $node -> where($map) -> field('id,pid,name') -> order('sort asc') -> select();
                } else {
                    $menu = $node -> where('id=1 OR is_del=0 AND PID=1') -> field('id,pid,name') -> order('sort asc') ->select();
                }
		$tree = list_to_tree($menu);
		$this -> assign('menu', popup_tree_menu($tree));
		$pid = array();
		$this -> assign('pid', $pid);
		$this -> display();
	
	}
}
?>