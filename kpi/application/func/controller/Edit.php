<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\func\controller;
use app\base\controller\Base;
use think\Db;
class Edit extends Base{
    /*
     * 带数据修改字段id方法
     */
    public function comon_edit(){
        $data = input('param.');
        $datatype = $data['datatype'];
        if($datatype == "date"){
            $new_con = strtotime($data['new_con']);
        }else{
            $new_con = $data['new_con'];        //修改的内容
        }
        $table_name = 'kpi_'.$data['table_name'];        //表名
        $id = $data['order_num'];                         //序列号id
        $key = $data['key_name'];                         //键名
        $rule=Db::name($table_name)->where('id='.$id)->update([$key => $new_con]);
        if($rule){
            $reslut['status']='1';
            $reslut['msg']='修改成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='修改失败！';
        }
        return json($reslut);
    }

    /*
     * 带数据修改字段id方法
     */
    public function comon_edit1(){
        $data = input('param.');
        $datatype = $data['datatype'];
        if($datatype == "date"){
            $new_con = strtotime($data['new_con']);
        }else{
            $new_con = $data['new_con'];        //修改的内容
        }

        $table_name = 'kpi_'.$data['table_name'];        //表名
        $key = $data['key_name'];                         //键名
        $year = $data['year'];                          //年份
        $month = $data['month'];                        //月份
        $store_id = $data['store_id'];                  //门店id
        $class_name = $data['class_name'];              //分类键名称
        $class_value = $data['class_value'];            //分类名称或者值
        if(!empty($class_name)){
            $rule=Db::name($table_name)
                ->where('year='.$year)
                ->where('month='.$month)
                ->where($class_name.'="'.$class_value.'"')
                ->where('store_id='.$store_id)
                ->update([$key => $new_con]);
        }else{
            $rule=Db::name($table_name)
                ->where('year='.$year)
                ->where('month='.$month)
                ->where('store_id='.$store_id)
                ->update([$key => $new_con]);
        }

        if($rule){
            $reslut['status']='1';
            $reslut['msg']='修改成功！';
        }else{
            $reslut['status']='0';
            $reslut['msg']='修改失败！';
        }
        return json($reslut);
    }

    /*
 * 修改车系方法
 */
public function comon_edit2(){
    $data = input('param.');
    $table_name = 'kpi_'.$data['table_name'];        //表名
    $id = $data['order_num'];                         //序列号id
    $rule=Db::name($table_name)->delete($id);
    if($rule){
        $reslut['status']='1';
        $reslut['msg']='删除成功！';
    }else{
        $reslut['status']='0';
        $reslut['msg']='删除失败！';
    }
    return json($reslut);

}

}
