<?php

namespace Home\Model;
use Think\Model;

class CarsizeModel extends CommonModel{

    protected $tableName = 'target_carsize';

    protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('carsize_name','require','车型必须',1), //必须验证
        array('carbrand_id','/\d/','车系不正确',self::EXISTS_VALIDATE,'regex',self::MODEL_BOTH)// 在修改新增的时候验证字段是否符合类型)
        );


     //自动完成添加
    protected $_auto = array (

        array('add_time','time',self::MODEL_BOTH,'function'), // 对add_time字段在添加的时候写入当前时间戳

        );

    public function carsizeList(){
        return $this -> where("is_del=0")->select();
    }
    //所有车系
    public function Allserise(){
        return $this -> table('think_target_carseries')->where("is_del=0")->getField("id,carseries_name");
    }
    //验证车型唯一
    public function Onlysize($carsize_name){
        $OverSize=$this -> where(array('carsize_name'=>$carsize_name,'is_del'=>0))->select();
        return $OverSize;

    }
    //列表
    public function SizeList(){
        $OverSize=$this ->alias('a')
                ->field('a.*,b.carseries_name')
                ->join("LEFT JOIN think_target_carseries b ON a.carseries_id=b.id")
                -> where("a.is_del=0")
                ->select();
            return $OverSize;
    }
    //查找单条信息
    public function Singleinfo($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
    }

}