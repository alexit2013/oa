<?php
namespace Home\Controller;
class TargetController extends HomeController {

    public function index(){
        $this ->display();
    }
    /*报表2*/
    function chart2(){
        $model=M('target_chart2');
         $excelname='车系金融基础三项指标表';
         $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
        if($_POST){
             $excelname='车系金融基础三项指标表';
             $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
            if(!empty($_POST['dept_id'])){
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where("a.dm_id={$_POST['dept_id']}")
                    ->where($where)
                    ->select();
                        $sub='基础三项指标表';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                       
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart2',$resources,600);

            }elseif (!empty($_POST['year']) && !empty($_POST['month'])) {
                $res=$model->where(array('year'=>$_POST['year'],'month'=>$_POST['month']))->where($where)->select();
                    $sub='基础三项指标表'.'('.$_POST['year'].'-'.$_POST['month'].')';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart2',$resources,600);
            }elseif (empty($_POST['dept_id'])) {
                $res=$model->field('a.*,b.NAME')       
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart2',$resources,600);
            }else{
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where(array('a.dm_id'=>$_POST['dept_id'],
                        'a.year'=>$_POST['year'],
                        'a.month'=>$_POST['month']))
                    ->where($where)
                    ->select();
                    $sub='基础三项指标表'.'('.$_POST['year'].'-'.$_POST['month'].')';
                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart2',$resources,600);
            }

        }else{
            $res=$model->field('a.*,b.NAME')
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart2',$resources,600);
        }           
        $Alldept=M('dept')->where('pid=1')->getField("id,name");
        $this -> assign('dept_list',$Alldept);
        $this -> assign('chart2list',$res);
        $this->display();
    }
   
    /*导出excel*/
    function exportExcel($excelname,$sub="说明：",$arr) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        //设置宽度
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'D')->setWidth(16);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'E')->setWidth(16);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'F')->setWidth(16);
        for($i=1;$i<=$dataNum+3;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':F'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:F2');//合并单元格
        
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A4:R4')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4','店面'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','品牌'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','车系'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4','本月放款台次'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4','本月收费（元）'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','本月ASP（元）');    
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+5),$arr[$i]['name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+5),$arr[$i]['carbrand']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+5),$arr[$i]['carseries']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+5),$arr[$i]['fktc']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+5),$arr[$i]['sf']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+5),$arr[$i]['asp']);  
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+5).':F'.($i+5))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
           
       }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
    //表1
    function chart1(){
            $model=M('target_chart1');
            $excelname='渠道指标表';    
            //search
        $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
        if(IS_POST){
            $excelname='渠道指标表';
                $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
               
                if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                    $where['a.is_del']=array('EQ',0);
                }else{
                $deptmodel=M('dept');
                $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
                $where['a.dm_id']=array('EQ',$deptsingle['pid']);
                }
             if(!empty($_POST['dept_id'])){
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where("a.dm_id={$_POST['dept_id']}")
                    ->where($where)
                    ->select();
                $xioaji=array();
                foreach ($res as $key =>$value) {
                $res[$key]['fxiaoji']=$value['fdzt']+$value['fdzd']+$value['fddh']+$value['fddk']+$value['fdwp'];
                $res[$key]['zxiaoji']=$value['zxzt']+$value['zxzd']+$value['zxdh']+$value['zxdk']+$value['zxwp'];
                $res[$key]['dxiaoji']=$value['dyzt']+$value['dyzd']+$value['dydh']+$value['dydk']+$value['dywp'];
                $res[$key]['xxiaoji']=$value['xlzt']+$value['xlzd']+$value['xldh']+$value['xldk']+$value['xlwp'];
                $res[$key]['asp']=($res[$key]['zxiaoji']/$res[$key]['fxiaoji']);
                $res[$key]['permeability']=sprintf("%.2f",($res[$key]['fxiaoji']/$res[$key]['xxiaoji']));
                } 
                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart1',$resources,600);

            }elseif (!empty($_POST['year']) && !empty($_POST['month'])) {
                $res=$model->where(array('year'=>$_POST['year'],'month'=>$_POST['month']))->$where($where)->select();
                $xioaji=array();
                foreach ($res as $key =>$value) {
                $res[$key]['fxiaoji']=$value['fdzt']+$value['fdzd']+$value['fddh']+$value['fddk']+$value['fdwp'];
                $res[$key]['zxiaoji']=$value['zxzt']+$value['zxzd']+$value['zxdh']+$value['zxdk']+$value['zxwp'];
                $res[$key]['dxiaoji']=$value['dyzt']+$value['dyzd']+$value['dydh']+$value['dydk']+$value['dywp'];
                $res[$key]['xxiaoji']=$value['xlzt']+$value['xlzd']+$value['xldh']+$value['xldk']+$value['xlwp'];
                $res[$key]['asp']=($res[$key]['zxiaoji']/$res[$key]['fxiaoji']);
                $res[$key]['permeability']=sprintf("%.2f",($res[$key]['fxiaoji']/$res[$key]['xxiaoji']));
                } 
                $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart1',$resources,600);
            }elseif (empty($_POST['dept_id'])) {
                $res=$model->field('a.*,b.NAME')
                        ->alias('a')
                        ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                        ->where($where)
                        ->select();
                $xioaji=array();
                foreach ($res as $key =>$value) {
                $res[$key]['fxiaoji']=$value['fdzt']+$value['fdzd']+$value['fddh']+$value['fddk']+$value['fdwp'];
                $res[$key]['zxiaoji']=$value['zxzt']+$value['zxzd']+$value['zxdh']+$value['zxdk']+$value['zxwp'];
                $res[$key]['dxiaoji']=$value['dyzt']+$value['dyzd']+$value['dydh']+$value['dydk']+$value['dywp'];
                $res[$key]['xxiaoji']=$value['xlzt']+$value['xlzd']+$value['xldh']+$value['xldk']+$value['xlwp'];
                $res[$key]['asp']=($res[$key]['zxiaoji']/$res[$key]['fxiaoji']);
                $res[$key]['permeability']=sprintf("%.2f",($res[$key]['fxiaoji']/$res[$key]['xxiaoji']));
                } 
                $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart1',$resources,600);
            }else{
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where(array('a.dm_id'=>$_POST['dept_id'],
                        'a.year'=>$_POST['year'],
                        'a.month'=>$_POST['month']))
                    ->where($where)
                    ->select();
                $xioaji=array();
                foreach ($res as $key =>$value) {
                $res[$key]['fxiaoji']=$value['fdzt']+$value['fdzd']+$value['fddh']+$value['fddk']+$value['fdwp'];
                $res[$key]['zxiaoji']=$value['zxzt']+$value['zxzd']+$value['zxdh']+$value['zxdk']+$value['zxwp'];
                $res[$key]['dxiaoji']=$value['dyzt']+$value['dyzd']+$value['dydh']+$value['dydk']+$value['dywp'];
                $res[$key]['xxiaoji']=$value['xlzt']+$value['xlzd']+$value['xldh']+$value['xldk']+$value['xlwp'];
                $res[$key]['asp']=($res[$key]['zxiaoji']/$res[$key]['fxiaoji']);
                $res[$key]['permeability']=sprintf("%.2f",($res[$key]['fxiaoji']/$res[$key]['xxiaoji']));
                } 
                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart1',$resources,600);
            }
            //search
        }else{  

            
                
                $res=$model->field('a.*,b.NAME')
                        ->alias('a')
                        ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                        ->where($where)
                        ->select();
                $xioaji=array();
                foreach ($res as $key =>$value) {
                $res[$key]['fxiaoji']=$value['fdzt']+$value['fdzd']+$value['fddh']+$value['fddk']+$value['fdwp'];
                $res[$key]['zxiaoji']=$value['zxzt']+$value['zxzd']+$value['zxdh']+$value['zxdk']+$value['zxwp'];
                $res[$key]['dxiaoji']=$value['dyzt']+$value['dyzd']+$value['dydh']+$value['dydk']+$value['dywp'];
                $res[$key]['xxiaoji']=$value['xlzt']+$value['xlzd']+$value['xldh']+$value['xldk']+$value['xlwp'];
                $res[$key]['asp']=($res[$key]['zxiaoji']/$res[$key]['fxiaoji']);
                $res[$key]['permeability']=sprintf("%.4f",($res[$key]['fxiaoji']/$res[$key]['xxiaoji']));
                
                } 
                $arr=array();
                $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart1',$resources,600);
               
            }

            $Alldept=M('dept')->where('pid=1')->getField("id,name");
            $this -> assign('dept_list',$Alldept);
            $this -> assign('chart1list',$res);
            $this->display();
    }
    /*导出excel*/
    function exportExcel1($excelname="表1",$sub="说明：",$arr) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        //设置宽度
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(20);
        // $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'E')->setWidth(16);
        // $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'F')->setWidth(16);
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:AK1');
        $objPHPExcel->getActiveSheet(0)->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet(0)->mergeCells('H2:M2');
        $objPHPExcel->getActiveSheet(0)->mergeCells('N2:S2');
        $objPHPExcel->getActiveSheet(0)->mergeCells('T2:Y2');
        $objPHPExcel->getActiveSheet(0)->mergeCells('Z2:AE2');
        $objPHPExcel->getActiveSheet(0)->mergeCells('AF2:AK2');
        for($i=1;$i<=$dataNum+3;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':AK'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','店名'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','本月放款数量(台)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2','本月实际ASP(元)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2','本月咨询服务费(元)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2','本月实际渗透率(%)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z2','本月落户抵押费(元)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF2','本月销量(台)');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'B3:AK3')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','展厅'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','自店二网'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','电话'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','大客'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','外批'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3','小计');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3','展厅'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3','自店二网'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3','电话'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3','大客'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3','外批'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3','平均ASP'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3','展厅'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3','自店二网'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3','电话'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3','大客'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3','外批'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3','小计'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3','展厅'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3','自店二网'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3','电话'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W3','大客'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X3','外批'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y3','综合渗透率'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z3','展厅'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA3','自店二网'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB3','电话'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC3','大客'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD3','外批'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE3','小计'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF3','展厅'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG3','自店二网'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH3','电话'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI3','大客'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ3','外批'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK3','小计'); 
 
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),$arr[$i]['name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+4),$arr[$i]['fdzt']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+4),$arr[$i]['fdzd']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['fddh']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['fddk']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+4),$arr[$i]['fdwp']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+4),$arr[$i]['fxiaoji']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+4),$arr[$i]['aspzt']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+4),$arr[$i]['aspzd']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+4), $arr[$i]['aspdh']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+4),$arr[$i]['aspdk']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+4),$arr[$i]['aspwp']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+4),$arr[$i]['asp']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+4),$arr[$i]['zxzt']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+4),$arr[$i]['zxzd']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+4),$arr[$i]['zxdh']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($i+4),$arr[$i]['zxdk']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($i+4),$arr[$i]['zxwp']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($i+4),$arr[$i]['zxiaoji']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($i+4), $arr[$i]['stzt']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.($i+4),$arr[$i]['stzd']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($i+4),$arr[$i]['stdh']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.($i+4),$arr[$i]['stdk']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($i+4),$arr[$i]['stwp']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.($i+4),$arr[$i]['permeability']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.($i+4),$arr[$i]['dyzt']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.($i+4),$arr[$i]['dyzd']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.($i+4),$arr[$i]['dydh']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.($i+4),$arr[$i]['dydk']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.($i+4), $arr[$i]['dywp']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.($i+4),$arr[$i]['dxiaoji']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.($i+4),$arr[$i]['xlzt']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.($i+4),$arr[$i]['xlzd']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.($i+4),$arr[$i]['xldh']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.($i+4), $arr[$i]['xldk']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.($i+4), $arr[$i]['xlwp']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.($i+4), $arr[$i]['xxiaoji']);
            // $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+4).':J'.($i+4))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
           
       }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
    //表3
    function chart3(){
        $model=M('target_chart3');
        $excelname='车系渗透率指标表';
        $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
        if($_POST){
             $excelname='车系渗透率指标表';
             $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
            if(!empty($_POST['dept_id'])){
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where("a.dm_id={$_POST['dept_id']}")
                    ->where($where)
                    ->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                       
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart3',$resources,600);

            }elseif (!empty($_POST['year']) && !empty($_POST['month'])) {
                $res=$model->where(array('year'=>$_POST['year'],'month'=>$_POST['month']))->where($where)->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart3',$resources,600);
            }elseif (empty($_POST['dept_id'])) {
                $res=$model->field('a.*,b.NAME')       
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart3',$resources,600);
            }else{
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where(array('a.dm_id'=>$_POST['dept_id'],
                        'a.year'=>$_POST['year'],
                        'a.month'=>$_POST['month']))
                    ->where($where)
                    ->select();
                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart3',$resources,600);
            }

        }else{
            $excelname='车系渗透率指标表';
             $Alldept=M('dept')->where('pid=1')->getField("id,name");
            $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where($where)
                    ->select();
                    $user=get_emp_no();
                            $arr['title']=$excelname;
                            $arr['list']=$res;
                            $resources=json_encode($arr);
                        tp_redis("$user".'chart3',$resources,600);
        }
        $this -> assign('dept_list',$Alldept);
        $this -> assign('chart3list',$res);
        $this->display();
    }
    //表3导出
    function exportExcel3($excelname,$sub="",$arr) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        for($i=1;$i<=$dataNum+3;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':F'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:F2');//合并单元格
        
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A4:R4')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3','店面'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','品牌'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','车系'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','本月渗透率'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','上月渗透率'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','环比'); 
 
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),$arr[$i]['name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+4),$arr[$i]['carbrand']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+4),$arr[$i]['carseries']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['byst']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['syst']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+4),$arr[$i]['hb']);  
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+4).':F'.($i+4))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
           
       }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
         //表4
    function chart4(){
        $model=M('target_chart4');
        $excelname='车系ASP指标表';
        $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
        if($_POST){
             $excelname='车系ASP指标表';
             $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
            if(!empty($_POST['dept_id'])){
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where("a.dm_id={$_POST['dept_id']}")
                    ->where($where)
                    ->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                       
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart4',$resources,600);

            }elseif (!empty($_POST['year']) && !empty($_POST['month'])) {
                $res=$model->where(array('year'=>$_POST['year'],'month'=>$_POST['month']))->where($where)->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart4',$resources,600);
            }elseif (empty($_POST['dept_id'])) {
                $res=$model->field('a.*,b.NAME')       
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart4',$resources,600);
            }else{

                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where(array('a.dm_id'=>$_POST['dept_id'],
                        'a.year'=>$_POST['year'],
                        'a.month'=>$_POST['month']))
                    ->where($where)
                    ->select();

                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart4',$resources,600);
            }

        }else{
         $Alldept=M('dept')->where('pid=1')->getField("id,name");
        $res=$model->field('a.*,b.NAME')
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart4',$resources,600);
        $this -> assign('dept_list',$Alldept);
        }
        $this -> assign('chart4list',$res);
        $this->display();
        
    }
    //表4
    function exportExcel4($excelname="表4",$sub="说明：",$arr=array('ad','sd')) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(24);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(26);
        for($i=1;$i<=$dataNum+3;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':F'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:F2');//合并单元格
        
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A4:R4')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3','店面'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','品牌'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','车系'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','本月ASP'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','上月ASP'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','环比'); 
//        Miscellaneous glyphs, UTF-8  4
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),$arr[$i]['name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+4),$arr[$i]['carbrand']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+4),$arr[$i]['carseries']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['byasp']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['syasp']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+4),$arr[$i]['hb']);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+4).':F'.($i+4))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
           
       }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
        
    }
          //表5sum(a.bytc),sum(a.sytc)
    function chart5(){
        $model=M('target_chart5');
        $excelname="车系台次指标表";
        $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            $map['dm_id']=array('EQ',$deptsingle['pid']);
            }
        if($_POST){
            $excelname='车系台次指标表';
            $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            }
            if(!empty($_POST['dept_id'])){
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where("a.dm_id={$_POST['dept_id']}")
                    ->where($where)
                    ->select();
                $totc=$model->field('sum(bytc) as bytot,sum(sytc) as sytot')
                    ->where("dm_id={$_POST['dept_id']}")
                    ->where($map)
                    ->find();
                 $res[]['tot']=$totc;
                        $sub='车系台次指标表';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                       
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);

            }elseif (!empty($_POST['year']) && !empty($_POST['month'])) {
                $res=$model->where(array('year'=>$_POST['year'],'month'=>$_POST['month']))->where($where)->select();
                $totc=$model->field('sum(bytc) as bytot,sum(sytc) as sytot')
                    ->where(array(
                        'year'=>$_POST['year'],
                        'month'=>$_POST['month']))
                    ->where($map)
                    ->find();
                 $res[]['tot']=$totc;
                    $sub='车系台次指标表'.'('.$_POST['year'].'-'.$_POST['month'].')';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
            }elseif (empty($_POST['dept_id'])) {
                $res=$model->field('a.*,b.NAME')       
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                $totc=$model->field('sum(bytc) as bytot,sum(sytc) as sytot')
                    ->$where($map)
                    ->find();
                 $res[]['tot']=$totc;
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
            }else{
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where(array('a.dm_id'=>$_POST['dept_id'],
                        'a.year'=>$_POST['year'],
                        'a.month'=>$_POST['month']))
                    ->where($where)
                    ->select();
                 $totc=$model->field('sum(bytc) as bytot,sum(sytc) as sytot')
                    ->where(array('dm_id'=>$_POST['dept_id'],
                        'year'=>$_POST['year'],
                        'month'=>$_POST['month']))
                    ->$where($map)
                    ->find();
                 $res[]['tot']=$totc;
                    $sub='车系台次指标表'.'('.$_POST['year'].'-'.$_POST['month'].')';
                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
            }

        }else{
        $res=$model->field('a.*,b.name')
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
        $totc=$model->field('sum(bytc) as bytot,sum(sytc) as sytot')->where($map)->find();
        $res[]['tot']=$totc;
                $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $arr['totc']=$totc;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
        }
        // $this ->exportExcel5('表5','xxxx',$res);
        $Alldept=M('dept')->where('pid=1')->getField("id,name");
        $this -> assign('dept_list',$Alldept);
        $this -> assign('chart5list',$res);
        $this->display();
    }
    /*导出表5*/
    function exportExcel5($excelname,$sub="",$arr) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(24);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(26);

        for($i=1;$i<=$dataNum+3;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':F'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:F2');//合并单元格
        // $objPHPExcel->getActiveSheet(0)->mergeCells('A8:C2');//合并单元格

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:F1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A4:R4')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3','店面'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','品牌'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','车系'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','本月台次'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','上月台次'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','环比'); 
//        Miscellaneous glyphs, UTF-8   
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),$arr[$i]['name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+4),$arr[$i]['carbrand']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+4),$arr[$i]['carseries']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['bytc']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['sytc']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+4),$arr[$i]['hb']);
           if($i==$dataNum-1){
            $objPHPExcel->getActiveSheet(0)->mergeCells('A'.($i+4).':C'.($i+4));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),'合计'); 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['tot']['bytot']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['tot']['sytot']);
           } 
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+4).':F'.($i+4))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
           
       }  
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','环比'); 
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }

    function chart6(){
        $model=M('target_chart6');
        $excelname="车系收费指标表";
            $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            $map['dm_id']=array('EQ',$deptsingle['pid']);
            }
        if($_POST){
            $excelname='车系台次指标表';
            $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
            if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                $where['a.is_del']=array('EQ',0);
            }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dm_id']=array('EQ',$deptsingle['pid']);
            $map['dm_id']=array('EQ',$deptsingle['pid']);
            }
            if(!empty($_POST['dept_id'])){
                $res=$model->field('a.*,b.NAME')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where("a.dm_id={$_POST['dept_id']}")
                    ->where($where)
                    ->select();
                $totf=$model->field('sum(bysf) as bycost,sum(sysf) as sycost')
                    ->where("dm_id={$_POST['dept_id']}")
                    ->where($map)
                    ->find();
                $res[]['tot']=$totf; 
                        $sub='车系台次指标表';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                       
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);

            }elseif (!empty($_POST['year']) && !empty($_POST['month'])) {
                $res=$model->where(array('year'=>$_POST['year'],'month'=>$_POST['month']))->where($where)->select();
                $totf=$model->field('sum(bysf) as bycost,sum(sysf) as sycost')->where(array(
                    'year'=>$_POST['year'],
                    'month'=>$_POST['month']))
                    ->where($map)
                    ->find();
                $res[]['tot']=$totf; 
                    $sub='车系台次指标表'.'('.$_POST['year'].'-'.$_POST['month'].')';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
            }elseif (empty($_POST['dept_id'])) {
                $res=$model->field('a.*,b.NAME')       
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();
                 $totf=$model->field('sum(bysf) as bycost,sum(sysf) as sycost')
                            ->where($map)
                            ->find();
                $res[]['tot']=$totf;
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
            }else{
                $res=$model->field('a.*,b.NAME,sum(bytc) as bytot,sum(sytc) as sytot')
                    ->alias('a')
                    ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                    ->where(array('a.dm_id'=>$_POST['dept_id'],
                        'a.year'=>$_POST['year'],
                        'a.month'=>$_POST['month']))
                    ->where($where)
                    ->select();
                    $totf=$model->field('sum(bysf) as bycost,sum(sysf) as sycost')->where(array('dm_id'=>$_POST['dept_id'],
                        'year'=>$_POST['year'],
                        'month'=>$_POST['month']))
                    ->where($map)
                    ->find();
                $res[]['tot']=$totf;
                    $sub='车系台次指标表'.'('.$_POST['year'].'-'.$_POST['month'].')';
                    $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$res;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart5',$resources,600);
            }
        }else{
        
        $res=$model->field('a.*,b.name')
                ->alias('a')
                ->join('LEFT JOIN think_dept as b ON a.dm_id=b.id')
                ->where($where)
                ->select();

        $totf=$model->field('sum(bysf) as bycost,sum(sysf) as sycost')->where($map)->find();
             $res[]['tot']=$totf;
             $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['list']=$res;
                        $arr['totc']=$totc;
                        $resources=json_encode($arr);
                        tp_redis("$user".'chart6',$resources,600);
        }     
        // $this ->exportExcel('表2','xxxx',$res);
         $Alldept=M('dept')->where('pid=1')->getField("id,name");
        $this -> assign('dept_list',$Alldept);
        $this -> assign('chart6list',$res);
        $this->display();
    }
    /*导出表6*/
    function exportExcel6($excelname,$sub="",$arr) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        for($i=1;$i<=$dataNum+3;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':F'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:F2');//合并单元格
        // $objPHPExcel->getActiveSheet(0)->mergeCells('A8:C2');//合并单元格

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A4:F4')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3','店面'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','品牌'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','车系'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','本月收费'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','上月收费'); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','环比'); 
//        Miscellaneous glyphs, UTF-8   
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),$arr[$i]['name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+4),$arr[$i]['carbrand']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+4),$arr[$i]['carseries']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['bysf']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['sysf']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+4),$arr[$i]['hb']);  
           if($i==$dataNum-1){
            $objPHPExcel->getActiveSheet(0)->mergeCells('A'.($i+4).':C'.($i+4));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+4),'合计'); 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+4),$arr[$i]['tot']['bycost']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+4),$arr[$i]['tot']['bycost']);
           } 

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+4).':F'.($i+4))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
//            
       }
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','环比'); 
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }
     //条件导出
    public function Chartexcel(){

        switch ($_GET['import']) {
            case 'a':
                    $user=get_emp_no();
                    $blog=tp_redis("$user".'chart1');
                    $arr=json_decode($blog,true);
                    $this ->exportExcel1($arr['title'],$arr['sub'],$arr['list']);
                break;
            case 'b':
                    $user=get_emp_no();
                    $blog=tp_redis("$user".'chart2');
                    $arr=json_decode($blog,true);
                    $this ->exportExcel($arr['title'],$arr['sub'],$arr['list']);
                break;
            case 'c':
                    $user=get_emp_no();
                    $blog=tp_redis("$user".'chart3');
                    $arr=json_decode($blog,true);
                    $this ->exportExcel3($arr['title'],$arr['sub'],$arr['list']);
                break;
            case 'd':
                    $user=get_emp_no();
                    $blog=tp_redis("$user".'chart4');
                    $arr=json_decode($blog,true);
                    $this ->exportExcel4($arr['title'],$arr['sub'],$arr['list']);
                break;
            case 'e':
                    $user=get_emp_no();
                    $blog=tp_redis("$user".'chart5');
                    $arr=json_decode($blog,true);
                    $this ->exportExcel5($arr['title'],$arr['sub'],$arr['list']);
                break;
            case 'f':
                    $user=get_emp_no();
                    $blog=tp_redis("$user".'chart6');
                    $arr=json_decode($blog,true);
                    $this ->exportExcel6($arr['title'],$arr['sub'],$arr['list']);
                break;  
        }
        
    }
}