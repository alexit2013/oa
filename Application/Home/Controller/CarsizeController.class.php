<?php
namespace Home\Controller;

class CarsizeController extends HomeController {
    public function index(){
        $model=D('Carsize');
        $res=$model->SizeList();
        $this->assign('list',$res);
        $this->display();
    }
    public function add(){
        $model=D('Carsize');
        $res=$model->Allserise();
        $this -> assign('Allserise',$res);
        $this ->display();
    }
    public function _insert(){
        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('Carsize');
            $data['carsize_name']=$_POST['caesize_name'];
            $data['carseries_id']=$_POST['serise_id'];
            $res=$model->Onlysize($data['carsize_name']);
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

    public function edit($id){
        $model=D('Carsize');
        $Allserise= $model->Allserise();
        $res=$model->Singleinfo($id);
        $this->assign('Allserise',$Allserise);
        $this->assign('list',$res);
        $this -> display();
    }
    public function _update(){
        $model = D('Carsize');
            $data['id']=$_POST['carsize_id'];
            $data['carsize_name']=$_POST['carsize_name'];
            $data['carseries_id']=$_POST['carseries_id'];
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
    public function sizedel(){
        $model=D('Carsize');
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