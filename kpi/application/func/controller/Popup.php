<?php
/*--------------------------------------------------------------------
广汇KPI报表--审批流程(弹框)

 --------------------------------------------------------------*/

namespace app\func\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;

class Popup extends Base{
    //选择不同类型
    public function read() {
        $this ->assign('type','dgp');     
        $this ->_dept_list();
        $this ->_position_list();
        $this ->_group_list();
        return view();
                 
    }
    //部门列表
    private function _dept_list() {
        $model = Db::name("Dept");
        $list = array();
        $list = $model -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') -> select();
        $list = list_to_tree($list);
        $this -> assign('list_dept', popup_tree_menu($list));
    }
    //职位列表
    private function _position_list() {
        $model = Db::name("Position");
        $list = array();
        $list = $model -> field('id,name') -> order('sort asc') -> select();
        $list = list_to_tree($list);
        $this -> assign('list_position', popup_tree_menu($list));
    }
    //单位
    private function _group_list() {
        $model = Db::name("dept_grade");
        $list = array();
        $where['user_id'] = array('eq', get_user_id());
        $list = $model -> field('id,name') -> order('sort asc') -> select();
        $list = list_to_tree($list);
        $this -> assign('list_dept_grade', popup_tree_menu($list));
    }
    //所在门店人员
    public function userajax(){ 
        $dept_id=input('param.dept_id');
        $is_dept=Db::name('dept')->field('id,pid,NAME')->where('id',$dept_id)->find();
        if($is_dept['pid']=='1'){
            $res= Db::name('user')->alias('a')->field('a.id,a.emp_no,a.name,b.name as position_name')
                ->join('think_position b','a.position_id=b.id','LEFT')
                ->where(array('a.is_del'=>0,'a.com_id'=>$dept_id))
                ->select();
        }else{
            $res= Db::name('user')->alias('a')->field('a.id,a.emp_no,a.name,b.name as position_name')
                ->join('think_position b','a.position_id=b.id','LEFT')
                ->where(array('a.is_del'=>0,'a.dept_id'=>$dept_id))
                ->select();
          
        }
 
        return json($res);
    }
     
}