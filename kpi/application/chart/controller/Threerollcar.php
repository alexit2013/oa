<?php
/*--------------------------------------------------------------------
广汇KPI报表--三月滚动库存(整车)

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Threerollcar extends Base{

    public function index(){
        $where = array();        
        
        //查询
        $store_id = input('param.store_id');
        if(empty($store_id)){
            $store_id = get_comlist()[0]['ID'];
            $where['store_id'] = $store_id;
        }else{
            $where['store_id'] = $store_id;
            $this->assign('sid',$store_id);
        }
        //查询条件去年12月截止到下个月，用月份分组查询
        $year = input('param.year');    //获取年份
        if(empty($year)){
            $year = date("Y");
        }
        $lastyear = $year-1;
        $result = Db::name('kpi_threerollcar')
                ->alias('a')
                ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
                ->where('year = '.$lastyear.' AND month = 12 OR year ='.$year)
                ->where($where)
                ->field('a.*,b.carseries_name')
                ->select();
        $data = $this->_data_list($result,$year);
        $data_over = Db::name('kpi_threerollcar_over')
                ->where('year = '.$lastyear.' AND month = 12 OR year ='.$year)
                ->where($where)
                ->select();
        $data_over_list = $this->_data_over($data_over);
        if(!isset($data_over_list['over'])){
            $data_over_list['over'] = array();
        }
        if(!isset($data_over_list['finance'])){
            $data_over_list['finance'] = array();
        }
        if(!isset($data['data'])){
            $data['data'] = array();
        }
        if(!isset($data['id_key'])){
            $data['id_key'] = array();
        }
        //报表审批是否通过
        $up['a.store_id']=$where['store_id'];
        $up['a.year']=$year;
        $up['a.chart_deptclass_id']=13;
        $data_status=check_flow_year($up);
        $this->assign([
            'data_over' => $data_over_list['over'],   //超期
            'data_list' => $data['data'],   //车系数据
            'data_id'=>$data['id_key'], //数据id
            'finance' => $data_over_list['finance'],  //金融
            'year' => $year, //当前年份
            'data_status'=>$data_status //审批状态
        ]);
                    
        return view();
    }
    /*分类数据处理*/
    private function _data_list($data,$year){
        $type_arr = ['其他','销量','进车数量','期末库存'];
        $res = array();
        foreach($data as $v){
            $res['data'][$type_arr[$v['type']]][$v['carseries_name']][$v['year'].'-'.$v['month'].'|expect'] = $v['expect'];    //预计
            $res['data'][$type_arr[$v['type']]][$v['carseries_name']][$v['year'].'-'.$v['month'].'|actual']= $v['actual'];     //实际
            $res['id_key'][$type_arr[$v['type']]][$v['carseries_name']][$v['year'].'-'.$v['month'].'|expect'] = $v['id'];
            $res['id_key'][$type_arr[$v['type']]][$v['carseries_name']][$v['year'].'-'.$v['month'].'|actual'] = $v['id'];
        }

        if(isset($res['data']['期末库存'])){
            foreach($res['data']['期末库存'] as $ko => $vo){
                for($i=1;$i<=12;$i++){
                    if($i == 1){
                        if(isset($vo[($year-1)."-12|actual"]) && isset($res['data']['进车数量'][$ko][$year."-".$i."|expect"]) && isset($res['data']['销量'][$ko][$year."-".$i."|expect"])){
                            $res['data']['期末库存'][$ko][$year."-".$i."|expect"] = round($vo[($year-1)."-12|actual"]+$res['data']['进车数量'][$ko][$year."-".$i."|expect"]-$res['data']['销量'][$ko][$year."-".$i."|expect"],2);
                        } 
                        if(isset($vo[($year-1)."-12|actual"]) && isset($res['data']['进车数量'][$ko][$year."-".$i."|actual"]) && isset($res['data']['销量'][$ko][$year."-".$i."|actual"])){
                            $res['data']['期末库存'][$ko][$year."-".$i."|actual"] = round($vo[($year-1)."-12|actual"]+$res['data']['进车数量'][$ko][$year."-".$i."|actual"]-$res['data']['销量'][$ko][$year."-".$i."|actual"],2);
                        }
                    }else{
                        if(isset($res['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]) && isset($res['data']['进车数量'][$ko][$year."-".$i."|expect"])  && isset($res['data']['销量'][$ko][$year."-".$i."|expect"])){
                            $res['data']['期末库存'][$ko][$year."-".$i."|expect"] = round($res['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]+$res['data']['进车数量'][$ko][$year."-".$i."|expect"]-$res['data']['销量'][$ko][$year."-".$i."|expect"],2);
                        }
                        if(isset($res['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]) && isset($res['data']['进车数量'][$ko][$year."-".$i."|actual"]) && isset($res['data']['销量'][$ko][$year."-".$i."|actual"])){
                            $res['data']['期末库存'][$ko][$year."-".$i."|actual"] = round($res['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]+$res['data']['进车数量'][$ko][$year."-".$i."|actual"]-$res['data']['销量'][$ko][$year."-".$i."|actual"],2);
                        }
                    }
                }
            }
            foreach($res['data']['期末库存'] as $ko => $vo){
                foreach ($vo as $ki => $vi) {
                    if(!empty($res['data']['销量'][$ko][$ki])){
                        $res['data']['分车型库存当量'][$ko][$ki] = @round($res['data']['期末库存'][$ko][$ki]/$res['data']['销量'][$ko][$ki],2);
                    }
                }
            }
        }
        if(isset($res['data'])){
            foreach ($res['data'] as $k => $v) { //求合计
                foreach($v as $ko => $vo){
                    foreach ($vo as $ki => $vi) {
                        if(!isset($res['data'][$k]['total'][$ki])){
                            $res['data'][$k]['total'][$ki] = 0;
                        }
                        $res['data'][$k]['total'][$ki] += $vi;
                    }
                }
            }
        }    
       
        if(isset($res['data']['期末库存']['total'][($year-1).'-12|actual']) && isset($res['data']['销量']['total'][($year-1).'-12|actual'])){
            $res['data']['整体库存当量']['total'][($year-1).'-12|actual'] = @round($res['data']['期末库存']['total'][($year-1).'-12|actual']/$res['data']['销量']['total'][($year-1).'-12|actual'],2);
        }
        for($i=1;$i<=12;$i++){
            if(isset($res['data']['分车型库存当量']['total'][$year.'-'.$i.'|actual']) && isset($res['data']['销量']['total'][$year.'-'.$i.'|actual'])){
                $res['data']['整体库存当量']['total'][$year.'-'.$i.'|actual'] = @round($res['data']['期末库存']['total'][$year.'-'.$i.'|actual']/$res['data']['销量']['total'][$year.'-'.$i.'|actual'],2);
            }
            if(isset($res['data']['分车型库存当量']['total'][$year.'-'.$i.'|expect']) && isset($res['data']['销量']['total'][$year.'-'.$i.'|expect'])){
                $res['data']['整体库存当量']['total'][$year.'-'.$i.'|expect'] = @round($res['data']['期末库存']['total'][$year.'-'.$i.'|expect']/$res['data']['销量']['total'][$year.'-'.$i.'|expect'],2);
            }
        }
        return $res;
    }
    /*报表其他部分数据*/
    private function _data_over($data){
        $res = array();
        foreach ($data as $v) {
            $res['over']['three_month'][$v['year'].'-'.$v['month'].'|actual'] = $v['three_month_actual']; //90天以上超期库存量本月实际
            $res['over']['three_month'][$v['year'].'-'.$v['month'].'|expect'] = $v['three_month_expect']; //90天以上超期库存量下月预计
            $res['over']['six_month'][$v['year'].'-'.$v['month'].'|expect'] = $v['six_month_expect']; //180天以上超期库存量预计
            $res['over']['six_month'][$v['year'].'-'.$v['month'].'|actual']  = $v['six_month_actual']; //180天以上超期库存量实际
            $res['over']['one_year'][$v['year'].'-'.$v['month'].'|expect'] = $v['one_year_expect']; //一年以上超期库存量下月预计
            $res['over']['one_year'][$v['year'].'-'.$v['month'].'|actual'] = $v['one_year_actual']; //一年以上超期库存量本月实际
            $res['over']['two_year'][$v['year'].'-'.$v['month'].'|expect'] = $v['two_year_expect']; //两年以上超期库存量预计
            $res['over']['two_year'][$v['year'].'-'.$v['month'].'|actual'] = $v['two_year_actual']; //两年以上超期库存量实际
            $res['finance']['bank_bill'][$v['year'].'-'.$v['month'].'|actual'] = $v['bank_bill_actual']; //银行票据（万元）本月实际
            $res['finance']['bank_bill'][$v['year'].'-'.$v['month'].'|expect'] = $v['bank_bill_expect']; //银行票据（万元）本月预计
            $res['finance']['financing'][$v['year'].'-'.$v['month'].'|expect'] = $v['financing_expect']; //厂家融资（万元）下月预计
            $res['finance']['financing'][$v['year'].'-'.$v['month'].'|actual'] = $v['financing_actual']; //厂家融资（万元）本月实际
            $res['finance']['cash'][$v['year'].'-'.$v['month'].'|expect'] = $v['cash_expect']; //现款（万元）下月预计
            $res['finance']['cash'][$v['year'].'-'.$v['month'].'|actual'] = $v['cash_actual']; //现款（万元）本月实际
        }
        return $res;
    }

    //第二个新增（新增超期需求）
    public function dateadd(){
        if(request()->isPost()){
            $data_add = input('param.');
            $year = date('Y');
            $month = (int)date('m');
            $data['year'] = date('Y');
            $data['month'] = date('m');            
            $data['store_id'] = $data_add['store_id'];
            $data['three_month_expect'] = $data_add['three_month_expect'];
            $data['six_month_expect'] = $data_add['six_month_expect'];
            $data['one_year_expect'] = $data_add['one_year_expect'];
            $data['two_year_expect'] = $data_add['two_year_expect'];
            $data['cash_expect'] = $data_add['cash_expect'];
            $data['bank_bill_expect'] = $data_add['bank_bill_expect'];
            $data['financing_expect'] = $data_add['financing_expect'];
            $sigle_data = Db::name('kpi_threerollcar_over')
                       ->where('year',$year)
                       ->where('month',$month)
                        ->where('store_id',$data_add['store_id'])
                       ->find();
            if(!empty($sigle_data)){
                $this->error('本月已经新增过数据');
            }
            Db::startTrans();
            $result = Db::name('kpi_threerollcar_over')->insert($data);
            if($result == FALSE){
                Db::rollback();
                $this->error('新增失败');
            }
            if($month == 1){
                $year = $year-1;
                $month_last = 12;
            } else {
                $month_last = $month-1;
            }
            $map['year'] = $year;
            $map['month'] =$month_last;
            $map['store_id'] = $data_add['store_id'];
            $over = Db::name('kpi_threerollcar_over')->where($map)->select();
            if(empty($over)){
                $data_last['year'] = $year;
                $data_last['month'] = $month_last;
                $data_last['store_id'] = $data_add['store_id'];
                $data_last['financing_actual'] = $data_add['financing_actual'];
                $data_last['bank_bill_actual'] = $data_add['bank_bill_actual'];
                $data_last['cash_actual'] = $data_add['cash_actual'];
                $data_last['two_year_actual'] = $data_add['two_year_actual'];
                $data_last['one_year_actual'] = $data_add['one_year_actual'];
                $data_last['six_month_actual'] = $data_add['six_month_actual'];
                $data_last['three_month_actual'] = $data_add['three_month_actual'];
                $res2 = Db::name('kpi_threerollcar_over')->insert($data_last);
                if($res2 == FALSE){
                    Db::rollback();
                    $this->error('新增失败');
                }
            }else{
                $over['financing_actual'] = $data_add['financing_actual'];
                $over['bank_bill_actual'] = $data_add['bank_bill_actual'];
                $over['cash_actual'] = $data_add['cash_actual'];
                $over['two_year_actual'] = $data_add['two_year_actual'];
                $over['one_year_actual'] = $data_add['one_year_actual'];
                $over['six_month_actual'] = $data_add['six_month_actual'];
                $over['three_month_actual'] = $data_add['three_month_actual'];
                $res3 = Db::name('kpi_threerollcar_over')->update($over);
                if($res3 == FALSE){
                    Db::rollback();
                    $this->error('新增失败');
                }
            }
            Db::commit();
            $this->success('新增成功','Threerollcar/index');
                
        }
        $list = get_comlist();
        $com_id = array('store_id' => $list[0]['ID'],'store_name' => $list[0]['NAME']);
        $this->assign('com_list',$com_id);
        return view();
    }
    
    //第一个新增（新增数据）
    public function add(){
        //品牌下拉框
        $list = get_comlist();
        $com_id = array('store_id' => $list[0]['ID'],'store_name' => $list[0]['NAME']);

        $data_brand = Db::name('kpi_carbrand')->field('id,carbrand_name')->select();
        $store_id = get_comlist();
        if(request()->isPost()){
            $data_add = input('param.');
            // dump($data_add);
            $year=date('Y');
            $month=date('n');
            // $month=1;
            //上月实际
            $about_actual['store_id']=$data_add['store_id'];
            $about_actual['year']=$year;
            $about_actual['month']=$month-1;
            $about_actual['type']=$data_add['type'];
            $about_actual['carseries_id']=$data_add['carseries_id'];
            $about_actual['actual']=$data_add['actual'];
            if($month==1){
                $about_actual['year']=$year-1;
                $about_actual['month']=12;
            }

            $about_expect['store_id']=$data_add['store_id'];
            $about_expect['year']=$year;
            $about_expect['month']=$month;
            $about_expect['type']=$data_add['type'];
            $about_expect['carseries_id']=$data_add['carseries_id'];
            $about_expect['expect']=$data_add['expect'];

            $is_exist=$this ->is_being($about_actual,$about_expect);
            // dump($is_exist);
            if(isset($is_exist['type'])){
                $this->error('本月已经新增过数据');
            }else if($about_actual['type']=='3' && $about_actual['month']=='1'){
                $rest=Db::name('kpi_threerollcar')->insert($about_actual);
                if(!empty($rest)){
                    $this->success('新增成功','Threerollcar/index');
                }else{
                    $this->error('新增失败');
                }
            }
            if(empty($is_exist['res_pre']) && empty($is_exist['res_tm'])){
                $recoure1=Db::name('kpi_threerollcar')->insert($about_actual);
                $recoure2=Db::name('kpi_threerollcar')->insert($about_expect);
                if(!empty($recoure1) && !empty($recoure2)){
                    $this->success('新增成功','Threerollcar/index');
                }else{
                    $this->error('新增失败');
                }
            }elseif(empty($is_exist['res_pre']) && empty($is_exist['res_tm']['expect'])){
                $map['id']=$is_exist['res_tm']['id'];
                $up1['expect']=$data_add['expect'];
                $up_prm = Db::name('kpi_threerollcar')->where($map)->update($up1);
                $recoure1=Db::name('kpi_threerollcar')->insert($about_actual);
                if(!empty($recoure1) && !empty($up_prm)){
                    $this->success('新增成功','Threerollcar/index');
                }else{
                    $this->error('新增失败');
                }
            }elseif(empty($is_exist['res_tm']) && empty($is_exist['res_pre']['actual'])){
                $map['id']=$is_exist['res_pre']['id'];
                $up2['actual']=$data_add['actual'];
                $up_tm=Db::name('kpi_threerollcar')->where($map)->update($up2);
                $recoure2=Db::name('kpi_threerollcar')->insert($about_expect);
                if(!empty($recoure2) && !empty($up_tm)){
                    $this->success('新增成功','Threerollcar/index');
                }else{
                    $this->error('新增失败');
                }
            }else{

                if(!empty($is_exist['res_tm']['expect']) && !empty($is_exist['res_pre']['actual'])){
                     $this->error('本月已经新增过数据');
                }

            }
            
        }
        $this->assign('data_brand',$data_brand);
        $this->assign('store_id',$store_id);
        $this->assign('com_list',$com_id);
        
        return view();
    }
    
   //判断第一个新增是否存在
   private function is_being($data_actual,$data_expect){
        unset($data_expect['expect']);
        unset($data_actual['actual']);
        if($data_actual['type']==3){
            $res_actual_3=Db::name('kpi_threerollcar')->where($data_actual)->find();
            return $res_actual_3;
        }
        $res_actual=Db::name('kpi_threerollcar')->where($data_actual)->find();
        $res_expect=Db::name('kpi_threerollcar')->where($data_expect)->find();
        $res['res_pre']=$res_actual;
        $res['res_tm']=$res_expect;
        return $res;
   }

}