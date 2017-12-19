<?php

namespace Home\Model;
use Think\Model;

class CompanyModel extends CommonModel{

    protected $tableName = 'target_company';

    protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('company_name','require','金融公司必须填写',1) //必须验证
        );

     //自动完成添加
    protected $_auto = array ( 

        array('add_time','time',self::MODEL_BOTH,'function'), // 对add_time字段在添加的时候写入当前时间戳

        );

    public function companyList(){
        return $this -> where("is_del=0")->select();
    }
    
    //验证品牌唯一
    public function OnlyCompany($company_name){
        $Allcompany=$this -> where(array('company_name'=>$company_name,'is_del'=>0))->select();
        return $Allcompany;

    }
    //查找单条信息
    public function Singleinfo($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
    }

}