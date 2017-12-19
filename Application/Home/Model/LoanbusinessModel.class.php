<?php
namespace Home\Model;
use Think\Model;

class LoanbusinessModel extends CommonModel{
    protected $tableName = 'target_Loanbusiness';

    protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    // protected $_validate = array(
    //     array('dept_name','require','店面必须选',1), //必须验证
    //     array('customer','客户必须',self::EXISTS_VALIDATE,'regex',self::MODEL_BOTH)
    //     );

    //自动完成添加
    protected $_auto = array ( 
        array('add_time','time',self::MODEL_BOTH,'function'), // 对add_time字段在添加的时候写入当前时间戳

        );  
    //全部店面列表
    public function Alldept(){
        $user_id = get_user_id();
        if(get_user_id() =='1'){
            $res = $this -> table('think_dept')->where("pid=1")->getField("id,name");
        }else {
            $res = $this -> table('think_dept')->where("id={$_SESSION['com_id']}")->getField("id,name");
        }
        return $res;
    } 
    //渠道列表
    public function Allchannel(){
        return $this -> table('think_target_channel')->where("is_del=0")->getField("id,channel_name");
    }
    //放款及咨询服务费类型列表
    public function Alllibrary(){
        return $this -> table('think_target_library')->where("is_del=0")->getField("id,library_title");
    }
    //金融公司列表
    public function Allcompany(){
        return $this -> table('think_target_company')->where("is_del=0")->getField("id,company_name");
    }

    //品牌列表
    public function Allcarbrand(){
  
        return $this -> table('think_target_carbrand')->where("is_del=0")->getField("id,carbrand_name");
    }
    //车系列表
    public function Allcarseries(){
        return $this -> table('think_target_carseries')->where("is_del=0")->getField("id,carseries_name");
    }
    //车系是否进口
    public function Single_improt($carsize_id=null){
        return $this -> table('think_target_carseries')->field('carseries_name,is_import')->where(array('is_del'=>0,'id'=>$carsize_id))->find();
    }
   //车型列表
    public function Allcarsize(){
        return $this -> table('think_target_carsize')->where("is_del=0")->getField("id,carsize_name");
    }
    //列表
    public function loanList(){
        return $this ->alias('a')
                ->field('a.*,b.NAME as dept_name,c.channel_name,d.library_title,e.company_name,f.carbrand_name,j.carseries_name,j.is_import,carsize_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_channel c ON a.channel_id=c.id')
                ->join('LEFT JOIN think_target_library d ON a.library_id=d.id')
                ->join('LEFT JOIN think_target_company e ON a.finance_company_id=e.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carseries_id=j.id')
                ->join('LEFT JOIN think_target_carsize h ON a.carsize_id=h.id')
                ->where("a.is_del=0")
                ->select();
    }
    //单条
    public function Singleloan($id=null){
         if(empty($id)){

            return false;
        }
        return $this -> find($id);
     }
     //搜索(两种存在)
     public function lzboth($loancar_time_start,$loancar_time_end,$zx_time_start,$zx_time_end){
         $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
        if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
            $map['a.is_del']=array('EQ',0);
        }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $map['a.is_del']=array('EQ',0);
            $map['a.dept_id']=array('EQ',$deptsingle['pid']);
        }
        $map['a.car_loan_time'] = array(array('EGT',$loancar_time_start),array('ELT',$loancar_time_end));
        $map['a.zxcost_time']=array(array('ELT',$zx_time_start),array('ELT',$zx_time_end));
        // $map="(a.car_loan_time <= {$loancar_time_start} AND a.car_loan_time <= {$loancar_time_end}) OR (a.zxcost_time <= {$zx_time_start} AND a.zxcost_time <= {$zx_time_end}) AND a.is_del=0";
        $map['a.is_del']=array('EQ',0);
        return $this ->alias('a')
                ->field('a.*,b.NAME as dept_name,c.channel_name,d.library_title,e.company_name,f.carbrand_name,j.carseries_name,h.carsize_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_channel c ON a.channel_id=c.id')
                ->join('LEFT JOIN think_target_library d ON a.library_id=d.id')
                ->join('LEFT JOIN think_target_company e ON a.finance_company_id=e.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carseries_id=j.id')
                ->join('LEFT JOIN think_target_carsize h ON a.carsize_id=h.id')
                ->where($map)
                ->select();

     }
     //车贷申请日期
     public function Searchloan($loancar_time_start,$loancar_time_end){
         $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
        if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
            $map['a.is_del']=array('EQ',0);
        }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $map['a.is_del']=array('EQ',0);
            $map['a.dept_id']=array('EQ',$deptsingle['pid']);
        }
        $map['a.car_loan_time'] = array(array('EGT',$loancar_time_start),array('ELT',$loancar_time_end));
        $map['a.is_del']=array('EQ',0);
        return $this ->alias('a')
                ->field('a.*,b.NAME as dept_name,c.channel_name,d.library_title,e.company_name,f.carbrand_name,j.carseries_name,h.carsize_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_channel c ON a.channel_id=c.id')
                ->join('LEFT JOIN think_target_library d ON a.library_id=d.id')
                ->join('LEFT JOIN think_target_company e ON a.finance_company_id=e.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carseries_id=j.id')
                ->join('LEFT JOIN think_target_carsize h ON a.carsize_id=h.id')
                ->where($map)
                ->select();

     }
     //咨询服务分交款日期
     public function Searchzx($zx_time_start,$zx_time_end){
        $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
        if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
            $map['a.is_del']=array('EQ',0);
        }else{
            $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $map['a.is_del']=array('EQ',0);
            $map['a.dept_id']=array('EQ',$deptsingle['pid']);
        }
        $map['a.zxcost_time'] = array(array('EGT',$zx_time_start),array('ELT',$zx_time_end));
        $map['a.is_del']=array('EQ',0);
        return $this ->alias('a')
                ->field('a.*,b.NAME as dept_name,c.channel_name,d.library_title,e.company_name,f.carbrand_name,j.carseries_name,h.carsize_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_channel c ON a.channel_id=c.id')
                ->join('LEFT JOIN think_target_library d ON a.library_id=d.id')
                ->join('LEFT JOIN think_target_company e ON a.finance_company_id=e.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carseries_id=j.id')
                ->join('LEFT JOIN think_target_carsize h ON a.carsize_id=h.id')
                ->where($map)
                ->select();
     } 
    
   
}