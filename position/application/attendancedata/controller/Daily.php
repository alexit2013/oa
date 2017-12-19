<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
日报-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendancedata\controller;
use app\base\controller\Base;
use think\Db;

class Daily extends Base{

    public function index(){

        $where = array();
        $data = input('param.');

        $where = $this->search($data);
        $this->assign('data',$data);
        $userinfo = session('user');
        if($userinfo['id'] != 1){   //非系统管理员
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();

            if(empty($com_data)){
                $where['com_id']=$userinfo['com_id'];
            }else{
                $where['com_id'] = ['IN',$com_data['com_ids']];
            }
        }
        $post_m = Db::name("pos_form")->where($where)->field('*')->limit(200)->select();

        $this->assign('data_list',$post_m);
        return view();
    }
    /*
     * 补签功能
     */
    function buqian(){
        if(request()->isAjax()){
            $data = input('param.');
            $userinfo = Db::name('user')->where('emp_no',$data['emp_no'])->find();
            if(empty($userinfo)){
                $result['msg'] = '账号不存在！';
                $result['status'] = 0;
                return $result;
            }
            $time_arr = explode('T', $data['time']);
            $Ymd_arr = explode('-', $time_arr[0]);
            $in_time = strtotime($time_arr[0]." ".$time_arr[1]);    //补签时间戳
            $map['emp_no'] = $data['emp_no'];
            $map['year'] = $Ymd_arr[0];
            $map['month'] = (int)$Ymd_arr[1];
            $map['day'] = (int)$Ymd_arr[2];
            $form = Db::name('pos_form')->where($map)->find();
            if(empty($form)){   //插入数据
                $dept_data = Db::name('dept')->where('id',$userinfo['dept_id'])->find();
                $position_data = Db::name('position')->where('id',$userinfo['position_id'])->find();
                $scheduling = Db::name('pos_scheduling')->where($map)->find();
                $schedual = Db::name('pos_schedual')->field('shift_name as schedule,work_start_time as on_work_time,work_end_time as out_work_time')
                    ->where('id',$scheduling['schedual_id'])->find();
                $insert = $schedual;
                $insert['emp_no'] = $userinfo['emp_no'];
                $insert['year'] = $Ymd_arr[0];
                $insert['month'] = (int)$Ymd_arr[1];
                $insert['day'] = (int)$Ymd_arr[2];
                $insert['user_name'] = $userinfo['name'];
                $insert['dept_name'] = $dept_data['NAME'];
                $insert['com_id'] = $userinfo['com_id'];
                $insert['position'] = $position_data['name'];
                $insert['type'] = '工作日';
                if($data['type'] == 1){   //签到
                    $insert['sign_in'] = $time_arr[1];
                }
                if($data['type'] == 2){ //签退
                    $insert['sign_out'] = $time_arr[1];
                }
                $insert['salary_time'] = 8;
                Db::name('pos_form')->insert($insert);
            }else{  //更新数据
                if($data['type'] == 1){   //签到
                    $up['sign_in'] = $time_arr[1];
                    $up['salary_time'] = 8;
                    if(!empty($form['sign_out'])){  //签退已存在  
                        $out_time_arr = explode(':', $form['sign_out']);
                        $out_time = mktime($out_time_arr[0], $out_time_arr[1], 0, $Ymd_arr[1], $Ymd_arr[2]);
                        $up['work_time'] = round(($out_time-$in_time)/3600,3);
                        if($up['work_time'] >= 8){
                            $up['work_time'] = 8;
                        }
                        if($up['work_time'] < 0){
                            $up['work_time'] = 0;
                        }
                        $up['absent_time'] = 0; //旷工清零
                        $up['absent_times'] = 0;
                        $up['late_time'] = 0; //迟到清零
                        $up['late_times'] = 0;
                    }
                }
                if($data['type'] == 2){ //签退
                    $up['salary_time'] = 8;
                    $up['sign_out'] = $time_arr[1];
                    if(!empty($form['sign_in'])){ //签到已存在
                        $ins_time_arr = explode(':', $form['sign_in']);
                        $ins_time = mktime($ins_time_arr[0], $ins_time_arr[1], 0, $Ymd_arr[1], $Ymd_arr[2]);
                        $up['work_time'] = round(($in_time-$ins_time)/3600,3);
                        if($up['work_time'] >= 8){
                            $up['work_time'] = 8;
                        }
                        if($up['work_time'] < 0){
                            $up['work_time'] = 0;
                        }
                        $up['absent_time'] = 0; //旷工清零
                        $up['absent_times'] = 0;
                        $up['leave_early_time'] = 0; //早退清零
                        $up['leave_early_times'] = 0;
                    }
                }
                Db::name('pos_form')->where('id='.$form['id'])->update($up);
            }
            $result['status'] = 1;
            $result['msg'] = '添加成功！';
            return json($result);
        }
        return view();
    }


    //搜索
    public function search($data){

        $map = array();

        if(!empty($data['user_name'])){
            $map['user_name'] = ['like','%'.$data['user_name'].'%'];
        }
        if(!empty($data['dept_name'])){
            $map['dept_name'] = ['like','%'.$data['dept_name'].'%'];
        }
        if(!empty($data['emp_no'])){
            $map['emp_no'] = ['like','%'.$data['emp_no'].'%'];
        }
        if(empty($data['starttime']) && empty($data['endtime'])){       //开始和结束为空
            $map['year'] = date('Y');
            $map['month'] = date('m');
        }elseif(!empty($data['starttime']) && empty($data['endtime'])){    //开始不为空，结束为空
            $time = strtotime($data['starttime']);
            $map['year'] = date('Y',$time);
            $map['month'] = ['=',(int)date('m',$time)];
            $map['day'] = ['>=',(int)date('d',$time)];
        }elseif(!empty ($data['endtime']) && empty ($data['starttime'])){ //开始为空，结束不为空
            $time = strtotime($data['endtime']);
            $map['year'] = date('Y',$time);
            $map['month'] = ['=',date('m',$time)];
            $map['day'] = ['<=',(int)date('d',$time)];
        }else{ //开始和结束不为空
            $starttime = strtotime($data['starttime']);
            $endtime = strtotime($data['endtime']);
            $map['year'][0] = ['>=',date('Y',$starttime)];
            $map['year'][1] = ['<=',date('Y',$endtime)];
            $map['day'][0] = ['>=',(int)date('d',$starttime)];
            $map['day'][1] = ['<=',(int)date('d',$endtime)];
            $map['month'][0] = ['>=',(int)date('m',$starttime)];
            $map['month'][1] = ['<=',(int)date('m',$endtime)];
        }
        if(!empty($data['dept_name'])){
            $map['dept_name'] = ['like','%'.$data['dept_name'].'%'];
        }
        return $map;
    }


    /**
     * Excel表
     */
    function export(){

        $where = array();
        $data = input('param.');
        $where = $this->search($data);
        $this->assign('data',$data);
        $userinfo = session('user');
        if($userinfo['id'] != 1){   //非系统管理员
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
            if(empty($com_data['com_ids'])){
                $where['a.com_id'] = $userinfo['com_id'];
            } else {
                $where['a.com_id'] = ['IN',$com_data['com_ids']];
            }

        }
        $arr = Db::name("pos_form")
            ->alias('a')
            ->join('think_user b','b.emp_no = a.emp_no','LEFT')
            ->where('is_del','0')
            ->where($where)
            ->field('a.*')
            ->select();

        $excelname = "考勤日报表";

        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);

        vendor("phpexcel_vendor.PHPExcel");
        $objPHPExcel = new \PHPExcel();   // 创建一个处理对象实例

        //设置宽度
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'B')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'C')->setWidth(60);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'D')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'E')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'F')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'G')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'H')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'I')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'J')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'K')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'L')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'M')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'N')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'O')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'P')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'Q')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'R')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'S')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'T')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'U')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'V')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'W')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'X')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'Y')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'Z')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AA')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AB')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AC')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AD')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AE')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AF')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'AG')->setWidth(20);
        for($i=1;$i<=$dataNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':AG'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }

        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1:AG1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','账号');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','姓名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','部门');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','职位');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','日期');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','星期');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','日期类型');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','班次');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','上班时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','下班时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','签到打卡');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','签退打卡');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1','工作时长');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1','计薪时长');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1','迟到（分钟）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1','迟到（次数）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1','早退（分钟）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1','早退（次数）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1','旷工（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1','旷工（次数）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1','调休（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1','调休（次数）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1','外出（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1','外出（次数）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1','加班（次）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1','加班（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1','婚假（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1','病假（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1','产假（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1','丧假（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1','事假（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1','出差（小时）');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1','其他假期（小时）');

        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+2),$arr[$i]['emp_no']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+2),$arr[$i]['user_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+2),$arr[$i]['dept_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+2),$arr[$i]['position']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+2),$arr[$i]['year'].'-'.$arr[$i]['month'].'-'.$arr[$i]['day']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+2),weekday(strtotime($arr[$i]['year'].'-'.$arr[$i]['month'].'-'.$arr[$i]['day'])));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2),$arr[$i]['type']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+2),$arr[$i]['schedule']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+2),$arr[$i]['on_work_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+2),$arr[$i]['out_work_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+2),$arr[$i]['sign_in']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+2),$arr[$i]['sign_out']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+2),$arr[$i]['work_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+2),$arr[$i]['salary_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+2),$arr[$i]['late_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+2),$arr[$i]['late_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($i+2),$arr[$i]['leave_early_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($i+2),$arr[$i]['leave_early_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($i+2),$arr[$i]['absent_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($i+2),$arr[$i]['absent_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.($i+2),$arr[$i]['adjust_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($i+2),$arr[$i]['adjust_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.($i+2),$arr[$i]['out_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($i+2),$arr[$i]['out_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.($i+2),$arr[$i]['over_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.($i+2),$arr[$i]['over_times']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.($i+2),$arr[$i]['marriage_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.($i+2),$arr[$i]['sick_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.($i+2),$arr[$i]['maternity_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.($i+2),$arr[$i]['death_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.($i+2),$arr[$i]['thing_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.($i+2),$arr[$i]['business_time']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.($i+2),$arr[$i]['other_time']);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+2).':AG'.($i+2))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        }

        ob_end_clean();
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


}