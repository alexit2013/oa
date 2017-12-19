<?php  
namespace Home\Controller;

class CarseriesController extends HomeController {
    public function index(){
        $model=D('Carseries');
        $res=$model->SeriesList();
        $this->assign('list',$res);
        $this->display();
    }
    //添加
    public function add(){
        $model=D('Carseries');
        $AllBrand= $model->AllBrand();
        $this->assign('brandlist',$AllBrand);
        $this->display();
    }

    public function _insert(){
        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('Carseries');
            $data['carseries_name']=$_POST['carseries_name'];
            $data['is_import']=$_POST['is_import'];
            $data['carbrand_id']=$_POST['brand_id'];
            $res=$model->Onlyseries($data['carseries_name']);
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
        $model=D('Carseries');
        $AllBrand= $model->AllBrand();
        $res=$model->SingleSeries($id);
        $this->assign('AllBrand',$AllBrand);
        $this->assign('list',$res);
        $this->display();
    }

    public function _update(){
        $model = D('Carseries');
            $data['id']=$_POST['carseries_id'];
            $data['carseries_name']=$_POST['carseries_name'];
            $data['is_import']=$_POST['is_import'];
            $data['carbrand_id']=$_POST['brand_id'];
            $res=$model->Onlyseries($data['carseries_name']);
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

    public function seriesdel(){
        $model=D('Carseries');
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