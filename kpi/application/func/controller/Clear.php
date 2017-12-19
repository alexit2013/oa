<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\func\controller;
use app\base\controller\Base;
use think\Db;
class Clear extends Base{
    /*
     * 清空车辆费用表的数据
     */
    public function carfee(){
        $data = input('param.');
        Db::execute("delete from think_kpi_carfee_financedrive where store_id=".$data['store_id']);         //财务帐面用车和实际车辆情况
        Db::execute("delete from think_kpi_carfee_saledrive where store_id=".$data['store_id']);         //4S店销售未使用试乘试驾车
        Db::execute("delete from think_kpi_carfee_selfdrive where store_id=".$data['store_id']);         //财务帐面用车和实际车辆情况
        Db::execute("delete from think_kpi_carfee_specialdrive where store_id=".$data['store_id']);         //4S店特殊车辆使用情况
        Db::execute("delete from think_kpi_carfee_testdrive where store_id=".$data['store_id']);         //4S店自用试乘试驾车
        $res = Db::execute("delete from think_kpi_carfee_vehicleuse where store_id=".$data['store_id']);         //4S店使用中的试乘试驾车辆（借出）
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空厂家任务表的数据
     */
    public function vendor(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_task where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }
    /*
     * 清空三月滚动库存（配件）表的数据
     */
    public function threerollparts(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_threerollparts where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空三月滚动库存（整车）表的数据
     */
    public function threerollcar(){
        $data = input('param.');
        Db::execute("delete from think_kpi_threerollcar where store_id=".$data['store_id']);
        $res = Db::execute("delete from think_kpi_threerollcar_over where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }


    /*
     * 清空税金测算表的数据
     */
    public function targetmesure(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_taxmeasure where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空售后重点经营指标表的数据
     */
    public function runtarget(){
        $data = input('param.');
        Db::execute("delete from think_kpi_runtarget where store_id=".$data['store_id']);       //售后重点经营指标数据
        Db::execute("delete from think_kpi_targetmvas where store_id=".$data['store_id']);       //售后重点增值业务指标数据
        $res = Db::execute("delete from think_kpi_target_manage where store_id=".$data['store_id']);       //售后重点管理指标数据
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空返利预估表的数据
     */
    public function rebate(){
        $data = input('param.');
        Db::execute("delete from think_kpi_rebate where store_id=".$data['store_id']);       //返利信息
        $res = Db::execute("delete from think_kpi_rebate_des where store_id=".$data['store_id']);       //返利预估数据
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空利润预算数据表的数据
     */
    public function profitbudget(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_profitbudget where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空市占率和满意度表的数据
     */
    public function marketsatisfield(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_marketdegree where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空市场营销预算表表的数据
     */
    public function marketbudget(){
        $data = input('param.');
        Db::execute("delete from think_kpi_market where store_id=".$data['store_id']);            //本月客流目标数据
        Db::execute("delete from think_kpi_market_custom where store_id=".$data['store_id']);            //市场营销预算数据
        Db::execute("delete from think_kpi_market_customlast where store_id=".$data['store_id']);            //上月客户来源数据
        $res = Db::execute("delete from think_kpi_market_last where store_id=".$data['store_id']);            //上月市场费用流向数据
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空月毛利预算表的数据
     */
    public function marginbudget(){
        $data = input('param.');
        Db::execute("delete from think_kpi_month_carprofit where store_id=".$data['store_id']);            //月销售正常毛利预测
        Db::execute("delete from think_kpi_month_carprofit_piao where store_id=".$data['store_id']);            //需开票
        Db::execute("delete from think_kpi_month_decorate_class where store_id=".$data['store_id']);            //装饰业务部分
        Db::execute("delete from think_kpi_month_decorate_emphasis where store_id=".$data['store_id']);            // 装饰业务重点采购
        Db::execute("delete from think_kpi_month_decorate_focus where store_id=".$data['store_id']);            // 装饰业务集中采购
        Db::execute("delete from think_kpi_month_insurance where store_id=".$data['store_id']);            // 新保业务->分类
        Db::execute("delete from think_kpi_month_insurance_target where store_id=".$data['store_id']);            // 新保业务->新保渗透率目标
        Db::execute("delete from think_kpi_month_newcar where store_id=".$data['store_id']);            // 新车延保
        Db::execute("delete from think_kpi_month_repair where store_id=".$data['store_id']);            // 维修业务
        Db::execute("delete from think_kpi_month_renewal where store_id=".$data['store_id']);            // 续保业务
        Db::execute("delete from think_kpi_month_three_card_business where store_id=".$data['store_id']);            // 三卡业务
        Db::execute("delete from think_kpi_month_non_newcar where store_id=".$data['store_id']);            // 非新车延保
        Db::execute("delete from think_kpi_month_other where store_id=".$data['store_id']);            // 其它业务
        Db::execute("delete from think_kpi_month_carloan where store_id=".$data['store_id']);            // 车贷业务
        Db::execute("delete from think_kpi_month_mortgage_num where store_id=".$data['store_id']);            // 车贷业务->厂家金融及银行按揭台次
        $res = Db::execute("delete from think_kpi_month_other_cost where store_id=".$data['store_id']);            //其它业务->人工成本
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空市费用预算表的数据
     */
    public function costbudget(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_costbudget where store_id=".$data['store_id']);            //
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空车型库龄表的数据
     */
    public function carseriesposage(){
        $data = input('param.');
        Db::execute("delete from think_kpi_carseriesposage where store_id=".$data['store_id']);            //车系库龄表
        Db::execute("delete from think_kpi_carseriesposage_way where store_id=".$data['store_id']);            //在途表
        $res = Db::execute("delete from think_kpi_inventory_variance where store_id=".$data['store_id']);            //库存数量差异
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空整车毛利测算表的数据
     */
    public function carprofit(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_carprofit where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

    /*
     * 清空应收账款账龄分析表的数据
     */
    public function account(){
        $data = input('param.');
        $res = Db::execute("delete from think_kpi_account where store_id=".$data['store_id']);
        if($res !== false){
            $reslut['status']='1';
            $reslut['msg']='删除成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='删除失败！';
        }
        return json($reslut);
    }

}
