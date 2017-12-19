<?php
/*--------------------------------------------------------------------
广汇KPI报表--审批

 --------------------------------------------------------------*/

namespace app\workflow\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;
class Flow extends Base{
    /*发起审批*/
    public function add(){
        $data=input('param.');
        $chart_type_id=input('param.chart_type_id');
        $flow_type_id = input('param.flow_type_id');
        if(!empty($flow_type_id)){
            $content = input('param.remark');
            $dept_id=get_dept_id();
            $emp_no= get_emp_no();
            $map[0][]=['exp',"FIND_IN_SET('$dept_id',a.dept_id)"];
            $map[0][]=['exp',"FIND_IN_SET('$emp_no',a.emp_no)"];
            $res=Db::name('kpi_chart_dept_flow')->alias('a')
                    ->field('c.id,c.sort,b.name,c.confirm,c.refer,b.name as chart_name,b.id as chart_type_id,b.type')
                    ->join('think_kpi_chart_type b','a.chart_type_id=b.id','LEFT')
                    ->join('think_kpi_flow_type c','a.flow_type_id=c.id','LEFT')
                    ->whereOR($map)
                    ->where('a.chart_type_id',$chart_type_id)
                    ->order('c.sort desc')
                    ->find();
            $data=array();
            $data['flow_type']=$res['id'];
            $data['flow_name']=$res['name'].'_'.get_dept_name();
            $data['confirm']=$res['confirm'];
            $data['refer']=$res['refer'];
            $data['chart']=$res['chart_name'];
            $data['chart_type_id']=$res['chart_type_id'];
            $data['type']=$res['type'];
            $data['store_id']=get_com_id();
            $data['dept_id'] = $dept_id;
            $data['emp_no']=get_emp_no();
            $data['user_name']=get_user_name();
            $data['content']=$content;

            $flow_m =new \app\workflow\model\Flow();
            $result = $flow_m->add($data);
            return json($result);
        }

        $this -> _allocation_flow();
        return view();
    }

    /*我的审批*/
    function read(){
        $map = $this->search();

        if(get_user_id()=='1'){
            $flow=Db::name('kpi_flow')->where($map)->select();
        }else{
            $where['emp_no']=get_emp_no();
            $flow=Db::name('kpi_flow')->where($where)->where($map)->select();
        }
        // dump($flow);
        $this -> assign('flow',$flow);
        return view();
    }
    /*已审批*/
    function finish(){
        $emp_no = get_emp_no();
        $list = Db::name('kpi_flow_log')->alias('fl')->field('f.id,fl.id as flow_log_id,f.flow_name,f.user_name,f.createtime,f.status')
                ->join('think_kpi_flow f','f.id=fl.flow_id','LEFT')
                ->where('is_del',0)->where('(fl.status=1 OR fl.status=2)')
                ->where('fl.emp_no',$emp_no)->order('fl.id desc')
                ->group('fl.flow_id')->select();
// dump($list);
        $this->assign('list',$list);
        return view();
    }
    /*待审批*/
    function pend(){
        if(request()->isAjax()){
            $flow_m =new \app\workflow\model\Flow();
            $flow_data = input('param.');
            $result = $flow_m->savedata($flow_data);
            return json($result);
        }
        $emp_no = get_emp_no();
        $list = Db::name('kpi_flow_log')->alias('fl')->field('f.id,fl.id as flow_log_id,f.flow_name,f.user_name,f.createtime,f.status')
                ->join('think_kpi_flow f','f.id=fl.flow_id','LEFT')
                ->where('is_del',0)->where('(fl.status is null OR fl.status=3)')
                ->where('fl.emp_no',$emp_no)->order('fl.id desc')->select();
        $this->assign('list',$list);
        return view();
    }
       /*分配发起审批*/
    private function _allocation_flow(){
        $emp_no=get_emp_no();
        $dept_id=get_dept_id();
        $up['ur.emp_no']=$emp_no;
        $up['ur.is_del']=0;
        $res=Db::name('kpi_user_role')->alias('ur')->field('ur.emp_no,r.name,r.pri_ids')
                ->join('kpi_role r','r.id=ur.role_id','LEFT')
                ->where($up)
                ->find();

        if($res['pri_ids']=='*'){
            $map['pid']='423';
        }else{
            $map['id']=['IN',$res['pri_ids']];
            $map['pid']='423';
        }
           
            
        $data_pri=Db::name('kpi_pri')->where($map)->field('name,chart_type_id')->select();
        $where[0][]=['exp',"FIND_IN_SET('$dept_id',a.dept_id)"];
        $where[0][]=['exp',"FIND_IN_SET('$emp_no',a.emp_no)"];

        foreach ($data_pri as $key => $value) {        
            $data_pri[$key]['flowtype']=Db::name('kpi_chart_dept_flow')->alias('a')
                        ->field('c.id as flow_type_id,c.name,b.name as chart_name,b.type')
                        ->join('think_kpi_chart_type b','a.chart_type_id=b.id','LEFT')
                        ->join('think_kpi_flow_type c','a.flow_type_id=c.id','LEFT')
                        ->whereOR($where)
                        ->where('a.chart_type_id',$value['chart_type_id'])
                        ->order('c.sort desc')
                        ->find();
        }
        // dump($data_pri);
        $this -> assign('data_pri',$data_pri);
        $this -> assign('userinfo',getUserNameByempNo($res['emp_no']));
    }
   
    //搜索
    private function  search(){
        $map=array();
        $data = input('param.');
        if(!empty($data['name'])){
            $map['user_name|id|emp_no|flow_name|chart'] = ['like','%'.$data['name'].'%']; 
            $this->assign('search_data',$data);
        }
       
        return $map;
    }

    //抄送
    function refer(){
        if(get_user_id()=='1'){
            $res=Db::name('kpi_flow_refer')->alias('a')->field('b.*,a.id as flow_refer_id,a.name as refer_name,a.emp_no as refer_emp_no')
                ->join('kpi_flow b','a.flow_id=b.id','LEFT')
                ->select();
        }else{
            $emp_no=get_emp_no();
            $where['a.emp_no']=$emp_no;
            // $where[]=['exp',"FIND_IN_SET('$emp_no',a.emp_no)"];
            $res=Db::name('kpi_flow_refer')->alias('a')->field('b.*,a.id as flow_refer_id,a.name as refer_name,a.emp_no as refer_emp_no')
                ->join('kpi_flow b','a.flow_id=b.id','LEFT')
                ->where($where)
                ->select();
        }
        // dump($res);
        $this -> assign('data_refer',$res);//抄送
        return view();
    }
    
}