<?php
/*--------------------------------------------------------------------
 kpi- 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\chart\model;
use think\Model;
use think\Db;

class Rebate extends Model{
    //
    public function kpi_rebate(){
        $map['is_del']=0;
        $map['year']=date('Y');
        $map['month']=date('m');
        $map['type']=1; //预计
        return Db::name('kpi_rebate')->where($map)->select();

    }
}