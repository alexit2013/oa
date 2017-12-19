<?php
/*--------------------------------------------------------------------


 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\home\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Carseries extends Base{

    public function index(){
        
        $carseries = Db::name('kpi_carseries')
                ->alias('a')
                ->join('think_kpi_carbrand b','b.id = a.carbrand_id','LEFT')
                ->field('a.id,b.carbrand_name,a.carseries_name,a.is_import')
                ->paginate(12);
        $page = $carseries->render();
        $this->assign('data_list',$carseries);
        $this->assign('page', $page);
        return view();
    }
    
    //添加
    public function add(){
        //品牌下拉框
        $data_brand = Db::name('kpi_carbrand')->field('id,carbrand_name')->select();
        
        if(request()->isPost()){
            $data_add = input('param.');
            $data['carseries_name'] = $data_add['carseries_name'];
            $data['carbrand_id'] = $data_add['carbrand_id'];
            $data['is_import'] = $data_add['is_import'];
            $data['add_time'] = time();
            $data['is_del'] = '0';
            $result = Db::name('kpi_carseries')->insert($data);
            
            if($result){
                $this->success('新增成功', 'Carseries/index');
            }else{
                $this->error('新增失败');
            }
        }
        
        $this->assign('data_brand',$data_brand);
        return view();
    }
    
    //车系编辑
    public function edit(){
        $id = input('param.id');
        $series = Db::name('kpi_carseries')
                ->alias('a')
                ->join('think_kpi_carbrand b','b.id = a.carbrand_id','LEFT')
                ->field('a.id,a.carbrand_id,b.carbrand_name,a.carseries_name,a.is_import')
                ->where('a.id='.$id)
                ->find();
        
        if(request()->isPost()){
            $res = input('param.');
            $data['carseries_name'] = $res['carseries_name'];
            $data['carbrand_id'] = $res['carbrand_id'];
            $data['is_import'] = $res['is_import'];
            $result = Db::name('kpi_carseries')->where('id',$res['id'])->update($data);
            if($result){
                $this->success('修改成功', 'Carseries/index');
            }else{
                $this->error('修改失败');
            }
        }
        $data_brand = Db::name('kpi_carbrand')->field('id,carbrand_name')->select();
        $this->assign('data_brand',$data_brand);
        $this->assign('series',$series);
        return view();
    }
    
    //删除
    public function del(){
        if(request()->isAjax()){
            $id = input('param.id');
            $carsize=Db::name('kpi_carsize')->where('carseries_id',$id)->find();
            if(!empty($carsize)){
                 $this->error('不能删除存在车型的车系!', 'Carseries/index');
                 exit;
            }
            $result = Db::name('kpi_carseries')->where('id='.$id)->delete();
            
            if($result){
                $this->success('删除成功', 'Carseries/index');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
