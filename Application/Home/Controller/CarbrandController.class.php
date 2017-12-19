<?php
namespace Home\Controller;

class CarbrandController extends HomeController {
    //列表
    public function index(){
        $model = D('Carbrand');
        $brandlist=$model -> carbrandList();
        $this -> assign('list',$brandlist);
        $this ->display();
    }

    //数据添加
    public function _insert(){
        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('Carbrand');
            $data['carbrand_name']=$_POST['carbrand_name'];
            $res=$model->OnlyBrand($data['carbrand_name']);
            if(!empty($res)){
               $this -> assign('jumpUrl',get_return_url());
               $this -> error('新增失败,品牌不能重复!');
            }
            $data['add_time']=time();
            if (false === $model -> create($data)) {
                $this -> error($model -> getError());
            }
            if ($opmode == "add") {
                $list = $model -> add();
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
    public function caredit() {
        $id=$_GET['id'];
        $model=D('Carbrand');
        $res=$model->Singleinfo($id);
        $this->assign('list',$res);
        $this->display();
    }

    public function _update(){
        $model = D('carbrand');
            $data['id']=$_POST['id'];
            $data['carbrand_name']=$_POST['carbrand_name'];
            $res=$model->OnlyBrand($data['carbrand_name']);
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
    public function cardel(){
        $model=D('Carbrand');
        $where['id']=$_POST['id'];
        $where['is_del'] =1;
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
