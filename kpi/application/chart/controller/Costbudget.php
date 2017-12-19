<?php
/*--------------------------------------------------------------------
广汇KPI报表--费用预算表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Costbudget extends Base{
    //费用预算表
    public function index(){
            $search_data = input('param.');
       

            $where = $this->search($search_data);
              
                              

        if(empty($where)){
            $map['year']=date('Y');
            $map['month']=date('n');
            $map['store_id']=get_comlist()[0]['ID'];
        }else{
            $map=$where;
        }
         $this->assign('search_data',$map);     

            $project=Db::name('kpi_costbudget_project')->field('id,project_pid as pid,project_name as name')->where('is_del=0')->select();
            $tree=list_to_tree($project);
            foreach ($tree as $key => &$vo) {
                foreach ($vo['_child'] as $ke => &$value) {
                    if(!empty($value['_child'])){
                        foreach ($value['_child'] as $k => &$va) {
                            $va['info']=Db::name('kpi_costbudget')->where($map)->where('project_id='.$va['id'])->select();
                        }
                    }
                   $value['info']=Db::name('kpi_costbudget')->where($map)->where('project_id='.$value['id'])->select();
                   
                }
            }
            //数据处理
            $data=array();
            foreach ($tree as $k => $val) {
                    $data[$val['name']]['id']=$val['id'];
                    $data[$val['name']]['pid']=$val['pid'];
                    foreach ($val['_child'] as $key => $value) {
                       $data[$val['name']]['_child'][$value['name']]['id']=$value['id'];
                       $data[$val['name']]['_child'][$value['name']]['pid']=$value['pid'];
                     
                       foreach ($value['info'] as $e => &$vo) {
                           $data[$val['name']]['_child'][$value['name']]['info']['id']=$vo['id']; //id
                            $data[$val['name']]['_child'][$value['name']]['info']['pm_expect']=$vo['pm_expect']; //上月预测
                            $data[$val['name']]['_child'][$value['name']]['info']['pm_actual']=$vo['pm_actual']; //上月实际
                            $data[$val['name']]['_child'][$value['name']]['info']['pm_diff']=round($vo['pm_actual']-$vo['pm_expect'],2); //实际－预测 差异
                            $data[$val['name']]['_child'][$value['name']]['info']['1_ppm_actual']=$vo['1_ppm_actual']; //1-上上月实际
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_tot_expect']=$vo['tm_salesDept_expect']+$vo['tm_repairDept_expect']+$vo['tm_ornDept_expect']+$vo['tm_adminDept_expect']+$vo['tm_financeDept_expect']+$vo['tm_gmDept_expect']+$vo['tm_serviceDept_expect']+$vo['tm_market_expect']+$vo['tm_other_expect']; //本月计划金额（总）
                            $data[$val['name']]['_child'][$value['name']]['info']['1_tm_expect_c']=$vo['pm_actual']+$vo['1_ppm_actual']+$data[$val['name']]['_child'][$value['name']]['info']['tm_tot_expect']; //1-本月预测
                            $data[$val['name']]['_child'][$value['name']]['info']['1_tm_expect_s']=$vo['1_tm_expect']; //1-本月预算
                            $data[$val['name']]['_child'][$value['name']]['info']['expect_diff']=round($data[$val['name']]['_child'][$value['name']]['info']['1_tm_expect_c']-$vo['1_tm_expect'],2); //预测－预算差异
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_expect']=$vo['tm_expect'];  //本月预算

                            $data[$val['name']]['_child'][$value['name']]['info']['tm_diff']=round(($vo['tm_salesDept_expect']+$vo['tm_repairDept_expect']+$vo['tm_ornDept_expect']+$vo['tm_adminDept_expect']+$vo['tm_financeDept_expect']+$vo['tm_gmDept_expect']+$vo['tm_serviceDept_expect']+$vo['tm_market_expect']+$vo['tm_other_expect'])-$vo['tm_expect'],2); //计划－预算差异
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_salesDept_expect']=$vo['tm_salesDept_expect']; //本月销售部预算
                             $data[$val['name']]['_child'][$value['name']]['info']['tm_repairDept_expect']=$vo['tm_repairDept_expect']; //本月维修部预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_ornDept_expect']=$vo['tm_ornDept_expect'];//本月装潢部预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_adminDept_expect']=$vo['tm_adminDept_expect']; //本月行政部预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_financeDept_expect']=$vo['tm_financeDept_expect']; //本月财务部预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_gmDept_expect']=$vo['tm_gmDept_expect']; //本月总经理预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_serviceDept_expect']=$vo['tm_serviceDept_expect'];//本月客服部预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_market_expect']=$vo['tm_market_expect']; //本月市场部预算
                            $data[$val['name']]['_child'][$value['name']]['info']['tm_other_expect']=$vo['tm_other_expect']; //本月其他预算
                            $data[$val['name']]['_child'][$value['name']]['info']['remark']=$vo['remark'];//备注
                           
                       }

                       if(!empty($value['_child'])){
                            foreach ($value['_child'] as $y => $v) {
                                $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['id']=$v['id']; 
                                $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['pid']=$v['pid']; 
                                foreach ($v['info'] as $a => &$vl) {
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['id']=$vl['id'];//id
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['pm_expect']=$vl['pm_expect'];//上月预测 
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['pm_actual']=$vl['pm_actual']; //上月实际
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['pm_diff']=round($vl['pm_actual']-$vl['pm_expect'],2);//实际－预测 差异
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['1_ppm_actual']=$vl['1_ppm_actual']; //1-上上月实际
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['1_tm_expect_c']=$vl['pm_actual']+$vl['1_ppm_actual']+$vl['tm_salesDept_expect']+$vl['tm_repairDept_expect']+$vl['tm_ornDept_expect']+$vl['tm_adminDept_expect']+$vl['tm_financeDept_expect']+$vl['tm_gmDept_expect']+$vl['tm_serviceDept_expect']+$vl['tm_market_expect']+$vl['tm_other_expect']; //1-本月预测
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['1_tm_expect_s']=$vl['1_tm_expect']; //1-本月预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['expect_diff']=round(($vl['1_ppm_actual']+$vl['tm_salesDept_expect']+$vl['tm_repairDept_expect']+$vl['tm_ornDept_expect']+$vl['tm_adminDept_expect']+$vl['tm_financeDept_expect']+$vl['tm_gmDept_expect']+$vl['tm_serviceDept_expect']+$vl['tm_market_expect']+$vl['tm_other_expect'])-$vl['1_tm_expect'],2); //预测－预算差异
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_expect']=$vl['tm_expect'];  //本月预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_tot_expect']=$vl['tm_salesDept_expect']+$vl['tm_repairDept_expect']+$vl['tm_ornDept_expect']+$vl['tm_adminDept_expect']+$vl['tm_financeDept_expect']+$vl['tm_gmDept_expect']+$vl['tm_serviceDept_expect']+$vl['tm_market_expect']+$vl['tm_other_expect']; //本月计划金额（总）
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_diff']=round(($vl['tm_salesDept_expect']+$vl['tm_repairDept_expect']+$vl['tm_ornDept_expect']+$vl['tm_adminDept_expect']+$vl['tm_financeDept_expect']+$vl['tm_gmDept_expect']+$vl['tm_serviceDept_expect']+$vl['tm_market_expect']+$vl['tm_other_expect'])-$vl['tm_expect'],2); //计划－预算差异
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_salesDept_expect']=$vl['tm_salesDept_expect']; //本月销售部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_repairDept_expect']=$vl['tm_repairDept_expect']; //本月维修部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_ornDept_expect']=$vl['tm_ornDept_expect'];//本月装潢部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_adminDept_expect']=$vl['tm_adminDept_expect']; //本月行政部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_financeDept_expect']=$vl['tm_financeDept_expect']; //本月财务部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_gmDept_expect']=$vl['tm_gmDept_expect']; //本月总经理预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_serviceDept_expect']=$vl['tm_serviceDept_expect'];//本月客服部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_market_expect']=$vl['tm_market_expect']; //本月市场部预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['tm_other_expect']=$vl['tm_other_expect']; //本月其他预算
                                    $data[$val['name']]['_child'][$value['name']]['_child'][$v['name']]['info_info']['remark']=$vl['remark'];//备注

                                } 
                            }
                        }
                    }
                   
                }
                // dump($data);
            //报表审批是否通过（总表）
            $up['store_id']=$map['store_id'];
            $up['year']=$map['year'];
            $up['month']=$map['month'];
            $up['chart_deptclass_id']=7;
            $up['status']=1;
            $data_status=operate_chart($up);
            $this -> assign('data_status',$data_status); //审批状态
        $this -> assign('data_cost',$data);
        $type = input('param.type');
            switch ($type) {
                case '4':   //财务部
                    $this -> chirld_status($map,9);
                    return view('c_index'); 
                    break;
                case '6':   //行政部
                    $this -> chirld_status($map,8); 
                    return view('x_index');
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

        //职工薪酬
    public function add(){
        $project=Db::name('kpi_costbudget_project')->where('project_pid=1')->where('is_del=0')->field('id,project_pid as pid,project_name as name')->select();
        $this->assign('project',$project);
            if(Request::instance()->isAjax()){      //点击提交通过AJAX方法后执行
                    $data = input('param.'); 

                    $store_id = $data['store_id'];      //单独提出前台传递的store_id
                    unset($data['store_id']);           //删除前台传递过来的数组中的store_id，剩下的数组便于下一步遍历
                    $classify_id = $data['classify_id'];
                    unset($data['classify_id']);
                    $about = array();                    //定义一个新数组，用于后面插入数据
                    foreach($data as $k => $v){         //遍历前台游泳数据
                            $about[$k] = $v;                 //向about数组中赋值（前台传递的数据）
                            $about[$k]['store_id'] = $store_id;     //向about数组中赋值（前台传递的store_id）
                            $about[$k]['year'] = date('Y');         //向about数组中赋值（当前年）
                            $about[$k]['month'] = date('m');;       //向about数组中赋值（当前月）
                            $about[$k]['classify_id'] = $classify_id;
                    }

                    $once_add = Db::name('kpi_costbudget')->where('year',date('Y'))->where('month',date('m'))->where('store_id',$store_id)->where('classify_id',$classify_id)->select();       //查找表中是否已经添加过当月的数据
                    if(!empty($once_add)){                      //如果数据已经存在，返回一个提示
                            $reslut['msg']='本月已经新增过数据!';
                            $reslut['status']='0';
                            return json($reslut);
                    }else{                                      //如果数据还不存在，向表中插入前台接收到且处理过的数据
                            foreach($about as $v){
                                    $res = Db::name('kpi_costbudget')->insert($v);      //插入数据
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
                    return view();
            }
    }

        //变动费用
        public function modificationadd(){
            $modification=Db::name('kpi_costbudget_project')->where('project_pid=2 OR project_pid=32')->where('is_del=0')->field('id,project_pid as pid,project_name as name')->select();
//            ->where('project_pid',['=',2],['=',32],'or');
       
            $this->assign('modification',$modification);
            return view();
        }

        //固定费用数据
        public function fixedadd(){
            $fixed=Db::name('kpi_costbudget_project')->where('project_pid=3 OR project_pid=53')->where('is_del=0')->field('id,project_pid as pid,project_name as name')->select();
            $this->assign('fixed',$fixed);
            return view();
        }

        //财务费用数据
        public function financeadd(){
           $finance=Db::name('kpi_costbudget_project')->where('project_pid=58 OR project_pid=62 OR project_pid=4')->where('is_del=0')->field('id,project_pid as pid,project_name as name')->select();
           $this->assign('finance',$finance);
           
           return view();
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
        $map['chart_type_id']  = 13;
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
    /*行政*/
    function administrative(){
        $map['chart_type_id']  = 17;
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
        $type = input('param.type'); //1财务 2行政
        $year = input('param.year');
        $check = $this->check($year, $month, $store_id, $type);
        if($check == FALSE){
            $result ['status'] = 0;
            $result ['msg'] = "你已经导入过数据，请勿重复导入！";
            return json($result);
        }
        $PHPExcel = import_excel($path); //读取excel
        $sheet0 = $PHPExcel->getSheet(0);  //获取sheet0
        $excel_type = (int)$sheet0->getCell('Z1')->getValue();
        if($excel_type != $type){
            $result ['status'] = 0;
            $result ['msg'] = "请选择导入正确的模版";
            return json($result);
        }
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
            $data_list[$j]['pm_expect'] = round($sheet0->getCell('E' . $i)->getValue(),2); //上月工资预测
            $data_list[$j]['pm_actual'] = round($sheet0->getCell('F' . $i)->getValue(),2); //上月工资实际
            $data_list[$j]['tm_expect'] = round($sheet0->getCell('G' . $i)->getValue(),2); //本月预测
            $data_list[$j]['tm_salesDept_expect'] = round($sheet0->getCell('H' . $i)->getValue(),2); //销售部（预测）
            $data_list[$j]['tm_repairDept_expect'] = round($sheet0->getCell('I' . $i)->getValue(),2); //维修部（预测）
            $data_list[$j]['tm_ornDept_expect'] = round($sheet0->getCell('J' . $i)->getValue(),2); //装潢（预测）
            $data_list[$j]['tm_adminDept_expect'] = round($sheet0->getCell('K' . $i)->getValue(),2); //行政部（预测）
            $data_list[$j]['tm_financeDept_expect'] = round($sheet0->getCell('L' . $i)->getValue(),2); //财务部（预测）
            $data_list[$j]['tm_gmDept_expect'] = round($sheet0->getCell('M' . $i)->getValue(),2); //总经办（预测）
            $data_list[$j]['tm_serviceDept_expect'] = round($sheet0->getCell('N' . $i)->getValue(),2); //客服部（预测）
            $data_list[$j]['tm_market_expect'] = round($sheet0->getCell('O' . $i)->getValue(),2); //市场部（预测）
            $data_list[$j]['tm_other_expect'] = round($sheet0->getCell('P' . $i)->getValue(),2); //其他（预测）
            $data_list[$j]['remark'] = (string)$sheet0->getCell('Q' . $i)->getValue(); //备注
            $data_list[$j]['add_time'] = time(); //录入时间
            $data_list[$j]['1_ppm_actual'] = round($sheet0->getCell('R' . $i)->getValue(),2); //1-上上月实际
            $data_list[$j]['1_tm_expect'] = round($sheet0->getCell('S' . $i)->getValue(),2); //1-本月预算
            if($data_list[$j]['project_id']>=5 && $data_list[$j]['project_id']<=14){
                $data_list[$j]['classify_id'] = '1';
            }else if($data_list[$j]['project_id']>=15 && $data_list[$j]['project_id']<=21){
                $data_list[$j]['classify_id'] = '2-1';
            }else if($data_list[$j]['project_id']>=22 && $data_list[$j]['project_id']<=32){
                $data_list[$j]['classify_id'] = '2-2';
            }else if($data_list[$j]['project_id']>=33 && $data_list[$j]['project_id']<=44){
                $data_list[$j]['classify_id'] = '2-3';
            }else if($data_list[$j]['project_id']>=45 && $data_list[$j]['project_id']<=52){
                $data_list[$j]['classify_id'] = '2-4';
            }else if($data_list[$j]['project_id']>=53 && $data_list[$j]['project_id']<=57){
                $data_list[$j]['classify_id'] = '3';
            }else if($data_list[$j]['project_id']>=58 && $data_list[$j]['project_id']<=71){
                $data_list[$j]['classify_id'] = '4';
            }
            $j++;
        }
        $res = Db::name('kpi_costbudget')->insertAll($data_list);
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
        $data = Db::name('kpi_costbudget_project')->where('id','>',4)->select();
        $data_list = array();
        foreach ($data as $v) {
            $data_list[]= $v['id'];
        }
        return $data_list;
    }
    private function check($year,$month,$store_id,$type){
        $map['year']=$year;
        $map['month']=$month;
        $map['store_id']=$store_id;
        if($type == 1){
            $map['classify_id'] = 1;
        }
        if($type == 2){
            $map['classify_id'] = ['neq',1];
        }
        $count = Db::name('kpi_costbudget')->where($map)->count();
        if($count>0){
            return FALSE;
        }
        return true;
    }
}