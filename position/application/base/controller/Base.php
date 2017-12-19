<?php
namespace app\base\controller;
use think\Controller;
class Base extends Controller{
    function __construct() {
        if(empty(session('user'))){
           $this->error('不允许访问',"https://".$_SERVER['SERVER_NAME']);
       }
        parent::__construct();
   
        
    }
    
}
