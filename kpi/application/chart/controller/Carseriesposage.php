<?php
/*--------------------------------------------------------------------
广汇KPI报表--车系库龄表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Carseriesposage extends Base{
    //车系库龄表
    public function index(){
        $where = array();
        $store_id = array();
        $store_id['store_id'] = input('param.store_id');
        $where=$this ->search();

        // //查询
        // if(request()->isPost()){
        //     $where = $this->search($store_id);
        //     //点击查询后仍然显示查询得店面
        //     $this->assign('search_id',$where);
        // }else{
        //     $where['store_id']=get_comlist()[0]['ID'];
        // }
        
        $carseriesposage = Db::name('kpi_carseriesposage')
                ->alias('a')                
                ->join('think_kpi_carseries s','s.id = a.carseries_id','LEFT')
                ->join('think_kpi_carbrand z','z.id = a.carbrand_id','LEFT')
                ->join('think_kpi_carsize c','c.id = a.carsize_id','LEFT')
                ->field('a.*,s.carseries_name,z.carbrand_name,c.carsize_name')
                ->where($where)
                ->select();
        $data = array();
        foreach ($carseriesposage as $k => $v) {
            $data[$v['carsize_name']] = $v;
            $data[$v['carsize_name']]['total_quantity'] = $v['three_num']+$v['threetosix_num']+$v['sixtotwelve_num']+$v['year_num'];
            $data[$v['carsize_name']]['aggregate_amount'] = $v['three_prices']+$v['threetosix_prices']+$v['sixtotwelve_prices']+$v['year_prices'];
        }
        foreach ($data as $k => $v) {
            foreach($v as $ko => $vo){
                if(!isset( $data['合计'][$ko])){
                    $data['合计'][$ko] = 0;
                }
                $data['合计'][$ko] += $vo;
            }
        }
        $this->assign('data',$data);
    
        //库存数量差异表
        $difference = Db::name('kpi_inventory_variance')
            ->where($where)
            ->select();
        $this->assign('difference',$difference);
    
        //在途表
        $carseriesposage_way = Db::name('kpi_carseriesposage_way')
                ->alias('a')                
                ->join('think_kpi_carseries s','s.id = a.finance_carseries_id','LEFT')                
                ->field('a.*,s.carseries_name as finance_carseries_name')
                ->where($where)
                ->select();
               
        $datalist = array();
        $datalist['finance_price'] = 0;    //财务在途不含税采购价合计
        foreach ($carseriesposage_way as $k => $v) {
                $datalist['finance_price'] += $v['finance_price'];
        }
        // $datalist['total_price'] = $data['合计']["aggregate_amount"] + $datalist['sale_price'];
        $this->assign('carseriesposage_way',$carseriesposage_way);
        $this->assign('datalist',$datalist);   
        
        //调节表
        $carseriesposage_adjust = Db::name('kpi_carseriesposage_adjust')
                ->select();
        $data_adjust = array();
        foreach($carseriesposage_adjust as $k => $v){
                $data_adjust[$v['name']]=$v;
        }
        
        // //报表审批是否通过
        $up['a.store_id']=$where['store_id'];
        $up['a.year']=$where['year'];
        $up['a.month']=$where['month'];
        $up['a.chart_deptclass_id']=33;
        $data_status=check_flow_month($up);
        $this -> assign('data_status',$data_status);//审批状态
        $this->assign('data_adjust',$data_adjust);        
        return view();
    }
    
    //根据车型查询厂家开票进货价格
    public function invoiceprice(){
        if(Request::instance()->isAjax()){
        $data=input('param.');
        $id=$data['id'];
        $res=Db::name('kpi_carsize')->field('invoice_price')->where('id',$id)->find();
        return json($res);
        }
    }
    
    //车系库龄表添加
    public function add(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.');
            $year = date("Y");
            $month = (int)date("m");
            $data['year'] = $year;
            $data['month'] = $month;
            $data['store_id'] = $data_add['store_id'];
            $data['carbrand_id'] = $data_add['carbrand_id'];
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['carsize_id'] = $data_add['carsize_id'];
            $data['three_num'] = $data_add['three_num'];
            $data['three_price'] = $data_add['three_price'];
            $data['three_prices'] = $data_add['three_prices'];
            $data['threetosix_num'] = $data_add['threetosix_num'];
            $data['threetosix_price'] = $data_add['threetosix_price'];
            $data['threetosix_prices'] = $data_add['threetosix_prices'];
            $data['sixtotwelve_num'] = $data_add['sixtotwelve_num'];
            $data['sixtotwelve_price'] = $data_add['sixtotwelve_price'];
            $data['sixtotwelve_prices'] = $data_add['sixtotwelve_prices'];
            $data['year_num'] = $data_add['year_num'];
            $data['year_price'] = $data_add['year_price'];
            $data['year_prices'] = $data_add['year_prices'];
            
            $map['year'] = $year;
            $map['month'] = $month;
            $map['store_id'] = $data_add['store_id'];
            $map['carsize_id'] = $data_add['carsize_id'];            
            $result_data = Db::name('kpi_carseriesposage')->where($map)->find();
            if(!empty($result_data)){
                $reslut['msg']='已录入数据请勿重复录入！';
                $reslut['status']='0';
                return json($reslut);
            }
            
            $res=Db::name('kpi_carseriesposage')->insert($data);
            if($res){
                $reslut['msg']='添加成功';
                $reslut['status']='1';
            }else{
                $reslut['msg']='添加失败';
                $reslut['status']='0';
            }
            return json($reslut);
        }else{
            $store=get_comlist();  //所属门店
            $this -> assign('stores',$store);
            return view();
        }
    }
    
    //在途表添加
    public function wayadd(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.');
//            $store_id = $data_add['store_id1'];      //单独提出前台传递的store_id
//            unset($data_add['store_id1']);           //删除前台传递过来的数组中的store_id，剩下的数组便于下一步遍历
//            $about = array();                    //定义一个新数组，用于后面插入数据
//            foreach($data_add as $k => $v){         //遍历前台有用数据
//                            $about[$k] = $v;                 //向about数组中赋值（前台传递的数据）
//                            $about[$k]['store_id'] = $store_id;     //向about数组中赋值（前台传递的store_id）
//                            $about[$k]['year'] = date('Y');         //向about数组中赋值（当前年）
//                            $about[$k]['month'] = date('m');;       //向about数组中赋值（当前月）
//                    }
            $store_id = $data_add['store_id1']; 
            unset($data_add['store_id1']); 
            unset($data_add['carbrand_id']);
            $about = array();
            foreach ($data_add as $k => $v) {
                foreach ($v as $ko => $vo){
                    $insert[$ko][$k] = $vo;
                }
            }
            foreach ($insert as $k => $v) {
                $about[$k] = $v; 
                $about[$k]['store_id'] = $store_id;     //向about数组中赋值（前台传递的store_id）
                $about[$k]['year'] = date('Y');         //向about数组中赋值（当前年）
                $about[$k]['month'] = date('m');;       //向about数组中赋值（当前月）
            }
//            $once_add = Db::name('kpi_carseriesposage_way')->where('year',date('Y'))->where('month',date('m'))->where('store_id',$store_id)->select();       //查找表中是否已经添加过当月的数据
//            if(!empty($once_add)){                      //如果数据已经存在，返回一个提示
//                            $reslut['msg']='本月已经新增过数据!';
//                            $reslut['status']='0';
//                            return json($reslut);
//            }else{
                foreach($about as $v){
                            $res = Db::name('kpi_carseriesposage_way')->insert($v);      //插入数据
                            if(!$res){                              //如果插入失败，返回一个失败提示
                                    $reslut['msg']='添加失败!';
                                    $reslut['status']='0';
                                    return json($reslut);
                            }
                }
//            }            
            $reslut['msg']='添加成功';              //添加成功后执行
            $reslut['status']='1';
            return json($reslut);
//            $year = date("Y");
//            $month = (int)date("m");
//            $data['year'] = $year;
//            $data['month'] = $month;
//            $data['store_id'] = $data_add['store_id'];
//            $data['finance_carseries_id'] = $data_add['finance_carseries_id'];
//            $data['finance_vin'] = $data_add['finance_vin'];
//            $data['finance_price'] = $data_add['finance_price'];
//            $data['sale_carseries_id'] = $data_add['sale_carseries_id'];
//            $data['sale_vin'] = $data_add['sale_vin'];
//            $data['sale_price'] = $data_add['sale_price'];
//            $data['pay_carseries_id'] = $data_add['pay_carseries_id'];
//            $data['pay_vin'] = $data_add['pay_vin'];
//            $data['pay_price'] = $data_add['pay_price'];
//            
//            $map['year'] = $year;
//            $map['month'] = $month;
//            $map['store_id'] = $data_add['store_id'];
//            $result_data=Db::name('kpi_carseriesposage_way')->where($map)->find();
//            if(!empty($result_data)){
//                $reslut['msg']='已录入数据请勿重复录入！';
//                $reslut['status']='0';
//                return json($reslut);
//            }            
//            $res=Db::name('kpi_carseriesposage_way')->insert($data);
//            
//            if($res){
//                $reslut['msg']='添加成功';
//                $reslut['status']='1';
//            }else{
//                $reslut['msg']='添加失败';
//                $reslut['status']='0';
//            }
//            return json($reslut);
        }else{
            $store=get_comlist();  //所属门店
            $this -> assign('stores',$store);
            return view();
        }
    }
    
    //库存数量差异添加
    public function difadd(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.');
            $data['store_id'] = $data_add['store_id']; 
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];
            $data['financial_inventory'] = $data_add['financial_inventory'];
            $data['sales_inventory'] = $data_add['sales_inventory'];
            $data['difference'] = $data_add['difference'];
            $data['remarks'] = $data_add['remarks'];
            $res=Db::name('kpi_inventory_variance')
                ->where('store_id',$data_add['store_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $reslut = Db::name('kpi_inventory_variance')->insert($data);            
                if($reslut){
                    $reslut['msg']='添加成功';
                    $reslut['status']='1';
                }else{
                    $reslut['msg']='添加失败';
                    $reslut['status']='0';
                }
                return json($reslut);
            }                       
        }else{
            $store=get_comlist();  //所属门店
            $this -> assign('stores',$store);
            return view();
        }
    }
    
    //查询
    // public function search($store_id){        
    //     $map = array();
    //     if(!empty($store_id['store_id'])){            
    //         $map['store_id'] = $store_id['store_id'];
    //     }
    //     return $map;
    // }
    function search(){
        $map = array();
        $data = input('param.');
        if(empty($data['store_id'])){
            $store_id = get_comlist()[0]['ID'];
            $map['store_id'] = $store_id;
        }else{
            $map['store_id'] = $data['store_id'];
            $this->assign('sid',$data['store_id']);
        }
        if(empty($data['year'])){
            $map['year'] = (int)date('Y');
        }else{
            $map['year'] = $data['year'];
            $this->assign('year',$data['year']);
        }
        if(empty($data['month'])){
            $map['month'] = (int)date('m');
        }else{
            $map['month'] = $data['month'];
            $this->assign('month',$data['month']);
        }
        return $map;
    }
}