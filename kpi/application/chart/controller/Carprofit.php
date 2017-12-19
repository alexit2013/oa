<?php
/*--------------------------------------------------------------------
广汇KPI报表--整车毛利测算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;

class Carprofit extends Base{

    public function index(){

//        $where = array();
//        $store_id = array();
//        $store_id['store_id'] = input('param.store_id');
        
        //查询
//        if(request()->isPost()){
//            $where = $this->search($store_id);
//            //点击查询后仍然显示查询得店面
//            $this->assign('search_id',$where);
//        }
        $map = $this->search();
            
        //整车毛利计算表
        $result = Db::name('kpi_carprofit')
                ->alias('a')
                ->join('think_kpi_carsize z','z.id = a.carsize_id','LEFT')
                ->join('think_kpi_carseries s','s.id = z.carseries_id','LEFT')
                ->field('a.id,s.carseries_name as carseries_name,
                        z.carsize_name as carsize_name,
                        z.guide_price as guide_price,
                        a.qzjj,
                        a.qzcb,
                        a.zslb,
                        a.zscb,
                        z.invoice_price as invoice_price,
                        a.cash_transfer as cash_transfer,
                        a.expect_sales as expect_sales')
                ->where($map)
                ->select();
        $sum_expect_sales = 0;  //总预计销售台次
        $sum_income = 0;        //总收入
        $sum_cost = 0;          //总成本
        $sum_profit = 0;        //总毛利额
        $sum_spread = 0;        //毛利进销差额
        $data = array();
        foreach ($result as $k => $v) {
            $data[$v['carseries_name']][$k]['id'] = $v['id'];
            $data[$v['carseries_name']][$k]['carsize_name'] = $v['carsize_name'];     //车型名
            $data[$v['carseries_name']][$k]['guide_price'] = $v['guide_price'];       //厂家指导价
            $data[$v['carseries_name']][$k]['invoice_price'] = $v['invoice_price'];   //厂家开票进货价格
            $data[$v['carseries_name']][$k]['cash_transfer'] = $v['cash_transfer'];   //现金折让
            $data[$v['carseries_name']][$k]['expect_sales'] = $v['expect_sales'];     //预算销售台数
            $data[$v['carseries_name']][$k]['qzjj'] = $v['qzjj'];
            $data[$v['carseries_name']][$k]['qzcb'] = $v['qzcb'];
            $data[$v['carseries_name']][$k]['zslb'] = $v['zslb'];
            $data[$v['carseries_name']][$k]['zscb'] = $v['zscb'];
            $data[$v['carseries_name']][$k]['base_profit'] = $v['guide_price'] - $v['invoice_price'];  //基本毛利
            $data[$v['carseries_name']][$k]['sale_price'] = $v['guide_price']+$v['qzjj']-$v['cash_transfer'];    //销售价格
            $data[$v['carseries_name']][$k]['single'] = $v['guide_price']+$v['qzjj']-$v['cash_transfer']-$v['invoice_price'];    //单车毛利额
            $data[$v['carseries_name']][$k]['single_lv'] = ((round(($v['guide_price']+$v['qzjj']-$v['cash_transfer']-$v['invoice_price'])/($v['guide_price']-$v['cash_transfer']),4))*100).'%';  //单车毛利率
            $data[$v['carseries_name']][$k]['income'] = round((($v['guide_price']+$v['qzjj']-$v['cash_transfer'])*$v['expect_sales'])/1.17,2);    //收入
            $data[$v['carseries_name']][$k]['cost'] = round(($v['invoice_price']*$v['expect_sales'])/1.17,2);    //成本
            $data[$v['carseries_name']][$k]['profit'] = round((($v['guide_price']+$v['qzjj']-$v['cash_transfer']-$v['invoice_price'])*$v['expect_sales'])/1.17,2);      //毛利额
            if($data[$v['carseries_name']][$k]['profit'] > 0){
                $data[$v['carseries_name']][$k]['profit_cha'] = ((round(((($v['guide_price']+$v['qzjj']-$v['cash_transfer']-$v['invoice_price'])*$v['expect_sales'])/1.17)/((($v['guide_price']-$v['cash_transfer'])*$v['expect_sales'])/1.17),4))*100).'%';      //毛利进销差额
            }else{
                $data[$v['carseries_name']][$k]['profit_cha'] = 0;
            }
            
            $sum_expect_sales += $v['expect_sales'];   //总预计销售台次
            $sum_income += (($v['guide_price']+$v['qzjj']-$v['cash_transfer'])*$v['expect_sales'])/1.17;    //总收入
            $sum_cost += ($v['invoice_price']*$v['expect_sales'])/1.17;    //总成本
            $sum_profit += (($v['guide_price']+$v['qzjj']-$v['cash_transfer']-$v['invoice_price'])*$v['expect_sales'])/1.17;      //总毛利额
            
            $sum_spread = $sum_profit/$sum_income;     //毛利进销差额

        }
        $sum_data = array();
        $sum_data['sum_expect_sales'] = round($sum_expect_sales,2);     //总预计销售台次
        $sum_data['sum_income'] = round($sum_income,2);                 //总收入
        $sum_data['sum_cost'] = round($sum_cost,2);                     //总成本
        $sum_data['sum_profit'] = round($sum_profit,2);                 //总毛利额
        $sum_data['sum_spread'] = ((round($sum_spread,4))*100).'%';     //毛利进销差额

        //报表审批是否通过
        $up['a.store_id']=$map['store_id'];
        $up['a.year']=$map['year'];
        $up['a.month']=$map['month'];
        $up['a.chart_deptclass_id']=15;
        $data_status=check_flow_month($up);
             
        $this->assign('sum_data',$sum_data);        //合计
        $this->assign('data_list',$data);           //13个月预计实际数据
        $this->assign('data_status',$data_status); //审批状态
        return view();
    }

    //整车毛利计算表数据收集页（新增）
    public function add(){
        //品牌下拉框
        $list = get_comlist();
        //默认查询当前店面
        $store_id = array('store_id' => $list[0]['ID'],'store_name' => $list[0]['NAME']);
        
        $this->assign('store_id',$store_id);
        if(request()->isPost()){
            $data_add = input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['carbrand_id'] = $data_add['carbrand'];
            $data['carseries_id'] = $data_add['carseries'];
            $data['carsize_id'] = $data_add['carsize'];
            $data['cash_transfer'] = $data_add['cash_discount'];
            $data['expect_sales'] = $data_add['projected_sale'];
            $data['qzjj'] = $data_add['qzjj'];
            $data['qzcb'] = $data_add['qzcb'];
            $data['zslb'] = $data_add['zslb'];
            $data['zscb'] = $data_add['zscb'];
            $data['year'] = $data_add['iyear'];
            $data['month'] = $data_add['imonth'];
            $result = Db::name('kpi_carprofit')->insert($data);
            
            if($result){
                $this->success('新增成功','Carprofit/index');
            }else{
                $this->error('新增失败');
            }
        }
        return view();
    }
    
//    //查询
//    public function search($store_id){        
//        $map = array();
//        if(!empty($store_id['store_id'])){            
//            $map['store_id'] = $store_id['store_id'];
//        }
//        return $map;
//    }
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