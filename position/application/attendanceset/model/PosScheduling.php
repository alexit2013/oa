<?php 
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷
oa考勤-考勤规则
 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\attendanceset\model;
use think\Model;
use think\Db;

class PosScheduling extends Model{
    function update_scheduling($data){
        return $this->saveAll($data);
    }
}