<?php
namespace Home\Controller;

class ChannelDataController extends HomeController {
    //列表
    public function index(){
        $model = D('Channeldata');
        $Channellist=$model -> channelList();
        $this -> assign('list',$Channellist);
        $this ->display();
    }

    //数据添加
 public function _insert(){

        if ($_POST) {
            $opmode = $_POST['opmode'];
            $model=D('Channeldata');
            $data['dept_id'] = $_POST['dept_id'];
            $data['showroom'] = $_POST['showroom'];
            $data['self_store'] = $_POST['self_store'];
            $data['tel_group'] = $_POST['tel_group'];
            $data['big_consumer'] = $_POST['big_consumer'];
            $data['outer_permit'] = $_POST['outer_permit'];
            $data['inputtime'] = strtotime($_POST['inputtime']);
            $data['add_time']=time();
            if ($opmode == "add") {
                $list = $model->add($data);
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
    public function edit($id) {
        $model=D('Channeldata');
        $Alldept=$model->Alldept();
        $res=$model->Singleinfo($id);
        $this->assign('list',$res);
        $this->assign('Alldept',$Alldept);
        $this->display();
    }

    public function _update(){
            $model=M('target_channeldata');
            $id = $_POST['id'];

            $data['dept_id'] = $_POST['dept_id'];
            $data['showroom'] = $_POST['showroom'];
            $data['self_store'] = $_POST['self_store'];
            $data['tel_group'] = $_POST['tel_group'];
            $data['big_consumer'] = $_POST['big_consumer'];
            $data['outer_permit'] = $_POST['outer_permit'];
            $data['inputtime'] = strtotime($_POST['inputtime']);
            // $data['add_time']=time();

//            if (false === $model -> create($data)) {
//                $this -> error($model -> getError());
//            }

            $list = $model->where('id='.$id)-> save($data);
            if (false != $list) {
                $this -> assign('jumpUrl', get_return_url());
                $this -> success('编辑成功!');
                //成功提示
            } else {
                $this -> error('编辑失败!');
                //错误提示
            }
    }
    //下拉店名菜单
    public function add(){
        $model = D('Channeldata');
        $dept = $model->Alldept();

        $this->assign('list',$dept);
        $this ->display();
    }

    //删除
    public function channeldel(){
        $model=D('Channeldata');
        $where['id']=I('post.id');


        $list = $model-> where($where)->delete();

        if (false !== $list) {
            $this -> assign('jumpUrl', get_return_url());

            $this -> success('删除成功!');
            //成功提示
        } else {
            $this -> error('删除失败!');
            //错误提示
        }
    }
}