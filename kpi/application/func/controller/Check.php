<?php
/*--------------------------------------------------------------------
广汇KPI报表--审批流程(弹框)

 --------------------------------------------------------------*/

namespace app\func\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;
class Check extends Base{
    /*检查报表是否已填写*/
    public function is_fillout(){
        $chart_id=input('param.chart_type_id');
        $res=Db::name('kpi_chart_type')->where('id',$chart_id)->find();
        $map['store_id']=get_com_id();
        $map['year']=date('Y');
        $map['month']=date('n');
        // $up['store_id']=get_com_id();
        // $up['year']=date('Y');
        $table=explode('|', $res['tables']);
        $i=1;
        foreach ($table as $key => $value) {
                $res=Db::table("$value")->where($map)->count(); 
                if($res<=0){
                    $i=0;
                    break;
                }
        }
        
        if($i==0){
            $recoure['status']='0';
            $recoure['info']='请添加报表数据!';
            return json($recoure); 
        }
    
        $BeginDate=date('Y-m-01', strtotime(date( "Y-m-d H:i:s",mktime (0,0,0,date('n'),1,date('Y')))));
        // $EenDate=date('Y-m-d', strtotime("$BeginDate +1 month -1 day"))
        $EenDate=date('Y-m-d', strtotime(date( "Y-m-d H:i:s",mktime (0,0,0,date('n')+1,1,date('Y')))));
        $where['chart_type_id']=$chart_id;
        $where['dept_id']=get_dept_id();
        $where['store_id']=get_com_id();
        $where['createtime'][0]=['>=',strtotime($BeginDate)];
        $where['createtime'][1]=['<=',strtotime($EenDate)];
        
        $rest=Db::name('kpi_flow')->where($where)->find();
                
        if(!empty($rest)){
            $recoure['status']='0';
            $recoure['info']='请勿重复发起!';
            return json($recoure);
            exit;
        }

        $recoure['status']='1';
        $recoure['info']='检查通过!';
        return json($recoure);
        
    }
    //弹窗
    public function check(){
            $emp_no=get_emp_no();
            $flow_id= input('param.flow_type_id');
            $chart_type_id = input('param.chart_type_id');
            $where['ft.id']=$flow_id;
            $data=Db::name('kpi_flow_type')->alias('ft')
                ->field('ft.id as flow_type_id,ft.name as flow_name,ft.confirm,ft.refer')
                ->join('think_kpi_chart_dept_flow cdf','cdf.flow_type_id=ft.id','LEFT')
                ->where($where)
                ->order('ft.sort desc')
                ->find();
            $chart_type = Db::name('kpi_chart_type')->where('id',$chart_type_id)->find();
            $data_list['user_name']=getUserNameByempNo($emp_no)['name'];
            $data_list['pic']=getUserNameByempNo($emp_no)['pic'];
            $data_list['dept_name']=get_dept_name();
            $data_list['flow_type_id']=$data['flow_type_id'];
            $data_list['flow_type_name']=$data['flow_name'];
            $data_list['chart_type_id']=$chart_type['id'];
            $data_list['chart_name']=$chart_type['name'];
            $data_list['type']=$chart_type['type'];
            $data_list['confirm']=$this ->empNo_Username($data['confirm']);
            $data_list['refer']=$this ->empNo_Username($data['refer']);
            $this -> assign('data_list',$data_list);
            // dump($data_list);
           return view(); 
        
    }
    private function empNo_Username($data){
        $model= new \app\workflow\model\Flow();
        $res=$model->_conv_auditor($data);
        $flowlist=explode('|',$res);
        unset($flowlist[count($flowlist)-1]);
        $userlist=array();
        $flow=array();
        foreach ($flowlist as $key => $value) {
            $userlist=explode(',', $value);
                foreach ($userlist as $k => $vo) {
                    $flow[$key][$k]=Db::name('user')->alias('u')->field('u.name as user_name,p.name as position_name,d.NAME as dept_name,u.pic')
                            ->join('think_position p','u.position_id=p.id','LEFT')
                            ->join('think_dept d','u.dept_id=d.id','LEFT')
                            ->where('u.emp_no',$vo)
                            ->find();
                }
        }
        return $flow;
    }
    /*我的审批-弹窗*/
    function win1(){
        $flow_id = input('param.flow_id');
        // dump($flow_id);
        $data=Db::name('kpi_flow')->where('id',$flow_id)->find();
        $emp_no = $data['emp_no'];
        $dept = Db::name('dept')->where('ID',$data['dept_id'])->find();
        $data_list['user_name']=getUserNameByempNo($emp_no)['name'];
        $data_list['emp_no'] = $data['emp_no'];
        $data_list['pic']=getUserNameByempNo($emp_no)['pic'];
        $data_list['dept_name']=$dept['NAME'];
        $data_list['flow_name']=$data['flow_name'];
        $data_list['chart']=$data['chart'];
        $data_list['content']=$data['content'];
        $data_list['createtime']=$data['createtime'];
        $data_list['status']=$data['status'];
        $data_list['confirm']=$this ->_confirm($flow_id);        
        $this -> assign('flow_own',$data_list);
        // dump($data_list);
        return view();
    }

    /*我的审批-流程编码装换*/
    private function ownflow_convert($data,$flow_id=null){
        if(!empty($data)){
            $flowlist=explode('|',$data);
            unset($flowlist[count($flowlist)-1]);
            dump($flowlist);
            $userlist=array();
            $flow=array();
            foreach ($flowlist as $key => $value) {
                $userlist=explode(',', $value);
                dump($userlist);
                    foreach ($userlist as $k => $vo) {
                        $flow[$key][$k]=Db::name('user')->alias('u')->field('u.name as user_name,p.name as position_name,d.NAME as dept_name,u.pic,fl.content,fl.step,fl.updatetime,fl.status')
                                ->join('think_position p','u.position_id=p.id','LEFT')
                                ->join('think_dept d','u.dept_id=d.id','LEFT')
                                ->join('think_kpi_flow_log fl','u.emp_no=fl.emp_no','LEFT')
                                ->where(array('u.emp_no'=>$vo,'fl.flow_id'=>$flow_id,'fl.step'=>$key+1))
                                ->fetchSql(true)
                                ->find();
                    }
                    return $flow;
            }
        }
    }

    /*待审批、已审批-弹窗*/
    function win2(){
        $flow_id= input('param.id');
        $yiban = input('param.yiban');  //已办参数
        $flow_log_id = input('param.flow_log_id');
        $data=Db::name('kpi_flow')->where('id',$flow_id)->find();
        $data_list['flow_log_id']=$flow_log_id;
        $emp_no = $data['emp_no'];
        $dept = Db::name('dept')->where('ID',$data['dept_id'])->find();
        $data_list['user_name']=getUserNameByempNo($emp_no)['name'];
        $data_list['emp_no'] = $data['emp_no'];
        $data_list['pic']=getUserNameByempNo($emp_no)['pic'];
        $data_list['dept_name']=$dept['NAME'];
        $data_list['flow_name']=$data['flow_name'];
        $data_list['chart_name']=$data['chart'];
        $data_list['status'] = $data['status'];
        $data_list['content']=$data['content'];
        $data_list['createtime']=$data['createtime'];
        $data_list['confirm']=$this ->_confirm($flow_id);
//        $flow_log = Db::name('kpi_flow_log')->where('id',$flow_log_id)->find();
        
        $flow_res=end($data_list['confirm']);//取出审批最后节点
        $data_flowend=array();
        foreach ($flow_res as $key => $value) {
            $data_flowend[$key]['emp_no']=$value['emp_no'];
            $data_flowend[$key]['status']=$value['status'];
        }
      
        $this -> assign('data_flowend',$data_flowend);
        $this->assign('yiban',$yiban);
        $this->assign('data_list',$data_list);
        return view();
    }
    
    private function _confirm($flow_id){
        $map['flow_id'] = $flow_id;
        $map['is_del'] = 0;
        $list = Db::name('kpi_flow_log')->where($map)->order('id')->select();
        $data_list = array();
        foreach ($list as $k => $v) {
            $data_list[$v['step']-1][$k] = Db::name('user')->alias('u')->field('u.emp_no,u.name as user_name,p.name as position_name,d.NAME as dept_name,u.pic')
                            ->join('think_position p','u.position_id=p.id','LEFT')
                            ->join('think_dept d','u.dept_id=d.id','LEFT')
                            ->where('u.emp_no',$v['emp_no'])
                            ->find();
            $data_list[$v['step']-1][$k]['status']=$v['status'];
            $data_list[$v['step']-1][$k]['content']=$v['content'];
            $data_list[$v['step']-1][$k]['updatetime']=$v['updatetime'];
        }
        return $data_list;
    }

}