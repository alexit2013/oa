<?php
namespace Home\Controller;

class ChannelController extends HomeController {
    //列表
    public function index(){
        $model = D('Channel');
        $Channellist=$model -> channelList();
        $this -> assign('list',$Channellist);
        $this ->display();
    }

    //数据添加
    public function _insert(){

        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('Channel');
            $data['channel_name']=$_POST['channel_name'];
            $res=$model->OnlyChannel($data['channel_name']);
            if(!empty($res)){
               $this -> assign('jumpUrl',get_return_url());
               $this -> error('新增失败,名称不能重复!');
            }
            $data['add_time']=time();
            if (false === $model -> create($data)) {
                $this -> error($model -> getError());
            }
            if ($opmode == "add") {
                $list = $model->add();
                if ($list !== false) {//保存成功
                    $this -> assign('jumpUrl',get_return_url());
                    $this -> success('新增成功!');
                } else {
                    $this -> error('新增失败!');
                    //失败提示
                }
            }
        }
    }
    /**编辑页面 **/
    public function channeledit() {
        $id=$_GET['id'];
        $model=D('Channel');
        $res=$model->Singleinfo($id);
        $this->assign('list',$res);
        $this->display();
    }

    public function _update(){
        $model = D('Channel');
            $data['id']=$_POST['id'];
            $data['channel_name']=$_POST['channel_name'];
            $res=$model->OnlyChannel($data['channel_name']);
            if(!empty($res)){
               $this -> assign('jumpUrl',get_return_url());
               $this -> error('新增失败,品牌不能重复!');
            }
            if (false === $model -> create($data)) {
                $this -> error($model -> getError());
            }

            $list = $model -> save();
            if (false !== $list) {
                $this -> assign('jumpUrl', get_return_url());
                $this -> success('编辑成功!');
                //成功提示
            } else {
                $this -> error('编辑失败!');
                //错误提示
            }

    }


    //删除
    public function channeldel(){
        $model=D('Channel');
        $where['id']=$_POST['id'];
        $where['is_del'] =1;
        // if (false === $model -> create($where)) {
        //     $this -> error($model -> getError());
        // }
        $list = $model-> save($where);
        if (false !== $list) {
            $this -> assign('jumpUrl', get_return_url());
            $this -> success('编辑成功!');
            //成功提示
        } else {
            $this -> error('编辑失败!');
            //错误提示
        }
    }
}