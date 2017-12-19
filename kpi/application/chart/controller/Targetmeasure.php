<?php
/*--------------------------------------------------------------------
广汇KPI报表--税金测算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Targetmeasure extends Base{

    public function index(){
        $map = $this->search();
        //税金测算表
        $result = Db::name('kpi_taxmeasure')
                ->where($map)
                ->find();
        $data_list = $result ;
        $data_list['payable_tax'] = $result['sales_vat']-$result['keep_the_balance']-$result['current_deductible'];
        $data_list['construction_tax'] = round($data_list['payable_tax'] * 0.05,2);
        $data_list['eduadd_tax'] = round($data_list['payable_tax'] * 0.03,2);
        $data_list['eduadd_tax_c'] = round($data_list['payable_tax'] * 0.02,2);
        $data_list['total'] = $data_list['construction_tax'] + $data_list['eduadd_tax'] + $data_list['eduadd_tax_c'] + $result['other_taxes'];
        //报表审批是否通过
        $up['a.store_id']=$map['store_id'];
        $up['a.year']=$map['year'];
        $up['a.month']=$map['month'];
        $up['a.chart_deptclass_id']=35;
        $data_status=check_flow_month($up);
        
        $this -> assign('data_status',$data_status); //审批状态
        $this -> assign('data_list',$data_list);
            
        return view();
    }

    public function add(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['keep_the_balance'] = $data_add['keep_the_balance'];
            $data['sales_vat'] = $data_add['sales_vat'];
            $data['current_deductible'] = $data_add['current_deductible'];
            $data['other_taxes'] = $data_add['other_taxes'];

            $res = Db::name('kpi_taxmeasure')
                ->where('store_id',$data_add['store_id'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月数据已添加!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_taxmeasure')->insert($data);
                if($result){
                    $reslut['msg']='添加成功!';
                    $reslut['status']='1';
                    return json($reslut);
                }else{
                    $reslut['msg']='添加失败!';
                    $reslut['status']='0';
                    return json($reslut);
                }
            }
        }else{
            return view();
        }
    }
    
    /*生成查询条件*/
    private function search(){
        $where = array();
        $data = input('param.');
        if(empty($data['store_id'])){   //门店id
            $data['store_id'] = get_comlist()[0]['ID'];
            $where['store_id'] = $data['store_id'];
        }else{
            $where['store_id'] = $data['store_id'];
            $this->assign('sid',$data['store_id']);
        }
        if(empty($data['year'])){   //年份
            $year = date("Y");
            $where['year'] = $year;
        }else{
            $where['year'] = $data['year'];
            $this->assign('year',$where['year']);
        }
        if(empty($data['month'])){  //月份
            $year = date("m");
            $where['month'] = $year;
        }else{
            $where['month'] = $data['month'];
            $this->assign('month',$where['month']);
        }
        return $where;
    }
    
}