<?php
namespace Home\Controller;

class TargetChartController extends HomeController {
    function index() {
    
        if($_POST){
            $data=I('post.');

            $this->charttable1($data['year'],$data['month']);
            $this->charttable2($data['year'],$data['month']);
            $this->charttable3($data['year'],$data['month']);
        }
        $this->display();
    }
    function charttable1($year,$month) {
            $channeldata_m = D('TargetChart');
            $channeldata_m->table1($year,$month);
    }
    function charttable2($year,$month){
        $channeldata_m = D('TargetChart');
        $channeldata_m->table2($year,$month);
    }
    function charttable3($year,$month){
        $channeldata_m = D('TargetChart');
        $channeldata_m->table3($year,$month);
    }
}