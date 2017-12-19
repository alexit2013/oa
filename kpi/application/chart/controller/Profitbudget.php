<?php
/*--------------------------------------------------------------------
广汇KPI报表--利润预算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Profitbudget extends Base{

    public function index(){
            $search_data = input('param.');
            $where = $this->search($search_data);
           
            $this->assign('search_data',$where);
      
        if(empty($where)){
            $map['year']=date('Y');
            $map['month']=date('n');
            $map['store_id']=get_comlist()[0]['ID'];
            // $map['year']=2017;
            // $map['month']=9;
            // $map['store_id']=11;
        }else{
            $map=$where;
        }

        $fitproject=Db::name('kpi_profitbudget_project')->field('id,project_pid as pid,project_name as name')->where('is_del=0')->select();
        $tree=list_to_tree($fitproject);
        foreach ($tree as $key => &$value) {

            if(!empty($value['_child'])){
                foreach ($value['_child'] as $k => &$va) {
                    if(!empty($va['_child'])){
                        foreach ($va['_child'] as $ki => &$vi) {
                            $vi['grandchildInfo']=Db::name('kpi_profitbudget')->where($map)->where('project_id='.$vi['id'])->select();
                        }
                      
                    }
                    $va['sonInfo']=Db::name('kpi_profitbudget')->where($map)->where('project_id='.$va['id'])->select();
                        
                }
               
            }            
            $value['parentInfo']=Db::name('kpi_profitbudget')->where($map)->where('project_id='.$value['id'])->select();
        
        }
        unset($value);
        // dump($tree);
        // echo '<hr>';
        // exit;
        //数据处理
        $data=array();
        foreach ($tree as $key => $value) {
                $data[$value['name']]['id']=$value['id'];
                $data[$value['name']]['pid']=$value['pid'];
            if(!empty($value['parentInfo'])){  //只有一级数据（存在录入数据）
                $data[$value['name']]['parentInfo']['id']=$value['parentInfo'][0]['id'];
                $data[$value['name']]['parentInfo']['pm_actualNum']=$value['parentInfo'][0]['pm_actualNum']; //上月实际数(上月发生数)
                $data[$value['name']]['parentInfo']['pm_expectAmount']=$value['parentInfo'][0]['pm_expectAmount'];//上月计划金额(上月发生数)
                $data[$value['name']]['parentInfo']['pm_diff']=$value['parentInfo'][0]['pm_actualNum']-$value['parentInfo'][0]['pm_expectAmount']; ////实际数-计划金额差异（上月发生数）
                $data[$value['name']]['parentInfo']['pm_completion_rate']=@number_format($value['parentInfo'][0]['pm_actualNum']/$value['parentInfo'][0]['pm_expectAmount'],4);//完成率(上月发生数)
                $data[$value['name']]['parentInfo']['pm_budgetAmount']=$value['parentInfo'][0]['pm_budgetAmount'];//月预算金额（上月发生数）
                $data[$value['name']]['parentInfo']['pm_budget_completion_rate']=@number_format($value['parentInfo'][0]['pm_actualNum']/$value['parentInfo'][0]['pm_budgetAmount'],4);//预算完成率(上月发生数)
                $data[$value['name']]['parentInfo']['tm_expectAmount']=$value['parentInfo'][0]['tm_expectAmount']; //计划金额（本月,月毛利预算表》扣除虚开票销售台次合计）(本月计划数)
                if($value['id']=='27'){//主营业务税金及附加
                    $data[$value['name']]['parentInfo']['tm_expectAmount']=$tm_expectAmount=$this ->Sales_tax($map);
                }else if($value['id']=='29'){//其他业务收入
                    $data[$value['name']]['parentInfo']['tm_expectAmount']=$tm_expectAmount=$this ->other_income($map);
                }else if($value['id']=='30'){//其他业务利润
                    $data[$value['name']]['parentInfo']['tm_expectAmount']=$tm_expectAmount=$this ->other_profit($map);
                }
                
                $data[$value['name']]['parentInfo']['tm_budgetAmount']=$value['parentInfo'][0]['tm_budgetAmount'];//预算金额（本月计划数)

                $data[$value['name']]['parentInfo']['tm_diff']=$tm_expectAmount-$value['parentInfo'][0]['tm_budgetAmount'];//计划－预算(本月)
                $data[$value['name']]['parentInfo']['tm_completion_rate']=@number_format($tm_expectAmount/$value['parentInfo'][0]['tm_budgetAmount'],4);//完成率(本月计划数) xxx
                $data[$value['name']]['parentInfo']['ro_1_ppm_actual']=$value['parentInfo'][0]['ro_1_ppm_actual']; //1-上上月实际(滚动预测数)
                $data[$value['name']]['parentInfo']['ro_1_tmtot_expect']=$value['parentInfo'][0]['pm_actualNum']+$tm_expectAmount+$value['parentInfo'][0]['ro_1_ppm_actual'];//1-本月累计预测(滚动预测数) xxx
                $data[$value['name']]['parentInfo']['ro_1_tmtot_budget']=$value['parentInfo'][0]['ro_1_tmtot_budget'];//1-本月累计预算(滚动预测数)
                $data[$value['name']]['parentInfo']['ro_diff']=($value['parentInfo'][0]['pm_actualNum']+$tm_expectAmount+$value['parentInfo'][0]['ro_1_ppm_actual'])-$value['parentInfo'][0]['ro_1_tmtot_budget'];//实际－预算(滚动预测数)  xxx
                $data[$value['name']]['parentInfo']['ro_ty_budget']=$value['parentInfo'][0]['ro_ty_budget'];//某某年预算（滚动预测数）
                $data[$value['name']]['parentInfo']['ro_completion_rate']=@number_format(($value['parentInfo'][0]['pm_actualNum']+$tm_expectAmount+$value['parentInfo'][0]['ro_1_ppm_actual'])/$value['parentInfo'][0]['ro_ty_budget'],4);//完成率（滚动预测数） xxxx
                $data[$value['name']]['parentInfo']['remark']=$value['parentInfo'][0]['remark'];//备注   
            }
            
            if(isset($value['_child'])){
             
                foreach ($value['_child'] as $k => $val) {
                        $data[$value['name']]['_child'][$val['name']]['pid']=$val['pid'];
                        $data[$value['name']]['_child'][$val['name']]['id']=$val['id'];
                        if(!empty($val['sonInfo'])){ //二级数据录入
                            foreach ($val['sonInfo'] as $ks => $vs) {
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['id']=$vs['id'];
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['pm_actualNum']=$vs['pm_actualNum'];//上月实际数(上月发生数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['pm_expectAmount']=$vs['pm_expectAmount'];//上月计划金额(上月发生数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['pm_diff']=$vs['pm_actualNum']-$vs['pm_expectAmount'];//实际数-计划金额差异（上月发生数）
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['pm_completion_rate']=@number_format($vs['pm_actualNum']/$vs['pm_expectAmount'],4);//完成率(上月发生数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['pm_budgetAmount']=$vs['pm_budgetAmount'];//月预算金额（上月发生数）
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['pm_budget_completion_rate']=@number_format($vs['pm_actualNum']/$vs['pm_budgetAmount'],4);//预算完成率(上月发生数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$vs['tm_expectAmount']; //计划金额（本月,月毛利预算表》扣除虚开票销售台次合计）(本月计划数)
                                    if($val['id']=='2'){  //本月计划金额(销售数量-整车)
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->sale_vehicle($map);//《月毛利预算表》扣除虚开票销售台次合计(本月计划数)
                                    }else if($val['id']=='3'){ //本月计划金额(销售数量-维修台次)
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->sale_repari($map);//《月毛利预算表》O100(本月计划数)
                                    }else if($val['id']=='5'){ //本月计划金额（主营业务收入-整车）
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->revenue_vehicle($map);//《月毛利预算表》L22(本月计划数)
                                    }else if($val['id']=='6'){//本月计划金额（主营业务收入-维修）
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->revenue_repari($map);//《月毛利预算表》K107(本月计划数)
                                    }else if($val['id']=='7'){ //本月计划金额（主营业务收入-装饰装潢）
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->revenue_decorate($map);//《月毛利预算表》H12(本月计划数)
                                    }else if($val['id']=='8'){ //本月计划金额（主营业务收入-佣金代理）
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->revenue_commission($map);//《月毛利预算表》L70+L79+L86+L127(本月计划数)
                                    }else if($val['id']=='10'){ //本月计划金额（主营业务成本-整车）
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->operating_vehicle($map);
                                    }else if($val['id']=='15'){//本月计划金额（主营业务成本-装饰装潢）
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->operating_decorate($map);
                                    }else if($val['id']=='16'){//本月计划金额（主营业务成本-佣金代理)
                                        $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_expectAmount']=$tm_expectAmount=$this ->operating_commission($map);
                                    }
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_budgetAmount']=$vs['tm_budgetAmount'];//预算金额（本月计划数)
                        
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_diff']=@number_format($tm_expectAmount-$vs['tm_budgetAmount'],2); 
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['tm_completion_rate']=@number_format($tm_expectAmount/$vs['tm_budgetAmount'],4);//完成率(本月计划数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['ro_1_ppm_actual']=$vs['ro_1_ppm_actual']; //1-上上月实际(滚动预测数)

                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['ro_1_tmtot_expect']=$vs['pm_actualNum']+$tm_expectAmount+$vs['ro_1_ppm_actual'];//1-本月累计预测(滚动预测数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['ro_1_tmtot_budget']=$vs['ro_1_tmtot_budget'];//1-本月累计预算(滚动预测数)
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['ro_diff']=($vs['pm_actualNum']+$tm_expectAmount+$vs['ro_1_ppm_actual'])-$vs['ro_1_tmtot_budget'];//实际－预算(滚动预测数) 
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['ro_ty_budget']=$vs['ro_ty_budget'];//某某年预算（滚动预测数）
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['ro_completion_rate']=@number_format(($vs['pm_actualNum']+$tm_expectAmount+$vs['ro_1_ppm_actual'])/$vs['ro_ty_budget'],4);//完成率（滚动预测数）
                                $data[$value['name']]['_child'][$val['name']]['sonInfo']['remark']=$vs['remark'];//备注
                                      
                                
                            }
                        }
                        if(!empty($val['_child'])){ //进入三级
                            foreach ($val['_child'] as $k => $vo) {
                                // $data[$value['name']]['_child'][$val['name']]['_child']['pid']=$vo['pid'];
                                // $data[$value['name']]['_child'][$val['name']]['_child']['id']=$vo['id']; 
                                if(!empty($vo['grandchildInfo'])){                                
                                    foreach ($vo['grandchildInfo'] as $kg => $vg) {
                                         $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['id']=$vg['id'];
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['pm_actualNum']=$vg['pm_actualNum'];//上月实际数(上月发生数)
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['pm_expectAmount']=$vg['pm_expectAmount'];//上月计划金额(上月发生数)
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['pm_diff']=$vg['pm_actualNum']-$vg['pm_expectAmount'];//实际数-计划金额差异（上月发生数）;
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['pm_completion_rate']=@number_format($vg['pm_actualNum']/$vg['pm_expectAmount'],4);//完成率(上月发生数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['pm_budgetAmount']=$vg['pm_budgetAmount'];//月预算金额（上月发生数）;
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['pm_budget_completion_rate']=@number_format($vg['pm_actualNum']/$vg['pm_budgetAmount'],4);//预算完成率(上月发生数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_expectAmount']=$vg['tm_expectAmount']; //计划金额（本月,月毛利预算表》扣除虚开票销售台次合计）(本月计划数);
                                            if($vo['id']=='12'){ //本月计划金额（主营业务成本-维修-零部件)
                                                $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_expectAmount']=$tm_expectAmount=$this ->operating_repari_a($map);
                                            }else if($vo['id']=='13'){//本月计划金额（主营业务成本-维修-工费)
                                                $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_expectAmount']=$tm_expectAmount=$this ->operating_repari_b($map);
                                            }else if($vo['id']=='14'){//本月计划金额（主营业务成本-维修-车间费用)
                                                $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_expectAmount']=$tm_expectAmount=$this ->operating_repari_c($map);
                                            }
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_budgetAmount']=$vg['tm_budgetAmount'];//预算金额（本月计划数);
                                        
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_diff']=@number_format($tm_expectAmount-$vg['tm_budgetAmount'],4);//计划-预算(本月计划数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['tm_completion_rate']=@number_format($tm_expectAmount/$vg['tm_budgetAmount'],4);//完成率(本月计划数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['ro_1_ppm_actual']=$vg['ro_1_ppm_actual']; //1-上上月实际(滚动预测数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['ro_1_tmtot_expect']=$vg['pm_actualNum']+$tm_expectAmount+$vg['ro_1_ppm_actual'];//1-本月累计预测(滚动预测数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['ro_1_tmtot_budget']=$vg['ro_1_tmtot_budget'];//1-本月累计预算(滚动预测数);
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['ro_diff']=($vg['pm_actualNum']+$tm_expectAmount+$vg['ro_1_ppm_actual'])-$vg['ro_1_tmtot_budget'];//实际－预算(滚动预测数) ;
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['ro_ty_budget']=$vg['ro_ty_budget'];//某某年预算（滚动预测数）;
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['ro_completion_rate']=@number_format(($vg['pm_actualNum']+$tm_expectAmount+$vg['ro_1_ppm_actual'])/$vg['ro_ty_budget'],4);//完成率（滚动预测数）
                                        $data[$value['name']]['_child'][$val['name']]['_child'][$vo['name']]['grandchildInfo']['remark']=$vg['remark'];//备注;
                                    }
                                    
                                }
                                
                                
                            }
                                
                        }

                }
            }
               
        }
        $data['利润总额']['_child']['所得税']['sonInfo']['tm_diff']=@round($data['利润总额']['_child']['所得税']['sonInfo']['tm_expectAmount']-$data['利润总额']['_child']['所得税']['sonInfo']['tm_budgetAmount'],2);
        $data['利润总额']['_child']['所得税']['sonInfo']['tm_completion_rate']=@round($data['利润总额']['_child']['所得税']['sonInfo']['tm_expectAmount']/$data['利润总额']['_child']['所得税']['sonInfo']['tm_budgetAmount'],3);
        $data['利润总额']['_child']['所得税']['sonInfo']['ro_1_tmtot_expect']=@$data['利润总额']['_child']['所得税']['sonInfo']['pm_actualNum']+@$data['利润总额']['_child']['所得税']['sonInfo']['tm_expectAmount']+@$data['利润总额']['_child']['所得税']['sonInfo']['ro_1_ppm_actual'];
        $data['利润总额']['_child']['所得税']['sonInfo']['ro_diff']=@$data['利润总额']['_child']['所得税']['sonInfo']['ro_1_tmtot_expect']-@$data['利润总额']['_child']['所得税']['sonInfo']['ro_1_tmtot_budget'];
        $data['利润总额']['_child']['所得税']['sonInfo']['ro_completion_rate']=@round($data['利润总额']['_child']['所得税']['sonInfo']['ro_1_tmtot_expect']/$data['利润总额']['_child']['所得税']['sonInfo']['ro_ty_budget'],3);

        $data['营业费用']['parentInfo']['tm_diff']=@round($data['营业费用']['parentInfo']['tm_expectAmount']-$data['营业费用']['parentInfo']['tm_budgetAmount'],2);
        $data['营业费用']['parentInfo']['tm_completion_rate']=@round($data['营业费用']['parentInfo']['tm_expectAmount']/$data['营业费用']['parentInfo']['tm_budgetAmount'],3);
        $data['营业费用']['parentInfo']['ro_1_tmtot_expect']=@$data['营业费用']['parentInfo']['pm_actualNum']+@$data['营业费用']['parentInfo']['tm_expectAmount']+@$data['营业费用']['parentInfo']['ro_1_ppm_actual'];
        $data['营业费用']['parentInfo']['ro_diff']=@round($data['营业费用']['parentInfo']['ro_1_tmtot_expect']-@$data['营业费用']['parentInfo']['ro_1_tmtot_budget'],2);
        $data['营业费用']['parentInfo']['ro_completion_rate']=@round($data['营业费用']['parentInfo']['ro_1_tmtot_expect']/$data['营业费用']['parentInfo']['ro_ty_budget'],3);

        $data['管理费用']['parentInfo']['tm_diff']=@round($data['管理费用']['parentInfo']['tm_expectAmount']-$data['管理费用']['parentInfo']['tm_budgetAmount'],2);
        $data['管理费用']['parentInfo']['tm_completion_rate']=@round($data['管理费用']['parentInfo']['tm_expectAmount']/$data['管理费用']['parentInfo']['tm_budgetAmount'],3);
        $data['管理费用']['parentInfo']['ro_1_tmtot_expect']=@$data['管理费用']['parentInfo']['pm_actualNum']+@$data['管理费用']['parentInfo']['tm_expectAmount']+@$data['管理费用']['parentInfo']['ro_1_ppm_actual'];
        $data['管理费用']['parentInfo']['ro_diff']=@round($data['管理费用']['parentInfo']['ro_1_tmtot_expect']-@$data['管理费用']['parentInfo']['ro_1_tmtot_budget'],2);
        $data['管理费用']['parentInfo']['ro_completion_rate']=@round($data['管理费用']['parentInfo']['ro_1_tmtot_expect']/$data['管理费用']['parentInfo']['ro_ty_budget'],3);

        $data['财务费用']['parentInfo']['tm_diff']=@round($data['财务费用']['parentInfo']['tm_expectAmount']-$data['财务费用']['parentInfo']['tm_budgetAmount'],2);
        $data['财务费用']['parentInfo']['tm_completion_rate']=@round($data['财务费用']['parentInfo']['tm_expectAmount']/$data['财务费用']['parentInfo']['tm_budgetAmount'],3);
        $data['财务费用']['parentInfo']['ro_1_tmtot_expect']=@$data['财务费用']['parentInfo']['pm_actualNum']+@$data['财务费用']['parentInfo']['tm_expectAmount']+@$data['财务费用']['parentInfo']['ro_1_ppm_actual'];
        $data['财务费用']['parentInfo']['ro_diff']=@$data['财务费用']['parentInfo']['ro_1_tmtot_expect']-@$data['财务费用']['parentInfo']['ro_1_tmtot_budget'];
        $data['财务费用']['parentInfo']['ro_completion_rate']=@round($data['财务费用']['parentInfo']['ro_1_tmtot_expect']/$data['财务费用']['parentInfo']['ro_ty_budget'],3);

        $data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_diff']=@round($data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_expectAmount']-@$data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_budgetAmount'],2);
        $data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_completion_rate']=@round($data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_expectAmount']/$data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_budgetAmount'],3);
        $data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_1_tmtot_expect']=@$data['营业利润']['_child']['营业外收支净额']['sonInfo']['pm_actualNum']+@$data['营业利润']['_child']['营业外收支净额']['sonInfo']['tm_expectAmount']+@$data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_1_ppm_actual'];
        $data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_diff']=@$data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_1_tmtot_expect']-@$data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_1_tmtot_budget'];
        $data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_completion_rate']=@round($data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_1_tmtot_expect']/$data['营业利润']['_child']['营业外收支净额']['sonInfo']['ro_ty_budget'],3);

        $data['营业利润']['_child']['投资收益']['sonInfo']['tm_diff']=@round($data['营业利润']['_child']['投资收益']['sonInfo']['tm_expectAmount']-$data['营业利润']['_child']['投资收益']['sonInfo']['tm_budgetAmount'],2);
        $data['营业利润']['_child']['投资收益']['sonInfo']['tm_completion_rate']=@round($data['营业利润']['_child']['投资收益']['sonInfo']['tm_expectAmount']/$data['营业利润']['_child']['投资收益']['sonInfo']['tm_budgetAmount'],3);
        $data['营业利润']['_child']['投资收益']['sonInfo']['ro_1_tmtot_expect']=@$data['营业利润']['_child']['投资收益']['sonInfo']['pm_actualNum']+@$data['营业利润']['_child']['投资收益']['sonInfo']['tm_expectAmount']+@$data['营业利润']['_child']['投资收益']['sonInfo']['ro_1_ppm_actual'];
        $data['营业利润']['_child']['投资收益']['sonInfo']['ro_diff']=@$data['营业利润']['_child']['投资收益']['sonInfo']['ro_1_tmtot_expect']-@$data['营业利润']['_child']['投资收益']['sonInfo']['ro_1_tmtot_budget'];
        $data['营业利润']['_child']['投资收益']['sonInfo']['ro_completion_rate']=@round($data['营业利润']['_child']['投资收益']['sonInfo']['ro_1_tmtot_expect']/$data['营业利润']['_child']['投资收益']['sonInfo']['ro_ty_budget'],3);

        $data['少数股东权益']['parentInfo']['tm_diff']=@round($data['少数股东权益']['parentInfo']['tm_expectAmount']-@$data['少数股东权益']['parentInfo']['tm_budgetAmount'],2);
        $data['少数股东权益']['parentInfo']['tm_completion_rate']=@round($data['少数股东权益']['parentInfo']['tm_expectAmount']/$data['少数股东权益']['parentInfo']['tm_budgetAmount'],3);
        $data['少数股东权益']['parentInfo']['ro_1_tmtot_expect']=@$data['少数股东权益']['parentInfo']['pm_actualNum']+@$data['少数股东权益']['parentInfo']['tm_expectAmount']+@$data['少数股东权益']['parentInfo']['ro_1_ppm_actual'];
        $data['少数股东权益']['parentInfo']['ro_diff']=@$data['少数股东权益']['parentInfo']['ro_1_tmtot_expect']-@$data['少数股东权益']['parentInfo']['ro_1_tmtot_budget'];
        $data['少数股东权益']['parentInfo']['ro_completion_rate']=@round($data['少数股东权益']['parentInfo']['ro_1_tmtot_expect']/$data['少数股东权益']['parentInfo']['ro_ty_budget'],3);
      // dump($data);
        //报表审批是否通过
            $up['store_id']=$map['store_id'];
            $up['year']=$map['year'];
            $up['month']=$map['month'];
            $up['chart_deptclass_id']=10;
            // $up['status']=1;
            $data_status=operate_chart($up);
            
        $this -> assign('data_status',$data_status); //审批状态
        $this -> assign('data',$data);
        $type = input('param.type');
        switch ($type) {
            case '1':   //总表                              
                return view();
                break;
            case '2':   //部门表 
                 $this -> chirld_status($map,11);         
                return view('c_index');
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
            // dump($data_dan);
            $this -> assign('data_dan',$data_dan);
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
        }
        if(!empty($data['month'])){   //月
            $map['month']=$data['month'];
        }else{
            $map['month']=date('n'); 
        }
        return $map;
    }
    //销售数量(整车)
    public function sale_vehicle($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->monthsalemargin($map);
        $salse_numtot=0;
        foreach ($res as $key => $value) {
            if(!empty($value['sale_num'])){
                $salse_numtot+=$value['sale_num'];
            }
        }
        // $expect_num=Db::name('kpi_month_carprofit')->field('SUM(expect_num) as expect')->where($map)->group('store_id')->find();
        $xu_expect=Db::name('kpi_month_carprofit_piao')->field('tm_sale_num')->where($map)->find();
        return $salse_numtot-$xu_expect['tm_sale_num'];
    }
    //销售数量(维修台次)
    public function sale_repari($map){
        
        $res=Db::name('kpi_month_repair')->field('repair_num')->where($map)->find();
        return $res['repair_num'];
    }
    //主营业务收入(整车)
    public function revenue_vehicle($map){
        
        $sale_incometot=$this ->revenue_vehicle_saletot($map);
        $xu_sale_price=Db::name('kpi_month_carprofit_piao')->field('tm_sale_price')->where($map)->find();
        if(!empty($sale_incometot) && !empty($xu_sale_price['tm_sale_price'])){
            return $sale_incometot-$xu_sale_price['tm_sale_price'];
        }
    }
    //主营业务收入(维修)
    public function revenue_repari($map){
        $res=$this ->reapri_t($map);
        if(!empty($res)){
            return $res['配件']['合计']['income']+$res['工时']['income']+$res['养护产品']['income']+$res['售后装饰美容精品']['income'];
        }
    }
    //主营业务收入(装饰装潢)
    public function revenue_decorate($map){
        $res=$this ->decorate_class_t($map);
        if(!empty($res)){
            return $res['小计']['income'];
        }
    }
    //主营业务收入(佣金代理)
    public function revenue_commission($map){
        $shinbo=$this ->shinbo_business($map);
        if(!isset($shinbo['class']['新保商业险']['income'])|| !isset($shinbo['class']['新保交强险']['income'])){
            $shinbo['class']['新保商业险']['income']=0;
            $shinbo['class']['新保交强险']['income']=0;
        }
        $newcar=$this->newcar_ACCP_business($map);
        if(!isset($newcar['class']['新车延保']['income'])){
            $newcar['class']['新车延保']['income']=0;
        }
        $Carloan=$this ->Car_loan_business($map);
        if(!isset($Carloan['非租赁佣金(指厂家金融及银行按揭)']['income'])|| !isset($Carloan['租赁佣金']['income'])){
           $Carloan['非租赁佣金(指厂家金融及银行按揭)']['income']=0;
           $Carloan['租赁佣金']['income']=0; 
        }
        $renewal=$this ->renewal_business($map);
        if(!isset($renewal['续保商业险']['income']) || !isset($renewal['续保交强险']['income'])){
            $renewal['续保商业险']['income']=0;
            $renewal['续保交强险']['income']=0;
        }
        $nocar=$this ->nocai_ACPP($map);
        if(!isset($nocar['非新车延保']['income'])){
            $nocar['非新车延保']['income']=0;
        }
        $other=$this ->other_business($map);
        
        $other_cost=0;   
        foreach ($other as $key => $value) {
                if(!empty($value['income'])){
                    $other_cost+=$value['income'];
                }
        }
        return $shinbo['class']['新保商业险']['income']+$shinbo['class']['新保交强险']['income']+$newcar['class']['新车延保']['income']+$Carloan['非租赁佣金(指厂家金融及银行按揭)']['income']+$Carloan['租赁佣金']['income']+$renewal['续保商业险']['income']+$renewal['续保交强险']['income']+$nocar['非新车延保']['income'];
       
    }

    //主营业务成本(整车)
    public function operating_vehicle($map){
        $res=$this ->monthsalemargin_t($map);
        $model =new \app\chart\model\Marginbudget();
        $fanlitot=$model->funli_tot($map);
        if(!isset($fanlitot['expect'])){
            $fanlitot['expect']=0;
        }
        $xu_tm_price=Db::name('kpi_month_carprofit_piao')->field('tm_price')->where($map)->find(); //虚开票;
        $xu_tot=$res['feed_priceTot']-$xu_tm_price['tm_price']-$fanlitot['expect'];
        return $xu_tot;

    } 
    //主营业务成本(维修-零部件)
    public function operating_repari_a($map){
        $res=$this -> reapri_t($map);
        if(!empty($res)){
        return $res['配件']['合计']['cost']+$res['养护产品']['cost'];
        }
    } 
    //主营业务成本（维修-工费)
    public function operating_repari_b($map){
        $res=$this -> reapri_t($map);
        if(!empty($res)){
        return $res['人工成本']['cost'];
         }
    }
     //主营业务成本（维修-车间费用)
    public function operating_repari_c($map){
        $res=$this -> reapri_t($map);
        if(!empty($res)){
       return $res['委托外加工费']['cost']+$res['车间间接费用']['cost'];
        }    
    }
    //主营业务成本(装饰装潢）
    public function operating_decorate($map){
        $res=$this ->decorate_class_t($map); 
        if(!isset($res['小计']['cost'])){
            $res['小计']['cost']=0;
        } 
            return $res['小计']['cost'];
    }
    //主营业务成本(佣金代理）
    public function operating_commission($map){
        $shinbo=$this ->shinbo_business($map);
        $newcar=$this ->newcar_ACCP_business($map);
        $carloan=$this ->Car_loan_business($map);
        $renewal=$this ->renewal_business($map);
        $nocar=$this->nocai_ACPP($map);
        $other_cost=Db::name('kpi_month_other_cost')->field('forecast_this')->where($map)->find();
        
        if(!empty($shinbo) && !empty($newcar) && !empty($carloan) && !empty($renewal) && !empty($nocar) && !empty($other_cost)){
             return $shinbo['class']['人工成本']['cost']+$newcar['class']['人工成本']['cost']+$carloan['人工成本(提成)']['cost']+$renewal['人工成本']['cost']+$nocar['人工成本']['cost']+$other_cost['forecast_this'];
        }
    }
    //主营业务税金及附加
    public function Sales_tax($map){

        $result = Db::name('kpi_taxmeasure')->where($map)->find();
        if(!empty($result)){
            return round($result['sales_vat']-$result['keep_the_balance']-$result['current_deductible'],2);
        }
    }
    //其他业务收入
    public function other_income($map){
        $res=$this -> other_business($map);
        $costTot=0;
        foreach ($res as $key => $value) {
            $costTot+=$value['cost'];
        }
        return $costTot;
    }
    //其他业务利润
    public function other_profit($map){
        $res=$this -> other_business($map);
        $otherRes=Db::name('kpi_month_other_cost')->field('*')->where($map)->find();
        $costTot=0;
        $incomeTot=0;
       foreach ($res as $key => $value) {
           $costTot+=$value['cost'];
           $incomeTot+=$value['income'];
       }
       // return $costTot-$otherRes['forecast_this'];//（???）
       return $incomeTot-$costTot-$otherRes['forecast_this'];
    }
    //财务费用
    public function overhead($map){
        // $map['year']=2017;
        // $map['month']=9;
        // $map['store_id']=3;
        $where['b.year']=$map['year'];
        $where['b.month']=$map['month'];
        $where['b.store_id']=$map['store_id'];
        $project=Db::name('kpi_costbudget_project')->alias('a')
              ->field('a.id,a.project_pid as pid,a.project_name as name,b.pm_expect,b.pm_actual,b.tm_expect,b.tm_salesDept_expect,b.tm_repairDept_expect,b.tm_ornDept_expect,b.tm_adminDept_expect,b.tm_financeDept_expect,b.tm_gmDept_expect,b.tm_serviceDept_expect,b.tm_market_expect,b.tm_other_expect,b.1_ppm_actual,b.1_tm_expect')
              ->join('think_kpi_costbudget b','a.id=b.project_id','LEFT')
              ->where(array('a.is_del'=>0,'a.project_pid'=>4))
              // ->where($where)
              ->select();
        foreach ($project as $key => $value) {
            $project[$key]['_child']=Db::name('kpi_costbudget_project')
            ->alias('a')
            ->field('a.id,a.project_pid as pid,a.project_name as name,b.pm_expect,b.pm_actual,b.tm_expect,b.tm_salesDept_expect,b.tm_repairDept_expect,b.tm_ornDept_expect,b.tm_adminDept_expect,b.tm_financeDept_expect,b.tm_gmDept_expect,b.tm_serviceDept_expect,b.tm_market_expect,b.tm_other_expect,b.1_ppm_actual,b.1_tm_expect')
            ->join('think_kpi_costbudget b','a.id=b.project_id','LEFT')
            ->where('a.project_pid='.$value['id'])
            // ->where($where)
            ->select();
          
        }
        // dump($project);
        $tot_expect_a=0;
        $tot_expect_b=0;
        foreach ($project as $key => $value) {
            $tot_expect_a+=$value['tm_expect'];
            if(isset($value['_child'])){
                foreach ($value['_child'] as $k => $vo) {
                        $tot_expect_b+=$vo['tm_expect'];
                }
            }
            
        }
        return $tot_expect_a+$tot_expect_b;

    }
    //返利总计
    public function fanli_t($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->fanli($map);
        // dump($res);
        if(!empty($res['expect'])){
            $tot=0;
            foreach ($res as $key => $value) {
               $tot+=$value['expect'];
            }
            return $tot;
        }
    } 
    /*预估返利*/
    public function yufanli_t($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->yufanli($map);
        $tot=0;
        foreach ($res as $key => $value) {
            if(!empty($res['expect'])){
                $tot+=$value['expect'];
            }
        }
        return $tot;
    }

    /*月销售正常毛利率合计*/
    public  function monthsalemargin_t($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->monthsalemargin($map);
        $feed_priceTot=0;
        $sale_incometot=0;
        foreach ($res as $key => $value) {
            if(!empty($value['income']) && !empty($value['purchase_price'])){
                $sale_incometot+=$value['income'];
                $feed_priceTot+=$value['purchase_price'];
            }
        }
        $data['sale_incometot']=$sale_incometot;
        $data['feed_priceTot']=$feed_priceTot;
        return $data;
    }
    /*维修*/
    public function reapri_t($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->repair($map);
        return $res;
    }
    /*装饰业务-分类*/
    public function decorate_class_t($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->decorate_class($map);
        return $res;
    }
    //新保业务
    public function shinbo_business($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->insurance($map);
        return $res;
    }
    //新车延保
    public function newcar_ACCP_business($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->newcar($map);
        return $res;
    }
    //车贷业务
    public function Car_loan_business($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->carloan($map);
        return $res;
    }
    //续保业务
    public function renewal_business($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->renewal($map);
        return $res;
    }
    //其他业务
    public function other_business($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->other($map);
        return $res;
    }
    //非新车延保
    public function nocai_ACPP($map){
        $model =new \app\chart\model\Marginbudget();
        $res=$model->non_newcar($map);
        return $res;
    }
    //主营业务收入(整车-销价合计)
    private function revenue_vehicle_saletot($map){

        $res=$this ->monthsalemargin_t($map);
        return $res['sale_incometot'];
        
    } 
    //添加利润预算表数据
    public function add(){
        $project=Db::name('kpi_profitbudget_project')->where('is_del=0')->field('id,project_pid as pid,project_name as name')->select();
        $this->assign('project',$project);
        if(Request::instance()->isAjax()){
            $data = input('param.');
                    $store_id = $data['store_id'];      //单独提出前台传递的store_id
                    unset($data['store_id']);           //删除前台传递过来的数组中的store_id，剩下的数组便于下一步遍历
                    $about = array();                    //定义一个新数组，用于后面插入数据
                    
                    foreach($data['profit'] as $k => $v){         //遍历前台有用数据
                            $about[$k] = $v;                 //向about数组中赋值（前台传递的数据）
                            $about[$k]['store_id'] = $store_id;     //向about数组中赋值（前台传递的store_id）
                            $about[$k]['year'] = date('Y');         //向about数组中赋值（当前年）
                            $about[$k]['month'] = date('m');;       //向about数组中赋值（当前月）
                    }
                    $once_add = Db::name('kpi_profitbudget')->where('year',date('Y'))->where('month',date('m'))->where('store_id',$store_id)->select();       //查找表中是否已经添加过当月的数据
                    if(!empty($once_add)){                      //如果数据已经存在，返回一个提示
                            $reslut['msg']='本月已经新增过数据!';
                            $reslut['status']='0';
                            return json($reslut);
                    }else{                                      //如果数据还不存在，向表中插入前台接收到且处理过的数据
                                    
                        foreach($about as $v){
                            $res = Db::name('kpi_profitbudget')->insert($v);      //插入数据
                            if(!$res){                              //如果插入失败，返回一个失败提示
                                    $reslut['msg']='添加失败!';
                                    $reslut['status']='0';
                                    return json($reslut);
                            }
                        }
                    }
                    $reslut['msg']='添加成功';              //添加成功后执行
                    $reslut['status']='1';
                    return json($reslut);
        }else{
            $store=get_comlist();  //所属门店
            $this -> assign('stores',$store);
            return view();
        }
    }
    function excel(){
        $path = dirname(ROOT_PATH).DS."kpi".DS."Uploads";
        $excelres = request()->file("upfile");
        if(empty($excelres)){
            $res['status'] = '0';
            $res['message'] = '没有文件!';
        }else{
            $info = $excelres->validate(['size'=>5242880,'ext'=>'xls,xlsx'])->move($path);  //上传限制500kb
            chmod($path."/".$info->getSaveName(),0755);
            if($info){
                $res['status'] = '1';
                $res['message'] = $path."/".$info->getSaveName();

            }else{
                $res['status'] = '0';
                $res['message'] = '请检查文件大小，或者文件类型';
            }
        }
        return json($res);
    }
    /*财务*/
    function finace(){
        $map['chart_type_id']  = 14;
        $map['store_id']  = get_com_id();
        $map['month']  = date('n');
        $map['year']  = date('Y');
        $status = Db::name('kpi_chart_deptstatus') 
                ->where($map)->select();
        if(empty($status)){
            $is_import = 0; //可编辑
        }else{
            $is_import = 1;//不可编辑
        }
        $this->assign('is_import',$is_import);
        return view();
    }
    function import(){
        $path = input('param.filepath');//文件路径
        if(empty($path)){
            $result ['status'] = 0;
            $result ['msg'] = "请选择导入文件";
            return json($result);
        }
        $project = $this->project();
        $month = input('param.month');   //月份
        $store_id = get_com_id();
        if($store_id == 0 || $store_id == 2){
            $result ['status'] = 0;
            $result ['msg'] = "请勿用集团账号导入！";
            return json($result);
        }
        $year = input('param.year');
        $check = $this->check($year, $month, $store_id);
        if($check == FALSE){
            $result ['status'] = 0;
            $result ['msg'] = "你已经导入过数据，请勿重复导入！";
            return json($result);
        }
        $PHPExcel = import_excel($path); //读取excel
        $sheet0 = $PHPExcel->getSheet(0);  //获取sheet0
        $allRow = $sheet0->getHighestRow(); // 取得一共有多少行
        $data_list = array();
        $j = 0;
        for($i=2;$i<=$allRow;$i++){
            $data_list[$j]['store_id'] = (int)$store_id; //门店id
            
            $data_list[$j]['year'] = (int)$sheet0->getCell('A' . $i)->getValue(); //年份
            if($data_list[$j]['year'] != $year){
                $result ['status'] = 0;
                $result ['msg'] = "年份错误，错误位置：(A".$i.")";
                return json($result);
            }
            $data_list[$j]['month'] = (int)$sheet0->getCell('B' . $i)->getValue(); //月份
            if($data_list[$j]['month'] != $month){
                $result ['status'] = 0;
                $result ['msg'] = "月份错误，错误位置：(B".$i.")";
                return json($result);
            }
            $data_list[$j]['project_id'] = (int)$sheet0->getCell('C' . $i)->getValue(); //月份
            if(!in_array($data_list[$j]['project_id'],$project)){
                $result ['status'] = 0;
                $result ['msg'] = "项目编码错误，错误位置：(C".$i.")";
                return json($result);
            }
            $data_list[$j]['pm_actualNum'] = round((float)$sheet0->getCell('E' . $i)->getValue(),2); //上月实际数
            $data_list[$j]['pm_expectAmount'] = round((float)$sheet0->getCell('F' . $i)->getValue(),2); //上月计划金额
            $data_list[$j]['pm_budgetAmount'] = round((float)$sheet0->getCell('G' . $i)->getValue(),2); //月预算金额（上月）
            $data_list[$j]['tm_expectAmount'] = round((float)$sheet0->getCell('H' . $i)->getValue(),2); //本月计划金额
            $data_list[$j]['tm_budgetAmount'] = round((float)$sheet0->getCell('I' . $i)->getValue(),2); //预算金额（本月）
            $data_list[$j]['ro_1_ppm_actual'] = round((float)$sheet0->getCell('J' . $i)->getValue(),2); //1-上上月实际（滚动预测数）
            $data_list[$j]['ro_1_tmtot_budget'] = round((float)$sheet0->getCell('K' . $i)->getValue(),2); //1-本月累计预算（滚动预测数）
            $data_list[$j]['ro_ty_budget'] = round((float)$sheet0->getCell('L' . $i)->getValue(),2); //本年预算
            $data_list[$j]['remark'] = (string)$sheet0->getCell('M' . $i)->getValue(); //备注
            $j++;
        }
        $res = Db::name('kpi_profitbudget')->insertAll($data_list);
        if($res){
            $result ['status'] = 1;
            $result ['msg'] = "导入成功！";
            return json($result);
        }else{
            $result ['status'] = 0;
            $result ['msg'] = "导入失败！";
            return json($result);
        }
    }
    private function project(){
        $data = Db::name('kpi_profitbudget_project')->select();
        $data_list = array();
        foreach ($data as $v) {
            $data_list[]= $v['id'];
        }
        return $data_list;
    }
    private function check($year,$month,$store_id){
        $map['year']=$year;
        $map['month']=$month;
        $map['store_id']=$store_id;
        $count = Db::name('kpi_profitbudget')->where($map)->count();
        if($count>0){
            return FALSE;
        }
        return true;
    }
}