<?php

namespace Home\Controller;

class ProjectController extends HomeController {
    public function index(){
        $data = I('post.');
        $map = $this->_search($data);
        $list = M('project')->where($map)->order('id desc')->select();
        $user_id = get_user_id();
        $userinfo = M('user')->find($user_id);
        if($user_id == 1){
            $maps['PID'] = 1;
        }else{
            $maps['ID'] = $userinfo['com_id'];
        }
        $comlist = M('dept')->field('id,name')->where($maps)->select();
        $this->assign([
            'comlist'=>$comlist,
            'list'=>$list,
            'user_id'=>$user_id
                ]);
        $this->display();
    }
    
    protected function _search($data){
        $user_id = get_user_id();
        $map = array();
        if(empty($data['emp_no'])){
            if($user_id != 1){
                $userinfo = M('user')->find($user_id);
                $map['emp_no'] = $userinfo['emp_no'];
            }
        }else{
            $map['emp_no|name'] = ['like','%'.$data['emp_no'].'%'];
            $this->assign('emp_no',$data['emp_no']);
        }
        if(!empty($data['com_id'])){
            $map['com_id'] = $data['com_id'];
            $this->assign('com_id',$data['com_id']);
        }
        if(empty($data['time'])){
            $start_time = mktime(0, 0, 0, date('n'), 1,date('Y'));
            $end_time = mktime(0, 0, 0, date('n')+1, 1,date('Y'));
        }else{
            $time = explode('-', $data['time']);
            $start_time = mktime(0, 0, 0, (int)$time[1], 1,$time[0]);
            $end_time = mktime(0, 0, 0, (int)$time[1]+1, 1,$time[0]);
            $this->assign('time',$data['time']);
        }
        $map['start_time'][0]= ['EGT',$start_time];
        $map['start_time'][1]= ['ELT',$end_time];
        return $map;
    }
    public function add(){
        if(IS_AJAX){
            $user=M("User")->find(get_user_id());       //获取用户信息
            $dept_name = M("Dept")->where('ID='.$user['dept_id'])->find();                     //链接公司部门表,查找部门名称
            $company = M("Dept")->where('ID='.$user['com_id'])->find();                        //链接公司部门表,查找公司名称
            $position = M("Position")->where('id='.$user['position_id'])->find();             //查询当前用户职务

            $data = I('param.');
            $about = array();
            foreach($data as $k => $v){         //遍历前台有用数据
                $v['start_time'] = strtotime($v['start_time']);
                $v['end_time'] = strtotime($v['end_time']);
                $about[$k] = $v;                 //向about数组中赋值（前台传递的数据）
                $about[$k]['emp_no'] = $user['emp_no'];
                $about[$k]['name'] = $user['name'];
                $about[$k]['user_id'] = $user['id'];
                $about[$k]['com_id'] = $user['com_id'];
                $about[$k]['dept_name'] = $dept_name['name'];
                $about[$k]['company'] = $company['name'];
                $about[$k]['position'] = $position['name'];
                $about[$k]['add_time'] = time();
            }
            foreach($about as $v){
                $res = M('Project')->add($v);      //插入数据
                if(!$res){                              //如果插入失败，返回一个失败提示
                    $reslut['msg']='添加失败!';
                    $reslut['status']='0';
                    $this->ajaxReturn($reslut);
                }
            }
            $reslut['msg']='添加成功';              //添加成功后执行
            $reslut['status']='1';
            $this->ajaxReturn($reslut);

        }else{
            $this->display();
        }
    }
    public function save(){
        if(IS_AJAX){
            $data = I('param.');
            $up['actual_time'] = strtotime($data['actual_time']);
            $up['update_time'] = time();
            $up['remark'] = $data['remark'];
            $up['is_finish'] = $data['is_finish'];
            $res = M('Project')->where("id=".$data['id'])->save($up);
            if(!$res){                              //如果插入失败，返回一个失败提示
                $reslut['msg']='添加失败!';
                $reslut['status']='0';
                $this->ajaxReturn($reslut);
            }else{
                $reslut['msg']='添加成功';              //添加成功后执行
                $reslut['status']='1';
                $this->ajaxReturn($reslut);
            }
        }
        $data = I('get.id');
        $project = M("Project")->where('id='.$data)->find();
        $this->assign("id",$data);
        $this->assign("project",$project);
        $this->display();
    }
}
