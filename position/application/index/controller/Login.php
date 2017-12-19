<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\session;
class Login extends Controller{
    /*登录系统*/
   function login(){
       $emp_no = input('param.emp_no');
       $map['emp_no'] = $emp_no;
       $map['is_del'] = 0;
       $user = Db::name('user')->field('id,name,emp_no,dept_id,com_id')->where($map)->find();
       if(empty($user)){
           $this->error('不允许访问');
       }else{
           session('user',$user);
           header("Location:".Url('index\index'));
           exit;
       }
   }
}
