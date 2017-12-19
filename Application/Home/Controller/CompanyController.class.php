<?php
namespace Home\Controller;

class CompanyController extends HomeController {
    //列表
    public function index(){
        $model = D('Company');
        $companylist=$model -> companyList();
        $this -> assign('list',$companylist);
        $this ->display();
    }

    //数据添加
    public function _insert(){
        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('Company');
            $data['company_name']=$_POST['company_name'];
            $res=$model->OnlyCompany($data['company_name']);
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
    public function companyedit() {
        $id=$_GET['id'];
        $model=D('Company');
        $res=$model->Singleinfo($id);
        $this->assign('list',$res);
        $this->display();
    }

    public function _update(){
        $model = D('Company');
            $data['id']=$_POST['id'];
            $data['company_name']=$_POST['company_name'];
            $res=$model->OnlyCompany($data['company_name']);
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

     public function del($id) {

        get_return_url();

    }

    public function companydel(){
        $model=D('Company');
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