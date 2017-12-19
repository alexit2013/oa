<?php
/*---------------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
 -------------------------------------------------------------------------*/

// 用户模型
namespace Home\Model;

class  TargetChartModel {
    function table1($year,$month) {
        if(empty($year)){
            $year = date('Y');
        }
        if(empty($month)){
            $month = (int)date('m');
        }
        $chart = M('target_chart1');
        $res = $chart->where("year='{$year}' and month='{$month}'")->select();
        if(!empty($res)){
            $chart->where("year='{$year}' and month='{$month}'")->delete();
        }
        $starttime = mktime(0,0,0,$month,1,$year);
        $endtime = mktime(0,0,0,$month+1,1,$year)-1;
        $wheres['inputtime'] = array(array('egt',$starttime),array('elt',$endtime));
        
        //销量数据
        $data=array();
        $xl_data = M('target_channeldata')
                ->field('dept_id AS dm_id,SUM(showroom) AS xlzt,SUM(self_store) AS xlzd,SUM(tel_group) xldh,SUM(big_consumer) AS xldk,SUM(outer_permit) AS xlwp')
                ->where($wheres)
                ->group('dept_id')
                ->select();
        foreach ($xl_data as $v) {
            $data[$v['dm_id']] = $v;
        }
        $wheresl['entry_time'] = $wheres['inputtime'];
        $wheresl['library_id'] ='1';
        $loan_data = M('target_loanbusiness')
                ->field('dept_id AS dm_id,channel_id,COUNT(*) AS fd,SUM(zxservice_cost) AS zx,SUM(settle_mortgage_cost) AS dy')
                ->where($wheresl)
                ->group('dept_id,channel_id')
                ->select();
        
        foreach ($loan_data as $v){
            if($v['channel_id']=='1'){//展厅
                $data[$v['dm_id']]['fdzt'] = $v['fd'];
                $data[$v['dm_id']]['zxzt'] = $v['zx'];
                $data[$v['dm_id']]['dyzt'] = $v['dy'];
            }
            if($v['channel_id']=='2'){//电话组
                $data[$v['dm_id']]['fddh'] = $v['fd'];
                $data[$v['dm_id']]['zxdh'] = $v['zx'];
                $data[$v['dm_id']]['dydh'] = $v['dy'];
            }
            if($v['channel_id']=='3'){//大客户
                $data[$v['dm_id']]['fddk'] = $v['fd'];
                $data[$v['dm_id']]['zxdk'] = $v['zx'];
                $data[$v['dm_id']]['dydk'] = $v['dy'];
            }
            if($v['channel_id']=='4'){//外批
                $data[$v['dm_id']]['fdwp'] = $v['fd'];
                $data[$v['dm_id']]['zxwp'] = $v['zx'];
                $data[$v['dm_id']]['dywp'] = $v['dy'];
            }
            if($v['channel_id']=='5'){//自店二组
                $data[$v['dm_id']]['fdzd'] = $v['fd'];
                $data[$v['dm_id']]['zxzd'] = $v['zx'];
                $data[$v['dm_id']]['dyzd'] = $v['dy'];
            }
        }
        
        foreach ($data as $k => $v) {
            //asp计算
            $data[$k]['aspzt'] = $this->asp($v['zxzt'], $v['fdzt']);
            $data[$k]['aspdh'] = $this->asp($v['zxdh'], $v['fddh']);
            $data[$k]['aspdk'] = $this->asp($v['zxdk'], $v['fddk']);
            $data[$k]['aspzd'] = $this->asp($v['zxzd'], $v['fdzd']);
            $data[$k]['aspwp'] = $this->asp($v['zxwp'], $v['fdwp']);
            //渗透率计算
            $data[$k]['stzt'] = $this->asp($v['fdzt'],$v['xlzt']);
            $data[$k]['stdh'] = $this->asp($v['fddh'],$v['xldh']);
            $data[$k]['stdk'] = $this->asp($v['fddk'],$v['xldk']);
            $data[$k]['stzd'] = $this->asp($v['fdzd'],$v['xlzd']);
            $data[$k]['stwp'] = $this->asp($v['fdwp'],$v['xlwp']);
            // $data[$k]['stzt'] = $this->asp($v['xlzt'], $v['fdzt']);
            // $data[$k]['stdh'] = $this->asp($v['xldh'], $v['fddh']);
            // $data[$k]['stdk'] = $this->asp($v['xldk'], $v['fddk']);
            // $data[$k]['stzd'] = $this->asp($v['xlzd'], $v['fdzd']);
            // $data[$k]['stwp'] = $this->asp($v['xlwp'], $v['fdwp']);
            $data[$k]['month'] = $month;
            $data[$k]['year'] = $year;
            $data[$k]['dm_id'] = $k;
            
        }   
        $charts = M('target_chart1');
        foreach ($data as $v){
            $charts->add($v);
        }
    }
    function table2($year,$month) {
        if(empty($year)){
            $year = date('Y');
        }
        if(empty($month)){
            $month = (int)date('m');
        }
        $chart = M('target_chart2');
        $res = $chart->where("year='{$year}' and month='{$month}'")->select();
        if(!empty($res)){
            $chart->where("year='{$year}' and month='{$month}'")->delete();
        }
        $starttime = mktime(0,0,0,$month,1,$year);
        $endtime = mktime(0,0,0,$month+1,1,$year)-1;
        $wheresl['entry_time'] = array(array('egt',$starttime),array('elt',$endtime));
        $wheresl['a.library_id'] ='1';
        $data_list = M('target_loanbusiness')->alias('a')
                ->field('a.dept_id AS dm_id,a.carbrand_id,b.carbrand_name,a.carseries_id,c.carseries_name,COUNT(*) AS fktc,SUM(a.zxservice_cost) AS sf')
                ->join('LEFT JOIN think_target_carbrand b ON a.carbrand_id=b.id')
                ->join('LEFT JOIN think_target_carseries c ON a.carseries_id=c.id')
                ->join('LEFT JOIN think_target_carsize d ON a.carsize_id=d.id')
                ->where($wheresl)
                ->group('carseries_id,dept_id')
                ->select();
        $data = array();
        foreach ($data_list as $k => $v) {
            $data[$k]['dm_id'] = $v['dm_id'];
            $data[$k]['year'] = $year;
            $data[$k]['month'] = $month;
            $data[$k]['carbrand_id'] = $v['carbrand_id'];
            $data[$k]['carbrand'] = $v['carbrand_name'];
            $data[$k]['carseries_id'] = $v['carseries_id'];
            $data[$k]['carseries'] = $v['carseries_name'];
            $data[$k]['fktc'] = $v['fktc'];
            $data[$k]['sf'] = $v['sf'];
            $data[$k]['asp'] = $v['sf']/$v['fktc'];
        }
        
        $data_list = array();
        $charts = M('target_chart2');
        foreach ($data as $v){
            $charts->add($v);
        }
    }
    function table3($year,$month) {
        if(empty($year)){
            $year = date('Y');
        }
        if(empty($month)){
            $month = (int)date('m');
        }
        
        $chart2 = M('target_chart2');
        $data_list = $chart2->where("year='{$year}' and month='{$month}'")->select();

        $chart3 = M('target_chart3');
        $res = $chart3->where("year='{$year}' and month='{$month}'")->select();
        if(!empty($res)){
            $chart3->where("year='{$year}' and month='{$month}'")->delete();
        }
        $data = array();
        foreach ($data_list as $k => $v) {
            $data[$k]['dm_id'] = $v['dm_id'];
            $data[$k]['year'] = $year;
            $data[$k]['month'] = $month;
            $data[$k]['carbrand_id'] = $v['carbrand_id'];
            $data[$k]['carbrand'] = $v['carbrand'];
            $data[$k]['carseries_id'] = $v['carseries_id'];
            $data[$k]['carseries'] = $v['carseries'];
            $ser = M('target_seriesdata')->field('number')->where(array('carserie_id'=>$v['carseries_id']))->select();
            if(!empty($ser)){
                $data[$k]['byst'] = $v['fktc']/$ser[0]['number'];
            }
            $maps['month'] = $month-1;
            $maps['year'] = $year;
            $maps['carseries_id'] = $v['carseries_id'];
            $syst = M('target_chart3')->field('byst')->where($maps)->select();
            $data[$k]['syst'] = $syst[0]['syst'];
            if(!empty($data[$k]['syst'])  && !empty($data[$k]['byst'])){
                $data[$k]['hb'] = ($data[$k]['byst']-$data[$k]['syst'])/$data[$k]['syst'];
            }
        }
        $charts = M('target_chart3');
        foreach ($data as $v){
            $charts->add($v);
        }
        //表4
        
        $this->table4($year, $month, $data_list);
    }
    function table4($year,$month,$data_list) {
        
        $chart4 = M('target_chart4');
        $res = $chart4->where("year='{$year}' and month='{$month}'")->select();
        if(!empty($res)){
            $chart4->where("year='{$year}' and month='{$month}'")->delete();
        }
        foreach ($data_list as $k => $v) {
            $data[$k]['dm_id'] = $v['dm_id'];
            $data[$k]['year'] = $year;
            $data[$k]['month'] = $month;
            $data[$k]['carbrand_id'] = $v['carbrand_id'];
            $data[$k]['carbrand'] = $v['carbrand'];
            $data[$k]['carseries_id'] = $v['carseries_id'];
            $data[$k]['carseries'] = $v['carseries'];
            $data[$k]['byasp'] = $v['asp'];
            $maps['month'] = $month-1;
            $maps['year'] = $year;
            $maps['carseries_id'] = $v['carseries_id'];
            $syst = M('target_chart4')->field('byasp')->where($maps)->select();
            $data[$k]['syasp'] = $syst[0]['syasp'];
            if(!empty($data[$k]['syasp'])  && !empty($data[$k]['byasp'])){
                $data[$k]['hb'] = ($data[$k]['byasp']-$data[$k]['syasp'])/$data[$k]['syasp'];
            }
        }
        $charts = M('target_chart4');
        foreach ($data as $v){
            $charts->add($v);
        }
        $this->table5($year, $month, $data_list);
    }
     function table5($year,$month,$data_list) {
         $chart5 = M('target_chart5');
        $res = $chart5->where("year='{$year}' and month='{$month}'")->select();
        if(!empty($res)){
            $chart5->where("year='{$year}' and month='{$month}'")->delete();
        }
        foreach ($data_list as $k => $v) {
            $data[$k]['dm_id'] = $v['dm_id'];
            $data[$k]['year'] = $year;
            $data[$k]['month'] = $month;
            $data[$k]['carbrand_id'] = $v['carbrand_id'];
            $data[$k]['carbrand'] = $v['carbrand'];
            $data[$k]['carseries_id'] = $v['carseries_id'];
            $data[$k]['carseries'] = $v['carseries'];
            $data[$k]['bytc'] = $v['fktc'];
            $maps['month'] = $month-1;
            $maps['year'] = $year;
            $maps['carseries_id'] = $v['carseries_id'];
            $syst = M('target_chart5')->field('bytc')->where($maps)->select();
            $data[$k]['sytc'] = $syst[0]['sytc'];
            if(!empty($data[$k]['sytc'])  && !empty($data[$k]['bytc'])){
                $data[$k]['hb'] = ($data[$k]['bytc']-$data[$k]['sytc'])/$data[$k]['sytc'];
            }
        }
        $charts = M('target_chart5');
        foreach ($data as $v){
            $charts->add($v);
        }
        $this->table6($year, $month, $data_list);
    }
    function table6($year,$month,$data_list) {
        $chart6 = M('target_chart6');
        $res = $chart6->where("year='{$year}' and month='{$month}'")->select();
        if(!empty($res)){
            $chart6->where("year='{$year}' and month='{$month}'")->delete();
        }
        foreach ($data_list as $k => $v) {
            $data[$k]['dm_id'] = $v['dm_id'];
            $data[$k]['year'] = $year;
            $data[$k]['month'] = $month;
            $data[$k]['carbrand_id'] = $v['carbrand_id'];
            $data[$k]['carbrand'] = $v['carbrand'];
            $data[$k]['carseries_id'] = $v['carseries_id'];
            $data[$k]['carseries'] = $v['carseries'];
            $data[$k]['bysf'] = $v['sf'];
            $maps['month'] = $month-1;
            $maps['year'] = $year;
            $maps['carseries_id'] = $v['carseries_id'];
            $syst = M('target_chart6')->field('bysf')->where($maps)->select();
            $data[$k]['sysf'] = $syst[0]['sysf'];
            if(!empty($data[$k]['sysf'])  && !empty($data[$k]['bysf'])){
                $data[$k]['hb'] = ($data[$k]['bysf']-$data[$k]['sysf'])/$data[$k]['sysf'];
            }
        }
        $charts = M('target_chart6');
        foreach ($data as $v){
            $charts->add($v);
        }
    }
    /*
     * 除法计算
     * $a zx渠道
     * $b fd渠道
     * $c asp渠道
     */
    private function asp($a,$b){ //asp计算规则
        if(!empty($a) && !empty($b)){
            return $a/$b;
        }else{
            return "";
        }
    }
    
    



    
}
