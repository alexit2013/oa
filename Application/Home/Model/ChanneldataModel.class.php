<?php
namespace Home\Model;
use Think\Model;

class ChannelDataModel extends CommonModel{

    protected $tableName = 'target_channeldata';

     protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('dept_id','require','验证码必须',1) //必须验证
        );

    public function channelList(){
        $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
         
        if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
                   $where['a.is_del']=array('EQ',0);
        }else{
           $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dept_id']=array('EQ',$deptsingle['pid']);
        }
        return $this -> alias('a')->field('a.id,b.name,a.dept_id,a.showroom,a.self_store,a.tel_group,a.big_consumer,a.outer_permit,a.inputtime')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')->where($where)->select();
    }
    //全部店面列表
    public function Alldept(){
        return $this -> table('think_dept')->where("pid=1")->getField("id,name");
    }
    //查找单条信息
    public function Singleinfo($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
    }

}