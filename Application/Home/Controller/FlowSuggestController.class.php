<?php
/*--------------------------------------------------------------------
 小微OA系统 - 让工作更轻松快乐

 Copyright (c) 2013 https://www.smeoa.com All rights reserved.

 Author:  jinzhu.yin<smeoa@qq.com>

 Support: https://git.oschina.net/smeoa/xiaowei
--------------------------------------------------------------*/

namespace Home\Controller;
use Think\View;
class FlowSuggestController{
    function suggest(){
        $data = I('get.');
        if(IS_POST){
            $data = I('post.');
            $model = M('flow_suggestion');
            $where['flow_id'] = $data['flow_id'];
            $user_suggest = $model->field('emp_no')->where($where)->select(); //已经收集过单据的人员列表
            foreach ($user_suggest as  $v) {
                $user_suggest_list[] = $v['emp_no'];
            }  
            if($data['token'] == session('token')){
                session('token',NULL);
                $insert['flow_id'] = $data['flow_id'];
                $insert['flow_log_id'] = $data['flow_log_id'];
                $insert['question'] = $data['question'];
                $insert['create_time'] = time();
                foreach ($data['user'] as $v){
                    if(!in_array($v['emp'],$user_suggest_list)){
                        $insert['emp_no'] = $v['emp'];
                        $insert['user_name'] = $v['name'];
                        $insert['user_id'] = $v['id'];
                        $usermess[]=$v['emp'];
                        $model->add($insert);
                    }
                }
                $url = "https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Public&a=wxlogin&biao=24&danju_id=".$data['flow_id'];//单据链接
                if(!empty($usermess)){
                    Pushmessage($data['flow_name'].'（单据意见）', '您有一张单据需要提交意见',$url, $usermess);
                }
                $resajax['status'] = 1;
                $resajax['info'] = '提交成功！';
            }else{
                $resajax['status'] = 0;
                $resajax['info'] = '单据正在提交中，请勿重复提交！';
            }
            $this->ajaxReturn($resajax);
        }
        if(empty(session('token'))){
            session('token', md5(microtime(true)));
        } 
        $com_list = $this->com_list();
        $view = new View;
        $view->assign([
            'com_list'=>$com_list,
            'data'=>$data
        ]);
        $view->display();
    }
    function com_list(){
        $map['PID'] = 1;
        $map['IS_DEL'] = 0;
        $com_list = M('dept')->field('id,name')->where($map)->select();
        return $com_list;
    }
    function dept_list(){
        $map['PID'] = I('post.comid');
        $map['IS_DEL'] = 0;
        $dept_list = M('dept')->field('id,name')->where($map)->select();
        $this->ajaxReturn($dept_list);
    }
    function user_list(){
        $map['is_del'] = 0;
        $map['dept_id'] = I('post.comid');
        $user_list = M('user')->field('id,emp_no,name')->where($map)->select();
        $this->ajaxReturn($user_list);
    }
    
    /*提交意见*/
    function flow_suggestion(){
        if(IS_POST){
            $data = I('post.');
            $data['write_time'] = time();
            $res = M('flow_suggestion')->save($data);
            if($res){
                $resajax['status'] = 1;
                $resajax['info'] = '提交成功！';
            }else{
                $resajax['status'] = 0;
                $resajax['info'] = '提交失败！';
            }
            $this->ajaxReturn($resajax);
        }
    }
    protected function ajaxReturn($data,$json_option=0) {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,$json_option);
        exit;
    }
}
