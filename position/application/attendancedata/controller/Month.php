<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
月报-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendancedata\controller;
use app\base\controller\Base;
use think\Db;


class Month extends Base{
    /*月报表*/
    function index(){
        $data = array();
        if(request()->isPost()){
            $data = input('param.');
            
        }
        
        $this->assign('data',$data);
        $map = $this->search($data);
        $userinfo = session('user');
        if($userinfo['id'] != 1){   //非系统管理员
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
            if(empty($com_data)){
                $map['com_id']=$userinfo['com_id'];
            }else{
                $map['com_id'] = ['IN',$com_data['com_ids']];
            }
        }
        $data_list = Db::name('pos_form')
                ->where($map)
                ->field('*,Round(sum(work_time)/8,3) as work_time_day,' 
                        . 'Round(sum(salary_time)/8,3) as salary_time_day,'
                        . 'SUM(late_time) as late_time,'
                        . 'Round(SUM(business_time)/8,3) as business_time,'
                        . 'SUM(leave_early_time) as leave_early_time,'
                        . 'Round(SUM(absent_time)/8,3) as absent_time,' //旷工
                        . 'Round(SUM(sick_time)/8,3) as sick_time,'
                        . 'Round((SUM(year_time)-SUM(surplus_year_time))/8,3) as year_time,'
                        . 'Round(SUM(surplus_year_time)/8,3) as surplus_year_time,'
                        . 'Round(SUM(over_time)/8,3) as over_time,'     //加班
                        . 'Round(SUM(other_time)/8,3) as other_time,'     //其他假期
                        . 'Round(SUM(death_time)/8,3) as death_time,'   //丧假
                        . 'Round(SUM(maternity_time)/8,3) as maternity_time,'   //产假
                        . 'Round(SUM(marriage_time)/8,3) as marriage_time,'   //请假
                        . 'Round(SUM(surplus_adjust_time)/8,3) as surplus_adjust_time,'
                        . 'Round((SUM(adjust_time)-SUM(surplus_adjust_time))/8,3) as adjust_time,'
                        . 'Round(SUM(out_time)/8,3) as out_time,'
                        . 'Round(SUM(thing_time)/8,3) as thing_time')
                ->group('emp_no')
                ->limit(200)
                ->select();
                $year=date('Y');
                $month=date('n');
                $month1=$month-1;
                $month2=$month1-1;
                if($month==1){
                    $year=date('Y')-1;
                    $month1=12;
                    $month2=$month1-1;
                }
                $a_where['year']=$year;
                $a_where['month']=['IN',[$month,$month1,$month2]];
            $ajust=Db::name('pos_form')->field('emp_no,Round(SUM(over_time)/8,3) as over_time,Round(SUM(adjust_time)/8,3) as adjust_time')//当前3个月剩余调休统计
            ->where($a_where)
            ->group('emp_no')
            ->select();
            $data_ajust=array();
            foreach ($ajust as $k => $vo) {
                $data_ajust[$vo['emp_no']]['over_time']=$vo['over_time'];
                $data_ajust[$vo['emp_no']]['adjust_time']=$vo['adjust_time'];
            }

        $this->assign([
            'data_list'=>$data_list,
            'data_ajust'=>$data_ajust
        ]);
        return view();
    }
    
    /*查询条件*/
    function search($data){
        if(empty($data['starttime']) && empty($data['endtime'])){       //开始为空，结束为空
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
        if(!empty($data['dept_name'])){
            $map['dept_name'] = ['like','%'.$data['dept_name'].'%'];
        }
        if(!empty($data['user_name'])){
            $map['user_name'] = ['like','%'.$data['user_name'].'%'];
        }
        if(!empty($data['emp_no'])){
            $map['emp_no'] = ['like','%'.$data['emp_no'].'%'];
        }
        
        return $map;
            
    }
    
      /**
     * Excel表
     */
    function export(){
        $data = input('param.');
        $map = $this->search($data);
        if(isset($map['year'])){
            $map_up['a.year']=$map['year'];
        }
        if(isset($map['month'])){
            $map_up['a.month']=$map['month'];
        }
        if(isset($map['dept_name'])){
            $map_up['a.dept_name']=$map['dept_name'];
        }
        if(isset($map['user_name'])){
            $map_up['a.user_name']=$map['user_name'];
        }
        if(isset($map['emp_no'])){
            $map_up['a.emp_no']=$map['emp_no'];
        }
        $userinfo = session('user');
        if($userinfo['id'] != 1){   //非系统管理员
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
            if(empty($com_data)){
                $map_up['a.com_id']=$userinfo['com_id'];
            }else{
                $map_up['a.com_id'] = ['IN',$com_data['com_ids']];
            }
        }
       
        $arr = Db::name('pos_form')
                ->alias('a')
                ->join('think_user b','b.emp_no = a.emp_no','LEFT')
                ->where('is_del','0')
                ->where($map_up)
                ->field('a.*,Round(sum(work_time)/8,3) as work_time_day,'
                        . 'Round(sum(salary_time)/8,3) as salary_time_day,'
                        . 'SUM(late_time) as late_time,'
                        . 'Round(SUM(business_time)/8,3) as business_time,'
                        . 'SUM(leave_early_time) as leave_early_time,'
                        . 'Round(SUM(absent_time)/8,3) as absent_time,' //旷工
                        . 'Round(SUM(sick_time)/8,3) as sick_time,'
                        . 'Round((SUM(year_time)-SUM(surplus_year_time))/8,3) as year_time,'
                        . 'Round(SUM(surplus_year_time)/8,3) as surplus_year_time,'
                        . 'Round(SUM(over_time)/8,3) as over_time,'     //加班
                        . 'Round(SUM(other_time)/8,3) as other_time,'     //其他假期
                        . 'Round(SUM(death_time)/8,3) as death_time,'   //丧假
                        . 'Round(SUM(maternity_time)/8,3) as maternity_time,'   //产假
                        . 'Round(SUM(marriage_time)/8,3) as marriage_time,'   //请假
                        . 'Round(SUM(surplus_adjust_time)/8,3) as surplus_adjust_time,'
                        . 'Round((SUM(adjust_time)-SUM(surplus_adjust_time))/8,3) as adjust_time,'
                        . 'Round(SUM(out_time)/8,3) as out_time,'
                        . 'Round(SUM(thing_time)/8,3) as thing_time')
                ->group('emp_no')
                ->select();
                
        //当前3个月剩余调休
                $year=date('Y');
                $month=date('n');
                $month1=$month-1;
                $month2=$month1-1;
                if($month==1){
                    $year=date('Y')-1;
                    $month1=12;
                    $month2=$month1-1;
                }
            $a_where['year']=$year;
            $a_where['month']=['IN',[$month,$month1,$month2]];
            $ajust=Db::name('pos_form')->field('emp_no,Round(SUM(over_time)/8,3) as over_time,Round(SUM(adjust_time)/8,3) as adjust_time')//当前3个月剩余调休统计
            ->where($a_where)
            ->group('emp_no')
            ->select();
           
            $data_ajust=array();
            foreach ($ajust as $k => $vo) {
                $data_ajust[$vo['emp_no']]['over_time']=$vo['over_time'];
                $data_ajust[$vo['emp_no']]['adjust_time']=$vo['adjust_time'];
            }

        $excelname = "考勤月报表";
 
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);

        vendor("phpexcel_vendor.PHPExcel");
        $objPHPExcel = new \PHPExcel();   // 创建一个处理对象实例

        //设置宽度
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'B')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'C')->setWidth(40);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'D')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'E')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'F')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'G')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'H')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'I')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'J')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'K')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'L')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'M')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'N')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'O')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'P')->setWidth(20);
//        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'Q')->setWidth(20);
        for($i=1;$i<=$dataNum;$i++){
         $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':Q'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }

        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1:Q1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','账号');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','姓名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','部门');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','职位');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','工作时长（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','计薪时长（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','迟到（分钟）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','早退（分钟）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','旷工（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','加班（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','调休（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','外出（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1','出差（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1','事假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1','病假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1','婚假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1','丧假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1','产假（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1','其他假期（天）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1','剩余调休（天）');

        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2),$arr[$i]['emp_no']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2),$arr[$i]['user_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2),$arr[$i]['dept_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2),$arr[$i]['position']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2),$arr[$i]['work_time_day']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2),$arr[$i]['salary_time_day']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2),$arr[$i]['late_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2),$arr[$i]['leave_early_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2),$arr[$i]['absent_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2),$arr[$i]['over_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2),$arr[$i]['adjust_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2),$arr[$i]['out_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2),$arr[$i]['business_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2),$arr[$i]['thing_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+2),$arr[$i]['sick_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+2),$arr[$i]['marriage_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($i+2),$arr[$i]['death_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($i+2),$arr[$i]['maternity_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($i+2),$arr[$i]['other_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($i+2),$data_ajust[$arr[$i]['emp_no']]['over_time']-$data_ajust[$arr[$i]['emp_no']]['adjust_time']);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+2).':U'.($i+2))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        }

        ob_end_clean();
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
}