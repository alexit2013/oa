<?php
/*--------------------------------------------------------------------
广汇KPI报表--抄送配置

 --------------------------------------------------------------*/

namespace app\workflow\controller;
use app\base\controller\Base;
use think\Request;
use think\Db;
class Refertype extends Base{
    
    public function index(){
        $res=Db::name('kpi_refer_type')->alias('a')
                ->field('a.*,b.name')
                ->join('think_kpi_chart_deptclass b','a.deptclass_id=b.id','LEFT')
                ->select();
        
        foreach ($res as $key => $value) {
            $controller= new \app\workflow\controller\Flowtype();
            $res[$key]['refer']=$controller ->_dispose($value['refer']);
            $res[$key]['deptclass_id']=$value['deptclass_id'];
            $res[$key]['name']=$value['name'];
            $res[$key]['sort']=$value['sort'];
        }
  
        $this -> assign('data_list',$res);
        return view();
    }

    /** 插入新数据 (抄送配置) **/
    public function add(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $list=Db::name('kpi_refer_type')->insert($data);
            if ($list !== false) {//保存成功
                $res['status']='1';
                $res['info']='添加成功!';
            } else {
                $res['status']='0';
                $res['info']='添加失败!';
            }
            return json($res);
        }else{
            $chart=Db::name('kpi_chart_deptclass')->where('pid=0')->select();
            $this -> assign('chart_list',$chart);
            return view();
        }
    
    }
    /* 更新数据(抄送配置)  */
    public function update() {
        if(Request::instance()->isAjax()){
            $data=input('param.');

            $about['refer']=implode('|', $data['refers']).'|';
       
            $about['deptclass_id']=$data['deptclass_id'];
            $about['sort']=$data['sort'];
            $map['id']=$data['id'];   

            $res=Db::name('kpi_refer_type')->where($map)->update($about);
            if (!empty($res)) {
                $reslute['status']='1';
                $reslute['info']='编辑成功!';
                //成功提示
            } else {
                $reslute['status']='0';
                $reslute['info']='编辑失败!';
            }
            return json($reslute);
        }else{
            $refertype_id=input('param.id');
            $res=Db::name('kpi_refer_type')->where('id',$refertype_id)->find();
            $chart=Db::name('kpi_chart_deptclass')->where('pid=0')->select();
            $data=array();
            $data['deptclass_id']=$res['deptclass_id'];
            $controller= new \app\workflow\controller\Flowtype();
            $data['refer']=$controller ->_dispose($res['refer']);
            $data['sort']=$res['sort'];
            $data['id']=$res['id'];
            $this -> assign('data_chart',$chart);
            $this -> assign('data_list',$data);
            return view();
        }
    }

    /*删除抄送配置*/
    public function del($id){
        if(!empty($id)){
            $res=Db::name('kpi_refer_type')->delete($id);
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
}