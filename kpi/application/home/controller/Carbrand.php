<?php
/*--------------------------------------------------------------------


 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\home\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;

class Carbrand extends Base{

    public function index(){
        
        $carbrand = Db::name('kpi_carbrand')->paginate(10);
        $page = $carbrand->render();

        $this->assign('data_list',$carbrand);
        $this->assign('page', $page);
        return view();
    }
    
    //增加
    public function add(){
        if(request()->isPost()){
            $data_add = input('param.');
            if(!empty($data_add)){
                
                $data['carbrand_name'] = $data_add['carbrand_name'];
                $data['add_time'] = time();
                $data['is_del'] = '0';
                $result = Db::name('kpi_carbrand')->insert($data);
                
                if($result){
                    $this->success('新增成功', 'Carbrand/index');
                }else{
                    $this->error('新增失败');
                }
            }
        }else{
            $stores=Db::name('dept')->field('id,name')->where('pid=1')->select();
            $this->assign('stores',$stores);
            return view();
        }
        
        
    }
    
    //修改
    public function edit(){
        
        $id = input('param.id');
        $start = Db::name('kpi_carbrand')->where('id='.$id)->find();
        if(request()->isPost()){
            $res = input('param.');
            $data['carbrand_name'] = $res['carbrand_name'];
            $result = Db::name('kpi_carbrand')->where('id',$res['id'])->update($data);
            
            if($result){
                $this->success('修改成功', 'Carbrand/index');
            }else{
                $this->error('修改失败');
            }
        }
        $this->assign('data_list',$start);
        
        return view();
    }
    
    //删除
    public function del(){
        if(request()->isAjax()){
            $id = input('param.id');
            $result = Db::name('kpi_carbrand')->where('id='.$id)->delete();
            
            if($result){
                $this->success('删除成功', 'Carbrand/index');
            }else{
                $this->error('删除失败');
            }
        }
    }

    //门店管理品牌
    public function brandstore(){
        if(Request::instance()->isAjax()){
            $data= input('param.');
            $store_id=$data['store_id'];
            $carbrands=$data['carbrands'];
            Db::startTrans();
            $res=Db::name('kpi_store_carbrand')->where('store_id='.$store_id)->column('id'); //本店是否有管理相关品牌
            if(!empty($res)){
                $dels=Db::name('kpi_store_carbrand')->delete($res); //删除本店面管理的品牌
                if(empty($dels)){
                    Db::rollback();
                }
            }
            foreach ($carbrands as $key => $value) {
                $about['store_id']=$store_id;
                $about['carbrand_id']=$value;
                $res=Db::name('kpi_store_carbrand')->insert($about);         
                if(empty($res)){
                    Db::rollback();
                    $result['msg']='操作失败';
                    $result['status']='0';
                    return json($result);
                }else{
                    Db::commit();
                }
            }

            $result['msg']='操作成功';
            $result['status']='1';
            return json($result);
        }else{
            $carbrand=Db::name('kpi_carbrand')->field('id,carbrand_name')->where('is_del=0')->select();
            $store=get_comlist();  //所属门店
     
            $this -> assign('stores',$store);
            $this -> assign('carbrand',$carbrand);
            return view();
        }
        
        
    }

}

