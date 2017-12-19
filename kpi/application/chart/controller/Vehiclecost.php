<?php
/*--------------------------------------------------------------------
广汇KPI报表--车辆费用表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Vehiclecost extends Base{

    public function index(){
        $where = array();

        // 查询
        $data_data = array();
        $date_data = input('param.');


        if(empty($date_data)){
            $date_data['store_id'] = get_comlist()[0]['ID'];
            $where['store_id'] = $date_data['store_id'];
            $where['year'] = date('Y');
            $where['month'] = date('m');
        }else{
            if(empty($date_data['store_id'])){
                $date_data['store_id']= get_comlist()[0]['ID'];
            }
            if(empty($date_data['year'])){
                $date_data['year'] = date('Y');
            }
            if(empty($date_data['month'])){
                $date_data['month'] = date('m');
            }
            $where['store_id'] = $date_data['store_id'];
            $where['year'] = $date_data['year'];
            $where['month'] = $date_data['month'];

            $this->assign('sid',$date_data['store_id']);
            $this->assign('year',$date_data['year']);
            $this->assign('smonth',$date_data['month']);

        }

        //4S店自用试乘试驾车
        $test_drive = Db::name('kpi_carfee_testdrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店使用中的试乘试驾车辆
        $vehicleuse = Db::name('kpi_carfee_vehicleuse')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店销售未使用试乘试驾车
        $sale_drive = Db::name('kpi_carfee_saledrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店自备经营用车
        $self_drive = Db::name('kpi_carfee_selfdrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店特殊车辆使用情况
        $special_drive = Db::name('kpi_carfee_specialdrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //财务帐面用车和实际车辆情况
        $finance_drive = Db::name('kpi_carfee_financedrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();
        //报表审批是否通过
        $up['a.store_id']=$where['store_id'];
        $up['a.year']=$where['year'];
        $up['a.month']=$where['month'];
        $up['a.chart_deptclass_id']=31;
        $data_status=check_flow_month($up);

        $this -> assign('data_status',$data_status); //审批状态
        $this->assign('test_drive',$test_drive);
        $this->assign('vehicleuse',$vehicleuse);
        $this->assign('sale_drive',$sale_drive);
        $this->assign('self_drive',$self_drive);
        $this->assign('special_drive',$special_drive);
        $this->assign('finance_drive',$finance_drive);

        return view();
    }

    public function demo(){
        $where = array();

        // 查询
        $data_data = array();
        $date_data = input('param.');


        if(empty($date_data)){
            $date_data['store_id'] = get_comlist()[0]['ID'];
            $where['store_id'] = $date_data['store_id'];
            $where['year'] = date('Y');
            $where['month'] = date('m');
        }else{
            if(empty($date_data['store_id'])){
                $date_data['store_id']= get_comlist()[0]['ID'];
            }
            if(empty($date_data['year'])){
                $date_data['year'] = date('Y');
            }
            if(empty($date_data['month'])){
                $date_data['month'] = date('m');
            }
            $where['store_id'] = $date_data['store_id'];
            $where['year'] = $date_data['year'];
            $where['month'] = $date_data['month'];

            $this->assign('sid',$date_data['store_id']);
            $this->assign('year',$date_data['year']);
            $this->assign('smonth',$date_data['month']);

        }

        //4S店自用试乘试驾车
        $test_drive = Db::name('kpi_carfee_testdrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店使用中的试乘试驾车辆
        $vehicleuse = Db::name('kpi_carfee_vehicleuse')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店销售未使用试乘试驾车
        $sale_drive = Db::name('kpi_carfee_saledrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店自备经营用车
        $self_drive = Db::name('kpi_carfee_selfdrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //4S店特殊车辆使用情况
        $special_drive = Db::name('kpi_carfee_specialdrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        //财务帐面用车和实际车辆情况
        $finance_drive = Db::name('kpi_carfee_financedrive')
            ->alias('a')
            ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
            ->where($where)
            ->field('a.*,b.carseries_name')
            ->select();

        $this->assign('test_drive',$test_drive);
        $this->assign('vehicleuse',$vehicleuse);
        $this->assign('sale_drive',$sale_drive);
        $this->assign('self_drive',$self_drive);
        $this->assign('special_drive',$special_drive);
        $this->assign('finance_drive',$finance_drive);

        return view();
    }

    public function testdriveadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');

            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['carnum'] =$data_add['carnum'];
            $data['buycartime'] =strtotime($data_add['buycartime']);
            $data['naked'] =$data_add['naked'];
            $data['price'] =$data_add['price'];
            $data['discount'] =$data_add['discount'];
            $data['plate'] =$data_add['plate'];
            $data['mileage'] =$data_add['mileage'];
            $data['enddate'] =strtotime($data_add['enddate']);
            $data['is_mana'] =$data_add['is_mana'];

            $res = Db::name('kpi_carfee_testdrive')
                ->where('store_id',$data_add['store_id'])
                ->where('carnum',$data_add['carnum'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';

            }else {
                $result = Db::name('kpi_carfee_testdrive')->insert($data);
                if (!empty($result)) {
                    $reslut['msg'] = '添加成功';
                    $reslut['status'] = '1';
                } else {
                    $reslut['msg'] = '添加失败!';
                    $reslut['status'] = '0';

                }
            }
            return json($reslut);
        }
    	return view();
    }
    
    public function vehicleuseadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['carnum'] =$data_add['carnum'];
            $data['buycartime'] =strtotime($data_add['buycartime']);
            $data['naked'] =$data_add['naked'];
            $data['price'] =$data_add['price'];
            $data['discount'] =$data_add['discount'];
            $data['plate'] =$data_add['plate'];
            $data['mileage'] =$data_add['mileage'];
            $data['enddate'] =strtotime($data_add['enddate']);
            $data['is_mana'] =$data_add['is_mana'];            
            $result = Db::name('kpi_carfee_vehicleuse')->insert($data);
            if($result){
                $reslut['msg']='添加成功';
                $reslut['status']='1';            
            }else{
                $reslut['msg']='添加失败';
                $reslut['status']='0';
            }
            return json($reslut);
        }
    	return view();
    }
    
    public function saledriveadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['carnum'] =$data_add['carnum'];
            $data['buycartime'] =strtotime($data_add['buycartime']);
            $data['naked'] =$data_add['naked'];
            $data['price'] =$data_add['price'];
            $data['discount'] =$data_add['discount'];
            $data['plate'] =$data_add['plate'];
            $data['saleprice'] =$data_add['saleprice'];
            $data['remark'] =$data_add['remark'];
            $res = Db::name('kpi_carfee_saledrive')
                ->where('store_id',$data_add['store_id'])
                ->where('carnum',$data_add['carnum'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';

            }else {
                $result = Db::name('kpi_carfee_saledrive')->insert($data);
                if (!empty($result)) {
                    $reslut['msg'] = '添加成功';
                    $reslut['status'] = '1';
                } else {
                    $reslut['msg'] = '添加失败!';
                    $reslut['status'] = '0';

                }
            }
            return json($reslut);
        }

    	return view();
    }
    
    public function selfdriveadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['carnum'] =$data_add['carnum'];
            $data['buycartime'] =strtotime($data_add['buycartime']);
            $data['naked'] =$data_add['naked'];
            $data['price'] =$data_add['price'];
            $data['discount'] =$data_add['discount'];
            $data['mileage'] =$data_add['mileage'];
            $data['month_mileage'] =$data_add['month_mileage'];
            $data['user'] =$data_add['user'];
            $res = Db::name('kpi_carfee_selfdrive')
                ->where('store_id',$data_add['store_id'])
                ->where('carnum',$data_add['carnum'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';

            }else {
                $result = Db::name('kpi_carfee_selfdrive')->insert($data);
                if (!empty($result)) {
                    $reslut['msg'] = '添加成功';
                    $reslut['status'] = '1';
                } else {
                    $reslut['msg'] = '添加失败!';
                    $reslut['status'] = '0';

                }
            }
            return json($reslut);
        }

    	return view();
    }
    
    public function specialdriveadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['carnum'] =$data_add['carnum'];
            $data['buycartime'] =strtotime($data_add['buycartime']);
            $data['naked'] =$data_add['naked'];
            $data['price'] =$data_add['price'];
            $data['discount'] =$data_add['discount'];
            $data['mileage'] =$data_add['mileage'];
            $data['month_mileage'] =$data_add['month_mileage'];
            $data['user'] =$data_add['user'];
            $res = Db::name('kpi_carfee_specialdrive')
                ->where('store_id',$data_add['store_id'])
                ->where('carnum',$data_add['carnum'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';

            }else {
                $result = Db::name('kpi_carfee_specialdrive')->insert($data);
                if (!empty($result)) {
                    $reslut['msg'] = '添加成功';
                    $reslut['status'] = '1';
                } else {
                    $reslut['msg'] = '添加失败!';
                    $reslut['status'] = '0';

                }
            }
            return json($reslut);
        }
    	return view();
    }
    
    public function financsdriveadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['finance_carnum'] =$data_add['finance_carnum'];
            $data['finance_buycartime'] =strtotime($data_add['finance_buycartime']);
            $data['finance_price'] =$data_add['finance_price'];
            $data['actual_carnum'] =$data_add['actual_carnum'];
            $data['actual_buycartime'] =strtotime($data_add['actual_buycartime']);
            $data['use'] =$data_add['use'];
            $data['difference'] =$data_add['difference'];
            $data['remark'] =$data_add['remark'];
                $result = Db::name('kpi_carfee_financedrive')->insert($data);
                if (!empty($result)) {
                    $reslut['msg'] = '添加成功';
                    $reslut['status'] = '1';
                } else {
                    $reslut['msg'] = '添加失败!';
                    $reslut['status'] = '0';

                }

            return json($reslut);
        }

    	return view();
    }
}