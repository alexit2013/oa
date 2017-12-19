<?php
namespace Home\Model;
use Think\Model;

class LibraryModel extends CommonModel{

    protected $tableName = 'target_library';

    protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('library_title','require','验证码必须',1) //必须验证
        );

     //自动完成添加
    protected $_auto = array (

        array('add_time','time',self::MODEL_BOTH,'function'), // 对add_time字段在添加的时候写入当前时间戳

        );

    public function libraryList(){
        return $this -> where("is_del=0")->select();
    }

    //验证品牌唯一
    public function OnlyLibrary($library_title){
        $AllLibrary=$this -> where(array('library_title'=>$library_title,'is_del'=>0))->select();
        return $AllLibrary;

    }
    //查找单条信息
    public function Singleinfo($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
    }

}