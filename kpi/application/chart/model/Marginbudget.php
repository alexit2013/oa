<?php

/*--------------------------------------------------------------------
 kpi- 月毛利率预算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\model;
use think\Model;
use think\Db;

class Marginbudget extends Model{
    /*月销售正常毛利率*/
    function monthsalemargin($map){
        foreach ($map as $k => $v){
            $where['kc.'.$k] = $v;
        }
        $month_carprofit = Db::name('kpi_month_carprofit')->alias('kc')
                ->field('c.carseries_name,kc.expect_num,kc.actual_num,kc.expect_margin,kc.actual_margin,kc.expect_marginprofit,kc.actual_marginprofit,kc.id')
                ->join('think_kpi_carseries c','c.id=kc.carseries_id','LEFT')
                ->where($where)->select();
        $carprofit =Db::name('kpi_carprofit')->alias('kc')
                ->field('c.carseries_name,kc.carsize_id,s.guide_price,s.invoice_price,kc.cash_transfer,kc.expect_sales,kc.qzjj')
                ->join('think_kpi_carseries c','c.id=kc.carseries_id','LEFT')
                ->join('think_kpi_carsize s','s.id=kc.carsize_id','LEFT')
                ->where($where)->select();
        $carprofit_list = array();
        foreach ($carprofit  as $k=>$v) {
            $carprofit_list[$k]['carseries_name'] = $v['carseries_name'];
            $carprofit_list[$k]['carsize_id'] = $v['carsize_id'];
            $carprofit_list[$k]['guide_price'] = $v['guide_price']/10000;
            $carprofit_list[$k]['invoice_price'] = $v['invoice_price']/10000;
            $carprofit_list[$k]['cash_transfer'] = $v['cash_transfer']/10000;
            $carprofit_list[$k]['expect_sales'] = $v['expect_sales'];
            $carprofit_list[$k]['qzjj'] = $v['qzjj']/10000;
        }
        $data_list = array();
        foreach($month_carprofit as $v){
            $carseries_name = $v['carseries_name'];
            unset($v['carseries_name']);
            $data_list[$carseries_name] = $v;
        }
        foreach ($carprofit_list as $v){
            if(!isset($data_list[$v['carseries_name']]['sale_num'])){
                $data_list[$v['carseries_name']]['sale_num'] = 0; //销售台数
            }
            $data_list[$v['carseries_name']]['sale_num']+=$v['expect_sales'];   //销售台数合计
            if(!isset($data_list[$v['carseries_name']]['purchase_price'])){
                $data_list[$v['carseries_name']]['purchase_price'] = 0; //进价合计
            }
            $data_list[$v['carseries_name']]['purchase_price'] += round(($v['invoice_price']*$v['expect_sales'])/1.17,2);   //进价合计
            if(!isset($data_list[$v['carseries_name']]['income'])){
                $data_list[$v['carseries_name']]['income'] = 0; //收入合计
            }
            $data_list[$v['carseries_name']]['income'] += round((($v['guide_price']+$v['qzjj']-$v['cash_transfer'])*$v['expect_sales'])/1.17,2);   //收入合计
        }
        return $data_list;
    }
    /*返利*/
    function fanli($map){
        foreach ($map as $k => $v) {
            $where['r.'.$k]=$v;
        }
        $res = $this->fanli_sql($where);
        $data=array();
        foreach ($res as $v) {
            
            if($v['type']=='2'){
                if(!isset($data[$v['rebate_name']]['expect'])){
                    $data[$v['rebate_name']]['expect'] = 0;
                }
                $data[$v['rebate_name']]['expect'] += round($v['sales_num']*$v['rebate_val']/1.17/10000,2);
                
            }                    
        }
        if($where['r.month'] == 1){
            $where['r.month'] = 12;
            $where['r.year'] = $where['r.year']-1;
        } else {
            $where['r.month'] = $where['r.month']-1;
        }
        $res2 = $this->fanli_sql($where);
        foreach ($res2 as $v){
            if($v['type']=='1'){
                if(!isset($data[$v['rebate_name']]['actual_last'])){
                        $data[$v['rebate_name']]['actual_last'] = 0;
                    }
                    $data[$v['rebate_name']]['actual_last']+=round($v['sales_num']*$v['rebate_val']/1.17/10000,2);
            }        
            if($v['type']=='2'){
                if(!isset($data[$v['rebate_name']]['expect_last'])){
                        $data[$v['rebate_name']]['expect_last'] = 0;
                    }
                    $data[$v['rebate_name']]['expect_last']+=round($v['sales_num']*$v['rebate_val']/1.17/10000,2);
            }          
        }
        return $data;
    }
    function fanli_sql($where){
        $res=Db::name('kpi_rebatename_val')->alias('rv')
            ->join('think_kpi_rebate r','rv.rebate_id=r.id','LEFT')
            ->field('rebate_name,rebate_val,sales_num,type')
            ->where($where)
            ->select();
        return $res;
    }
    function funli_tot($map){
        $res = $this->fanli($map);
        $sum = array();
        foreach ($res as  $v){
            if(!isset($sum['expect'])){
                $sum['expect']=0;
            }
            if(!isset($sum['expect_last'])){
                $sum['expect_last']=0;
            }
            if(!isset($sum['actual_last'])){
                $sum['actual_last']=0;
            }
            if(!empty($v['expect'])){
                $sum['expect'] += $v['expect'];
            }
            if(!empty($v['expect_last'])){
                $sum['expect_last'] += $v['expect_last'];
            }
            if(!empty($v['actual_last'])){
                $sum['actual_last'] += $v['actual_last'];
            }
        }
        return $sum;
    }
    /*预估返利*/
    function yufanli($map){
        $list1 = Db::name('kpi_rebate_des')->field('s_rebate,m_rebate,type,j_rebate,d_rebate,dq_rebate,q_rebate')->where($map)->select();
        $where['store_id'] = $map['store_id'];
        if($map['month'] == 1){
            $where['year'] = $map['year']-1;
            $where['month'] = 12;
        }else{
            $where['year'] = $map['year'];
            $where['month'] = $map['month']-1;
        }
        $list2 = Db::name('kpi_rebate_des')->field('s_rebate,m_rebate,type,j_rebate,d_rebate,dq_rebate,q_rebate')->where($where)->select();
        $data_list = array();
        foreach ($list1 as $v){
            if($v['type'] == '2' || $v['type'] == 2){
                $data_list['当期市场推广类预估返利']['expect'] = round($v['s_rebate']/10000/1.17,2);
                $data_list['当期满意度类预估返利']['expect'] = round($v['m_rebate']/10000/1.17,2);
                $data_list['当期日常检查类预估返利']['expect'] = round($v['j_rebate']/10000/1.17,2);
                $data_list['当期大客户类预估返利']['expect'] = round($v['d_rebate']/10000/1.17,2);
                $data_list['当期其他类预估返利']['expect'] = round($v['dq_rebate']/10000/1.17,2);
                $data_list['前期未预估的补估返利']['expect'] = round($v['q_rebate']/10000/1.17,2);
            }
        }
        foreach ($list2 as $v){
            if($v['type'] == '2' || $v['type'] == 2){
                $data_list['当期市场推广类预估返利']['expect_last'] = round($v['s_rebate']/10000/1.17,2);
                $data_list['当期满意度类预估返利']['expect_last'] = round($v['m_rebate']/10000/1.17,2);
                $data_list['当期日常检查类预估返利']['expect_last'] = round($v['j_rebate']/10000/1.17,2);
                $data_list['当期大客户类预估返利']['expect_last'] = round($v['d_rebate']/10000/1.17,2);
                $data_list['当期其他类预估返利']['expect_last'] = round($v['dq_rebate']/10000/1.17,2);
                $data_list['前期未预估的补估返利']['expect_last'] = round($v['q_rebate']/10000/1.17,2);
            }
            if($v['type'] == '1' || $v['type'] == 1){
                $data_list['当期市场推广类预估返利']['actual_last'] = round($v['s_rebate']/10000/1.17,2);
                $data_list['当期满意度类预估返利']['actual_last'] = round($v['m_rebate']/10000/1.17,2);
                $data_list['当期日常检查类预估返利']['actual_last'] = round($v['j_rebate']/10000/1.17,2);
                $data_list['当期大客户类预估返利']['actual_last'] = round($v['d_rebate']/10000/1.17,2);
                $data_list['当期其他类预估返利']['actual_last'] = round($v['dq_rebate']/10000/1.17,2);
                $data_list['前期未预估的补估返利']['actual_last'] = round($v['q_rebate']/10000/1.17,2);
            }
        }
        return $data_list;
    }
    /*装饰业务-分类*/
    function decorate_class($map){
        $list = Db::name('kpi_month_decorate_class')->where($map)->select();
        $data_list = array();
        foreach($list as $v){
            $data_list[$v['class_name']]['id'] = $v['id'];
            $data_list[$v['class_name']]['expect_income'] = $v['expect_income'];
            $data_list[$v['class_name']]['actual_income'] = $v['actual_income'];
            $data_list[$v['class_name']]['actual_margin'] = $v['actual_margin'];
            $data_list[$v['class_name']]['expect_margin'] = $v['expect_margin'];
            if(empty($v['expect_income']) || $v['expect_income']==0 ){
                $data_list[$v['class_name']]['expect_marginprofit'] = 0;
            }else{
                $data_list[$v['class_name']]['expect_marginprofit'] = @round(($v['expect_margin']/$v['expect_income'])*100,2);
            }
            if(empty($v['actual_income']) || $v['actual_income']==0){
                $data_list[$v['class_name']]['actual_marginprofit'] = 0;
            }else{
                $data_list[$v['class_name']]['actual_marginprofit'] = @round(($v['actual_margin']/$v['actual_income'])*100,2);
            }
            $data_list[$v['class_name']]['cost'] = $v['cost']; 
            $data_list[$v['class_name']]['income'] = $v['income'];
            $data_list[$v['class_name']]['margin'] = $v['income']-$v['cost'];
            if(empty($v['income']) || $v['income']==0){
                $data_list[$v['class_name']]['marginprofig'] = 0;
            }else{
                $data_list[$v['class_name']]['marginprofig'] = @round(($data_list[$v['class_name']]['margin']/$v['income'])*100,2);
            }
            
            foreach ($v as $ko => $vo) {
                if($ko == 'expect_income' || $ko == 'actual_income' || $ko == 'actual_margin' || $ko == 'expect_margin' || $ko == 'cost' || $ko == 'income'){
                    if(!isset($data_list['小计'][$ko])){
                        $data_list['小计'][$ko] = 0;
                    }
                    $data_list['小计'][$ko] += $v[$ko];
                }
            }
            if(!isset($data_list['小计']['margin'])){
                $data_list['小计']['margin'] = 0;
            }
            $data_list['小计']['margin'] += $data_list[$v['class_name']]['margin'];
        }
        return $data_list;
    }
    /*新保业务*/
    function insurance($map){
        $list = Db::name('kpi_month_insurance')->where($map)->select();
        $data_list['class'] = array();
        foreach ($list as $v){
            $data_list['class'][$v['class_name']]['id'] = $v['id'];
            $data_list['class'][$v['class_name']]['expect_num_last'] = $v['expect_num_last'];
            $data_list['class'][$v['class_name']]['actual_num_last'] = $v['actual_num_last'];
            $data_list['class'][$v['class_name']]['expect_income_last'] = $v['expect_income_last'];
            $data_list['class'][$v['class_name']]['actual_income_last'] = $v['actual_income_last'];
            $data_list['class'][$v['class_name']]['expect_num'] = $v['expect_num'];
            $data_list['class'][$v['class_name']]['cost'] = $v['cost'];
            $data_list['class'][$v['class_name']]['income'] = $v['income'];
            $data_list['class'][$v['class_name']]['margin'] = $v['income']-$v['cost'];
            if(empty($v['income']) || $v['income']==0){
                $data_list['class'][$v['class_name']]['marginprofig']=0;
            }else{
                $data_list['class'][$v['class_name']]['marginprofig'] = @round(($data_list['class'][$v['class_name']]['margin']/$v['income'])*100,2);
            }
        }
        $data = Db::name('kpi_month_insurance_target')->where($map)->find();
        $data_list['target'] = $data;
        return $data_list;
    }
    /*新车延保*/
    function newcar($map){
        $list = Db::name('kpi_month_newcar')->where($map)->select();
        $data_list['class'] = array();
        
        foreach ($list as $k => $v) {
            $data_list['class'][$v['class_name']]['id'] = $v['id'];
            $data_list['class'][$v['class_name']]['cost'] = $v['cost'];
            $data_list['class'][$v['class_name']]['income'] = $v['income'];
            $data_list['class'][$v['class_name']]['margin'] = $v['income']-$v['cost'];
            if($v['class_name']=='新车延保'){
                $data_list['class'][$v['class_name']]['expect_num_last'] = $v['expect_num_last'];
                $data_list['class'][$v['class_name']]['actual_num_last'] = $v['actual_num_last'];
                $data_list['class'][$v['class_name']]['expect_income_last'] = $v['expect_income_last'];
                $data_list['class'][$v['class_name']]['actual_income_last'] = $v['actual_income_last'];
                $data_list['class'][$v['class_name']]['expect_num'] = $v['expect_num'];
            }
            if($v['class_name']=='人工成本'){
                $data_list['class'][$v['class_name']]['expect_margin'] = $v['expect_margin'];
                $data_list['class'][$v['class_name']]['actual_margin'] = $v['actual_margin'];
            }
            if($v['class_name']=='新车延保'||$v['class_name']=='小计'){
                if(empty($v['income']) || $v['income']==0){
                    $data_list['class'][$v['class_name']]['marginprofit'] = 0;
                }else{
                   $data_list['class'][$v['class_name']]['marginprofit'] = @round(($data_list['class'][$v['class_name']]['margin']/$v['income'])*100,2);
                }
            }
        }
        return $data_list;
    }
    /*车贷业务*/
    function carloan($map){
        $list = Db::name('kpi_month_carloan')
                ->field('class_name,expect_income_last,actual_income_last,expect_margin,actual_margin,cost,income,id')
                ->where($map)->select();
        $data_list = array();
        foreach($list as $v){
            $class_name = $v['class_name'];
            unset($v['class_name']);
            $data_list[$class_name] = $v;
            if($class_name == '非租赁佣金(指厂家金融及银行按揭)' || $class_name == '租赁佣金'){
                $data_list[$class_name]['expect_margin'] = $v['expect_income_last']*0.81;
                $data_list[$class_name]['actual_margin'] = $v['actual_income_last']*0.81;
                $data_list[$class_name]['margin'] = $v['income']-$v['cost'];
                if(empty($v['cost']) || $v['cost']==0){
                    $data_list[$class_name]['marginprofit'] = 0;
                }else{
                    if($v['income']<=0){
                        $data_list[$class_name]['marginprofit'] = 0;
                    }else{
                        $data_list[$class_name]['marginprofit'] = @round(($data_list[$class_name]['margin']/$v['income'])*100,2);
                    }
                    
                }
            }
        }
        if(isset($data_list['小计'])){
            $data_list['小计']['expect_income_last']=$data_list['非租赁佣金(指厂家金融及银行按揭)']['expect_income_last']+$data_list['租赁佣金']['expect_income_last'];
            $data_list['小计']['actual_income_last']=$data_list['非租赁佣金(指厂家金融及银行按揭)']['actual_income_last']+$data_list['租赁佣金']['actual_income_last'];
            $data_list['小计']['expect_margin']=$data_list['非租赁佣金(指厂家金融及银行按揭)']['expect_margin']+$data_list['租赁佣金']['expect_margin']+$data_list['人工成本(提成)']['expect_margin'];
            $data_list['小计']['actual_margin']=$data_list['非租赁佣金(指厂家金融及银行按揭)']['actual_margin']+$data_list['租赁佣金']['expect_margin']+$data_list['人工成本(提成)']['actual_margin'];
            $data_list['小计']['income']=$data_list['非租赁佣金(指厂家金融及银行按揭)']['income']+$data_list['租赁佣金']['income'];
            $data_list['小计']['margin'] = $data_list['小计']['income']-$data_list['小计']['cost'];
            if(empty($data_list['小计']['cost']) || $data_list['小计']['cost']==0){
                $data_list['小计']['marginprofit'] =0;
            }else{
                if($data_list['小计']['income']<=0){
                    $data_list['小计']['marginprofit'] = 0;
                }else{
                    $data_list['小计']['marginprofit'] = @round(($data_list['小计']['margin']/$data_list['小计']['income'])*100,2); 
                }
            }
        }
        return $data_list;
    }
    /*维修业务*/
    function repair($map){
        $list = Db::name('kpi_month_repair')->where($map)->select();
        $data_list = array();
        foreach ($list as $k => $v) {
            
            if($v['type'] == 1){
                $data_list['配件'][$v['class_name']]['id'] = $v['id'];
                $data_list['配件'][$v['class_name']]['expect_income_last'] = $v['expect_income_last'];
                $data_list['配件'][$v['class_name']]['actual_income_last'] = $v['actual_income_last'];
                $data_list['配件'][$v['class_name']]['expect_margin'] = $v['expect_margin'];
                $data_list['配件'][$v['class_name']]['actual_margin'] = $v['actual_margin'];
                if(empty($v['expect_income_last']) || $v['expect_income_last']==0){
                    $data_list['配件'][$v['class_name']]['expect_marginprofit'] =0;
                }else{
                    $data_list['配件'][$v['class_name']]['expect_marginprofit'] = @round(($v['expect_margin']/$v['expect_income_last'])*100,2);
                }
                if(empty($v['actual_income_last']) || $v['actual_income_last']==0){
                    $data_list['配件'][$v['class_name']]['actual_marginprofit'] = 0;
                }else{
                    $data_list['配件'][$v['class_name']]['actual_marginprofit'] = @round(($v['actual_margin']/$v['actual_income_last'])*100,2);
                }
                $data_list['配件'][$v['class_name']]['cost'] = $v['cost'];
                $data_list['配件'][$v['class_name']]['income'] = $v['income'];
                $data_list['配件'][$v['class_name']]['margin'] = $v['income']-$v['cost'];
                if(empty($v['income']) || $v['income']==0){
                    $data_list['配件'][$v['class_name']]['marginprofig'] = 0;
                }else{
                    $data_list['配件'][$v['class_name']]['marginprofig'] = @round(($data_list['配件'][$v['class_name']]['margin']/$v['income'])*100,2);
                }
                if(!isset($data_list['配件']['合计']['expect_income_last'])){
                    $data_list['配件']['合计']['expect_income_last'] = 0;
                }
                $data_list['配件']['合计']['expect_income_last'] += $v['expect_income_last'];
                
                if(!isset($data_list['配件']['合计']['actual_income_last'])){
                    $data_list['配件']['合计']['actual_income_last'] = 0;
                }
                $data_list['配件']['合计']['actual_income_last'] += $v['actual_income_last'];
                
                if(!isset($data_list['配件']['合计']['expect_margin'])){
                    $data_list['配件']['合计']['expect_margin'] = 0;
                }
                $data_list['配件']['合计']['expect_margin'] += $v['expect_margin'];
                
                if(!isset($data_list['配件']['合计']['actual_margin'])){
                    $data_list['配件']['合计']['actual_margin'] = 0;
                }
                $data_list['配件']['合计']['actual_margin'] += $v['actual_margin'];
                
                if(!isset($data_list['配件']['合计']['cost'])){
                    $data_list['配件']['合计']['cost'] = 0;
                }
                $data_list['配件']['合计']['cost'] += $v['cost'];
                
                if(!isset($data_list['配件']['合计']['income'])){
                    $data_list['配件']['合计']['income'] = 0;
                }
                $data_list['配件']['合计']['income'] += $v['income'];
            }else{
                if($v['type']==0){
                    if($v['class_name'] == '养护产品'){
                        $data_list[$v['class_name']]['repair_num'] = $v['repair_num'];
                    }
                    $data_list[$v['class_name']]['id'] = $v['id'];
                    $data_list[$v['class_name']]['expect_income_last'] = $v['expect_income_last'];
                    $data_list[$v['class_name']]['actual_income_last'] = $v['actual_income_last'];
                    if(empty($v['expect_income_last']) || $v['expect_income_last']==0){
                        $data_list[$v['class_name']]['expect_marginprofit'] = 0;
                    }else{
                        $data_list[$v['class_name']]['expect_marginprofit'] = @round(($v['expect_margin']/$v['expect_income_last'])*100,2);
                    }
                    if(empty($v['actual_income_last']) || $v['actual_income_last']==0){
                        $data_list[$v['class_name']]['actual_marginprofit'] = 0;
                    }else{
                        $data_list[$v['class_name']]['actual_marginprofit'] = @round(($v['actual_margin']/$v['actual_income_last'])*100,2);
                    }
                    
                    $data_list[$v['class_name']]['income'] = $v['income'];
                    $data_list[$v['class_name']]['margin'] = $v['income']-$v['cost'];
                    if(empty($v['income']) || $v['income']==0){
                        $data_list[$v['class_name']]['marginprofig'] = 0;
                    }else{
                        $data_list[$v['class_name']]['marginprofig'] = @round(($data_list[$v['class_name']]['margin']/$v['income'])*100,2);
                    }
                    
                }
                $data_list[$v['class_name']]['id'] = $v['id'];
                $data_list[$v['class_name']]['expect_margin'] = $v['expect_margin'];
                $data_list[$v['class_name']]['actual_margin'] = $v['actual_margin'];
                $data_list[$v['class_name']]['cost'] = $v['cost'];
            }
        }
       
        return $data_list;
    }
    /*三卡业务*/
    function three_card($map){
        $list = Db::name('kpi_month_three_card_business')->where($map)->select();
        $data_list = array();
        foreach ($list as $v) {
            $data_list[$v['class_name']]['id'] = $v['id'];
            $data_list[$v['class_name']]['expect_num_last'] = $v['expect_num_last'];
            $data_list[$v['class_name']]['actual_num_last'] = $v['actual_num_last'];
            $data_list[$v['class_name']]['expect_num_this'] = $v['expect_num_this'];            
        }
        return $data_list;
    }
    /*续保业务*/
    function renewal($map){
        $list = Db::name('kpi_month_renewal')->where($map)
                ->field('id,class_name,expect_num,actual_num,expect_income,actual_income,expect_carnum,cost,income,expect_margin,actual_margin')
                ->select();
        $data_list = array();
        foreach ($list as $v) {
            $class_name = $v['class_name'];
            unset($v['class_name']);
            $data_list[$class_name] = $v;
        }
        return $data_list;
    }
    /*非新车延保*/
    function non_newcar($map){
        $list = Db::name('kpi_month_non_newcar')->field('id,class_name,expect_num,actual_num,expect_income,actual_income,expect_carnum,cost,income,expect_margin,actual_margin,new_car_sales')->where($map)->select();
        $data_list = array();
        foreach($list as $v){
            $class_name = $v['class_name'];
            unset($v['class_name']);
            $data_list[$class_name] = $v;
        }
        return $data_list;
    }
    /*其他业务*/
    function other($map){
        $list = Db::name('kpi_month_other')
                ->field('id,class_name,expect_num_last,actual_num_last,expect_income_last,actual_income_last,change_num,sale_num,cost,income')
                ->where($map)->select();
        $data_list = array();
        foreach ($list as $v) {
            $class_name = $v['class_name'];
            unset($v['class_name']);
            $data_list[$class_name] = $v;
            $data_list[$class_name]['margin'] = $v['income']-$v['cost'];
        }
        if(isset($data_list['其它业务毛利'])){
            $data_list['其它业务毛利']['expect_income_last'] = $data_list['小计']['expect_income_last']+$data_list['人工成本']['expect_income_last'];
            $data_list['其它业务毛利']['actual_income_last'] = $data_list['小计']['actual_income_last']+$data_list['人工成本']['actual_income_last'];
            $data_list['其它业务毛利']['income'] = $data_list['二手车']['income']-$data_list['二手车']['cost']+$data_list['厂家延保']['income']+$data_list['服务费']['income']+$data_list['车辆入户费及档案费收入']['income']+$data_list['租金收入']['income']+$data_list['汇通租赁返手续费']['income'];
            $data_list['其它业务毛利']['margin'] = $data_list['其它业务毛利']['income']-$data_list['其它业务毛利']['cost'];
        }
        return $data_list;
    }
}