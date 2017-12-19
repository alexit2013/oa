<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
排班-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendanceset\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Scheduling extends Base{

    public function index(){
        $query = array();
        $data = input('param.');
        $where = $this->search1($data);
        if(!empty($data['time'])){
            $query['time'] = $data['time'];
        }
        if(!empty($data['user_name'])){
            $query['user_name'] = $data['user_name'];
        }
        if(!empty($data['emp_no'])){
            $query['emp_no'] = $data['emp_no'];
        }
        $userinfo = session('user');
        if($userinfo['id'] != 1){
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
            if(empty($com_data)){
                $where['u.com_id']=$userinfo['com_id'];
            }else{
                $where['u.com_id'] = ['IN',$com_data['com_ids']];
            }   
          
        }
        $where['u.id'] = ['neq',1]; //排除系统管理员
        $where['u.is_del'] = 0;
        
        
        $user = Db::name('user')->alias('u')->field('u.id,u.emp_no,u.name,d.name as dept_name,p.name as position_name')
                ->join('think_dept d','d.id=u.dept_id','LEFT')
                ->join('think_position p','p.id=u.position_id','LEFT')
               // ->fetchSql(true)
                ->where($where)->paginate(8,FALSE,['query'=>$query]);
        $page = $user->render();
        $list = array();
        // dump($user);
        $map = $this->search2($data);   //查询月份条件
        foreach($user as $k => $v){
            $list[$k]['id'] = $v['id'];
            $list[$k]['emp_no'] = $v['emp_no'];
            $list[$k]['user_name'] = $v['name'];
            $list[$k]['dept_name'] = $v['dept_name'];
            $list[$k]['position'] = $v['position_name'];
            $list[$k]['year'] = $map['year'];
            $list[$k]['month'] = $map['month'];
            $datas = Db::name('pos_scheduling')->where($map)->where('emp_no',$v['emp_no'])->select(); 
            if(!empty($datas)){    
                foreach ($datas as $ko => $vo){
                    $list[$k]['scheduling'][$vo['day']]['id']=$vo['id'];
                    $list[$k]['scheduling'][$vo['day']]['schedual_id'] = $vo['schedual_id'];
                    $list[$k]['scheduling'][$vo['day']]['schedual_name'] = $vo['schedual_name'];
                }
            }
        }   
        $daynum=$this ->get_day($map['year'].'-'.$map['month'].'-01','1');
        $month=$map['month'];
        $this->assign('daynum',$daynum);
        $this ->assign('month',$month); 
        $this->assign('data',$data);
        $this->assign('data_list',$list);
        $this->assign('page',$page);
        return view();
    }

    function get_day( $date ,$rtype = '1'){
        $tem = explode('-' , $date);    //切割日期 得到年份和月份
        $year = $tem['0'];
        $month = $tem['1'];
        if( in_array($month , array( 1 , 3 , 5 , 7 , 8 , 01 , 03 , 05 , 07 , 08 , 10 , 12))){
          // $text = $year.'年的'.$month.'月有31天';
          $text = '31';
        }elseif( $month == 2 ){
          if ( $year%400 == 0 || ($year%4 == 0 && $year%100 !== 0) )  {   //判断是否是闰年
            // $text = $year.'年的'.$month.'月有29天';
            $text = '29';
          }
          else{
            // $text = $year.'年的'.$month.'月有28天';
            $text = '28';
          }
        }
        else{
          // $text = $year.'年的'.$month.'月有30天';
          $text = '30';
        }
        if ($rtype == '2') {
          for ($i = 1; $i <= $text ; $i ++ ) {
              if($i<=9){
                  $r[] = $year."-".$month."-0".$i;
              }else{
                  $r[] = $year."-".$month."-".$i;
              }
            
          }
        } else {
          $r = $text;
        }
        return $r;
    }
    //修改排班
    public function schededit(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $map['id']=$data['id'];
            $res=Db::name('pos_scheduling')->where($map)->update($data);
            if($res){
                $reslut['status']='1';
                $reslut['msg']='操作成功';
            }else{
                $reslut['status']='0';
                $reslut['msg']='操作失败';
            }
            return json($reslut);
        }else{
            $id=input('param.id');
            $singleschedual=Db::name('pos_scheduling')->field('id,schedual_id,schedual_name')->where('id='.$id)->find();
            $allschedual=Db::name('pos_schedual')->field('id,shift_name,short,work_start_time,work_end_time')->select();
            $this->assign('data_schedual',$allschedual);
            $this ->assign('single_schedual',$singleschedual);
            return view();
        }
    }
    //搜索
    public function search1($data){

        $map = array();

        if(!empty($data['user_name'])){
            $map['u.name'] = ['like','%'.$data['user_name'].'%'];
        }
        if(!empty($data['emp_no'])){
            $map['u.emp_no'] = ['like','%'.$data['emp_no'].'%'];
        }
        return $map;
    }
    
     //搜索
    public function search2($data){
        $map = array();
        if(empty($data['time'])){
            $map['year'] = date('Y');
            $map['month'] = (int)date('m');
        }else{
            $time = strtotime($data['time']);
            $map['year'] = date('Y',$time);
            $map['month'] = (int)date('m',$time);
        }
        return $map;
    }
    

    
    //上传
    function excelUpload(){
        $path = dirname(ROOT_PATH).DS."position".DS."Uploads".DS."SchedulingXls";
        $excelres = request()->file("upfile");
        
        if(empty($excelres)){
            $res['status'] = '0';
            $res['message'] = '没有文件!';
        }else{
            $info = $excelres->validate(['size'=>5242880,'ext'=>'xls,xlsx'])->move($path);  //上传限制500kb
            chmod(dirname(ROOT_PATH).DS."position".DS."Uploads/SchedulingXls/".$info->getSaveName(),0755);
            if($info){
                $res['status'] = '1';
                $res['message'] = dirname(ROOT_PATH).DS."position".DS."Uploads/SchedulingXls/".$info->getSaveName();

            }else{
                $res['status'] = '0';
                $res['message'] = '请检查文件大小，或者文件类型';
            }
        }
        return json($res);
    }
    
     //导入排班
    public function importExcel(){
        if(Request::instance()->isAjax()){
            $data = input('param.');
            $path = $data['filepath'];//文件路径
            $date =$data['month'];   //选择月份
            $range=$data['range'];
            $res=$this ->getempes($range); //获取多选组织图下所属人员
            $schedual = $this->Schedual();//获取班次
            if(empty($date)){
                $result ['status'] = '0';
                $result ['msg'] = "请导入月份";
                return json($result);
            }
            if(!empty($path)){
                $PHPExcel = import_excel($path); //读取excel
                $sheet0 = $PHPExcel->getSheet(0);  //获取sheet0
                $allRow = $sheet0->getHighestRow(); // 取得一共有多少行
              
               $date_num=$this ->get_day($date.'-01','1');
                // $day = dateToPHP($sheet0->getCell('B' . 2)->getValue(), 'Y-m-');
                if($date_num=='31'){
                    $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM'); //31天
               }elseif($date_num=='30'){
                    $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL'); //30天
               }elseif($date_num=='29'){
                    $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK');//29天
               }elseif($date_num=='28'){
                    $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ'); //28天
               }
               $j = 0;
               $scheduling_data = array();
               $error = array();
                for ($i = 2; $i <= $allRow; $i ++) {  //行循环
                    // $import_res=$sheet0->getCell('A' . $i)->getValue();                        
                        for ($colum=0; $colum <=$date_num-1 ; $colum++) {  //列循环
                            $import_empno=$sheet0->getCell('A' . $i)->getValue(); //账号
                            $import_name=$sheet0->getCell('B' . $i)->getValue(); //姓名    
                            $import_deptname=$sheet0->getCell('C' . $i)->getValue();//部门名称
                            $import_position=$sheet0->getCell('D' . $i)->getValue();//职位
                            $year = $sheet0->getCell('E' . $i)->getValue(); //年
                            $month=$sheet0->getCell('F' . $i)->getValue();//月
                            $import_waynames=$sheet0->getCell('G' . $i)->getValue(); //打卡方式
                            $import_playdayname=$sheet0->getCell('H' . $i)->getValue();//休息日
                            $playdayid=$this ->GetplayIdBypalydayName($import_playdayname)['id']; //获取休息日id
                            if(!empty($import_empno) && !empty($import_deptname) && !empty($res[$import_empno]['dept_name'])
                                    && !empty($res[$import_empno]['position_name'])
                                    && !empty($year) && !empty($month) && !empty($import_waynames)
                                    && !empty($playdayid)){
                                if (($res[$import_empno]['dept_name'] == trim($import_deptname)) && ($res[$import_empno]['position_name'] == trim($import_position))){
                                    $map['emp_no'] = $import_empno;
                                    $map['year'] = $year;
                                    $map['month'] = $month;
                                    $map['day'] = $colum+1;
                                    $scheduling_data[$j] = Db::name('pos_scheduling')->field('id,emp_no,day')->where($map)->find();
                                    $import_schedualname = $sheet0->getCell("$remrk[$colum]" . $i)->getValue(); //导入班次名称
                                    $import_schedualname = trim($import_schedualname);
                                    if(!empty($import_schedualname)){
                                        $scheduling_data[$j]['schedual_name']=$import_schedualname;
                                        $scheduling_data[$j]['schedual_id']=$schedual[$import_schedualname];
                                    }else{
                                        $scheduling_data[$j]['schedual_id']=0;
                                        $scheduling_data[$j]['schedual_name']='';
                                    }                                    
                                    $j++;                            
                                }else{
                                    $error[$import_empno] = $import_name;
                                }
                            }else{
                                $error[$import_empno] = $import_name;
                            }
                        }  
                }
                $scheduling_m = new \app\attendanceset\model\PosScheduling();
                $resedit = $scheduling_m->update_scheduling($scheduling_data);
                if($resedit){
                    $result['status'] = 1;
                    $result['msg'] = $this->msg(1,$error);
                    return json($result);
                }else{
                    $result['status']=0;
                    $result['msg']= $this->msg(2,$error); 
                    return json($result);
                }
                
            }  
           
        }
    
    }
    /*
     * 返回结果
     */
    function msg($status,$error=array()){
        if($status==1){
            $msg = '导入完成';
            $i = 0;
            foreach ($error as $v) {
                if($i == 0){
                    $msg.=',未导入员工:'.$v.',';
                } else {
                    $msg.=$v.',';
                }
                $i++;
            }
        }
        if($status==2){
            $msg = '导入失败';
        }
        return $msg;
    }

    function GetDepts(){
        $list = Db::name('dept')->field('id,pid,name')->select();
        $data_list = array();
        foreach($list as $v){
            $data_list[$v['name']] = $v['id'];
        }
        return $data_list;
    }
    function GetWays(){
        $list = Db::name('pos_way')->field('id,name')->select();
        $data_list = array();
        foreach($list as $v){
            $data_list[$v['name']] = $v['id'];
        }
        return $data_list;
    }
    function Schedual(){
        $list = Db::name('pos_schedual')->field('id,shift_name')->select();
        $data_list = array();
        foreach($list as $v){
            $data_list[$v['shift_name']] = $v['id'];
        }
        return $data_list;
    }

    //获取公司或部门获取id
    function GetDeptIDByDeptName($dept_name){
        return Db::name('dept')->field('id,pid,name')->where(array('is_del'=>0,'name'=>$dept_name))->find();
    }

    //获取班次获取id
    function GetSchedualIDBySchedualName($schedual_name){
        return Db::name('pos_schedual')->field('id,shift_name,short')->where("shift_name='$schedual_name'")->find();
    }

    //获取班次获取id
    function GetwayIdByWayName($way_name){
        $arr=explode(',', $way_name);
        $way_ids=array();

        foreach ($arr as $key => $value) {
             $way_ids[]=Db::name('pos_way')->where("name='$value'")->value("id"); 
        }
        $ways_ids=implode(',',$way_ids);
        return $ways_ids;
    }

    //获取休息日获取id
    function GetplayIdBypalydayName($playday_name){
        return Db::name('pos_playday')->field('id,name')->where("name='$playday_name'")->find();
    } 

    //多选组织架构图下的所属人员
    function getempes($range){
        $comid_list = Db::name('dept')->field('id')->where('PID',1)->select();
            $comid_arr =array_column($comid_list,'id');//所有公司id
            $applied=explode('|',$range);

            foreach ($applied as $k => $value) {
                //公司或部门
                if (strpos("$value", "dept") !== false){
                        $temp = explode("_", $value);
                        $deptids = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$deptids");
                        $deptres=Db::name('dept')->field('id,pid,name')->where($map)->select();

                }
                if(!empty($deptres)){
                    $com_arr = array(); 
                    $dept_arr = array();
                    $com_empres=array();
                    $dept_empres=array();
                        foreach ($deptres as $ke => $vd) {

                            if($vd['pid']=='1'){   //应用范围内公司
                                $com_arr[] = $vd['id'];
                              
                            }
                             if(in_array($vd['pid'],$comid_arr)){    //判断是否为部门
                                 $dept_arr[]=$vd['id'];
                             }
                        }

                        if(!empty($com_arr)){
                            $com_empres=Db::name('user')->field('id,emp_no,name,dept_id,position_id')->where(array('is_del'=>0))->where('com_id','in',$com_arr)->select();

                        }

                        if(!empty($dept_arr)){
                            $dept_empres=Db::name('user')->field('id,emp_no,name,dept_id,position_id')->where(array('is_del'=>0))->where('dept_id','in',$dept_arr)->select();
                            // $dept_empres = array();

                        }

                }
                
                //应用范围内人员
                $sin_emp=array();
                if (strpos("$value", "emp") !== false){
                        $temp = explode("_", $value);
                        $emps = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$emps");
                        $sin_emp=Db::name('user')->field('id,emp_no,name,dept_id,position_id')->where($map)->select();
                       
                }
            }

            $data_uniemp=array();
            $data_emp=array();
            if(!empty($com_empres)){
            $data_emp=array_merge($com_empres);
            }
            // $data_emp=array_merge($com_empres,$dept_empres,$sin_emp);
            if(!empty($com_empres) && !empty($sin_emp)){
            $data_emp=array_merge($com_empres,$sin_emp);
            }
            // if(!empty($com_empres) && !empty($dept_empres)){
            // $data_emp=array_merge($com_empres,$dept_empres);
            // }
            // if(!empty($com_empres) && !empty($sin_emp)){
            // $data_emp=array_merge($com_empres,$sin_emp);
            // }
            if(!empty($sin_emp)){
            $data_emp=array_merge($sin_emp);
            }
            $data_uniemp=$this -> array_unique_fb($data_emp); //去重
            $data_arr = array();
            foreach ($data_uniemp as $v) {
                $data_arr[$v['emp_no']]['id'] = $v['id'];
                $data_arr[$v['emp_no']]['dept_id'] = $v['dept_id'];
                $data_arr[$v['emp_no']]['name'] = $v['name'];
                $data_arr[$v['emp_no']]['position_id'] = $v['position_id'];
                $data_arr[$v['emp_no']]['dept_name'] = $v['dept_name'];
                $data_arr[$v['emp_no']]['position_name'] = $v['position_name'];
            }
            return $data_arr;

    }

     //去除重复人员 (二维数组去掉重复值)
    function array_unique_fb($array2D){
        $temp=array();

        foreach ($array2D as $k=>$v){
            $v=join(',',$v); //降维
            $temp[$k]=$v;
        }
 
            $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组 
            $temp2 = array();
        foreach ($temp as $k => $v){
            $array=explode(',',$v); //再将拆开的数组重新组装
            $temp2[$k]['id'] =$array[0];
            $temp2[$k]['emp_no'] =$array[1];
            $temp2[$k]['name'] =$array[2];
            $temp2[$k]['dept_id'] =$array[3];
            $temp2[$k]['position_id'] =$array[4];
            $data_dept = Db::name('dept')->field('NAME as dept_name')->find($array[3]);
            $data_position = Db::name('position')->field('name as position_name')->find($array[4]);
            $temp2[$k]['dept_name'] = $data_dept['dept_name'];
            $temp2[$k]['position_name'] = $data_position['position_name'];
        }
            return $temp2;
    }
    /*导出排班表(考勤管理员管理公司)*/
    public function atten_manage_com(){
        $userinfo = session('user');
         if($userinfo['id'] != 1){   //非系统管理员
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
        
            if(empty($com_data)){
                $where['id']=$userinfo['com_id'];
            }else{
                $where['id'] = ['IN',$com_data['com_ids']];
            }
            $where['IS_DEL']=0;
            $com_m = Db::name("dept")->where($where)->field('*')->column("name","id");
            return json($com_m);
        }
               
    }

    function  download(){
        $type = input('param.type');
        $com_idt=input('param.com_id');
        if(empty($com_idt)){
            $com_id=session('user.com_id');
        }else{
            $com_id=$com_idt;
        }
        if($com_id == 0 ||$com_id == "0"){
            echo "请勿使用admin下载模版！";
            exit;
        }
        $rest=Db::name('dept')->where("pid",$com_id)->column("id");

        if(empty($type)){
            $month=(int)date( "m",mktime (0,0,0,date('n'),1,date('Y'))); //本月月第一天
        }else{
            $month=(int)date( "m",mktime (0,0,0,date('n')+1,1,date('Y'))); //下个月第一天
        }

        if($month==12){
            $year=date("Y")+1;
        }else{
            $year=date("Y");
        }
        $map['ps.dept_id']=array('in',$rest);
        $map['ps.year']=$year;
        $map['ps.month']=$month;
        $map['u.is_del'] = 0;
        $res=Db::name('pos_scheduling')->alias('ps')
                ->field('ps.*')
                ->join('think_user u','u.emp_no=ps.emp_no','LEFT')
                ->where($map)->select(); 

        $excelname = '排班列表'.date( "Y-m-d",mktime (0,0,0,date('n')+1,1,date('Y')));
       $data=array();
       foreach ($res as $key => $val) {
            $data[$val['emp_no']]['emp_no'] = $val['emp_no'];
            $data[$val['emp_no']]['user_name'] = $val['user_name'];
            $data[$val['emp_no']]['dept_name'] = $val['dept_name'];
            $data[$val['emp_no']]['position'] = $val['position'];
            $data[$val['emp_no']]['year'] = $year;
            $data[$val['emp_no']]['month'] = $month;
            $data[$val['emp_no']]['way_name'] = $this ->GetWayName($val['way_ids']);
            $data[$val['emp_no']]['playday_name'] =$this->GetpalydayName($val['playday_id']);
            $data[$val['emp_no']]['schedual_name'][$val['day']] = $val['schedual_name'];
            // $data[$val['emp_no']]['schedual_name'][$i]=$val['schedual_name'];
         
       }
       
       $excelname='排班列表('.$year.'-'.$month.')';
       $dao_date=$year.'-'.$month.'-01'; //导出年年月日
        if(empty($data)){
            echo "无数据导出";
            exit;
        } else {
            $this ->exportschedul($excelname,$data,$dao_date);
        }
    }
    //获取休息日获取name
    function GetpalydayName($playday_id){
        return Db::name('pos_playday')->where("id='$playday_id'")->value("name");
    } 
    //获取打卡方式名称
    private function GetWayName($way_ids){
        $arr=explode(',', $way_ids);
        $ways_ids=array();

        foreach ($arr as $key => $value) {
             $ways_ids[]=Db::name('pos_way')->where("id='$value'")->value("name"); 
        }
        $wayids=implode(',',$ways_ids);
        return $wayids;
    } 
    /**
     * 导出模板表
     */
    private function exportschedul($excelname,$arr,$dao_date){    

        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);

        $date_num=$this ->get_day($dao_date,'1');
        // dump(date( "Y-m-d",mktime (0,0,0,date('n')+1,1,date('Y'))));
        if($date_num=='31'){
            $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM'); //31天
       }elseif($date_num=='30'){
            $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL'); //30天
       }elseif($date_num=='29'){
            $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK');//29天
       }elseif($date_num=='28'){
            $remrk=array('I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ'); //28天
       }
        vendor("phpexcel_vendor.PHPExcel");
        $objPHPExcel = new \PHPExcel();   // 创建一个处理对象实例

     
        // for($i=1;$i<=$dataNum;$i++){
        //  $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':H'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        // }

        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1:H1')->getFont()->setBold(true);//加粗
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','账号'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','姓名'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','部门'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','职位'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','年'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','月'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','打卡方式'); 
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','休息日名称');
       // $ym=date( "Y/m/",mktime (0,0,0,date('n')+1,1,date('Y')));
       if(strlen($dao_date)=='10'){
            $ym=substr($dao_date,0,7).'-';
       }else{
            $ym=substr($dao_date,0,6).'-';
       }
      
        for ($i=0; $i <= $date_num-1; $i++) { 
          // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($remrk[$i].'1',$i+1);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($remrk[$i].'1',$ym.($i+1).'('.weekday(strtotime($ym.($i+1))).')');
       }
       $j=2;
        foreach ($arr as $key => $val) {
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$j,$val['emp_no']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$j,$val['user_name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$j,$val['dept_name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$j,$val['position']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$j,$val['year']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$j,$val['month']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$j,$val['way_name']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$j,$val['playday_name']);
          
           for ($i=0; $i <=$date_num-1; $i++) { 
             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($remrk[$i].$j,$val['schedual_name'][$i+1]);
            
           }
            $j++;
           // $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':H'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        
        } 
        
        ob_end_clean();
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
   

    //所在门店人员
    function userajax(){
        $com_id=input('param.com_id');
        $dept_id=input('param.dept_id');
 
        if(!empty($com_id) && $com_id!='undefined'){
            $res= Db::name('user')->field('id,emp_no,name,pic')
                ->where(array('is_del'=>0,'com_id'=>$com_id))
                ->select();
        }
        if(!empty($dept_id) && $dept_id!='undefined'){
            $res= Db::name('user')->field('id,emp_no,name,pic')
                ->where(array('is_del'=>0,'dept_id'=>$dept_id))
                ->select();
        }
 
        return json($res);
    }
    
     //弹框
    function popup(){
       $range=input('param.range');
       
       if(!empty($range)){
            $applied=explode('*',$range);
            foreach ($applied as $key => $value) {            
            //公司或部门
                if (strpos("$value", "dept") !== false){
                    if(!empty($value)){
                        $temp = explode("_", $value);
                        $deptids = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$deptids");
                        $reslut[$key]['dept']=Db::name('dept')->field('id,pid,name')->where($map)->select();                    
                    }else{
                        $reslut[$key]['dept']='dept_';
                    }
                }
                 //人员
                if (strpos("$value", "emp") !== false){
                    if(!empty($value)){
                        $temp = explode("_", $value);
                        $emps = $temp[1];
                        if(!empty($emps)){
                            $map['is_del']=0;
                            $map['id']=array('in',"$emps");
                            $reslut[$key]['emp']=Db::name('user')->field('id as emp_id,emp_no,name as emp_name')->where($map)->select(); 
                        }
                    }else{
                        $reslut[$key]['dept']='emp_';
                    }       
                } 
            }
            $this -> assign('data',json_encode($reslut,JSON_UNESCAPED_UNICODE));

        }
        
        $node = Db::name("Dept");
        $menu = array();
        $userinfo = session('user');
  
        if($userinfo['id'] !=1){
            $com_data = Db::name('pos_com')->where('emp_no',$userinfo['emp_no'])->find();
        
            if(empty($com_data)){
                $where['id']=$userinfo['com_id'];
                $where['pid']=$userinfo['com_id'];
            }else{
                $where['id'] = ['IN',$com_data['com_ids']];
                $where['pid']=['IN',$com_data['com_ids']];
            }
            $menu=Db::name('dept')->field('id,pid,name')->whereOr('pid=0')->whereOr($where)->order('sort asc') -> select();
            // $menu = $node  ->field('id,pid,name')->whereOr("id=".$userinfo['com_id'])->whereOr("pid=0")->whereOr('pid='.$userinfo['com_id'])-> order('sort asc') -> select();
        }else{
            $menu =Db::name('dept') -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') -> select();
        }
        $tree = list_to_tree($menu);

        $this ->assign('tree',$tree);
        return view();
        
    }
    
    function import(){
        //账号，姓名，部门，职位
        return view();
    }
    
}