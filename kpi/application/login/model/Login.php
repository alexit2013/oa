<?php
/*--------------------------------------------------------------------
 KPI系统 - 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/


namespace app\login\model;
use think\Model;
use think\Db;
class Login extends Model{
    /*
     * 登录验证
     */
    function check(){
        $emp_no = input('param.emp_no');
        $map['emp_no'] = $emp_no;
        $user = Db::name('kpi_user_role')->field('role_id')->where($map)->find();
        if(empty($user)){
           return FALSE;
        }else{
            $userinfo = Db::name('user')->where($map)->find();
            session('user',$userinfo);
            $config = Db::name('kpi_config')->where("name='clear_button'")->find();
            session('clear_button',$config['value']);
            $this->_putPriToSession($user['role_id']);
            return TRUE;
        }
    }
    /*
     * weixin登录
    */
    function check_weixin($emp_no){
        $map['emp_no'] = $emp_no;
        $user = Db::name('kpi_user_role')->field('role_id')->where($map)->find();
        if(empty($user)){
           return FALSE;
        }else{
            $userinfo = Db::name('user')->where($map)->find();
            session('user',$userinfo);
            $config = Db::name('kpi_config')->where("name='clear_button'")->find();
            session('clear_button',$config['value']);
            $this->_putPriToSession($user['role_id']);
            return TRUE;
        }
    }
    // 取出一个管理员所有的权限并放到session中
	private function _putPriToSession($role_id){
            //根据角色ID取出这个角色的权限id
            $role = Db::name('kpi_role')->field('pri_ids')->where('id',$role_id)->find();

            $priModel = Db::name('kpi_pri');
            if($role['pri_ids'] == '*'){
                    session('privilege', '*');
                    /****************** 取出所有的前两级的权限 ***********************************/
                    // 取出所有顶级的权限
                    $menu = $priModel->field('id,pid,name,module_name,controller_name,action_name,icon,type')->where('pid',0)->order('rank')->select();

                    // 循环每一个顶级权限再取出二级权限
                    foreach ($menu as $k => $v){
                            $menu[$k]['sub'] = $priModel->field("id,pid,name,module_name,controller_name,action_name,icon,type")->where('pid',$v['id'])->order('rank')->select();

                    }
                    session('menu', $menu);
            }else{
                // 根据权限的ID取出这些权限对应的方法名称
                $_priData = $priModel->field('id,pid,name,module_name,controller_name,action_name,icon,type')->where("id IN({$role['pri_ids']})")->order('rank')->select();
                $privilege = array();
                foreach ($_priData as $k => $v) {
                    $privilege[$k] = $v['module_name'].'/'.$v['controller_name'].'/'.$v['action_name'];
                }
                session('privilege', $privilege);
                $menu = array();

                // 把这个数组处理成一个一维数组
                $priData = array();
                foreach ($_priData as $v){
                    // 挑出顶级权限
                    if($v['pid'] == 0){
                        $menu[] = $v;
                    }
                }
                // 循环每一个顶级的权限取出二级权限
                foreach ($menu as $k => $v){
                    // 再从$_priData里挑出每个顶级分类的子分类
                    foreach ($_priData as $v1){
                        if($v1['pid'] == $v['id']){
                            $menu[$k]['sub'][] = $v1;
                        }
                    }
                }
                session('menu', $menu);
            }
	}
}

