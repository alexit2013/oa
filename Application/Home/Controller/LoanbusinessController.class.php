<?php  
namespace Home\Controller;

class LoanbusinessController extends HomeController {
    public function index(){
        $model=D('Loanbusiness');
        if(IS_POST){
            $loancar_time_start=strtotime($_POST['loan_start']);
            $loancar_time_end=strtotime($_POST['loan_end']);
            $zx_time_start=strtotime($_POST['zx_end']);
            $zx_time_end=strtotime($_POST['zx_start']);
            $excelname='车贷业务进度表';
            if(!empty($loancar_time_start) && !empty($loancar_time_end)){
                 $list=$model->Searchloan($loancar_time_start,$loancar_time_end);
                        $this->assign('dao','导出');
                        $sub='车贷申请日期'.'('.$_POST['loan_start'].'-'.$_POST['loan_end'].')';
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$list;
                        $resources=json_encode($arr);
                        tp_redis("$user".'车贷业务进度表',$resources,600);
                    
            }
            if(!empty($zx_time_start) && !empty($zx_time_end)){
                $list=$model->Searchzx($zx_time_start,$zx_time_end);
                     $this->assign('dao','导出');
                        $sub='咨询服务分交款日期'.'('.$_POST['zx_end'].'-'.$_POST['zx_start'].')';
                        // $this ->exportExcel($excelname,$sub,$list);
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$list;
                        $resources=json_encode($arr);
                        tp_redis("$user".'车贷业务进度表',$resources,600);
            }
            if(!empty($loancar_time_start) && !empty($loancar_time_end) && !empty($zx_time_start) && !empty($zx_time_end)){
                $list=$model->lzboth($loancar_time_start,$loancar_time_end,$zx_time_start,$zx_time_end);
                     $this->assign('dao','导出');
                        $sub='车贷申请和咨询服务分交款日期'.'('.$_POST['zx_end'].'-'.$_POST['zx_start'].'|'.$_POST['loan_start'].'-'.$_POST['loan_end'].')';
                        // $this ->exportExcel($excelname,$sub,$list);
                        $user=get_emp_no();
                        $arr['title']=$excelname;
                        $arr['sub']=$sub;
                        $arr['list']=$list;
                        $resources=json_encode($arr);
                        tp_redis("$user".'车贷业务进度表',$resources,600);
            }
        }else{
           $list = $this->loanlist();
        }
        $delres=M('role_user')->alias('a')->join('LEFT JOIN think_role as b ON a.role_id=b.id')
        ->where("a.user_id={$_SESSION['auth_id']}")
        ->getField('id,name');
        $str=implode(',',$delres);
            if (strpos($str ,'金融') != false ){
            $is_finace='金融';
            }
        $this->assign('is_finace',$is_finace);      				
        $this ->assign('list',$list);
        $this ->display();
    }
    //条件导出
    public function laonexcel(){
        if($_GET['import']=='e'){
            $user=get_emp_no();
            $blog=tp_redis("$user".'车贷业务进度表');
            $arr=json_decode($blog,true);
            $this ->exportExcel($arr['title'],$arr['sub'],$arr['list']);
        }

    }
    public function add(){
        $model=D('Loanbusiness');
        $Alldept=$model->Alldept();
        $Allchannel=$model->Allchannel();
        $Alllibrary=$model->Alllibrary();
        $Allcompany=$model->Allcompany();
        $Allcarbrand=$model->Allcarbrand();
        $Allcarseries=$model->Allcarseries();
        $Allcarsize=$model->Allcarsize();
        $this -> assign('list',array(
            'Alldept'=>$Alldept,
            'Allchannel'=>$Allchannel,
            'Alllibrary'=>$Alllibrary,
            'Allcompany'=>$Allcompany,
            'Allcarbrand'=>$Allcarbrand,
            'Allcarseries'=>$Allcarseries,
            'Allcarsize'=>$Allcarsize
            ));
        
        $this ->display();
    }
    //品牌找车系
    public function Singlebrand($brand_id){
        $model=M('target_carseries');
        $res=$model-> table('think_target_carseries')
            ->where(array('carbrand_id'=>$brand_id,'is_del'=>0))
            ->select();
        if(!empty($res)){
            $msg['status']=1;
            $msg['info']=$res;
        }
       $this->ajaxReturn($msg);
    }

     //车系找车型
    public function Cartype($cartype_id){
        $model=M('target_carsize');
        $res=$model-> table('think_target_carsize')
            ->where(array('carseries_id'=>$cartype_id,'is_del'=>0))
            ->select();
        if(!empty($res)){
            $msg['status']=1;
            $msg['info']=$res;
        }
       $this->ajaxReturn($msg);
    }

    public function _insert(){
        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('Loanbusiness');
            $data['dept_id']=$_POST['dept_name'];
            $data['customer']=$_POST['customer'];
            $data['channel_id']=$_POST['channel_id'];
            $data['library_id']=$_POST['library_id'];
            $data['mortgage_status']=$_POST['mortgage'];
            $data['zxservice_cost']=$_POST['zxservice_cost'];
            $data['zxcost_time']=strtotime($_POST['zxcost_time']);
            $data['collateral']=$_POST['collateral'];
            $data['collateral_time']=strtotime($_POST['collateral_time']);
            $data['settle_mortgage_cost']=$_POST['settle_mortgage_cost'];
            $data['settle_mortgage_time']=strtotime($_POST['settle_mortgage_time']);
            $data['car_loan_time']=strtotime($_POST['car_loan_time']);
            $data['sales_user']=$_POST['sales_user'];
            $data['finance_service_manager']=$_POST['finance_service_manager'];
            $data['finance_company_id']=$_POST['finance_company_id'];
            $data['carbrand_id']=$_POST['carbrand_name'];
            $data['carseries_id']=$_POST['carseries_name'];
            $data['carsize_id']=$_POST['carsize_name'];
            $data['car_money']=$_POST['car_money'];
            $data['loan_money']=$_POST['loan_money'];
            $data['deadline']=$_POST['deadline'];
            $data['permit_loan_money']=$_POST['permit_loan_money'];
            $data['loan_product_name']=$_POST['loan_product_name'];
            $data['customer_telephone']=$_POST['customer_telephone'];
            $data['customer_telephone1']=$_POST['customer_telephone1'];
            $data['customer_telephone2']=$_POST['customer_telephone2'];
            $data['frame_number']=$_POST['frame_number'];
            $data['entry_time']=strtotime($_POST['entry_time']);
            $data['remark']=$_POST['remark'];
            $data['add_time']=time();
            if (false === $model -> create($data)) {
                $this -> error($model -> getError());
            }
            if ($opmode == "add") {
                $list = $model -> add();
                if ($list !== false) {//保存成功
                    $this -> assign('jumpUrl',get_return_url());
                    $this -> success('新增成功!');
                } else {
                    $this -> error('新增失败!');
                    //失败提示
                }
            }
        }
    }

    public  function edit($id){
        $model=D('Loanbusiness');
        $Onlyloan=$model->Singleloan($id);
        $seris_import=$model->Single_improt($Onlyloan['carseries_id']);
        $Alldept=$model->Alldept();
        $Allchannel=$model->Allchannel();
        $Alllibrary=$model->Alllibrary();
        $Allcompany=$model->Allcompany();
        $Allcarbrand=$model->Allcarbrand();
        $Allcarseries=$model->Allcarseries();
        $Allcarsize=$model->Allcarsize();
        $this -> assign('list',array(
            'Alldept'=>$Alldept,
            'Allchannel'=>$Allchannel,
            'Alllibrary'=>$Alllibrary,
            'Allcompany'=>$Allcompany,
            'Allcarbrand'=>$Allcarbrand,
            'Allcarseries'=>$Allcarseries,
            'Allcarsize'=>$Allcarsize,
            'Onlyloan'=>$Onlyloan,
            'seris_import'=>$seris_import
            ));
        $this->display();
    }

    public function _update(){
        $model=D('Loanbusiness');
            $data['id']=$_POST['loan_id'];
            $data['dept_id']=$_POST['dept_name'];
            $data['customer']=$_POST['customer'];
            $data['channel_id']=$_POST['channel_id'];
            $data['library_id']=$_POST['library_id'];
            $data['mortgage_status']=$_POST['mortgage'];
            $data['zxservice_cost']=$_POST['zxservice_cost'];
            $data['zxcost_time']=strtotime($_POST['zxcost_time']);
            $data['collateral']=$_POST['collateral'];
            $data['collateral_time']=strtotime($_POST['collateral_time']);
            $data['settle_mortgage_cost']=$_POST['settle_mortgage_cost'];
            $data['settle_mortgage_time']=strtotime($_POST['settle_mortgage_time']);
            $data['car_loan_time']=strtotime($_POST['car_loan_time']);
            $data['sales_user']=$_POST['sales_user'];
            $data['finance_service_manager']=$_POST['finance_service_manager'];
            $data['finance_company_id']=$_POST['finance_company_id'];
            $data['carbrand_id']=$_POST['carbrand_name'];
            $data['carseries_id']=$_POST['carseries_name'];
            $data['carsize_id']=$_POST['carsize_name'];
            $data['car_money']=$_POST['car_money'];
            $data['loan_money']=$_POST['loan_money'];
            $data['deadline']=$_POST['deadline'];
            $data['permit_loan_money']=$_POST['permit_loan_money'];
            $data['loan_product_name']=$_POST['loan_product_name'];
            $data['customer_telephone']=$_POST['customer_telephone'];
            $data['customer_telephone1']=$_POST['customer_telephone1'];
            $data['customer_telephone2']=$_POST['customer_telephone2'];
            $data['frame_number']=$_POST['frame_number'];
            $data['entry_time']=strtotime($_POST['entry_time']);
            $data['remark']=$_POST['remark'];
            $data['add_time']=time();
            if (false === $model -> create($data)) {
                $this -> error($model -> getError());
            }
           
            $list = $model -> save();
            if (false != $list) {
                $this -> assign('jumpUrl', get_return_url());
                $this -> success('编辑成功!');
                //成功提示
            } else {
                $this -> error('编辑失败!');
                //错误提示
            }
    }

    public function loandel(){
        $model=D('Loanbusiness');
        $ids=$_POST['id'];
        $idx=implode(',',$ids);
        $list = $model-> delete("$idx");
        if (false !== $list) {
            $this -> assign('jumpUrl', get_return_url());
            $this -> success('编辑成功!');
            //成功提示
        } else {
            $this -> error('编辑失败!');
            //错误提示
        }
    }
    /*导出excel*/
    public function exportExcel($excelname="表2",$sub="说明：",$arr) {
        $xlsTitle = iconv('utf-8', 'gb2312', $excelname);//文件名称
        $dataNum = count($arr);
        vendor("Excel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        //设置宽度
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'D')->setWidth(16);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'E')->setWidth(16);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension( 'F')->setWidth(16);
        for($i=1;$i<=$dataNum+4;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i).':AA'.($i))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:AA1');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:AA2');//合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A3:AA3');//合并单元格

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:J1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$excelname); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',$sub); 
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A1')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->getStyle( 'A4:AA4')->getFont()->setBold(true);//加粗
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4','店面'); //dept_id
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','客户名称'); //customer
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','渠道'); //channel_id
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4','放款及咨询服务费状态');// library_id
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4','抵押状态'); //mortgage_status
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','咨询服务费（元）'); //zxservice_cost
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','咨询服务费交款日期'); //zxcost_time
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4','续保保证金（元）'); //collateral
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4','续保保证金缴费日期（元）'); //collateral_time
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4','落户抵押费（元）'); //csettle_mortgage_cost
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4','落户抵押费缴费日期'); //settle_mortgage_time
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','销售顾问'); //sales_user
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4','金融服务经理');// finance_service_manager
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4','金融公司/渠道'); //finance_company_id
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4','品牌'); //
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4','车系'); //
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4','车型'); //
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4','车价（元）'); //car_money
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4','贷款金额（元）'); //loan_money
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4','车贷申请日期'); //car_loan_time
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4','期限（月）'); //deadline
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V4','准贷金额（元）'); //permit_loan_money
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W4','贷款产品名称'); //loan_product_name
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X4','客户联系电话'); //customer_telephone
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y4','车架号'); //frame_number
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z4','备注'); //
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA4','录入时间');//
       for($i=0;$i<$dataNum;$i++){
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i+5),$arr[$i]['dept_name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i+5),$arr[$i]['customer']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i+5),$arr[$i]['channel_name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i+5),$arr[$i]['library_title']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i+5),$this->skkt($arr[$i]['mortgage_status'])); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i+5),$arr[$i]['zxservice_cost']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+5),date("Y-m-d",$arr[$i]['zxcost_time']));  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i+5),$arr[$i]['collateral']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i+5),date("Y-m-d",$arr[$i]['collateral_time']));
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i+5),$arr[$i]['settle_mortgage_cost']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i+5),date("Y-m-d",$arr[$i]['settle_mortgage_time']));
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i+5),$arr[$i]['sales_user']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($i+5),$arr[$i]['finance_service_manager']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($i+5),$arr[$i]['company_name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i+5),$arr[$i]['carbrand_name']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($i+5),$arr[$i]['carseries_name']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($i+5),$arr[$i]['carsize_name']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($i+5),$arr[$i]['car_money']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($i+5),$arr[$i]['loan_money']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($i+5),date("Y-m-d",$arr[$i]['car_loan_time']));
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.($i+5),$arr[$i]['deadline']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($i+5),$arr[$i]['permit_loan_money']); 
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.($i+5),$arr[$i]['loan_product_name']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($i+5),$arr[$i]['customer_telephone']);  
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.($i+5),$arr[$i]['frame_number']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.($i+5),$arr[$i]['remark']);
           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.($i+5),date("Y-m-d",$arr[$i]['entry_time']));
            // $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.($i+5).':J'.($i+5))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
           
       }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$excelname.'.xls"');
        header("Content-Disposition:attachment;filename=$xlsTitle.xls");//attachment新窗口打印inline本窗口打印
        $objWriter =  \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save('php://output'); 
    }

    function skkt($num){
        if($num=='0'){
            return '未抵押';
        }else{
            return '已抵押';
        }
    }
    /*
     * 查看单据详情
     */
    function read() {
        $id = I('id');
        $model=D('Loanbusiness');
        $Onlyloan=$model->Singleloan($id);
        $seris_import=$model->Single_improt($Onlyloan['carseries_id']);
        $Alldept=$model->Alldept();
        $Allchannel=$model->Allchannel();
        $Alllibrary=$model->Alllibrary();
        $Allcompany=$model->Allcompany();
        $Allcarbrand=$model->Allcarbrand();
        $Allcarseries=$model->Allcarseries();
        $Allcarsize=$model->Allcarsize();
        $this -> assign('list',array(
            'Alldept'=>$Alldept,
            'Allchannel'=>$Allchannel,
            'Alllibrary'=>$Alllibrary,
            'Allcompany'=>$Allcompany,
            'Allcarbrand'=>$Allcarbrand,
            'Allcarseries'=>$Allcarseries,
            'Allcarsize'=>$Allcarsize,
            'Onlyloan'=>$Onlyloan,
            'seris_import'=>$seris_import
            ));
        $this->display();
    }
    private function loanlist() {
             $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
        if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
            $where['a.is_del']=array('EQ',0);
            $map['is_del']=array('EQ',0);
        }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.is_del']=array('EQ',0);
            $where['a.dept_id']=array('EQ',$deptsingle['pid']);
            $map['is_del']=array('EQ',0);
            $map['dept_id']=array('EQ',$deptsingle['pid']);
        }
        $count = M('target_loanbusiness')->where($map)->count();
        $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show = $Page->show();// 分页显示输出
        $list = M('target_loanbusiness')->alias('a')
                ->field('a.*,b.NAME as dept_name,c.channel_name,d.library_title,e.company_name,f.carbrand_name,j.carseries_name,j.is_import,carsize_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_channel c ON a.channel_id=c.id')
                ->join('LEFT JOIN think_target_library d ON a.library_id=d.id')
                ->join('LEFT JOIN think_target_company e ON a.finance_company_id=e.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carseries_id=j.id')
                ->join('LEFT JOIN think_target_carsize h ON a.carsize_id=h.id')
                ->limit($Page->firstRow.','.$Page->listRows)
                ->where($where)
                ->select();
        $this->assign('page',$show);
        return $list;
    }
}