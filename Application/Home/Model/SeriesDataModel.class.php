<?php
namespace Home\Model;
use Think\Model;

class SeriesDataModel extends CommonModel{ 

    protected $tableName = 'target_seriesdata';

    protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('dept_id','require','台数',1) //必须验证
        );

     //自动完成添加
    protected $_auto = array (

        array('add_time','time',self::MODEL_BOTH,'function'), // 对add_time字段在添加的时候写入当前时间戳

        );

    public function SeriesdataList(){
        return $this ->alias('a')
                ->field('a.*,b.NAME as dept_name,f.carbrand_name,j.carseries_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carserie_id=j.id')
                ->select();
    }

    // //验证品牌唯一
    // public function OnlyBrand($carbrand_name){
    //     $AllBrand=$this -> where(array('carbrand_name'=>$carbrand_name,'is_del'=>0))->select();
    //     return $AllBrand;

    // }
    //全部店面列表
    public function Alldept(){
        return $this -> table('think_dept')->where("pid=1")->getField("id,name");
    } 

    //品牌列表
    public function Allcarbrand(){
        return $this -> table('think_target_carbrand')->where("is_del=0")->getField("id,carbrand_name");
    }
    //车系列表
    public function Allcarseries(){
        return $this -> table('think_target_carseries')->where("is_del=0")->getField("id,carseries_name");
    }
    //查找单条信息
    public function Singleinfo($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
    }

}