<?php
/*---------------------------------------------------------------------------
  小微OA系统 - 让工作更轻松快乐 

  Copyright (c) 2013 https://www.smeoa.com All rights reserved.                                             


  Author:  jinzhu.yin<smeoa@qq.com>                         

  Support: https://git.oschina.net/smeoa/xiaowei               
 -------------------------------------------------------------------------*/

namespace Home\Model;
use Think\Model\ViewModel;

class  UserViewModel extends ViewModel {
	public $viewFields=array(
		'User'=>array('id','emp_no','name','nickname','weixin','dept_id','position_id','email','duty','office_tel','mobile_tel','pic','birthday','sex','password','is_del'),
		'Position'=>array('name'=>'position_name','_on'=>'Position.id=User.position_id'),
		'Dept'=>array('name'=>'dept_name','_on'=>'Dept.id=User.dept_id')
		);
}