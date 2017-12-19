<?php
/*--------------------------------------------------------------------
广汇KPI报表--市场营销预算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Marketbudget extends Base{

    public function index(){
        $map = $this->search();
        $mark = $this->market($map);    //市场营销
        $custom = Db::name('kpi_market_custom')->where($map)->find();   //市场营销客户
        
        $mlast = $this->mlast($map);    //上月市场营销
        $mlastid = $this->mlast2($map);    //上月市场营销id
        $cuslast = $this->customlast($map); //上月客户来源
        $cuslastid = $this->customlast2($map); //上月客户来源id
        //报表审批是否通过
            $up['a.store_id']=$map['store_id'];
            $up['a.year']=$map['year'];
            $up['a.month']=$map['month'];
            $up['a.chart_deptclass_id']=23;
            $data_status=check_flow_month($up);
            
        $this->assign([
            'mark'=>$mark,
            'custom'=>$custom,
            'mlast' => $mlast,
            'mlast2' => $mlastid,
            'cuslast' => $cuslast,
            'cuslast2' => $cuslastid,
            'data_status'=>$data_status //审批状态
                ]);
        return view();
    }
    /*
     * 本月市场费用
     * @param $map 查询条件
     */
    protected function market($map){
        $list = Db::name('kpi_market')->alias('a')
                ->field('a.id,a.plan_y,a.pay_y,a.plan_m,a.pay_m,a.mark,mt.name')
                ->join('think_kpi_market_type mt','a.type_id=mt.id','LEFT')
                ->where($map)->select();
        $data_list = array();
        foreach($list as $v){
            $data_list[$v['name']]['id'] = $v['id'];
            $data_list[$v['name']]['plan_y'] = $v['plan_y'];
            $data_list[$v['name']]['pay_y'] = $v['pay_y'];
            $data_list[$v['name']]['surplus'] = $v['plan_y']-$v['pay_y'];   //盈余
            if($v['plan_y']>0 && $v['pay_y']>0){
                $data_list[$v['name']]['use'] = round($v['pay_y']/$v['plan_y'],3)*100;   //使用率
            }else{
                $data_list[$v['name']]['use'] = 0;
            }
            $data_list[$v['name']]['plan_m'] = $v['plan_m'];
            $data_list[$v['name']]['pay_m'] = $v['pay_m'];
            $data_list[$v['name']]['mark'] = $v['mark'];
            if(!isset($data_list['合计']['plan_y'])){
                $data_list['合计']['plan_y'] = 0;
            }
            $data_list['合计']['plan_y'] += $v['plan_y'];
            if(!isset($data_list['合计']['pay_y'])){
                $data_list['合计']['pay_y'] = 0;
            }
            $data_list['合计']['pay_y'] += $v['pay_y'];
            if(!isset($data_list['合计']['plan_m'])){
                $data_list['合计']['plan_m'] = 0;
            }
            $data_list['合计']['plan_m'] += $v['plan_m'];
            if(!isset($data_list['合计']['pay_m'])){
                $data_list['合计']['pay_m'] = 0;
            }
            $data_list['合计']['pay_m'] += $v['pay_m'];
            if(!isset($data_list['合计']['mark'])){
                $data_list['合计']['mark'] = "";
            }
        }
        return $data_list;
    }
    /*
     * 上月市场营销
     * @param $map 查询条件
     */
    protected function mlast($map){
        $list = Db::name('kpi_market_last')->alias('a')
                ->field('a.investment,a.id,mt.name')
                ->join('think_kpi_market_type mt','a.type_id=mt.id','LEFT')
                ->where($map)->select();
        $data_list = array();
        foreach ($list as $v) {            
            $data_list[$v['name']] = $v['investment'];
        }
        return $data_list;
    }
    protected function mlast2($map){
        $list = Db::name('kpi_market_last')->alias('a')
                ->field('a.investment,a.id,mt.name')
                ->join('think_kpi_market_type mt','a.type_id=mt.id','LEFT')
                ->where($map)->select();
        $info_list = array();
        foreach ($list as $v) {            
            $info_list[$v['name']] = $v['id'];
        }
        return $info_list;
    }
    /*
     * 上月市场营销客户来源
     * @param $map 查询条件
     */
    protected function customlast($map){
        $list = Db::name('kpi_market_customlast')->alias('a')
                ->field('a.file,mt.name')
                ->join('think_kpi_market_type mt','a.type_id=mt.id','LEFT')
                ->where($map)->select();
        $data_list = array();
        foreach ($list as $v) {
            $data_list[$v['name']] = $v['file'];
        }
        return $data_list;
    }
    protected function customlast2($map){
        $list = Db::name('kpi_market_customlast')->alias('a')
                ->field('a.file,a.id,mt.name')
                ->join('think_kpi_market_type mt','a.type_id=mt.id','LEFT')
                ->where($map)->select();
        $data_list = array();
        foreach ($list as $v) {
            $data_list[$v['name']] = $v['id'];
        }
        return $data_list;
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
    
    //添加市场营销预算数据
    public function customadd(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.'); 
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];
            $data['sale_one'] = $data_add['sale_one'];
            $data['sale_two'] = $data_add['sale_two'];
            $data['deal_y'] = $data_add['deal_y'];
            $data['deal_gh'] = $data_add['deal_gh'];
            $data['file_y'] = $data_add['file_y'];
            $data['file_gh'] = $data_add['file_gh'];
            $res = Db::name('kpi_market_custom')
                ->where('store_id',$data_add['store_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $reslut = Db::name('kpi_market_custom')->insert($data);            
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
    
    //添加本月客流目标数据
    public function add(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.'); 
            $data['type_id'] = $data_add['type_id'];
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];
            $data['plan_y'] = $data_add['plan_y'];
            $data['pay_y'] = $data_add['pay_y'];
            $data['plan_m'] = $data_add['plan_m'];
            $data['pay_m'] = $data_add['pay_m'];
            $data['mark'] = $data_add['mark'];
            $res = Db::name('kpi_market')
                ->where('type_id',$data_add['type_id'])
                ->where('store_id',$data_add['store_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该费用类型该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_market')->insert($data);
                if($result){
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
    
    //添加上月客户来源数据
    public function cuslastadd(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.'); 
            $data['type_id'] = $data_add['type_id'];
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];
            $data['file'] = $data_add['file'];
            $res = Db::name('kpi_market_customlast')
                ->where('type_id',$data_add['type_id'])
                ->where('store_id',$data_add['store_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该费用类型该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_market_customlast')->insert($data);
                if($result){
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
    
    //添加上月市场费用流向数据
    public function marlastadd(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.'); 
            $data['type_id'] = $data_add['type_id'];
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];
            $data['investment'] = $data_add['investment'];
            $res = Db::name('kpi_market_last')
                ->where('type_id',$data_add['type_id'])
                ->where('store_id',$data_add['store_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该费用类型该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_market_last')->insert($data);
                if($result){
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
    
}