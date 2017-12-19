<?php
/*--------------------------------------------------------------------
 oa系统 - 让工作更加灵活便捷
休息日-oa考勤

 Copyright (c) 2017 http://car.qqxio.com All rights reserved.

 Author:  jiajun.lin<13629618142@163.com>,shaosen.Yu<yushaosen@163.com>,guanyu.Shi<shiguanyu@126.com>

 --------------------------------------------------------------*/

namespace app\attendanceset\controller;
use app\base\controller\Base;
use think\Db;
use think\Request;
class Closed extends Base{

    function index(){
        $model = new \app\attendanceset\model\Closed();
        $data_list=$model->playlist();
        $this ->assign('list',$data_list);
        return view();
    }

    //添加
    function add(){  
        return view('closed_add');
    }

    //列表
    function closedadd(){
        // if(Request::instance()->isAjax()){
            Db::startTrans();
            $palyday =$_POST['data']['playday']; //节假日-日常休息日
            $holiday=$_POST['data']['holiday']; //节假日 - 法定节假日
            $fillwork=$_POST['data']['fillworkday']; //节假日-补班日

            if(!empty($palyday)){
                $palyday['daily']=implode(',', $palyday['daily']);
                $p_res=Db::name('pos_playday')->insertGetId($palyday);
            }else{
                $p_res=Db::name('pos_playday')->insertGetId($palyday);
            }
            if(!empty($holiday)){
                foreach ($holiday as $key => $value) {
                    $holiday[$key]['playday_id']=$p_res;
                }
                $h_res=Db::name('pos_holiday')->insertAll($holiday);
            }
            if(!empty($fillwork)){
                foreach ($fillwork as $key => $value) {
                    $fillwork[$key]['playday_id']=$p_res;
                }
                $f_res=Db::name('pos_fillworkday')->insertAll($fillwork);
            }
            if(!empty($p_res) && !empty($h_res) && !empty($f_res)){
                echo "<script>alert('操作成功')</script>";
                echo  '<script>location.href="'.request()->domain().'/position/index.php/attendanceset/closed/index"</script>';
                Db::commit();
            }else{
                echo "<script>alert('操作失败')</script>";
                echo  '<script>location.href="'.request()->domain().'/position/index.php/attendanceset/closed/index"</script>';
                Db::rollback();
            }
            // return json($reslut);
        // }else{
        //     dump($_POST);
  
        //     return view('closed_add');
        // }
        
    }

    //修改列表
    function edit(){
        $id=input('param.id');
        $model = new \app\attendanceset\model\Closed();
        $holidayInfo=$model->GetFillWorkInfoByplayID($id);

        $fillworkInfo=$model->GetHolidayInfoByplayID($id);

        $playInfo=$model->GetPlayInfoById($id);
        $this->assign('playInfo',$playInfo);
        $this->assign('fillworkInfo',$fillworkInfo);
        $this->assign('holidayInfo',$holidayInfo);
        return view();
    }
    //修改
    function closededit(){
        if(Request::instance()->isAjax()){
            $id=input('param.id'); //playday表id
            $palyday =$_POST['data']['playday']; //节假日-日常休息日
            $holiday=$_POST['data']['holiday']; //节假日 - 法定节假日
            $fillwork=$_POST['data']['fillworkday']; //节假日-补班日
            $model = new \app\attendanceset\model\Closed();
            $holidayInfo=$model->GetHolidayIdByplayID($id); //获取holiday相关数据
            $fillworkInfo=$model->GetFillworkIdByplayID($id); //获取fillwork表相关数据
            Db::startTrans();
                $fill_del=Db::name('pos_holiday')->delete($holidayInfo);
                $holiday_del=Db::name('pos_fillworkday')->delete($fillworkInfo);
                if($fill_del && $holiday_del){
                    Db::commit();
                }else{
                    Db::rollback();
                }
            if(!empty($palyday)){
                $palyday['daily']=implode(',', $palyday['daily']);
                $map['id']=$id;
                $p_res=Db::name('pos_playday')->where($map)->update($palyday);
            }
            if(!empty($holiday)){
                 foreach ($holiday as $key => $value) {
                    $holiday[$key]['playday_id']=$id;
                }
                $h_res=Db::name('pos_holiday')->insertAll($holiday);
            }
            if(!empty($fillwork)){
                 foreach ($fillwork as $key => $value) {
                    $fillwork[$key]['playday_id']=$id;
                }
                $f_res=Db::name('pos_fillworkday')->insertAll($fillwork);
            }
            if(!empty($p_res) && !empty($h_res) && !empty($f_res)){
                $reslut['status']='1';
                $reslut['msg']='操作成功';
                Db::commit();
            }else{
                $reslut['status']='0';
                $reslut['msg']='操作失败';
                Db::rollback();
            }
            return json($reslut);
        }
    }

    //法定节假日修改(1)
    function holidayedit(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $map['id']=$data['id'];
            $res=Db::name('pos_holiday')->where($map)->update($data);
            if(!empty($res)){
                $reslut['status']='1';
            }else{
                $reslut['status']='0';
            }
        }
    }

    //补班日修改(1)
    function fillworkedit(){
        if(Request::instance()->isAjax()){
            $data=input('param.');
            $map['id']=$data['id'];
            $res=Db::name('pos_fillworkday')->where($map)->update($data);
            if(empty($res)){
                $reslut['status']='0';
            }else{
                $reslut['status']='1';
            }
        }
    }

    //法定节假日删除(1)
    function holidaydel(){
          if(Request::instance()->isAjax()){
            $id=input('param.id');
            $res=Db::name('pos_holiday')->delete($id);
            if(!empty($res)){
                $reslut['status']='1';
            }else{
                $reslut['status']='0';
            }
        }
    }
      //补班日删除(1)
    function fillworkdel(){
          if(Request::instance()->isAjax()){
            $id=input('param.id');
            $res=Db::name('pos_fillworkday')->delete($id);
            if(!empty($res)){
                $reslut['status']='1';
            }else{
                $reslut['status']='0';
            }
        }
    }

    //删除
    function del(){
         if(Request::instance()->isAjax()){
            $id=input('param.id');
            $model = new \app\attendanceset\model\Closed();
            $holidayInfo=$model->GetHolidayIdByplayID($id); //获取holiday相关数据
            $fillworkInfo=$model->GetFillWorkIdByplayID($id); //获取fillwork表相关数据

            Db::startTrans();
                $p_del=Db::name('pos_playday')->delete($id);
                $fill_del=Db::name('pos_holiday')->delete($holidayInfo);
                $holiday_del=Db::name('pos_fillworkday')->delete($fillworkInfo);
      
                if($fill_del && $holiday_del && $p_del){
                    $reslut['status']='1';
                    $reslut['msg']='操作成功';
                    Db::commit();
                }else{
                    $reslut['status']='0';
                    $reslut['msg']='操作失败';
                    Db::rollback();
                }
            return json($reslut);
        }
    }

}