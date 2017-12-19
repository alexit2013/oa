<?php
namespace app\login\controller;
use think\Controller;
class Login extends Controller{
    /*登录系统*/
   function login(){
       $Login_m = new \app\login\model\Login();
       $res = $Login_m->check();
       if($res){
           header("Location:".Url('home\index'));
           exit;
       }else{
           $this->error('不允许访问');
       }
   }
}
