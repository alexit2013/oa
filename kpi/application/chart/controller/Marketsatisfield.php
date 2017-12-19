<?php
/*--------------------------------------------------------------------
广汇KPI报表--市占率和满意度表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;

class Marketsatisfield extends Base{

    public function index(){
        //查询条件
        $where = $this->search();
        $list = Db::name('kpi_marketdegree')->where($where)->select();
        $data_list = $this->_data_list($list);
         //报表审批是否通过
        $up['a.store_id']=$where['store_id'];
        $up['a.year']=$where['year'];
        $up['a.chart_deptclass_id']=27;
        $data_status=check_flow_year($up);
        $this->assign([
            'data_list' => $data_list,
            'year' => $where['year'],
            'data_status'=>$data_status
        ]);
        //dump($data_list);
        return view();
    }
    /*按类型分类*/
    private function _data_list($data){
        $data_list = array();
        foreach($data as $v){
            $data_list['manufacturer_target'][$v['year']."-".$v['month']] = $v['manufacturer_target'];  //厂家目标
            $data_list['actual_reach'][$v['year']."-".$v['month']] = $v['actual_reach'];  //实际达成
            $data_list['ssi_tel_score'][$v['year']."-".$v['month']] = $v['ssi_tel_score'];  //ssi-电话-得分
            $data_list['ssi_tel_regionrank'][$v['year']."-".$v['month']] = $v['ssi_tel_regionrank'];  //ssi-电话-分区排名
            $data_list['ssi_tel_countryrank'][$v['year']."-".$v['month']] = $v['ssi_tel_countryrank'];  //ssi-电话-全国排名
            $data_list['ssi_mystery_score'][$v['year']."-".$v['month']] = $v['ssi_mystery_score'];  //ssi-神秘客-得分
            $data_list['ssi_mystery_regionrank'][$v['year']."-".$v['month']] = $v['ssi_mystery_regionrank'];  //ssi-神秘客-分区排名
            $data_list['ssi_mystery_countryrank'][$v['year']."-".$v['month']] = $v['ssi_mystery_countryrank'];  //ssi-神秘客-全国排名
            $data_list['csi_tel_score'][$v['year']."-".$v['month']] = $v['csi_tel_score'];  //csi-电话-得分
            $data_list['csi_tel_regionrank'][$v['year']."-".$v['month']] = $v['csi_tel_regionrank'];  //csi-电话-分区排名
            $data_list['csi_tel_countryrank'][$v['year']."-".$v['month']] = $v['csi_tel_countryrank'];  //csi-电话-全国排名
            $data_list['csi_mystery_score'][$v['year']."-".$v['month']] = $v['csi_mystery_score'];  //csi-神秘客-得分
            $data_list['csi_mystery_regionrank'][$v['year']."-".$v['month']] = $v['csi_mystery_regionrank'];  //csi-神秘客-分区排名
            $data_list['csi_mystery_countryrank'][$v['year']."-".$v['month']] = $v['csi_mystery_countryrank'];  //csi-神秘客-全国排名
            $data_list['mystery_sale'][$v['year']."-".$v['month']] = $v['mystery_sale'];  //销售得分
            $data_list['mystery_after'][$v['year']."-".$v['month']] = $v['mystery_after'];  //售后得分
            $data_list['quality'][$v['year']."-".$v['month']] = $v['quality'];  //数据质量
            $data_list['spq'][$v['year']."-".$v['month']] = $v['spq'];  //SPQ
        }
        return $data_list;
    }
    /*搜索条件*/
    protected function search(){
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
        return $where;
    }

    public function add(){
        if(Request::instance()->isAjax()){
            $data=input('param.');

            $about['store_id']=$data['store_id']; //门店ID
            $about['manufacturer_target']=$data['manufacturer_target']; //厂家目标
            $about['actual_reach']=$data['actual_reach']; //实际达成
            $about['ssi_tel_score']=$data['ssi_tel_score']; //ssi-电话-得分
            $about['ssi_tel_regionrank']=$data['ssi_tel_regionrank']; //ssi-电话-分区排名
            $about['ssi_tel_countryrank']=$data['ssi_tel_countryrank']; //ssi-电话-全国排名
            $about['ssi_mystery_score']=$data['ssi_mystery_score']; //ssi-神秘客-得分
            $about['ssi_mystery_regionrank']=$data['ssi_mystery_regionrank'];//ssi-神秘客-分区排名
            $about['ssi_mystery_countryrank']=$data['ssi_mystery_countryrank']; //ssi-神秘客-全国排名
            $about['csi_tel_score']=$data['csi_tel_score']; //csi-电话-得分
            $about['csi_tel_regionrank']=$data['csi_tel_regionrank']; //csi-电话-分区排名
            $about['csi_tel_countryrank']=$data['csi_tel_countryrank']; //ssi-电话-全国排名
            $about['csi_mystery_score']=$data['csi_mystery_score']; //csi-神秘客-得分
            $about['csi_mystery_regionrank']=$data['csi_mystery_regionrank']; //csi-神秘客-分区排名
            $about['csi_mystery_countryrank']=$data['csi_mystery_countryrank']; //csi-神秘客-全国排名
            $about['mystery_sale']=$data['mystery_sale']; //销售得分
            $about['mystery_after']=$data['mystery_after']; //售后得分
            $about['quality']=$data['quality']; //数据质量
            $about['spq']=$data['spq']; //SPQ
            $about['year'] = $data['year'];
            $about['month'] = $data['month'];

            Db::startTrans();
            $sigle_data = Db::name('kpi_marketdegree')
                       ->where('year',$data['year'])
                       ->where('month',$data['month'])
                       ->where('store_id',$data['store_id'])
                       ->select();
            //判断一个月只能添加一次
            if(!empty($sigle_data)){
                    $reslut['msg']='本月已经新增过数据!';
                    $reslut['status']='0';
                    Db::rollback();
             }else{                
               $rebate_id=Db::name('kpi_marketdegree')->insertGetId($about);

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