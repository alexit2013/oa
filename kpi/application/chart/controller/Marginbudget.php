<?php
/*--------------------------------------------------------------------
广汇KPI报表--月毛利预算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;

class Marginbudget extends Base{

    public function index(){
        
        $map = $this->search();
        $margin_m = new \app\chart\model\Marginbudget();
        $sale_margin = $margin_m->monthsalemargin($map);    //月销售正常毛利预测
        $lirun = Db::name('kpi_profitbudget')->field('pm_actualNum,pm_expectAmount')->where($map)->where('project_id=5')->find();//主营业务收入-整车
        $lirun_one = Db::name('kpi_profitbudget')->field('pm_actualNum,pm_expectAmount')->where($map)->where('project_id=10')->find();//主营业务成本-整车
        $fanli = $margin_m->fanli($map);    //返利
        $yufanli = $margin_m->yufanli($map);    //预返利
        $xupiao = Db::name('kpi_month_carprofit_piao')->where($map)->find();    //需开票
        $decorate_class = $margin_m->decorate_class($map);  //装饰客单价
        $decorate_focus = Db::name('kpi_month_decorate_focus')->where($map)->find();    //集中产品
        $decorate_emphasis = Db::name('kpi_month_decorate_emphasis')->where($map)->select();  //装饰业务-重点产品
        $insurance = $margin_m->insurance($map);    //新保业务
        $newcar = $margin_m->newcar($map);  //新车延保
        $carloan = $margin_m->carloan($map); //车贷业务
        $mortgage = Db::name('kpi_month_mortgage_num')->where($map)->find();//厂家金融及银行按揭台次
        $repair = $margin_m->repair($map); //维修业务
        $three_card = $margin_m->three_card($map);  //三卡业务
        $renewal = $margin_m->renewal($map);   //续保业务
        $renewal_pen = Db::name('kpi_month_penetrance')->where($map)->find();   //续保渗透率目标
        $non_newcar = $margin_m->non_newcar($map); //非新车业务
        $other = $margin_m->other($map);    //其他业务
        $other_cost = Db::name('kpi_month_other_cost')->where($map)->find();   //续保渗透率目标
        $profit_Vehicle=Db::name('kpi_profitbudget')->field('pm_actualNum,pm_expectAmount')->where('project_id=5')->where($map)->find();//利润表整车
        //报表审批是否通过
            $up['store_id']=$map['store_id'];
            $up['year']=$map['year'];
            $up['month']=$map['month'];
            $up['chart_deptclass_id']=1;
            $up['status']=1;
            $data_status=operate_chart($up);
            
        $this->assign([
            'sale_margin'=>$sale_margin,
            'fanli'=>$fanli,
            'yufanli'=>$yufanli,
            'xupiao'=>$xupiao,
            'lirun'=>$lirun,
            'lirun_one'=>$lirun_one,
            'decorate_class'=>$decorate_class,
            'decorate_focus'=>$decorate_focus,
            'decorate_emphasis'=>$decorate_emphasis,
            'insurance'=>$insurance,
            'mortgage'=>$mortgage,
            'newcar'=>$newcar,
            'carloan'=>$carloan,
            'repair'=>$repair,
            'three_card'=>$three_card,
            'renewal'=>$renewal,
            'renewal_pen'=>$renewal_pen,
            'non_newcar'=>$non_newcar,
            'other'=>$other,
            'other_cost'=>$other_cost,
            'data_status'=>$data_status, //审批状态
            'profit_Vehicle'=>$profit_Vehicle
                ]);
        $type = input('param.type');
        switch ($type) {
            case '1':   //销售部
            $this -> chirld_status($map,$type='2');
                return view('x_index');
                break;
            case '9':   //装饰部
            $this -> chirld_status($map,$type='6');
                return view('z_index');
                break;
            case '8':   //保险部
            $this -> chirld_status($map,$type='5');
                return view('b_index');
                break;
            case '2':   //售后部
            $this -> chirld_status($map,$type='3');
                return view('s_index');
                break;
            case '7':   //金融部
            $this -> chirld_status($map,$type='4');
                return view('j_index');
                break;
            default:
                return view();
                break;
        }
    }
    //子表状态
    private  function chirld_status($map,$type){
            $where['store_id']=$map['store_id'];
            $where['year']=$map['year'];
            $where['month']=$map['month'];
            $where['chart_deptclass_id']=$type;
            $data_dan=check_flow_month($where);
            $this -> assign('data_dan',$data_dan);
    }
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

    //月销售正常毛利预测
    public function normaladd(){
        if(request()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['carbrand_id'] = $data_add['carbrand_id'];
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['expect_num'] = $data_add['expect_num'];
            $data['actual_num'] = $data_add['actual_num'];
            $data['expect_margin'] = $data_add['expect_margin'];
            $data['actual_margin'] = $data_add['actual_margin'];
            $data['expect_marginprofit'] = $data_add['expect_marginprofit'];
            $data['actual_marginprofit'] = $data_add['actual_marginprofit'];

            $res = Db::name('kpi_month_carprofit')
                ->where('store_id',$data_add['store_id'])
                ->where('carbrand_id',$data_add['carbrand_id'])
                ->where('carseries_id',$data_add['carseries_id'])
                ->where('year',date('Y'))
                ->where('month',date('n'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='该车系本月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_month_carprofit')->insert($data);
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

    //需开票
    public function invoiceadd(){
        if(request()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['expect_num'] = $data_add['expect_num'];
            $data['actual_num'] = $data_add['actual_num'];
            $data['expect_margin'] = $data_add['expect_margin'];
            $data['actual_margin'] = $data_add['actual_margin'];
            $data['expect_marginprofit'] = $data_add['expect_marginprofit'];
            $data['actual_marginprofit'] = $data_add['actual_marginprofit'];
            $data['tm_sale_num'] = $data_add['tm_sale_num'];
            $data['tm_price'] = $data_add['tm_price'];
            $data['tm_sale_price'] = $data_add['tm_sale_price'];
            $data['tm_margin'] = $data_add['tm_margin'];
            $data['tm_marginprofit'] = $data_add['tm_marginprofit'];

            $res = Db::name('kpi_month_carprofit_piao')
                ->where('store_id',$data_add['store_id'])
                 ->where('year',date('Y'))
                ->where('month',date('n'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='该车系本月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_month_carprofit_piao')->insert($data);
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

    //装饰业务部分
    public function decoratepartadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_decorate_class')
                ->where('year',date('Y'))
                ->where('month',date('n'))
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
                    $res = Db::name('kpi_month_decorate_class')->insert($v);
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

    //装饰业务重点采购
    public function decoratekeyadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_decorate_emphasis')
                ->where('year',date('Y'))
                ->where('month',date('n'))
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
                    $res = Db::name('kpi_month_decorate_emphasis')->insert($v);
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

    //装饰业务集中采购
    public function decoratefocusadd(){
        if(request()->isAjax()){
            $data_add=input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['target'] = $data_add['target'];
            $data['actual'] = $data_add['actual'];
            $data['target2'] = $data_add['target2'];

            $res = Db::name('kpi_month_decorate_focus')
                ->where('store_id',$data_add['store_id'])
                ->where('year',date('Y'))
                ->where('month',date('n'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_month_decorate_focus')->insert($data);
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

    //新保业务->分类
    public function sinpoadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_insurance')
                ->where('year',date('Y'))
                ->where('month',date('n'))
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
                    $res = Db::name('kpi_month_insurance')->insert($v);
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

    //新保业务->新保渗透率目标
    public function penetranceadd(){
        if(request()->isAjax()){
            $data_add=input('param.');

            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['average'] = $data_add['average'];
            $data['store'] = $data_add['store'];
            $data['actual'] = $data_add['actual'];

            $res = Db::name('kpi_month_insurance_target')
                ->where('store_id',$data_add['store_id'])
                ->where('year',date('Y'))
                ->where('month',date('n'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_month_insurance_target')->insert($data);
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

    //新车延保
    public function insuranceadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_newcar')
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
                    $res = Db::name('kpi_month_newcar')->insert($v);
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

    //维修业务
    public function repairadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_repair')
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
                    $res = Db::name('kpi_month_repair')->insert($v);
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

    //续保业务
    public function maintainadd(){
        if(request()->isAjax()){
            $data=input('param.');
            $store_id = $data['store_id'];      //提出store_id单独使用
            unset($data['store_id']);           //删除接收到的数组中的store_id，以便后面遍历
            $target = $data['target'];           //提出续保渗透率目标
            unset($data['target']);             //从数组中删除续保渗透率目标

            $about =array();                    //续保业务第一个表
            foreach($data as $k => $v){         //遍历接收到的数组
                $about[$k] = $v;
                $about[$k]['store_id'] = $store_id;
                $about[$k]['year'] = date('Y');
                $about[$k]['month'] = date('m');
            }

            $about1 = array();
            $about1['store_id'] = $store_id;
            $about1['year'] = date('Y');
            $about1['month'] = date('m');
            $about1['class_name'] = $target['class_name'];
            $about1['average'] = $target['average'];

            $sigle_data = Db::name('kpi_month_renewal')
                ->where('year',date('Y'))
                ->where('month',date('n'))
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
                    $res = Db::name('kpi_month_renewal')->insert($v);
                    if(!$res){
                        $reslut['msg']='添加失败!';
                        $reslut['status']='0';
                        Db::rollback();
                        return json($reslut);
                    }
                }
                $res1 = Db::name('kpi_month_penetrance')->insert($about1);
                if(!$res1){
                    $reslut['msg']='添加失败!';
                    $reslut['status']='0';
                    Db::rollback();
                    return json($reslut);
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

    //三卡业务
    public function threecaradd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_three_card_business')
                ->where('year',date('Y'))
                ->where('month',date('n'))
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
                    $res = Db::name('kpi_month_three_card_business')->insert($v);
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

    //非新车延保
    public function nonnewcaradd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_non_newcar')
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
                    $res = Db::name('kpi_month_non_newcar')->insert($v);
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

    //其它业务
    public function otherbusinessadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_other')
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
                    $res = Db::name('kpi_month_other')->insert($v);
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

    //车贷业务
    public function carloanadd(){
        if(request()->isAjax()){
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

            $sigle_data = Db::name('kpi_month_carloan')
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
                    $res = Db::name('kpi_month_carloan')->insert($v);
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

    //车贷业务->厂家金融及银行按揭台次
    public function mortgagenumadd(){
        if(request()->isAjax()){
            $data_add=input('param.');

            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['class_name'] = $data_add['class_name'];
            $data['forecast_last'] = $data_add['forecast_last'];
            $data['actual_last'] = $data_add['actual_last'];
            $data['forecast_report_profit'] = $data_add['forecast_report_profit'];
            $data['actual_report_profit'] = $data_add['actual_report_profit'];
            $data['forecast_this'] = $data_add['forecast_this'];
            $data['poundage'] = $data_add['poundage'];

            $res = Db::name('kpi_month_mortgage_num')
                ->where('store_id',$data_add['store_id'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_month_mortgage_num')->insert($data);
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

    //其它业务->人工成本
    public function othercostadd(){
        if(request()->isAjax()){
            $data_add=input('param.');

            $data['store_id'] = $data_add['store_id'];
            $data['year'] = date('Y');
            $data['month'] = date('m');
            $data['forecast_last'] = $data_add['forecast_last'];
            $data['actual_last'] = $data_add['actual_last'];
            $data['forecast_this'] = $data_add['forecast_this'];

            $res = Db::name('kpi_month_other_cost')
                ->where('store_id',$data_add['store_id'])
                ->where('year',date('Y'))
                ->where('month',date('m'))
                ->find();
            if(!empty($res)){
                $reslut['msg']='本月已经新增过数据!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_month_other_cost')->insert($data);
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