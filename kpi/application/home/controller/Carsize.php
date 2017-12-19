<?php
/*--------------------------------------------------------------------


 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\home\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Carsize extends Base{

    public function index(){
        
        $carsize = Db::name('kpi_carsize')
                ->alias('a')
                ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
                ->field('a.id,a.carsize_name,b.carseries_name,a.guide_price,a.invoice_price')
                ->paginate(12);
        $page = $carsize->render();
        $this->assign('data_list',$carsize);
        $this->assign('page', $page);
        return view();
    }
    
    public function add(){
        //品牌下拉框
        $data_brand = Db::name('kpi_carbrand')->field('id,carbrand_name')->select();
        
        //车系下拉框
        if(request()->isPost()){
            $data_add = input('param.');
            $data['carsize_name'] = $data_add['carsize_name'];
            $data['carseries_id'] = $data_add['carseries_id'];
            $data['guide_price'] = $data_add['guide_price'];
            $data['invoice_price'] = $data_add['invoice_price'];
            $data['add_time'] = time();
            $data['is_del'] = '0';
            $result = Db::name('kpi_carsize')->insert($data);
            
            if($result){
                $this->success('新增成功', 'Carsize/index');
            }else{
                $this->error('新增失败');
            }
        }
        $this->assign('data_brand',$data_brand);
        return view();
    }

    public function edit(){
        
        $id = input('param.id');
        $size = Db::name('kpi_carsize')
                ->alias('a')
                ->join('think_kpi_carseries b','b.id = a.carseries_id','LEFT')
                ->field('a.id,a.carsize_name,a.carseries_id,b.carseries_name,a.guide_price,a.invoice_price')
                ->where('a.id='.$id)
                ->find();
        
        if(request()->isPost()){
            $res = input('param.');
            
            $data['carsize_name'] = $res['carsize_name'];
            $data['carseries_id'] = $res['carseries_id'];
            $data['guide_price'] = $res['guide_price'];
            $data['invoice_price'] = $res['invoice_price'];
            $result = Db::name('kpi_carsize')->where('id',$res['id'])->update($data);
            
            if($result){
                $this->success('修改成功', 'Carsize/index');
            }else{
                $this->error('修改失败');
            }
        }
        
        //车系下拉框
        $car_serice = Db::name('kpi_carseries')->field('id,carseries_name')->select();
        $this->assign('car_serice',$car_serice);
        $this->assign('size',$size);
        return view();
    }
    
    //删除
    public function del(){
        if(request()->isAjax()){
            $id = input('param.id');
            $result = Db::name('kpi_carsize')->where('id='.$id)->delete();
            
            if($result){
                $this->success('删除成功', 'Carsize/index');
            }else{
                $this->error('删除失败');
            }
        }
    }
    
    //
    public function other_brand(){
        //品牌下拉框
        $data_brand = Db::name('kpi_carbrand')->field('id,carbrand_name')->select();
        
        if(request()->isAjax()){
            
            $res = input('param.carbrand_id');
            
            if(!empty($res)){
                
                return Db::name('kpi_carseries')->where('carbrand_id',$res)->field('id,carseries_name')->select();
            }
            
        }
    }
}