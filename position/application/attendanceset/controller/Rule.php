<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
考勤规则-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendanceset\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;
class Rule extends Base{

    function index(){
        $rule=Db::name('pos_rule')->select();
        foreach ($rule as $key => $val) {
       
            $applied=explode('|',$val['range']);
            foreach ($applied as $k => $value) {
                //公司或部门
                if (strpos("$value", "dept") !== false){
                        $temp = explode("_", $value);
                        $deptids = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$deptids");
                        $rule[$key]['dept']=Db::name('dept')->field('id,pid,name')->where($map)->select();
                       
                }
                //人员
                if (strpos("$value", "emp") !== false){
                        $temp = explode("_", $value);
                        $emps = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$emps");
                        $rule[$key]['emp']=Db::name('user')->field('id,emp_no,name')->where($map)->select();
                        // dump($res);
                }
            }
            
                $ways=$val['way_ids']; //打卡方式
                $where['id']=array('in',$ways);
                $rule[$key]['ways']=Db::name('pos_way')->where($where)->select();
               
                $playdayID=$val['playday_id'];    //休息日
                $rule[$key]['playday']=Db::name('pos_playday')->where('id='.$playdayID)->select();
                
                $schedualID=$val['schedual_ids']; //班次
                if(!empty($schedualID)){
                     $rule[$key]['schedual']=Db::name('pos_schedual')->where('id='.$schedualID)->select();
                }
               
       }
     
        $this ->assign('data_list',$rule); 
        return view();
    }
    //添加
    function add(){
        //打卡方式
        $ways=Db::name('pos_way')->field('id,name')->where('is_del=1')->select();
        //休息日
        $playdays=Db::name('pos_playday')->field('id,name')->select();
        //班次
        $schedual=Db::name('pos_schedual')->select();

         $this->assign([
            'ways'=>$ways,
            'playdays'=>$playdays,
            'schedual'=>$schedual
        ]);
        return view();
    }
    //数据添加
    function ruleadd(){
        if(Request::instance()->isAjax()){
            $data =input('param.');
            $data['way_ids']=implode(',',$data['way_ids']);
            $res=Db::name('pos_rule')->insert($data);
             if($res){
                $reslut['status']='1';
                $reslut['msg']="操作成功";
            }else{
                $reslut['status']='0';
                $reslut['msg']="操作失败";
            }
            return json($reslut);
        }
   
    }

    //编辑弹框
    function popupedit(){
       $range=input('param.range');
  
       if(!empty($range)){
            $applied=explode('*',$range);
            foreach ($applied as $key => $value) {            
            //公司或部门
                if (strpos("$value", "dept") !== false){
                    if(!empty($value)){
                        $temp = explode("_", $value);
                        $deptids = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$deptids");
                        $reslut[$key]['dept']=Db::name('dept')->field('id,pid,name')->where($map)->select();                    
                    }else{
                        $reslut[$key]['dept']='dept_';
                    }
                }
                 //人员
                if (strpos("$value", "emp") !== false){
                    if(!empty($value)){
                        $temp = explode("_", $value);
                        $emps = $temp[1];
                        if(!empty($emps)){
                            $map['is_del']=0;
                            $map['id']=array('in',"$emps");
                            $reslut[$key]['emp']=Db::name('user')->field('id as emp_id,emp_no,name as emp_name')->where($map)->select(); 
                        }
                    }else{
                        $reslut[$key]['dept']='emp_';
                    }       // dump($res);
                } 
            }
            $this -> assign('data',json_encode($reslut,JSON_UNESCAPED_UNICODE));

        } 
        $node = Db::name("Dept");
        $menu = array();
        $menu = $node -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') -> select();
        $tree = list_to_tree($menu);
        $this ->assign('tree',$tree);
        return view();

    
    }

    //添加弹框 
    function popupadd(){
        $node = Db::name("Dept");
        $menu = array();
        $menu = $node -> where('is_del=0') -> field('id,pid,name') -> order('sort asc') -> select();
        $tree = list_to_tree($menu);
        $this ->assign('tree',$tree);
        return view();

    } 
 
    //所在门店人员
    function userajax(){
        $com_id=input('param.com_id');
        $dept_id=input('param.dept_id');
 
        if(!empty($com_id) && $com_id!='undefined'){
            $res= Db::name('user')->field('id,emp_no,name,pic')
                ->where(array('is_del'=>0,'com_id'=>$com_id))
                ->select();
        }
        if(!empty($dept_id) && $dept_id!='undefined'){
            $res= Db::name('user')->field('id,emp_no,name,pic')
                ->where(array('is_del'=>0,'dept_id'=>$dept_id))
                ->select();
        }
 
        return json($res);
    }

    //修改
    function edit(){
        $id=input('param.id');
        $rule=Db::name('pos_rule')->where('id='.$id)->find();
        $appliedrange=explode('|', $rule['range']);//应用范围
        foreach ($appliedrange as $key => $value) {
            //公司或部门
                if (strpos("$value", "dept") !== false){
                        $temp = explode("_", $value);
                        $deptids = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$deptids");
                        $rule['dept']=Db::name('dept')->field('id as dept_id,pid as dept_id,name as dept_name')->where($map)->select();
                       
                }
           
                //人员
                if (strpos("$value", "emp") !== false){
                        $temp = explode("_", $value);
                        $emps = $temp[1];
                        $map['is_del']=0;
                        $map['id']=array('in',"$emps");
                        $rule['emp']=Db::name('user')->field('id as emp_id,emp_no,name as emp_name')->where($map)->select();
                       
                }
                
        }
            $ways=$rule['way_ids']; //打卡方式
            $where['id']=array('in',$ways);
            $rule['ways']=Db::name('pos_way')->where($where)->select();
           
            $playdayID=$rule['playday_id'];    //休息日
            $rule['playday']=Db::name('pos_playday')->where('id='.$playdayID)->select();
            
            $schedualID=$rule['schedual_ids']; //班次
            if(!empty($schedualID)){
                 $rule['schedual']=Db::name('pos_schedual')->where('id='.$schedualID)->select();
            }
            //合并数组
        // $rule['dept_emp']=array_merge($rule['dept'],$rule['emp']);
            
        //全部打卡方式
        $allways=Db::name('pos_way')->field('id,name')->where('is_del=1')->select();
        

        //全部休息日
        $allplayday=Db::name('pos_playday')->field('id,name')->select();
        //班次
        $allschedual=Db::name('pos_schedual')->field('')->select();


        $this ->assign('allschedual',$allschedual);
        $this ->assign('allplayday',$allplayday);
        $this ->assign('allways',$allways);
        $this ->assign('rule',$rule);
     
        return view();
    }
    //修改数据
    function ruleedit(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $map['id']=$data['id'];
            $res=Db::name('pos_rule')->where($map)->update($data);
            if($res){
                $reslut['status']='1';
                $reslut['msg']='操作成功';
            }else{
                $reslut['status']='0';
                $reslut['msg']='操作失败';
            }
            return json($reslut);
        }
        
    }

    //删除
    function del(){
        if(Request::instance()->isAjax()){ 
            $id =input('param.id');
            $res=Db::name('pos_rule')->delete($id);
            if($res){
                $reslut['status']='1';
                $reslut['msg']="删除成功";
            }else{
                $reslut['status']='0';
                $reslut['msg']="删除失败";
            }
            return json($reslut);
        }
    }

    //编辑优先值
    function priority(){
        if(Request::instance()->isAjax()){ 
            $map['id'] =input('param.id');
            $data['priority']=input('param.priority');
            $res=Db::name('pos_rule')->where($map)->update($data);
            if($res){
                $reslut['status']='1';
                $reslut['msg']="操作成功";
            }else{
                $reslut['status']='0';
                $reslut['msg']="操作失败";
            }
            return json($reslut);
        }
    }

}