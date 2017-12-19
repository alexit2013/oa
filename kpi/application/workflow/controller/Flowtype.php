<?php
/*--------------------------------------------------------------------
广汇KPI报表--审批流程

 --------------------------------------------------------------*/

namespace app\workflow\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;
class Flowtype extends Base{
    //流程列表
    function index(){
        $data=Db::name('kpi_flow_type')->order('sort desc')->select();
        $data_list=array();
        foreach ($data as $key => $value) {
            $data_list[$key]['id']=$value['id'];
            $data_list[$key]['name']=$value['name'];
            $data_list[$key]['confirm']=$this->_dispose($value['confirm']);
            $data_list[$key]['refer']=$this->_dispose($value['refer']);
            $data_list[$key]['sort']=$value['sort'];
            $data_list[$key]['update_time']=date('Y/m/d,H:i:s',$value['update_time']);
        }
        $this -> assign('data_list',$data_list);
        return view();

    }
    /** 插入新新数据 (新建流程) **/
    function add(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $data['create_time']=time();
            $data['update_time']=time();
            $list=Db::name('kpi_flow_type')->insert($data);
            if ($list !== false) {//保存成功
                $res['status']='1';
                $res['info']='编辑成功!';
            } else {
                $res['status']='0';
                $res['info']='编辑失败!';
            }
            return json($res);
        }else{
               
            return view();
        }
       
    }
     
    /* 更新数据  */
    public function update() {
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $data['update_time']=time();
            $model = Db::name('kpi_flow_type');
            $list = $model -> update($data);
            if (false !== $list) {
                $res['status']='1';
                $res['info']='编辑成功!';
                //成功提示
            } else {
                $res['status']='0';
                $res['info']='编辑失败!';
            }
            return json($res);
        }else{

            $Flowtype_id=input('param.id');
            $res=Db::name('kpi_flow_type')->where('id',$Flowtype_id)->find();
            $data=array();
            $data['id']=$res['id'];
            $data['name']=$res['name'];
            $data['confirm']=$this ->_dispose($res['confirm']);
            $data['refer']=$this ->_dispose($res['refer']);
            $data['sort']=$res['sort'];
            $this -> assign('data_list',$data);
            return view();
        }
    }

    /*永久删除*/
    public function del($id){
        if(!empty($id)){
            $res=Db::name('kpi_flow_type')->delete($id);
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

    function _dispose($data){
        $cds['dsp']='多部门';
        $cds['csp']='多公司';
        $cds['emp']='人员';
        $position=Db::name('position')->select();
        foreach ($position as $key => $value) {
                $position_arr[$value['id']]=$value['name'];
        }
           $arr=explode('|', $data);
           unset($arr[count($arr)-1]);
           $data_list =array();
            foreach ($arr as $key => $value) {
                    $arr_b=array();
                    $arr_b=explode('_',$value);
                    $data_list[$key]['ask'] = $value;
                    if($arr_b[0]=='emp'){
                        $emp_arr=Db::name('user')->field('name')->where('emp_no',$arr_b[1])->find();
        
                        if(!isset($emp_arr['name'])){
                                $emp_arr['name']='人员已删除';
                        }
                        $data_list[$key]['name']=$emp_arr['name'];
                    }else if($arr_b[0]=='dp'){
                          $dept_arr=Db::name('dept')->field('NAME')->where("id",$arr_b['1'])->find();
                          if(!isset($dept_arr['NAME'])){
                                $dept_arr['NAME']='部门已删除';
                          }
                          $data_list[$key]['name']=$dept_arr['NAME'].'-'.$position_arr[$arr_b[2]];  
                    
                    }else if($arr_b[0]=='dgp'){
                        
                        $com_arr=Db::name('dept_grade')->field('name')->where('id',$arr_b['1'])->find();
                        if(!isset($com_arr['name'])){
                                $com_arr['name']='单位已删除';
                          }
                        $data_list[$key]['name']=$com_arr['name'].'-'.$position_arr[$arr_b[2]];  
                    
                    }else{
                        $data_list[$key]['name']=$cds[$arr_b[0]].'-'.$position_arr[$arr_b[2]];
                    }
            }
            return $data_list;
    }
    
}