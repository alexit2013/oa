<?php
/*--------------------------------------------------------------------
广汇KPI报表--售后重点经营指标

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;
class  Runtarget extends Base{
    public function index(){
            $search_data = input('param.');

            $where = $this->search($search_data);
           
            $this->assign('search_data',$search_data);
        
        if(empty($where)){
            $store_id = get_comlist()[0]['ID'];
            //重点经营指标|售后重点增值业务指标
            $map['a.year']=date('Y');
            $map['a.month']=date('n');
            $map['a.store_id']=$store_id;
            //重点经营指标占比
            $map1['year']=date('Y');
            $map1['month']=date('n');
            $map1['store_id']=$store_id;
            //售后重点管理指标
            $map2['year']=date('Y');
            $map2['month']=date('n');
            $map2['store_id']=$store_id;
        }else{
            //重点经营指标|售后重点增值业务指标
            $map['a.year']=$where['year'];
            $map['a.month']=$where['month'];
            $map['a.store_id']=$where['store_id'];
            //重点经营指标占比
            $map1['year']=$where['year'];
            $map1['month']=$where['month'];
            $map1['store_id']=$where['store_id'];
            //售后重点管理指标
            $map2['year']=$where['year'];
            $map2['month']=$where['month'];
            $map2['store_id']=$where['store_id'];
        }
       
        $runres=$this -> runtarget($map); //重点经营指标
        
        $runrateres=$this ->runrate($map1); //重点经营指标占比
        
        $MVASres=$this -> MVAStarget($map); //售后重点增值业务指标
        // dump($prem_expect_selltot);
        // dump($prem_actual_selltot);
        // dump($thatm_expect_selltot);
        // dump($runrateres);
        $manageres=$this -> managetarget($map2);//售后重点管理指标
        $this -> assign('manageres',$manageres);
        //---------------------------------
        $this -> assign('MVASres',$MVASres);
        //--------------------------------
        $this -> assign('runrateres',$runrateres);
        //------------------------------
        //报表审批是否通过
        $up['a.store_id']=$map1['store_id'];
        $up['a.year']=$map1['year'];
        $up['a.month']=$map1['month'];
        $up['a.chart_deptclass_id']=21;
        $data_status=check_flow_month($up);
        
        $this -> assign('data_status',$data_status); //审批状态
        $this -> assign('data_run',$runres['data_run']);
        $this -> assign('prem_expect_selltot',$runres['prem_expect_selltot']);
        $this -> assign('prem_actual_selltot',$runres['prem_actual_selltot']);
        $this -> assign('thatm_expect_selltot',$runres['thatm_expect_selltot']);
//        dump($manageres);
        return view();
    }

    //重点经营指标
    private function runtarget($map=null){
        $res=Db::name('kpi_runtarget')
              ->alias('a')
              ->field('a.*,b.type_name')
              ->join('think_kpi_runtargettype b','a.type_id=b.id','LEFT')
              ->where($map)
              ->select();
        $data_run=array();
        $prem_expect_selltot=0;
        $prem_actual_selltot=0;
        $thatm_expect_selltot=0;
        foreach ($res as $key => $val) {
         
            $prem_expect_selltot+=$val['expect_sellnum']; //上月预计销售总台次
            $prem_actual_selltot+=$val['actual_sellnum']; //上月实际销售总台次
            $thatm_expect_selltot+=$val['thatmonth_expext_sellnum'];//本月预测销售台次
            $data_run[$val['type_name']]['id']=$val['id'];
            $data_run[$val['type_name']]['expect_sellnum']=$val['expect_sellnum']; //预计销售台次
            $data_run[$val['type_name']]['actual_sellnum']=$val['actual_sellnum']; //实际销售台次
            $data_run[$val['type_name']]['expect_guestprice']=$val['expect_guestprice']; //预计客单价
            $data_run[$val['type_name']]['actual_guestprice']=$val['actual_guestprice']; //实际客单件
        
            $data_run[$val['type_name']]['thatmonth_expext_sellnum']=$val['thatmonth_expext_sellnum'];//本月预测销售台次
            $data_run[$val['type_name']]['thatmonth_expect_guestprice']=$val['thatmonth_expect_guestprice'];//本月预测客单价
            $data_run[$val['type_name']]['other_sellnum']=$val['other_sellnum'];//其他销量台次
            $data_run[$val['type_name']]['other_guestprice']=$val['other_guestprice'];//其他客单价
            $data_run[$val['type_name']]['store_id']=$val['store_id'];
            $data_run[$val['type_name']]['premonth_expect_output']=round($val['expect_guestprice']*$val['expect_sellnum'],2); //上月预测产值
            $data_run[$val['type_name']]['premonth_actual_output']=round($val['actual_guestprice']*$val['actual_sellnum'],2); //上月实际产值
            $data_run[$val['type_name']]['thatmonth_expect_output']=round($val['thatmonth_expect_guestprice']*$val['thatmonth_expext_sellnum'],2); //本月预测产值
        }
        $reslut['prem_expect_selltot']=$prem_expect_selltot;
        $reslut['prem_actual_selltot']=$prem_actual_selltot;
        $reslut['thatm_expect_selltot']=$thatm_expect_selltot;
        $reslut['data_run']=$data_run;
        
        return $reslut;
    }
    //重点经营指标占比
    private function runrate($map1){
        $res=Db::name('kpi_runrate')->where($map1)->find();
        return $res;
    }
    //售后重点增值业务指标
    private function MVAStarget($map){
       $res= Db::name('kpi_targetmvas')->alias('a')->field('a.*,b.MVAS_name')->join('think_kpi_mvasname b','a.MVASname_id=b.id')->where($map)->select();
       $data_MVAS=array();
       foreach ($res as $key => $val) {
            $data_MVAS[$val['MVAS_name']]['id']=$val['id'];
            $data_MVAS[$val['MVAS_name']]['thatmonth_complete']=$val['thatmonth_complete'];
            $data_MVAS[$val['MVAS_name']]['month_yoy']=$val['month_yoy']; //上月同比
            $data_MVAS[$val['MVAS_name']]['month_chain']=$val['month_chain']; //上月环比
            $data_MVAS[$val['MVAS_name']]['thatyear_total']=$val['thatyear_total'];//当月累计
            $data_MVAS[$val['MVAS_name']]['total_yoy']=$val['total_yoy'];//累计同比
           
       }
        return $data_MVAS;
    }
    //售后重点管理指标
    private function managetarget($map2){
        $res=Db::name('kpi_target_manage')->where($map2)->find();
        return $res;
    }

    //搜索
    public function search($data){
        
        $map = array();

        if(empty($data['store_id'])){
           $map['store_id']=get_comlist()[0]['ID'];
        }else{
            $map['store_id']=$data['store_id'];
            $this->assign('sid',$data['store_id']);
        }
        if(empty($data['year'])){     //年
            $map['year']=date('Y');
        }else{
            $map['year']=$data['year'];
            $this->assign('year',$data['year']);
        }
        if(!empty($data['month'])){   //月
            $map['month']=$data['month'];
            $this->assign('month',$data['month']);
        }else{
            $map['month']=date('n');
         }
        return $map;
    }

    // 售后重点经营指标
    public function operateadd(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $store_id = $data['store_id'];      //提出store_id单独使用
            unset($data['store_id']);           //删除接收到的数组中的store_id，以便后面遍历
            $about =array();
            foreach($data as $k => $v){         //遍历接收到的数组
                $about[$k] = $v;
                $about[$k]['store_id'] = $store_id;
                $about[$k]['year'] = date('Y');
                $about[$k]['month'] = date('m');
            }
            Db::startTrans();
            $sigle_data = Db::name('kpi_runtarget')
                       ->where('year',date('Y'))
                       ->where('month',date('m'))
                       ->where('store_id',$store_id)
                       ->select();
            //判断一个月只能添加一次
            if(!empty($sigle_data)){
                    $reslut['id']= $store_id;
                    $reslut['msg']='本月已经新增过数据!';
                    $reslut['status']='0';
                    Db::rollback();
                    return json($reslut);
             }else{   
             foreach($about as $v){
                    $res = Db::name('kpi_runtarget')->insert($v);
                    if(!$res){
                        $reslut['msg']='添加失败!';
                        $reslut['status']='0';
                        Db::rollback();
                        return json($reslut);
                    }
             }             
            $reslut['msg']='添加成功';
            $reslut['status']='1';
            Db::commit();
            return json($reslut);
        }
        }else{
            return view();
        }    
    }

    // 售后重点增值业务指标数据
    public function businessadd(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $store_id = $data['store_id'];      //提出store_id单独使用
            unset($data['store_id']);           //删除接收到的数组中的store_id，以便后面遍历
            $about =array();
            foreach($data as $k => $v){         //遍历接收到的数组
                $about[$k] = $v;
                $about[$k]['store_id'] = $store_id;
                $about[$k]['year'] = date('Y');
                $about[$k]['month'] = date('m');
            }
            Db::startTrans();

            $sigle_data = Db::name('kpi_targetmvas')
                       ->where('year',date('Y'))
                       ->where('month',date('m'))
                       ->where('store_id',$store_id)
                       ->select();
            //判断一个月只能添加一次
            if(!empty($sigle_data)){
                    $reslut['id']= $store_id;
                    $reslut['msg']='本月已经新增过数据!';
                    $reslut['status']='0';
                    Db::rollback();
                    return json($reslut);
             }else{   
             foreach($about as $v){
                    $res = Db::name('kpi_targetmvas')->insert($v);
                    if(!$res){
                        $reslut['msg']='添加失败!';
                        $reslut['status']='0';
                        Db::rollback();
                        return json($reslut);
                    }
             }             
            $reslut['msg']='添加成功';
            $reslut['status']='1';
            Db::commit();
            return json($reslut);
        }
        }else{
            return view();
        } 
    }

    // 售后重点管理指标数据
    public function managementadd(){
        if(Request::instance()->isAjax()){
            $data=input('param.');

            $about['store_id']=$data['store_id']; //门店ID
            $about['onetime_repair_rate_thatmonth']=$data['onetime_repair_rate_thatmonth']; //一次性修复率(当月)
            $about['onetime_repair_rate_monthchain']=$data['onetime_repair_rate_monthchain']; //一次性修复率(月环比)
            $about['onetime_repair_rate_monthyoy']=$data['onetime_repair_rate_monthyoy']; //一次性修复率(月同比)
            $about['ontime_turncar_rate_thatmonth']=$data['ontime_turncar_rate_thatmonth']; //准时交车率(当月)
            $about['ontime_turncar_rate_monthchain']=$data['ontime_turncar_rate_monthchain']; //准时交车率(月环比)
            $about['ontime_turncae_rate_monthyoy']=$data['ontime_turncae_rate_monthyoy']; //准时交车率(月同比)
            $about['parts_turnore_rete_thatmonth']=$data['parts_turnore_rete_thatmonth'];//备件周转率(当月)
            $about['parts_turnore_rate_monthchain']=$data['parts_turnore_rate_monthchain']; //备件周转率（月环比）
            $about['parts_turnore_rate_monthyoy']=$data['parts_turnore_rate_monthyoy']; //备件周转率(月同比)
            $about['onetime_supply_rate_thatmonth']=$data['onetime_supply_rate_thatmonth']; //一次供货率（当月）
            $about['onetime_supply_rate_monthchain']=$data['onetime_supply_rate_monthchain']; //一次供货率（月环比）
            $about['onetime_supply_rate_monthyoy']=$data['onetime_supply_rate_monthyoy']; //一次供货率（月同比）
            $about['station_turnore_rate_electrical_thatmonth']=$data['station_turnore_rate_electrical_thatmonth']; //工位周转率(机电)台次（当月）
            $about['station_turnore_rate_electrical_monthchain']=$data['station_turnore_rate_electrical_monthchain']; //工位周转率（机电）台次（月环比）
            $about['station_turnore_rate_electrical_monthyoy']=$data['station_turnore_rate_electrical_monthyoy']; //工位周转率（机电）台次（月同比）
            $about['station_turnore_rate_coinspray_thatmonth']=$data['station_turnore_rate_coinspray_thatmonth']; //工位周转率钣喷（台次）（当月）
            $about['station_turnore_rate_coinspray_monthchain']=$data['station_turnore_rate_coinspray_monthchain']; //工位周转率钣喷（台次）（月环比）
            $about['station_turnore_rate_coinspray_monthyoy']=$data['station_turnore_rate_coinspray_monthyoy']; //工位周转率钣喷（台次）（月同比）
            $about['aftificial_rate_receptionele_thatmonth']=$data['aftificial_rate_receptionele_thatmonth']; //人工效率前台机电（台次）（当月）
            $about['aftificial_rate_receptionele_monthchain']=$data['aftificial_rate_receptionele_monthchain']; //人工效率前台机电（月环比）
            $about['aftificial_rate_receptionele_monthyoy']=$data['aftificial_rate_receptionele_monthyoy']; //人工效率前台机电（月同比）
            $about['aftificial_rate_reception_accident_thatmonth']=$data['aftificial_rate_reception_accident_thatmonth']; //人工效率前台事故（当月）
            $about['aftificial_rate_reception_accident_monthchain']=$data['aftificial_rate_reception_accident_monthchain']; //人工效率前台事故（月环比）
            $about['aftificial_rate_reception_accident_monthyoy']=$data['aftificial_rate_reception_accident_monthyoy']; //人工效率前台事故（月同比）
            $about['aftificial_rate_electrical_thatmonth']=$data['aftificial_rate_electrical_thatmonth']; //人工效率机电(当月)
            $about['aftificial_rate_electrical_monthchain']=$data['aftificial_rate_electrical_monthchain']; //人工效率机电（月环比）
            $about['aftificial_rate_electrical_monthyoy']=$data['aftificial_rate_electrical_monthyoy']; //人工效率机电（月同比）
            $about['aftificial_rate_coinspray_thatmonth']=$data['aftificial_rate_coinspray_thatmonth']; //人工效率钣喷（当月）
            $about['aftificial_rate_coinspray_monthchain']=$data['aftificial_rate_coinspray_monthchain']; //人工效率钣喷（月环比）
            $about['aftificial_rate_coinspray_monthyoy']=$data['aftificial_rate_coinspray_monthyoy']; //人工效率钣喷（月同比）
            $about['year'] = date('Y');
            $about['month'] = date('m');

            Db::startTrans();
            $sigle_data = Db::name('kpi_target_manage')
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->where('store_id',$data['store_id'])
                ->select();
            //判断一个月只能添加一次
            if(!empty($sigle_data)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                Db::rollback();
            }else{
                $rebate_id=Db::name('kpi_target_manage')->insertGetId($about);

                if(!empty($rebate_id)){
                    $reslut['msg']='添加成功';
                    $reslut['status']='1';
                    Db::commit();
                }else{
                    $reslut['msg']='添加失败!';
                    $reslut['status']='0';
                    Db::rollback();
                }
            }
            return json($reslut);
        }else{
            return view();
        }
    }


    // 售后重点管理指标占比数据
    public function proportionadd(){
        if(Request::instance()->isAjax()){
            $data=input('param.');

            $about['store_id']=$data['store_id']; //门店ID
            $about['year'] = date('Y');
            $about['month'] = date('m');
            $about['num_premonth_yoy']=$data['num_premonth_yoy'];
            $about['num_premonth_chain']=$data['num_premonth_chain'];
            $about['num_thatyear_total']=$data['num_thatyear_total'];
            $about['num_total_chain']=$data['num_total_chain'];
            $about['numrate_premonth_yoy']=$data['numrate_premonth_yoy'];
            $about['numrate_premonth_chain']=$data['numrate_premonth_chain'];
            $about['numrate_thatyear_total']=$data['numrate_thatyear_total'];
            $about['numrate_total_chain']=$data['numrate_total_chain'];
            $about['guestprice_premonth_yoy']=$data['guestprice_premonth_yoy'];
            $about['guestprice_premonth_chain']=$data['guestprice_premonth_chain'];
            $about['guestprice_thatyear_total']=$data['guestprice_thatyear_total'];
            $about['guestprice_total_chain']=$data['guestprice_total_chain'];
            $about['output_premonth_yoy']=$data['output_premonth_yoy'];
            $about['output_premonth_chain']=$data['output_premonth_chain'];
            $about['output_thatyear_total']=$data['output_thatyear_total'];
            $about['output_total_chain']=$data['output_total_chain'];
            $about['outputrate_premonth_yoy']=$data['outputrate_premonth_yoy'];
            $about['outputrate_premonth_chain']=$data['outputrate_premonth_chain'];
            $about['outputrate_thatyear_total']=$data['outputrate_thatyear_total'];
            $about['outputrate_total_chain']=$data['outputrate_total_chain'];

            Db::startTrans();
            $sigle_data = Db::name('kpi_runrate')
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->where('store_id',$data['store_id'])
                ->select();
            //判断一个月只能添加一次
            if(!empty($sigle_data)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                Db::rollback();
            }else{
                $rebate_id=Db::name('kpi_runrate')->insertGetId($about);

                if(!empty($rebate_id)){
                    $reslut['msg']='添加成功';
                    $reslut['status']='1';
                    Db::commit();
                }else{
                    $reslut['msg']='添加失败!';
                    $reslut['status']='0';
                    Db::rollback();
                }
            }
            return json($reslut);
        }else{
            return view();
        }
    }

}