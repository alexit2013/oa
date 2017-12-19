<?php
/*--------------------------------------------------------------------
广汇KPI报表--审批配置关联报表

 --------------------------------------------------------------*/

namespace app\workflow\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;
class Connection extends Base{
    //关联列表
    public function index(){
        $res=Db::name('kpi_chart_dept_flow')->alias('a')->field('a.id,a.dept_id,a.emp_no,a.sort as chart_dept_sort,c.name as chart_type_name,d.name as flow_name')
                ->join('think_kpi_chart_type c','a.chart_type_id=c.id','LEFT')
                ->join('think_kpi_flow_type d','a.flow_type_id=d.id','LEFT')
                ->select();
       
        foreach ($res as $key => $value) {
            $res[$key]['dept_name']=Db::name('dept')->field('id,pid,NAME')->where('id','IN',$value['dept_id'])->select();
            $res[$key]['emp']=Db::name('user')->field('name as user_name')->where('emp_no','IN',$value['emp_no'])->select();  
            $res[$key]['dept_emp']=array_merge($res[$key]['dept_name'],$res[$key]['emp']);
            unset($res[$key]['dept_name']);
            unset($res[$key]['emp']);
        }
        
        $this -> assign('data_list',$res);
        return view();

    }
    //关联添加
    public function add(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            if(!empty($data['depts'])){
                $about['dept_id']=implode(',', $data['depts']);
            }
            if(!empty($data['emps'])){
                $about['emp_no']=implode(',', $data['emps']);
            }
            $about['chart_type_id']=$data['chart_type_id'];
            $about['flow_type_id']=$data['flow_type_id'];
            $res=Db::name('kpi_chart_dept_flow')->insert($about);
            if(!empty($res)){
                $reslut['status']='1';
                $reslut['info']='添加成功!';
            }else{
                $reslut['status']='0';
                $reslut['info']='添加失败!';
            }
            return json($reslut);
        }else{
            $this->_dept_list();//部门列表
            $chart=Db::name('kpi_chart_type')->select();//部门报表列表
            $flow=Db::name('kpi_flow_type')->field('id,name')->select();
            $this -> assign('flow_list',$flow);
            $this -> assign('data_chart',$chart);
            return view();
        }
        
    } 
    //关联修改
    public function update(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $map['id']=$data['id'];
            $about['dept_id']=implode(',', $data['depts']);
            $about['emp_no']=implode(',', $data['emps']);
            $about['chart_type_id']=$data['chart_type_id'];
            $about['flow_type_id']=$data['flow_type_id'];
            $res=Db::name('kpi_chart_dept_flow')->where($map)->update($about);
            if(!empty($res)){
                $reslut['status']='1';
                $reslut['info']='修改成功!';
            }else{
                $reslut['status']='0';
                $reslut['info']='修改失败!';
            }
            return json($reslut);
        }else{
            $this->_dept_list();//部门列表
            $chart=Db::name('kpi_chart_type')->select();//部门报表列表
            $flow=Db::name('kpi_flow_type')->field('id,name')->select();
            $id=input('param.id');
            $data=Db::name('kpi_chart_dept_flow')->where('id',$id)->find();
            $res=array();
            $res['id']=$data['id'];
            $rest=Db::name('dept')->field('id,NAME')->where('id','IN',$data['dept_id'])->select();
            if(!empty($rest)){
                foreach ($rest as $key => $value) {
                    // $dept_name.=$value['NAME'].',';
                    $res['depts'][$key]['id']=$value['id'];
                    $res['depts'][$key]['name']=$value['NAME'];
                }
            }else{
                $res['depts']=array();
            }
            $rest_emp=Db::name('user')->field('emp_no,name')->where('emp_no','IN',$data['emp_no'])->select();

            if(!empty($rest_emp)){
                foreach ($rest_emp as $key => $value) {
                    // $emps.=$value['name'].',';
                    $res['emps'][$key]['emp_no']=$value['emp_no'];
                    $res['emps'][$key]['name']=$value['name'];
                }
            }else{
                $res['emps']=array();
            }
            $res['dept_id']=$data['dept_id'];
            $res['emp_no']=$data['emp_no'];
            $res['chart_type_id']=$data['chart_type_id'];
            $res['flow_type_id']=$data['flow_type_id'];

            $this -> assign('data_list',$res);
            $this -> assign('flow_list',$flow);
            $this -> assign('data_chart',$chart);
            return view();
        }
    }

    /*永久删除*/
    public function del($id){
        if(!empty($id)){
            $res=Db::name('kpi_chart_dept_flow')->delete($id);
            if(!empty($res)){
                $result['status']='1';
                $result['info']='删除成功!';
            }else{
                $result['status']='1';
                $result['info']='删除失败!';
            }
            return json($result);
        }
    }
    //部门列表
    private function _dept_list() {
        $model = Db::name("Dept");
        $list = array();
        $list = $model -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') -> select();
        $list = list_to_tree($list);
        $this -> assign('list_dept', popup_tree_menu($list));
    }          
}