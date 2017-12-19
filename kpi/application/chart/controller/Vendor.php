<?php
/*--------------------------------------------------------------------
广汇KPI报表--厂家任务

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Vendor extends Base{

    public function index(){
        $where = array();

        //查询条件
        $store_id = input('param.store_id');
        if(empty($store_id)){
            $store_id = get_comlist()[0]['ID'];
            $where['store_id'] = $store_id;
        }else{
            $where['store_id'] = $store_id;
            $this->assign('sid',$store_id);
        }
        $year = input('param.year');    //获取年份
        if(empty($year)){
            $year = date("Y");
            $where['year'] = $year;
        }
        $list = Db::name('kpi_task')->alias('t')   //分月查询
                ->field('t.id,c.carseries_name,t.task,t.actual,t.year,t.month')
                ->join('think_kpi_carseries c','c.id=t.carseries_id','LEFT')
                ->where($where)
                ->select();
        $data_list = $this->_data_list($list);
        if(!isset($data_list['key_id'])){
            $data_list['key_id'] = array();
        }
        $data_key = $data_list['key_id'];
        
        $count = Db::name('kpi_task')->alias('t')
                ->field('c.carseries_name,sum(task) as task,sum(actual) as actual')
                ->join('think_kpi_carseries c','c.id=t.carseries_id','LEFT')
                ->where($where)->group('carseries_id')->select();   //年度累计
        $data_list['data'] = $this->_data_list_year($count, $data_list['data']);
        //报表审批是否通过
        $up['a.store_id']=$where['store_id'];
        $up['a.year']=$where['year'];
        $up['a.chart_deptclass_id']=29;
        $data_status=check_flow_year($up);
        
        $this->assign([
            'data_list' => $data_list['data'],
            'data_id'=>$data_key,
            'year' => $year,
            'data_status'=>$data_status
        ]);
        return view();
    }

    /*
     * 月份按车系分组
     * @param $data 数据列表
     */
    function _data_list($data){
        $data_list = array();
        foreach ($data as $v) {
            $data_list['data'][$v['carseries_name']][$v['year']."-".$v['month']."|task"] = $v['task'];    //主机任务
            $data_list['data'][$v['carseries_name']][$v['year']."-".$v['month']."|actual"] = $v['actual'];    //实际完成销量
            $data_list['key_id'][$v['carseries_name']][$v['year']."-".$v['month']."|task"] = $v['id'];
            $data_list['key_id'][$v['carseries_name']][$v['year']."-".$v['month']."|actual"] = $v['id'];
            $data_list['data'][$v['carseries_name']][$v['year']."-".$v['month']."|rate"] = @round($v['actual']/$v['task'],2);  //达成率
            if($v['month'] == 1 || $v['month'] == 2 || $v['month'] == 3){
                if(!isset($data_list['data'][$v['carseries_name']]["1|task"])){
                    $data_list['data'][$v['carseries_name']]["1|task"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["1|task"] += $v['task'];    //主机任务
                if(!isset($data_list['data'][$v['carseries_name']]["1|actual"])){
                    $data_list['data'][$v['carseries_name']]["1|actual"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["1|actual"] += $v['actual'];    //实际完成销量
            }
            if($v['month'] == 4 || $v['month'] == 5 || $v['month'] == 6){
                if(!isset($data_list['data'][$v['carseries_name']]["2|task"])){
                    $data_list['data'][$v['carseries_name']]["2|task"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["2|task"] += $v['task'];    //主机任务
                if(!isset($data_list['data'][$v['carseries_name']]["2|actual"])){
                    $data_list['data'][$v['carseries_name']]["2|actual"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["2|actual"] += $v['actual'];    //实际完成销量
            }
            if($v['month'] == 7 || $v['month'] == 8 || $v['month'] == 9){
                if(!isset($data_list['data'][$v['carseries_name']]["3|task"])){
                    $data_list['data'][$v['carseries_name']]["3|task"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["3|task"] += $v['task'];    //主机任务
                if(!isset($data_list['data'][$v['carseries_name']]["3|actual"])){
                    $data_list['data'][$v['carseries_name']]["3|actual"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["3|actual"] += $v['actual'];    //实际完成销量
            }
            if($v['month'] == 10 || $v['month'] == 11 || $v['month'] == 12){
                if(!isset($data_list['data'][$v['carseries_name']]["4|task"])){
                    $data_list['data'][$v['carseries_name']]["4|task"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["4|task"] += $v['task'];    //主机任务
                if(!isset($data_list['data'][$v['carseries_name']]["4|actual"])){
                    $data_list['data'][$v['carseries_name']]["4|actual"] = 0;
                }
                $data_list['data'][$v['carseries_name']]["4|actual"] += $v['actual'];    //实际完成销量
            }
        }
        if(!isset($data_list['data'])){
            $data_list['data']=array();
        }
        foreach ($data_list['data'] as $k => $v) {
            for($i=0;$i<=4;$i++){
                if(!empty($v[$i."|actual"]) && !empty($v[$i."|task"])){
                $data_list['data'][$k][$i."|rate"] = @round($v[$i."|actual"]/$v[$i."|task"],4);  //达成率
                }
            }
        }
        return $data_list;
    }
    /*
     * 季度按车系分组
     * @param $data 数据列表
     * @param $arr 月份按车系分组数组
     */
    function _data_list_qurtar($data,$arr){
        foreach ($data as $v) {
            $arr[$v['carseries_name']][$v['quter']."|task"] = $v['task'];    //主机任务
            $arr[$v['carseries_name']][$v['quter']."|actual"] = $v['actual'];    //实际完成销量
            $arr[$v['carseries_name']][$v['quter']."|rate"] = @round($v['actual']/$v['task'],2);  //达成率
        }
        return $arr;
    }
    /*
     * 年度按车系分组
     * @param $data 数据列表
     * @param $arr 数组
     */
    function _data_list_year($data,$arr){
        foreach ($data as $v) {
            $arr[$v['carseries_name']]["year|task"] = $v['task'];    //主机任务
            $arr[$v['carseries_name']]["year|actual"] = $v['actual'];    //实际完成销量
            $arr[$v['carseries_name']]["year|rate"] = @round($v['actual']/$v['task'],2);  //达成率
        }
        return $arr;
    }

    //月度数据添加
    public function monthadd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['task'] = $data_add['task'];
            $data['actual'] = $data_add['actual'];
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];

            $res = Db::name('kpi_task')
                ->where('store_id',$data_add['store_id'])
                ->where('carseries_id',$data_add['carseries_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该车系本月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_task')->insert($data);
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
    //季度数据添加
    public function quarteradd(){
        if(Request::instance()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['task'] = $data_add['task'];
            $data['year'] = $data_add['year'];
            $data['quter'] = $data_add['quter'];
            $data['actual'] = $data_add['actual'];

            $res = Db::name('kpi_task_quarter')
                ->where('store_id',$data_add['store_id'])
                ->where('carseries_id',$data_add['carseries_id'])
                ->where('year',$data_add['year'])
                ->where('quter',$data_add['quter'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该车系本季度数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_task_quarter')->insert($data);
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
}