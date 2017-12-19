<?php
/*--------------------------------------------------------------------
广汇KPI报表--应收账款账龄表

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\chart\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;

class Account extends Base{

    public function index(){
        //获取科目类别
        $account_class = $this->account_class();    //科目分类
        $map = $this->search();
        $list = Db::name('kpi_account') //明细列表
                ->field('id,name,class_id,three_m,fourtosix_m,seventotwelve_m,onetotwo_y,two_y,three_y,mark')->where($map)->select();
        $data_list = $this->data_list($list);
        $count = Db::name('kpi_account')  //获取合计
                ->field('class_id,sum(three_m) as three_m,sum(fourtosix_m) as fourtosix_m,sum(seventotwelve_m) as seventotwelve_m,sum(onetotwo_y) as onetotwo_y,sum(two_y) as two_y,sum(three_y) as three_y')
                ->group('class_id')->where($map)->select();
        $count_list = $this->count_list($count,$account_class);
        $store = Db::name('dept')->where('id',$map['store_id'])->find();
        //报表审批是否通过
        $up['a.store_id']=$map['store_id'];
        $up['a.year']=$map['year'];
        $up['a.month']=$map['month'];
        $up['a.chart_deptclass_id']=25;
        $data_status=check_flow_month($up);
        $this->assign([
            'store_name'=>$store['NAME'],
            'account_class'=>$account_class,
            'data_list' => $data_list,
            'count_list' => $count_list,
            'data_status'=>$data_status //审批状态
        ]);
        return view();
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
    /*
     * 按科目类别分组明细列表
     * @param $data 明细列表 
     */
    private function data_list($data){
        $list = array();
        foreach ($data as $k => $v) {
            $list[$v['class_id']][$k] = $v;
        }
        return $list;
    }
    /*
     * 求各科目类别的和
     * @param $data 合计列表
     * @param $class 科目列表
     */
    private function count_list($data,$class){
        $list = array();
        foreach ($data as $v) {
            $class_id = $v['class_id'];
            unset($v['class_id']);
            $list[$class_id] = $v;
        }
        $lists = $this->_counts($class,$list);
        return $lists;
    }
    /*
     * 求上级科目类别的和
     * @param $data 合计列表
     * @param $class 科目列表
     */
    private function _counts($class,$data){
        $list = array();
        foreach ($data as $k => $v) {
            foreach ($v as $ko =>$vo){  //求当前科目的合计
                if(!isset($list[$k][$ko])){
                    $list[$k][$ko] = 0;
                }
                $list[$k][$ko] += $vo;
            } 
            $id = $class[$k]['pid'];    //求上一级科目的合计
            if($id != 0){   //是否到顶级
                foreach ($v as $ko => $vo) {
                    if(!isset($list[$id][$ko])){
                        $list[$id][$ko] = 0;
                    }
                    $list[$id][$ko] += $vo;
                }
                $id2 = $class[$id]['pid'];  //求上两级科目的合计
                    if($id2 != 0){  //是否到顶级
                        foreach ($v as $ko => $vo) {
                        if(!isset($list[$id2][$ko])){
                            $list[$id2][$ko] = 0;
                        }
                        $list[$id2][$ko] += $vo;
                        $id3 = $class[$id2]['pid']; //求上三级科目的合计
                        if($id3 != 0){  //是否到顶级
                            foreach ($v as $ko => $vo) {
                                if(!isset($list[$id3][$ko])){
                                    $list[$id3][$ko] = 0;
                                }
                                $list[$id3][$ko] += $vo;
                            }
                        }
                    }
                }
            }
        }
        return $list;
    }
    /*
     * 获取科目类别列表
     */
    private function account_class(){
        $list = Db::name('kpi_account_class')->select();
        $data_list = $this->_reSort($list);
        return $data_list;
    }
    /*
     * 科目类别分级
     * @param $data 科目类别
     * @param $pid 父级id
     * @param $level 级别
     */
    private function _reSort($data,$pid=0,$level=0){
        static $ret=array();
        foreach ($data as $v){
            if ($v['pid'] == $pid) {
                //把level值放到这个分类里
                $v['level']=$level;
                $ret[$v['id']]=$v;
                //再找这个分类的子分类
                $this->_reSort($data, $v['id'],$level+1);
            }
        }
        return $ret;
    }
    
    //应收账款账龄数据添加
    public function add(){
        if(Request::instance()->isAjax()){
            $data_add = input('param.');
            $data['store_id'] = $data_add['store_id'];
            $data['name'] = $data_add['name'];
            $data['year'] = $data_add['year'];
            $data['month'] = $data_add['month'];
            $data['class_id'] = $data_add['class_id'];
            $data['three_m'] = $data_add['three_m'];
            $data['fourtosix_m'] = $data_add['fourtosix_m'];
            $data['seventotwelve_m'] = $data_add['seventotwelve_m'];
            $data['onetotwo_y'] = $data_add['onetotwo_y'];
            $data['two_y'] = $data_add['two_y'];
            $data['three_y'] = $data_add['three_y'];
            $data['mark'] = $data_add['mark'];
            $res = Db::name('kpi_account')
                ->where('name',$data_add['name'])
                ->where('store_id',$data_add['store_id'])
                ->where('year',$data_add['year'])
                ->where('month',$data_add['month'])
                ->where('class_id',$data_add['class_id'])
                ->find();
            if(!empty($res)){
                $reslut['msg']='该类型该月数据已存在!';
                $reslut['status']='0';
                return json($reslut);
            }else{
                $result = Db::name('kpi_account')->insert($data);
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
    /*财务*/
    function finace(){
        $map['chart_type_id']  = 11;
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
            $data_list[$j]['name'] = (string)$sheet0->getCell('C' . $i)->getValue(); //明细
            
            $data_list[$j]['class_id'] = (int)$sheet0->getCell('D' . $i)->getValue(); //科目编码
            if(!in_array($data_list[$j]['class_id'],$project)){
                $result ['status'] = 0;
                $result ['msg'] = "科目编码不存在，错误位置：(D".$i.")";
                return json($result);
            }
            $data_list[$j]['three_m'] = round($sheet0->getCell('E' . $i)->getValue(),2); //三月以内
            $data_list[$j]['fourtosix_m'] = round($sheet0->getCell('F' . $i)->getValue(),2); //4-6月
            $data_list[$j]['seventotwelve_m'] = round($sheet0->getCell('G' . $i)->getValue(),2); //7-12月
            $data_list[$j]['onetotwo_y'] = round($sheet0->getCell('H' . $i)->getValue(),2); //1-2年
            $data_list[$j]['two_y'] = round($sheet0->getCell('I' . $i)->getValue(),2); //2年以上
            $data_list[$j]['three_y'] = round($sheet0->getCell('J' . $i)->getValue(),2); //3年以上
            $data_list[$j]['mark'] = (string)$sheet0->getCell('K' . $i)->getValue(); //备注
            $j++;
        }
        $res = Db::name('kpi_account')->insertAll($data_list);
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
        $data = Db::name('kpi_account_class')->where('id','>',1)->select();
        $data_list = array();
        foreach ($data as $v) {
            $data_list[]= $v['id'];
        }
        return $data_list;
    }
    
}

