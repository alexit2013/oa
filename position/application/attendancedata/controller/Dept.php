<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
部门报表-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendancedata\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;


class Dept extends Base{
     public function index(){
         
        $data = array();
        if(Request::instance()->isPost()){
            $data = input('param.');  
            
        } 
        $this->assign('data',$data);
        $where = $this->search($data);
        //员工账号
        /*
         * late_times迟到次数，absent_times旷工次数，sign_in签到时间,sign_out签退时间，work_time工作时长，salary_time计薪时长
         * late_time迟到时间，absent_time旷工时间，leave_early_time早退时间，adjust_time调休时间，out_time外出时间，business_time出差时间
         * over_time加班时间，thing_time事假，sick_time病假，marriage_time婚假，maternity_time产假，death_time丧假，other_time其他假期
         * surplus_adjust_time剩余调休时间
         */
        
        $res = Db::name('pos_form')
                ->field('emp_no,dept_name,
                    SUM(late_times) as late_times,
                    SUM(absent_times) as absent_times,
                    SUM(work_time) as work_time,          
                    SUM(salary_time) as salary_time,      
                    SUM(late_time) as late_time,
                    SUM(leave_early_time) as leave_early_time,
                    SUM(absent_time) as absent_time,
                    SUM(adjust_time) as adjust_time,
                    SUM(out_time) as out_time,
                    SUM(business_time) as business_time,
                    SUM(over_time) as over_time,
                    SUM(thing_time) as thing_time,
                    SUM(sick_time) as sick_time,
                    SUM(marriage_time) as marriage_time,
                    SUM(maternity_time) as maternity_time,
                    SUM(death_time) as death_time,
                    SUM(other_time) as other_time,
                    SUM(surplus_adjust_time) as surplus_adjust_time')
                ->where($where)
                ->group('dept_name')
                ->select();
        if(!isset($where['com_id'])){
            $where['com_id'] = 1;
        }
        $com_name = Db::name('dept')->field('name')->where('id',$where['com_id'])->find();
        $data_arr = $this->shuju($res, $com_name['name']);  //数据处理
        
        
        //公司名id
        $map = array();
        $userinfo = session('user');
        if($userinfo['id'] == 1){
            $map['PID'] = 1;
        }else{
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
            if(empty($com_data)){
                $map['ID'] = $userinfo['id'];
            }else{
                $map['ID'] = ['IN',$com_data['com_ids']];
            }
        }
        $com = Db::name('dept')->field('id as com_id,name')->where($map)->select();

        $this->assign([
            'com_id'=>$com,
            'where'=>$where,
            'count'=>$data_arr['count'],
            'data_list'=>$data_arr['data_list']
            ]);
        return view();
    }

    //搜索
    public function search($data){
        if(empty($data['starttime']) && empty($data['endtime'])){       //开始不为空，结束为空
            $map['year'] = date('Y');
            $map['month'] = date('m');
        }elseif(!empty($data['starttime']) && empty($data['endtime'])){    //开始不为空，结束为空
            $time = strtotime($data['starttime']);
            $map['year'] = date('Y',$time);
            $map['month'] = ['>=',date('m',$time)];
        }elseif(!empty ($data['endtime']) && empty ($data['starttime'])){ //开始为空，结束不为空
            $time = strtotime($data['endtime']);
            $map['year'] = date('Y',$time);
            $map['month'] = ['<=',date('m',$time)];
        }else{ //开始和结束不为空
            $starttime = strtotime($data['starttime']);
            $endtime = strtotime($data['endtime']);
            $map['year'][0] = ['>=',date('Y',$starttime)];
            $map['year'][1] = ['<=',date('Y',$endtime)];
            $map['month'][0] = ['>=',date('m',$starttime)];
            $map['month'][1] = ['<=',date('m',$endtime)];
        }
        if(empty($data['com_id'])){
            $userinfo = session('user');
            if($userinfo['id'] != 1){   //非系统管理员
                $map['com_id']=$userinfo['com_id'];
            }
        }else{
            $map['com_id'] = $data['com_id'];
        }
        if(!empty($data['dept_name'])){
            $map['dept_name'] = ['like','%'.$data['dept_name'].'%'];
        }
        $map['LENGTH(emp_no)'] = ['>',0];
        $map['LENGTH(dept_name)'] = ['>',0];
        return $map;
    }
    
    private function shuju($data,$com){
        $work_time = 0;
        $salary_time = 0;
        $late_time = 0;
        $leave_early_time = 0;
        $absent_time = 0;
        $absent_times = 0;
        $adjust_time = 0;
        $out_time = 0;
        $business_time = 0;
        $over_time = 0;
        $thing_time = 0;
        $sick_time = 0;
        $marriage_time = 0;
        $maternity_time = 0;
        $death_time = 0;
        $other_time = 0;
        $surplus_adjust_time = 0;
        $data_list = array();
        if(!empty($data)){
            foreach ($data as $k => $v){
                $work_time += $v['work_time'];
                $salary_time += $v['salary_time'];
                $late_time += $v['late_time'];
                $leave_early_time += $v['leave_early_time'];
                $absent_time += $v['absent_time'];
                $absent_times += $v['absent_times'];
                $adjust_time += $v['adjust_time'];
                $out_time += $v['out_time'];
                $business_time += $v['business_time'];
                $over_time += $v['over_time'];
                $thing_time += $v['thing_time'];
                $sick_time += $v['sick_time'];
                $marriage_time += $v['marriage_time'];
                $maternity_time+= $v['maternity_time'];
                $death_time += $v['death_time'];
                $other_time += $v['other_time'];
                $surplus_adjust_time += $v['surplus_adjust_time'];
                $data_list[$k]['dept_name'] = $v['dept_name'];
                $data_list[$k]['work_time'] = round($v['work_time']/8,3);
                $data_list[$k]['salary_time'] = round($v['salary_time']/8,3);
                $data_list[$k]['late_time'] = $v['late_time'];
                $data_list[$k]['leave_early_time'] = $v['leave_early_time'];
                $data_list[$k]['absent_time'] = round($v['absent_time']/8,3);
                $data_list[$k]['absent_times'] = $v['absent_times'];
                $data_list[$k]['adjust_time'] = round($v['adjust_time']/8,3);
                $data_list[$k]['out_time'] = round($v['out_time']/8,3);
                $data_list[$k]['business_time'] = round($v['business_time']/8,3);
                $data_list[$k]['over_time'] = round($v['over_time']/8,3);
                $data_list[$k]['thing_time'] = round($v['thing_time']/8,3);
                $data_list[$k]['sick_time'] = round($v['sick_time']/8,3);
                $data_list[$k]['marriage_time'] = round($v['marriage_time']/8,3);
                $data_list[$k]['maternity_time'] = round($v['maternity_time']/8,3);
                $data_list[$k]['death_time'] = round($v['death_time']/8,3);
                $data_list[$k]['other_time'] = round($v['other_time']/8,3);
                $data_list[$k]['surplus_adjust_time'] = round($v['surplus_adjust_time']/8,3);
            }
        }
        $count['dept_name'] = $com;
        $count['work_time'] = round($work_time/8,3);
        $count['salary_time'] = round($salary_time/8,3);
        $count['late_time'] = $late_time;
        $count['leave_early_time'] = $leave_early_time;
        $count['absent_time'] = round($absent_time/8,3);
        $count['absent_times'] = $absent_times;
        $count['adjust_time'] = round($adjust_time/8,3);
        $count['out_time'] = round($out_time/8,3);
        $count['business_time'] = round($business_time/8,3);
        $count['over_time'] = round($over_time/8,3);
        $count['thing_time'] = round($thing_time/8,3);
        $count['sick_time'] = round($sick_time/8,3);
        $count['marriage_time'] = round($marriage_time/8,3);
        $count['maternity_time'] = round($maternity_time/8,3);
        $count['death_time'] = round($death_time/8,3);
        $count['other_time'] = round($other_time/8,3);
        $count['surplus_adjust_time'] = round($surplus_adjust_time/8,3);
        $data_arr['data_list'] = $data_list;
        $data_arr['count'] = $count;
        return $data_arr;
    }
    /**
     * Excel表
     */
    function export(){

        $data = input('param.');
        $where = $this->search($data);
        $this->assign('data',$data);
        
        
        $res = Db::name('pos_form')
                ->field('emp_no,dept_name,
                    SUM(late_times) as late_times,
                    SUM(absent_times) as absent_times,
                    SUM(work_time) as work_time,          
                    SUM(salary_time) as salary_time,      
                    SUM(late_time) as late_time,
                    SUM(leave_early_time) as leave_early_time,
                    SUM(absent_time) as absent_time,
                    SUM(adjust_time) as adjust_time,
                    SUM(out_time) as out_time,
                    SUM(business_time) as business_time,
                    SUM(over_time) as over_time,
                    SUM(thing_time) as thing_time,
                    SUM(sick_time) as sick_time,
                    SUM(marriage_time) as marriage_time,
                    SUM(maternity_time) as maternity_time,
                    SUM(death_time) as death_time,
                    SUM(other_time) as other_time,
                    SUM(surplus_adjust_time) as surplus_adjust_time')
                ->where($where)
                ->group('dept_name')
                ->select();
        if(!isset($where['com_id'])){
            $where['com_id'] = 1;
        }
        $com_name = Db::name('dept')->field('name')->where('id',$where['com_id'])->find();
        $data_arr = $this->shuju($res, $com_name['name']);  //数据处理
        $data_list = $data_arr['data_list'];
        $count = $data_arr['count'];
        $excelname = "考勤部门报表";

        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($data_list);

        vendor("phpexcel_vendor.PHPExcel");
        $objPHPExcel = new \PHPExcel();   // 创建一个处理对象实例

        //设置宽度
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('S')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('V')->setWidth(30);
        for($i=1;$i<=$dataNum;$i++){
         $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':V'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1:V1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','公司');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','工作时长（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','计薪时长（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','迟到');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','早退');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','旷工（次）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','旷工（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','调休（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','外出（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','出差（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','加班（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','病假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1','婚假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1','丧假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1','产假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1','事假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1','其他假期（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1','剩余调休（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1','异常天数');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1','异常天数占比');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1','异常天数（纯异常）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1','异常天数（纯异常占比）');
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$count['dept_name']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2',$count['work_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2',$count['salary_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2',$count['late_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2',$count['leave_early_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2',$count['absent_times']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2',$count['absent_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2',$count['adjust_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2',$count['out_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2',$count['business_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2',$count['over_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2',$count['sick_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2',$count['marriage_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2',$count['death_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2',$count['maternity_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2',$count['thing_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2',$count['other_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2',$count['surplus_adjust_time']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2',"");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2',"");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2',"");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2',"");
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+3),$data_list[$i]['dept_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+3),$data_list[$i]['work_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+3),$data_list[$i]['salary_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+3),$data_list[$i]['late_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+3),$data_list[$i]['leave_early_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+3),$data_list[$i]['absent_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+3),$data_list[$i]['absent_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+3),$data_list[$i]['adjust_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+3),$data_list[$i]['out_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+3),$data_list[$i]['business_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+3),$data_list[$i]['over_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+3),$data_list[$i]['sick_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+3),$data_list[$i]['marriage_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+3),$data_list[$i]['death_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+3),$data_list[$i]['maternity_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+3),$data_list[$i]['thing_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($i+3),$data_list[$i]['other_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($i+3),$data_list[$i]['surplus_adjust_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($i+3),"");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($i+3),"");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.($i+3),"");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($i+3),"");
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+3).':V'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        }

        ob_end_clean();
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}