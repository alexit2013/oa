<?php
namespace Home\Controller;

class SeriesdataController extends HomeController {
    //列表
    public function index(){
        $res=$this->SeriesdataList();
        $this -> assign('list',$res);
        $this ->display();
    }
    private function SeriesdataList(){
          $is_jituan=M('dept')->where("id={$_SESSION['com_id']}")->find();
           
        if($is_jituan['id']== 2 || $is_jituan['pid']== 2 || $is_jituan== null){
            $where['a.is_del']=array('EQ',0);
        }else{
           $deptmodel=M('dept');
            $deptsingle=$deptmodel->field('pid,name')->where("id={$_SESSION['dept_id']}")->find();
            $where['a.dept_id']=array('EQ',$deptsingle['pid']);
        }
        $model=M('target_seriesdata');
         $list=$model ->alias('a')
                ->field('a.*,b.NAME as dept_name,f.carbrand_name,j.carseries_name')
                ->join('LEFT JOIN think_dept b ON a.dept_id=b.id')
                ->join('LEFT JOIN think_target_carbrand f ON a.carbrand_id=f.id')
                ->join('LEFT JOIN think_target_carseries j ON a.carserie_id=j.id')
                ->where($where)
                ->select();
            return $list; 
    }

    public function add(){
        $model=D('SeriesData');
        $Alldept=$model->Alldept();
        $Allcarbrand=$model->Allcarbrand();
        $Allcarseries=$model->Allcarseries();
        $this -> assign('list',array(
            'Alldept'=>$Alldept,
            'Allcarbrand'=>$Allcarbrand,
            'Allcarseries'=>$Allcarseries
            ));
        $this ->display();
    }
    //品牌找车系
    public function Singlebrand($brand_id){
        $model=M('target_carseries');
        $res=$model-> table('think_target_carseries')
            ->where(array('carbrand_id'=>$brand_id,'is_del'=>0))
            ->select();
        if(!empty($res)){
            $msg['status']=1;
            $msg['info']=$res;
        }
       $this->ajaxReturn($msg);
    }

    public function _insert(){
        if ($_POST) {
            $opmode = $_POST["opmode"];
            $model=D('SeriesData');
            $data['dept_id']=$_POST['dept_id'];
            $data['carbrand_id']=$_POST['brand_id'];
            $data['carserie_id']=$_POST['series_id'];
            $data['number']=$_POST['num'];
            $data['inputtime']=strtotime($_POST['inputtime']);
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
     public  function edit($id){
        $model=D('SeriesData');
        $Onlyseries=$model->Singleinfo($id);
        $Alldept=$model->Alldept();
        $Allcarbrand=$model->Allcarbrand();
        $Allcarseries=$model->Allcarseries();
        $this -> assign('list',array(
            'Alldept'=>$Alldept,
            'Allcarbrand'=>$Allcarbrand,
            'Allcarseries'=>$Allcarseries,
            'Onlyseries'=>$Onlyseries
            ));
        $this->display();
    }

    public function _update(){
        $model=D('SeriesData');
            $data['id']=$_POST['id'];
            $data['dept_id']=$_POST['dept_id'];
            $data['carbrand_id']=$_POST['brand_id'];
            $data['number']=$_POST['num'];
            $data['carserie_id']=$_POST['series_id'];
            $data['inputtime']=strtotime($_POST['inputtime']);
            if (false === $model -> create($data)) {
                $this -> error($model -> getError());
            }
           
            $list = $model -> save();
            if (false != $list) {
                $this -> assign('jumpUrl', get_return_url());
                $this -> success('编辑成功!');
                //成功提示
            } else {
                $this -> error('编辑失败!');
                //错误提示
            }
        }
    public function seriesdatadel(){
            $model=D('SeriesData');
            $ids=$_POST['id'];
            $idx=implode(',',$ids);
            $list = $model-> delete("$idx");
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