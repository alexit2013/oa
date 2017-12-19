<?php
namespace Home\Model;
use Think\Model;

class CarseriesModel extends CommonModel{ 

    protected $tableName = 'target_carseries';

    protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('carseries_name','require','车系必须填写',1), //必须验证
        array('carbrand_id','/\d/','品牌不正确',self::EXISTS_VALIDATE,'regex',self::MODEL_BOTH)// 在修改新增的时候验证字段是否符合类型)
        );
    //自动完成添加
    protected $_auto = array ( 

        array('add_time','time',self::MODEL_BOTH,'function'), // 对add_time字段在添加的时候写入当前时间戳

        );   
     //列表
    public  function SeriesList(){
        $Overbrand=$this ->alias('a')
                ->field('a.*,b.carbrand_name')
                ->join("LEFT JOIN think_target_carbrand b ON a.carbrand_id=b.id")
                -> where("a.is_del=0")
                ->select();
            return $Overbrand;
    }
    //所有品牌
    public function AllBrand(){
       return $this -> table('think_target_carbrand')->where("is_del=0")->getField("id,carbrand_name");
    }
    //单一车系(添加)
    public function Onlyseries(){
         $Allseries=$this -> where(array('carseries_name'=>$carseries_name,'is_del'=>0))->select();
        return $Allseries;
    }
     //单一车系(修改)
     public function SingleSeries($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
     }
}