<?php
/*--------------------------------------------------------------------
广汇KPI报表--三月滚动库存(配件)

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Threerollparts extends Base{

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
        $store = Db::name('dept')->where('id',$store_id)->find();
        //查询条件去年12月截止到下个月，用月份分组查询
        $year = input('param.year');    //获取年份
        if(empty($year)){
            $year = date("Y");
        }
        $lastyear = $year-1;
        $result = Db::name('kpi_threerollparts')
                ->where('year = '.$lastyear.' AND month = 12 OR year ='.$year)
                ->where($where)  
                ->select();
        $data = $this->_data_list($result,$year);
        if(!isset($data['data'])){
            $data['data'] = array();
        }
        if(!isset($data['key_id'])){
            $data['key_id'] = array();
        }
        //报表审批是否通过
        $up['a.store_id']=$where['store_id'];
        $up['a.year']=$year;
        $up['a.chart_deptclass_id']=19;
        $data_status=check_flow_year($up);
        $this->assign([
            'year'=>$year,
            'data_list'=>$data['data'],
            'data_id'=>$data['key_id'],
            'store_name'=>$store['NAME'],
            'data_status'=>$data_status //审批状态
        ]);
        return view();
    }
    /*
     * 厂家任务数据处理
     */
    private function _data_list($data_list,$year){
        $type_arr = ['配件销售','配件购进','期末库存','配件分类当量','一年以上的库存'];
        $data = array();
        foreach ($data_list as $v) {
            $data['data'][$type_arr[$v['type']]]['boutique'][$v['year'].'-'.$v['month']."|expect"] = $v['boutique_expect'];//精品配件预计
            $data['data'][$type_arr[$v['type']]]['boutique'][$v['year'].'-'.$v['month']."|actual"] = $v['boutique_actual'];//精品配件实际
            $data['data'][$type_arr[$v['type']]]['maintain'][$v['year'].'-'.$v['month']."|expect"] = $v['maintain_expect'];//保养预计
            $data['data'][$type_arr[$v['type']]]['maintain'][$v['year'].'-'.$v['month']."|actual"] = $v['maintain_actual'];//保养实际
            $data['data'][$type_arr[$v['type']]]['metal'][$v['year'].'-'.$v['month']."|expect"] = $v['metal_expect'];//钣喷预计
            $data['data'][$type_arr[$v['type']]]['metal'][$v['year'].'-'.$v['month']."|actual"] = $v['metal_actual'];//钣喷实际
            $data['data'][$type_arr[$v['type']]]['repair'][$v['year'].'-'.$v['month']."|expect"] = $v['repair_expect'];//一般维修预计
            $data['data'][$type_arr[$v['type']]]['repair'][$v['year'].'-'.$v['month']."|actual"] = $v['repair_actual'];//一般维修实际
            $data['data'][$type_arr[$v['type']]]['oil'][$v['year'].'-'.$v['month']."|expect"] = $v['oil_expect'];//机油预计
            $data['data'][$type_arr[$v['type']]]['oil'][$v['year'].'-'.$v['month']."|actual"] = $v['oil_actual'];//机油实际
            $data['data'][$type_arr[$v['type']]]['chemical'][$v['year'].'-'.$v['month']."|expect"] = $v['chemical_expect'];//化学品预计
            $data['data'][$type_arr[$v['type']]]['chemical'][$v['year'].'-'.$v['month']."|actual"] = $v['chemical_actual'];//化学品实际
            $data['data'][$type_arr[$v['type']]]['battery'][$v['year'].'-'.$v['month']."|expect"] = $v['battery_expect'];//电瓶预计
            $data['data'][$type_arr[$v['type']]]['battery'][$v['year'].'-'.$v['month']."|actual"] = $v['battery_actual'];//电瓶实际
            $data['data'][$type_arr[$v['type']]]['tyre'][$v['year'].'-'.$v['month']."|expect"] = $v['tyre_expect'];//轮胎预计
            $data['data'][$type_arr[$v['type']]]['tyre'][$v['year'].'-'.$v['month']."|actual"] = $v['tyre_actual'];//轮胎实际
                    
            $data['key_id'][$type_arr[$v['type']]]['boutique'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//精品配件预计
            $data['key_id'][$type_arr[$v['type']]]['boutique'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//精品配件实际
            $data['key_id'][$type_arr[$v['type']]]['maintain'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//保养预计
            $data['key_id'][$type_arr[$v['type']]]['maintain'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//保养实际
            $data['key_id'][$type_arr[$v['type']]]['metal'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//钣喷预计
            $data['key_id'][$type_arr[$v['type']]]['metal'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//钣喷实际
            $data['key_id'][$type_arr[$v['type']]]['repair'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//一般维修预计
            $data['key_id'][$type_arr[$v['type']]]['repair'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//一般维修实际
            $data['key_id'][$type_arr[$v['type']]]['oil'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//机油预计
            $data['key_id'][$type_arr[$v['type']]]['oil'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//机油实际
            $data['key_id'][$type_arr[$v['type']]]['chemical'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//化学品预计
            $data['key_id'][$type_arr[$v['type']]]['chemical'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//化学品实际
            $data['key_id'][$type_arr[$v['type']]]['battery'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//电瓶预计
            $data['key_id'][$type_arr[$v['type']]]['battery'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//电瓶实际
            $data['key_id'][$type_arr[$v['type']]]['tyre'][$v['year'].'-'.$v['month']."|expect"] = $v['id'];//轮胎预计
            $data['key_id'][$type_arr[$v['type']]]['tyre'][$v['year'].'-'.$v['month']."|actual"] = $v['id'];//轮胎实际
        }
        if(!isset($data['data'])){
            $data['data'] = array();
        }
        if(isset($data['data']['期末库存'])){
            foreach($data['data']['期末库存'] as $ko => $vo){
                for($i=1;$i<=12;$i++){
                    if($i == 1){
                        if(isset($data['data']['期末库存'][$ko][($year-1)."-12|actual"]) && isset($data['data']['配件购进'][$ko][$year."-".$i."|expect"]) && isset($data['data']['配件销售'][$ko][$year."-".$i."|expect"])){
                            $data['data']['期末库存'][$ko][$year."-".$i."|expect"] = round($data['data']['期末库存'][$ko][($year-1)."-12|actual"]+$data['data']['配件购进'][$ko][$year."-".$i."|expect"]-$data['data']['配件销售'][$ko][$year."-".$i."|expect"],2);
                        } 
                        if(isset($data['data']['期末库存'][$ko][($year-1)."-12|actual"]) && isset($data['data']['配件购进'][$ko][$year."-".$i."|actual"]) && isset($data['data']['配件销售'][$ko][$year."-".$i."|actual"])){
                            $data['data']['期末库存'][$ko][$year."-".$i."|actual"] = round($data['data']['期末库存'][$ko][($year-1)."-12|actual"]+$data['data']['配件购进'][$ko][$year."-".$i."|actual"]-$data['data']['配件销售'][$ko][$year."-".$i."|actual"],2);
                        }
                    }else{
                        if(isset($data['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]) && isset($data['data']['配件销售'][$ko][$year."-".$i."|expect"])){
                            $data['data']['期末库存'][$ko][$year."-".$i."|expect"] = round($data['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]+$data['data']['配件购进'][$ko][$year."-".$i."|expect"]-$data['data']['配件销售'][$ko][$year."-".$i."|expect"],2);
                        }
                        if(isset($data['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]) && isset($data['data']['配件销售'][$ko][$year."-".$i."|actual"])){
                            $data['data']['期末库存'][$ko][$year."-".$i."|actual"] = round($data['data']['期末库存'][$ko][$year."-".($i-1)."|actual"]+$data['data']['配件购进'][$ko][$year."-".$i."|actual"]-$data['data']['配件销售'][$ko][$year."-".$i."|actual"],2);
                        }
                    }
                }
            }
            foreach($data['data']['期末库存'] as $ko => $vo){
                foreach ($vo as $ki => $vi) {
                    if(!empty($data['data']['配件销售'][$ko][$ki]) && $data['data']['配件销售'][$ko][$ki]>0 && !empty($data['data']['期末库存'][$ko][$ki])){
                        $data['data']['配件分类当量'][$ko][$ki] = round($data['data']['期末库存'][$ko][$ki]/$data['data']['配件销售'][$ko][$ki],2);
                    }
                }
            }    
        }
        
        foreach ($data['data'] as $k => $v) {   //求合计
            foreach($v as $ko => $vo){
                foreach ($vo as $ki => $vi) {
                    if(!isset($data['data'][$k]['total'][$ki])){
                        $data['data'][$k]['total'][$ki] = 0;
                    }
                    $data['data'][$k]['total'][$ki] += $vi;
                }
            }
        }
        foreach ($data['data'] as $k => $v) {
            foreach($v as $ko => $vo){
                if($ko == 'total'){
                    foreach ($vo as $ki => $vi) {
                        if(!empty($data['data']['期末库存'][$ko][$ki]) && !empty($data['data']['配件销售'][$ko][$ki])){
                            $data['data']['整体配件库存当量'][$ki] = round($data['data']['期末库存'][$ko][$ki]/$data['data']['配件销售'][$ko][$ki],2);
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function add(){
        if(Request::instance()->isAjax()){      //点击提交通过AJAX方法后执行
            $data = input('param.');
            $store_id = $data['store_id'];      //单独提出前台传递的store_id
            unset($data['store_id']);           //删除前台传递过来的数组中的store_id，剩下的数组便于下一步遍历
            
            $year = date('Y');
            $month = (int)date('m');
            $once_add = Db::name('kpi_threerollparts')->where('year',date('Y'))->where('month',$month)->where('store_id',$store_id)->select();       //查找表中是否已经添加过当月的数据
            if(!empty($once_add)){                      //如果数据已经存在，返回一个提示
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                return json($reslut);
            }
            $about = array();                    //定义一个新数组，用于后面插入数据
            $about_last = array();
            foreach($data as $k => $v){   
                $type = $v['type'];
                unset($v['type']);
                foreach ($v as $ko => $vo){
                    if($ko == 'expect'){
                        $about[$k] = $vo;
                        $about[$k]['type'] = $type;
                        $about[$k]['store_id'] = $store_id;
                        $about[$k]['year'] = $year;         //向about数组中赋值（当前年）
                        $about[$k]['month'] = $month;       //向about数组中赋值（当前月）
                    }
                    if($ko == 'actual'){
                        $about_last[$k] = $vo;
                        $about_last[$k]['type'] = $type;
                        $about_last[$k]['store_id'] = $store_id;
                        if($month == 1){
                            $year = $year-1;
                            $month_last = 12;
                        } else {
                            $month_last = $month-1;
                        }
                        $about_last[$k]['year'] = $year;  
                        $about_last[$k]['month'] = $month_last;       //向about数组中赋值（上月）
                    }
                }
            }
            $res = Db::name('kpi_threerollparts')->insertAll($about);      //插入数据
            foreach ($about_last as $k => $v) {
                $map = array();
                $map['type'] = $v['type'];
                $map['year'] = $v['year'];
                $map['month'] = $v['month'];
                $map['store_id'] = $v['store_id'];
                $last = Db::name('kpi_threerollparts')->where($map)->find();
                if(empty($last)){
                    Db::name('kpi_threerollparts')->insert($v);
                }else{
                    foreach ($v as $key => $val) {
                        $last[$key] = $val;
                    }
                    Db::name('kpi_threerollparts')->update($last);
                }
            }
            if($res){
                $reslut['msg']='添加成功';              //添加成功后执行
                $reslut['status']='1';
                return json($reslut);
            }else{
                    $reslut['msg']='添加失败!';
                $reslut['status']='0';
                return json($reslut);
            }
         }
        return view();
    }


    public function lastyearadd(){
        if(Request::instance()->isAjax()){
            $data=input('param.');

            $about['store_id']=$data['store_id']; //门店ID
            $about['type']=$data['type'];
            $about['year']=$data['year'];
            $about['month']=$data['month'];
            $about['boutique_actual']=$data['boutique_actual'];
            $about['maintain_actual']=$data['maintain_actual'];
            $about['metal_actual']=$data['metal_actual'];
            $about['repair_actual']=$data['repair_actual'];
            $about['oil_actual']=$data['oil_actual'];
            $about['chemical_actual']=$data['chemical_actual'];
            $about['battery_actual']=$data['battery_actual'];
            $about['tyre_actual']=$data['tyre_actual'];

            Db::startTrans();
            $sigle_data = Db::name('kpi_threerollparts')
                ->where('year',$data['year'])
                ->where('month',$data['month'])
                ->where('store_id',$data['store_id'])
                ->where('type',$data['type'])
                ->select();
            //判断一个月只能添加一次
            if(!empty($sigle_data)){
                $reslut['msg']='已经新增过上年期末库存数据!';
                $reslut['status']='0';
                Db::rollback();
            }else{
                $rebate_id=Db::name('kpi_threerollparts')->insertGetId($about);

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