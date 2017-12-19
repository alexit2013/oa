<?php
/*--------------------------------------------------------------------
 售后服务系统 - 让工作更加灵活便捷

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/
namespace app\admin\model;
use think\Model;
use think\Db;
class Privilege extends Model{
    public function priTree($map){
        $data =  Db::name('kpi_pri')->where($map)->select();
        return $this->_reSort($data);
    }
    
    //递归对所有分类排序
    private function _reSort($data,$parent_id=0,$level=0){
        static $ret=array();
        foreach ($data as $k => $v){
            if ($v['pid'] == $parent_id) {
                //把level值放到这个分类里
                $v['level']=$level;
                $ret[]=$v;
                //再找这个分类的子分类
                $this->_reSort($data, $v['id'],$level+1);
            }
        }
        return $ret;
    }
}
