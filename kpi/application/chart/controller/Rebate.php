<?php
/*--------------------------------------------------------------------
广汇KPI报表--返利计算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;
class Rebate extends Base{
    //返利计算表
    public function index(){
            $search_data = input('param.');

            $where = $this->search($search_data);
           
            $this->assign('search_data',$search_data);
        
        if(empty($where)){
            
            $year=date('Y');
            $month=date('n');
            if($month==1){
                $premonth=12;
                $preyear=$year-1;
            }else{
                $premonth=$month-1;
                $preyear=$year;
            }
            //实际
            $map_actual['a.is_del']=0;
            $map_actual['a.year']=$preyear;
            $map_actual['a.month']=$premonth;
            $map_actual['a.type']=1; //实际
            $map_actual['a.store_id']=get_comlist()[0]['ID'];
            //预计
            $map_expect['a.is_del']=0;
            $map_expect['a.year']=$year;
            $map_expect['a.month']=$month;
            $map_expect['a.type']=2; //预计
            $map_expect['a.store_id']=get_comlist()[0]['ID'];
            //返利预估数据（实际）
            $map_des_actual['month']=$premonth;
            $map_des_actual['year']=$preyear;
            $map_des_actual['store_id']=get_comlist()[0]['ID'];
            $map_des_actual['type']=1;
            //返利预估数据（预计）
            $map_des_expect['month']=$month;
            $map_des_expect['year']=$year;
            $map_des_expect['store_id']=get_comlist()[0]['ID'];
            $map_des_expect['type']=2;
            //返利名称
            $map_rebatename['a.store_id']=get_comlist()[0]['ID'];
            $map_rebatename['c.is_del']=0;
            
        }else{
            $year=$where['a.year'];
            $month=$where['a.month'];
            if($month==1){
                $premonth=12;
                $preyear=$year-1;
            }else{
                $premonth=$month-1;
                $preyear=$year;
            }
            //实际
            $map_actual['a.is_del']=0;
            $map_actual['a.month']=$premonth;
            $map_actual['a.year']=$preyear;
            $map_actual['a.store_id']=$where['a.store_id'];
            $map_actual['a.type']=1;

            //预计
            $map_expect['a.is_del']=0;
            $map_expect['a.year']=$year;
            $map_expect['a.month']=$month;
            $map_expect['a.type']=2;
            $map_expect['a.store_id']=$where['a.store_id'];

            //返利预估数据（实际）
            $map_des_actual['year']=$preyear;
            $map_des_actual['month']=$premonth;
            $map_des_actual['type']=1;
            $map_des_actual['store_id']=$where['a.store_id'];
            //返利预估数据（预计）
            $map_des_expect['year']=$year;
            $map_des_expect['month']=$month;
            $map_des_expect['type']=2;
            $map_des_expect['store_id']=$where['a.store_id'];
            //返利名称
            $map_rebatename['c.is_del']=0;
            $map_rebatename['a.store_id']=$where['a.store_id'];

        }
        //全部返利名称
        $rebatenameres=Db::name('kpi_store_carbrand')->alias('a')
            ->field('c.*,b.carbrand_name')
            ->join('kpi_carbrand b','a.carbrand_id=b.id','LEFT')
            ->join('kpi_rebatename c','c.carbrand_id=b.id','LEFT')
            ->where($map_rebatename)
            ->select();
        //统计返利名称个数
        $rebatenamenum=Db::name('kpi_store_carbrand')->alias('a')
            ->field('c.*,b.carbrand_name')
            ->join('kpi_carbrand b','a.carbrand_id=b.id','LEFT')
            ->join('kpi_rebatename c','c.carbrand_id=b.id','LEFT')
            ->where($map_rebatename)
            ->count();
            // $rebatenameres=Db::name('kpi_rebatename')->where('is_del=0')->select(); //全部返利名称
            // $rebatenamenum=Db::name('kpi_rebatename')->count(); //统计返利名称个数
            $rebate_des=Db::name('kpi_rebate_des')->where($map_des_actual)->find(); //实际
            $rebate_des_expect=Db::name('kpi_rebate_des')->where($map_des_expect)->find(); //预计
            $actual = $this->touch($map_actual); //实际
            $expect = $this->touch($map_expect); //预计
            
            //报表审批是否通过
            $up['a.store_id']=$map_expect['a.store_id'];
            $up['a.year']=$map_expect['a.year'];
            $up['a.month']=$map_expect['a.month'];
            $up['a.chart_deptclass_id']=17;
            $data_status=check_flow_month($up);
            
            $this -> assign('data_status',$data_status);
            $this -> assign('rebate_des',$rebate_des);
            $this -> assign('rebate_des_expect',$rebate_des_expect);
            $this -> assign('rebatenamenum',$rebatenamenum);
            $this -> assign('rebatenameres',$rebatenameres);
            $this -> assign('actual_data',$actual);
            $this -> assign('expect_data',$expect);
            $this -> assign('year',$year);
            $this -> assign('month',$month);
            $this -> assign('preyear',$preyear);
            $this -> assign('premonth',$premonth);
            return view();
    }

    //返利信息添加
    public function add(){
        if(Request::instance()->isAjax()){
            $data=input('param.');

            $about['store_id']=$data['store_id']; //门店ID
            $about['carbrand_id']=$data['carbrand']; //品牌ID
            $about['carsize_id']=$data['carsize']; //车系id
            $about['carseries_id']=$data['carseries']; //车系ID
            $about['sales_num']=$data['sale_datass']; //销售台次
//            $about['into_seling_diffprice']=$data['selling_price']-$data['market_guidance_price'];//进差价
//            $about['marketprice']=$data['market_guidance_price']; //市场指导价
//            $about['batchprice']=$data['selling_price']; //批售价
            $about['year']=$data['iyear']; //年
            $about['month']=$data['imonth']; //月
            $about['type']=$data['rebate_data']; //预计或实际
            $about['add_time']=time();
            Db::startTrans();
           $rebate_id=Db::name('kpi_rebate')->insertGetId($about);

           if(!empty($rebate_id)){
            
                foreach ($data['reinfo'] as $key => $val) {
                    $source['rebate_name_id']=$val['id'];
                    $source['rebate_val']=$val['value'];
                    $source['rebate_name']=$val['name'];
                    $source['rebate_id']=$rebate_id;
                    $res=Db::name('kpi_rebatename_val')->insert($source);
                    if(empty($res)){
                        $reslut['msg']='添加失败!';
                        $reslut['status']='0';
                        Db::rollback();
                        return json($reslut);
                    }
                }
                $reslut['msg']='添加成功';
                $reslut['status']='1';
                Db::commit();
           }else{
                $reslut['msg']='添加失败!';
                $reslut['status']='0';
                Db::rollback();
           } 

           return json($reslut);
        }else{
            $store=get_comlist();  //所属门店
            // $this ->assign('rebatename',getrebatename());
            $this -> assign('stores',$store);
            return view();
        }
    }
    //品牌下的返利名称
    public function getrebatenameBycarbrand(){
        $data=input('param.');
        $carbrand_id=$data['carbrand_id'];
        $rebatename=Db::name('kpi_rebatename')->field('id,rebate_name')->where(array('carbrand_id'=>$carbrand_id,'is_del'=>0))->select();
        return json($rebatename);
    }
    //搜索
    public function search($data){
        
        $map = array();

        if(empty($data['store_id'])){
           $map['a.store_id']=get_comlist()[0]['ID'];
        }else{
            $map['a.store_id']=$data['store_id'];
        }
        if(empty($data['year'])){     //年
            $map['a.year']=date('Y');
        }else{
            $map['a.year']=$data['year'];
        }
        if(!empty($data['month'])){   //月
            $map['a.month']=$data['month'];
        }else{
            $map['a.month']=date('n'); 
        }
        return $map;
    }

    private function touch($map){
        $res=Db::name('kpi_rebate')->alias('a')
            ->field('a.*,b.carseries_name,b.is_import,c.carsize_name,c.guide_price,c.invoice_price')
            ->join('kpi_carseries b','a.carseries_id=b.id','LEFT')
            ->join('kpi_carsize c','a.carsize_id=c.id','LEFT')
            ->where($map)
            ->select();
            $sales_sum=0;
            $sum=array();
            $data=array();
            foreach ($res as $key => &$val) {
                $sales_sum+=$val['sales_num'];
                $data[$val['carseries_name']][$key]['id']=$val['id'];
                $data[$val['carseries_name']][$key]['sales_num']=$val['sales_num'];
                $data[$val['carseries_name']][$key]['marketprice']=$val['guide_price'];
                $data[$val['carseries_name']][$key]['batchprice']=$val['invoice_price'];
                $data[$val['carseries_name']][$key]['into_seling_diffprice']=$val['guide_price']-$val['invoice_price'];
                $data[$val['carseries_name']][$key]['year']=$val['year'];
                $data[$val['carseries_name']][$key]['month']=$val['month'];
                $data[$val['carseries_name']][$key]['type']=$val['type'];
                $data[$val['carseries_name']][$key]['carsize_name']=$val['carsize_name'];
                $data[$val['carseries_name']][$key]['rebate']=$val['rebate']=Db::name('kpi_rebatename_val')->where('rebate_id='.$val['id'])->column("rebate_name,rebate_val");
                
                foreach ($val['rebate'] as $k => $v) {
                    if(!isset($sum[$k])){
                        $sum[$k]=0;
                    }
                    $data[$val['carseries_name']][$key]['tax_rebate'][$k]=round($val['sales_num']*$v/1.17/10000,2);
                    
                    $sum[$k]= $sum[$k]+round($val['sales_num']*$v/1.17/10000,2);
                }
            }

            $reslut['sum']=$sum;
            $reslut['data_list'] = $data;
            $reslut['sales_sum'] = $sales_sum;
            return $reslut;
    }

    //返利名称列表 
    public function rebatenameindex(){
        $stores=get_comlist();
        $str_store=implode(',',array_column($stores,'ID'));
        $map['a.store_id']=['IN',$str_store];
                $res=Db::name('kpi_store_carbrand')->alias('a')
                    ->field('c.*,b.carbrand_name,d.NAME,d.id as store_id')
                    ->join('think_kpi_carbrand b','a.carbrand_id=b.id','LEFT')
                    ->join('think_kpi_rebatename c','c.carbrand_id=b.id','LEFT')
                    ->join('think_dept d','d.id=a.store_id','LEFT')
                    ->where($map)
                    ->paginate(15);
       
      $data=$this -> index_callback($res);
   
        // $res=Db::name('kpi_rebatename')->where('is_del=0')->paginate(15);
        $page = $res->render(); 
        $this -> assign('data_list',$data);
        $this -> assign('page',$page);        
        return view();
    }
    //回调过滤返利名称为空的数据
    function index_callback($res){
        $data=array();
        foreach ($res as $key => $value) {
            if(!empty($value['rebate_name'])){
                $data[$key]['rebate_name']=$value['rebate_name'];
                $data[$key]['id']=$value['id'];
                $data[$key]['carbrand_name']=$value['carbrand_name'];
                $data[$key]['store_id']=$value['store_id'];
                $data[$key]['carbrand_id']=$value['carbrand_id'];
                $data[$key]['store_name']=$value['NAME'];
            }
        }
        return $data;
    }

    //返利名称添加
    public function rebatenameadd(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $about['carbrand_id']=$data['carbrand'];
            foreach ($data['rebate_name'] as $key => $value) {
                    $about['rebate_name']=$value; //配置名称
                    $res=Db::name('kpi_rebatename')->insert($about);
                    if(empty($res)){
                        $reslut['msg']='添加失败';
                        $reslut['status']='0';
                        return json($reslut);
                    }
            }
           $reslut['msg']='添加成功';
           $reslut['status']='1';
           return json($reslut);
        }else{
            $this ->assign('store',get_comlist());
            return view();
        }
    }

    //返利名称修改
    public function reabtenameedit(){
            $id=input('param.id');
        if(Request::instance()->isAjax()){
                $map['id']=$id;
                $data=input('param.rebate_name');
                $res=Db::name('kpi_rebatename')->where($map)->update($data);
                if($res){
                    $reslut['msg']='操作成功';
                    $reslut['status']='1';
                }else{
                    $reslut['msg']='操作失败';
                    $reslut['status']='0';
                }
            return json($reslut);
        }else{
            
            $rebatename=Db::name('kpi_rebatename')->field('id,rebate_name,carbrand_id')->where('id='.$id)->find(); //选中返利名称
            $this -> assign('rebatename',$rebatename);

        }

    }

    //返利名称删除
    public function rebatenamedel(){
        $id=input('param.id');
        $res=Db::name('kpi_rebatename')->delete($id);
            if($res){
                $reslut['msg']='操作成功';
                $reslut['status']='1';
            }else{
                $reslut['msg']='操作失败';
                $reslut['status']='0';
            }
        return json($reslut);
    }

    //返利预估数据添加
    public function adddata(){
        if(Request::instance()->isAjax()){
        $data=input('param.');
           $about['type']=$data['rebate_data'];//类型
           $about['store_id']=$data['store_id'];//门店ID
           $about['s_rebate']=$data['market_promotion_data'];//市场推广返利
           $about['m_rebate']=$data['satisfaction_data'];//当期满意度类预估返利
           $about['j_rebate']=$data['check_data'];//日常检查类返利
           $about['d_rebate']=$data['big_customer_data'];//大客户类型返利
           $about['dq_rebate']=$data['other_data'];//当期其他类返利
           $about['q_rebate']=$data['not_estimate_data'];//前期未预估的补估返利
           $about['year']=$data['iyear'];
           $about['month']=$data['imonth'];
           $once = Db::name('kpi_rebate_des')
                ->where('store_id',$data['store_id'])
                ->where('year',$data['iyear'])
                ->where('month',$data['imonth'])
                ->where('type',$data['rebate_data'])
                ->find();
            if(!empty($once)){
                $reslut['msg']='该类型该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $res=Db::name('kpi_rebate_des')->insert($about);            
                if($res){
                    $reslut['msg']='操作成功';
                    $reslut['status']='1';
                }else{
                    $reslut['msg']='操作失败';
                    $reslut['status']='0';
                }
                return json($reslut);
            }            
        }else{
            $this ->assign('store',get_comlist());
            return view();
        }
    }
    

}