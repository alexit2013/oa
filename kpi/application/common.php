<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
require_once $_SERVER['DOCUMENT_ROOT'].'/Application/Common/Common/JSSDK.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Application/Common/Common/redirect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Application/Common/Common/wx/Material.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Application/Common/Common/wx/SendMessage.php';
// 应用公共文件
/*
 * redis基本操作
 * @param $name string redis键
 * @param $value string redis值
 * @param $time string redis设置时间
 */
function tp_redis($name,$value="",$time=""){
    $redis = new \Redis();
    $redis->connect(Config('redis.redis_url'), Config('redis.redis_port'));
    $redis->select(Config('redis.redis_db'));
    // $redis->auth('password'); # 如果没有密码则不需要这行
    if(empty($value)){
        $data = $redis->get($name);
        return $data;
    }else{
        if(empty($time)){
            $redis->set($name,$value);
        }  else {
            $redis->setex($name,$time,$value);
        }
    }  
}
/** 
  * 根据时间戳返回星期几 
  * @param string $time 时间戳 
  * @return 星期几 
  */
function weekday($time){ 
   if(is_numeric($time)) { 
        $weekday = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六'); 
        return $weekday[date('w', $time)]; 
    } 
    return false; 
} 
function get_user_id(){
    $user = session('user');
    return $user['id'];
}
function get_com_id(){
    $user = session('user');
    return $user['com_id'];
}
/*获取门店*/
function get_comlist(){
    $user_id = get_user_id();
    $com_id = get_com_id();
    $emp_no=get_emp_no();
    $map['is_del'] = 0;
    $map['kpi_is_del']=0;
    $map['pid'] = 1;
    $map['id']= ['<>',2];
    if($user_id != 1){  //非管理员
        if($com_id != 2){   //非集团员工
            $com_data = \think\Db::name('kpi_com')->where('emp_no',$emp_no)->find();
            if(empty($com_data)){
                $map['id']=$com_id;
            }else{
                $map['id'] = ['IN',$com_data['com_ids']];
            } 
            // $map['id'] = $com_id;
        }
    }

    $list = \think\Db::name('dept')->where($map)->select();
    return $list;
}
/*
 * 获取当前人员部门id
 */
function get_dept_id($user_id = null) {
    if (empty(session('user.dept_id'))) {
        $where['id'] = array('eq', $user_id);
                $res = \think\Db::name("User") -> where($where) ->field('dept_id')-> find();
                session('dept_id',$res['dept_id']);
                return $res['dept_id'];
        } else {
        return session('user.dept_id');
    }
}
/*
 * 将数组转为树形结构
 */
function list_to_tree($list, $root = 0, $pk = 'id', $pid = 'pid', $child = '_child') {
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = 0;
            if (isset($data[$pid])) {
                $parentId = $data[$pid];
            }
            if ((string)$root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}
/*
 * 将树转为列表
 */
function popup_tree_menu($tree, $level = 0) {
    $level++;
    $html = "";
    if (is_array($tree)) {
        $html = "<ul class=\"tree_menu level$level\">\r\n";
        foreach ($tree as $val) {
            if (isset($val["name"])) {
                $title = $val["name"];
                $id = $val["id"];
                if (empty($val["id"])) {
                    $id = $val["name"];
                }
                if (!empty($val["is_del"])) {
                    $del_class = "is_del";
                } else {
                    $del_class = "";
                }
                if (isset($val['_child'])) {
                    $html = $html . "<li>\r\n<a class=\"$del_class\" node=\"$id\" ><i class=\"fa fa-angle-right level$level\"></i><span>$title</span></a>\r\n";
                    $html = $html . popup_tree_menu($val['_child'], $level);
                    $html = $html . "</li>\r\n";
                } else {
                    $html = $html . "<li>\r\n<a class=\"$del_class\" node=\"$id\" ><i class=\"fa fa-angle-right level$level\"></i><span>$title</span></a>\r\n</li>\r\n";
                }
            }
        }
        $html = $html . "</ul>\r\n";
    }
    return $html;
}
/**
 * Excel导入
 */
function import_excel($filePath){
    vendor("phpexcel_vendor.PHPExcel");
    /**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
     // $PHPReader = new \PHPExcel_Reader_Excel2007();
      if(empty($filePath) or !file_exists($filePath)){die('文件不存在');}
        $PHPReader = new \PHPExcel_Reader_Excel2007();        //建立reader对象
        if(!$PHPReader->canRead($filePath)){
                $PHPReader = new \PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($filePath)){
                        echo 'Excel不存在!';
                        return ;
                }
        }

    $PHPExcel = $PHPReader->load($filePath);     
    return $PHPExcel;
}
/**
 * excel时间转PHP格式
 * @param type $data
 * @param type $str
 * @return type
 */

function dateToPHP($data,$str){
    /*导入phpExcel核心类 */
    vendor("phpexcel_vendor.PHPExcel");
    return gmdate($str,\PHPExcel_Shared_Date::ExcelToPHP($data));
}
    /**
     * 读取XLS文件
     */
    function read_xls($filename = NULL){
        if(!$filename){
            return false;
        }
        $handle=fopen($filename,'r');
        if(!$handle){
            return false;
        }
        $result = input_xls($handle); //解析xls
        return $result;
    }

    /**
     * 解析xls
     * @param type $handle
     * @return type
     */
    function input_xls($handle) {
        $out = array ();
        $n = 0;
        while ($data = fgetcsv($handle, 10000)) {
            $num = count($data);
            for ($i = 0; $i < $num; $i++) {
                $out[$n][$i] = $data[$i];
            }
            $n++;
        }
        return $out;
    }
    
    /**
 * 根据数字获取对应大写字母
 * $num 数字
 * $moda 模式默认为大写
 */
function getalphnum($num,$moda){
    if($num == NULL){
        return FALSE;
        exit;
    }
    if($moda == NULL){
        $array = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ');
    }else{
        $array=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','aa','ab','ac','ad','ae','af','ag','ah','ai','aj');
    }
    $letter = 'A';
    foreach ($array as $key=>$value){
        if($key == $num-1){
            $letter = $value;
            break;
        }
    }
    return $letter;
}
/*三月滚动库存整车*/
function threerollcar($data){
    $res = "";
    switch ($data) {
        case 'three_month':
            $res = '90天以上的超期';
            break;
        case 'six_month':
            $res = '180天以上的超期';
            break;
        case 'one_year':
            $res = '一年以上的超期';
            break;
        case 'two_year':
            $res = '两年以上的超期';
            break;
        case 'bank_bill':
            $res = '银行票据';
            break;
        case 'cash':
            $res = '现金';
            break;
        case 'financing':
            $res = '厂家融资';
            break;
    }
    return $res;
}
/*三月滚动库存配件*/
function threerollparts($data){
    $res = "";
    switch ($data) {
        case 'boutique':
            $res = '装饰美容精品件';
            break;
        case 'maintain':
            $res = '保养';
            break;
        case 'metal':
            $res = '钣喷';
            break;
        case 'repair':
            $res = '一般维修（除保养、钣喷）';
            break;
        case 'oil':
            $res = '机油';
            break;
        case 'chemical':
            $res = '化学品';
            break;
        case 'battery':
            $res = '电瓶';
            break;
        case 'tyre':
            $res = '轮胎';
            break;
        case 'total':
            $res = '小计';
            break;
    }
    return $res;
}
//全部返利名称
function getrebatename(){
       return  \think\Db::name('kpi_rebatename')->where('is_del=0')->select();
}

//三维数组，二维和三维键值互换
function rotate($a) {
    $b = array();
    if (is_array($a)) {
        foreach ($a as $val) {
            foreach ($val as $k => $v) {
                $b[$k][] = $v;
            }
        }
    }
    return $b;
}

function get_dept_name() {
        $result = \think\Db::name("Dept") ->where('id',session("user.dept_id"))->find();
        return $result['NAME'];
}


function get_emp_no($user_id = null) {
    if (empty($user_id)) {
        $emp_no = session("user.emp_no");
        return isset($emp_no) ? $emp_no : 0;
    } else {
        $where['id'] = array('eq', $user_id);
        return \think\Db::name("User") -> where($where) -> value('emp_no');
    }
}
function get_user_name($user_id = null) {
    if (empty($user_id)) {
        $user_name = session('user.name');
        return isset($user_name) ? $user_name : 0;
    } else {
        $where['id'] = array('eq', $user_id);
        return \think\Db::name("User") -> where($where) -> value('name');
    }
}

function get_dept_id1() {
        $user_name = session('user.dept_id');
        return isset($user_name) ? $user_name : 0;
}
function getUserNameByempNo($emp_no=null){
        if(!empty($emp_no)){
            $res= \think\Db::name('user')->field('id,name,pic')->where('emp_no',$emp_no)->find();
            return $res;
        }
}
/*
 * 微信授权登录回调方法
 */
function tp_wxcallback(){   
    $access_token = tp_getAccess_Token();
    $code=input('param.code');
    $get_user_info_url = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token='.$access_token.'&code='.$code;
    $res = tp_http($get_user_info_url);
    $user = json_decode($res,true);
    return $user;
}
/*推送消息*/
 function Pushmessage($title,$description,$url,$usermess){
     $token = tp_getAccess_Token();
     $sendMessage = new SendMessage($token);
     return $sendMessage->sendNews(Config('wx_config.appid'), array(array('title'=>$title, 'description'=>$description, 'url'=>$url)),$usermess);
 }
 /*
 * 获取Access_Token
 * return access_token 微信token
 */
function tp_getAccess_Token() {
    $access_token = tp_redis('kpi_access_token');
    if(empty($access_token)){
        $corpid = Config('wx_config.corpid');
        $secret = Config('wx_config.secret');
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$corpid.'&corpsecret='.$secret;
        $info = tp_http($url);
        $data = json_decode($info,true);
        tp_redis('kpi_access_token',$data['access_token'],6800);
        return $data['access_token'];  
    }else{
        return $access_token;
    }  
}
/*get请求*/
function tp_http($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER,0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
    $temp= curl_exec($curl);
    curl_close($curl);
    return $temp;
}

//报表审批是否通过(整年)
function  check_flow_year($map){
    if(!empty($map)){
        $res=\think\Db::name('kpi_chart_deptstatus')->alias('a')
              ->field('a.id,a.year,a.month,a.status,a.emp_no')
              ->join('kpi_chart_type b','a.chart_type_id=b.id','LEFT')
              ->where($map)
              ->select();
        $map['month']=date('n');
        $rest=check_flow_month($map);
            
        $data_list=array();
        $data_up=array();
        $months  = flow_month();
        foreach ($res as $value) {
            $data_list[$value['month']] = $value;
        }
        foreach ($months as $key => $value) {
            if(isset($data_list[$value])){
                if($data_list[$value]['emp_no'] == get_emp_no()){
                    $data_up[$value] = $data_list[$value]['status'];
                }else{
                    $data_up[$value] = 0;
                }
            }else{
                if($value == date('n')){
                    $data_up[$value] = 2;
                }else{
                    $data_up[$value] = 0;
                }
                
            }
        }
        $recoure['update_list']=$data_up;
        $recoure['status_list']=$rest;
        
        return $recoure;

    }
}

//报表审批是否通过(单月)
function check_flow_month($map){
    if(!empty($map)){
        $res=\think\Db::name('kpi_chart_deptstatus')->alias('a')
                  ->field('a.year,a.month,a.status,b.type,a.emp_no')
                  ->join('kpi_chart_type b','a.chart_type_id=b.id','LEFT')
                  ->where($map)
                  ->find();
        return $res;
    }
}
//经营报表审批是都通过
function operate_chart($map){
    if(!empty($map)){
        $res=\think\Db::name('kpi_chart_status')->where($map)->find();
        return $res;
    }
}
//管理报表和分表审批状态
function is_pass($data){
    if(empty($data)){
        echo  '<span style="color:red;">(未发起审批)</span>';
    }else{
        if($data['status']=='0'){
            echo  '<span style="color:red;">(正在审批中)</span>';
        }elseif ($data['status']=='1') {
            echo  '<span style="color:red;">(审批通过)</span>';
        }elseif($data['status']=='2'){
            echo  '<span style="color:red;">(审批未通过)</span>';
        }
    }
}
//经营报表审批状态
function is_operateis_pass($data){
    if(empty($data)){
        echo  '<span style="color:red;">(审批未通过)</span>';
    }else{
        echo  '<span style="color:red;">(审批通过)</span>';
    }
}
//月
function flow_month(){
    $flow_month=array();
    for ($i=1; $i <=date('n') ; $i++) { 
        $flow_month[]=$i;
    }
    return $flow_month;
}
//整年的管理报表状态
function allyear_pass($data){
    $month=flow_month();
    if(empty($data)){
        echo  '<span style="color:red;">(审批未通过)</span>';
    }else{
        foreach ($month as $key => $value) {
            if(isset($data[$value]) && $data[$value]=='0'){
                echo  '<span style="color:red;">(正在审批中)</span>';
                break;
            }elseif(isset($data[$value]) && $data[$value]=='1'){
                echo  '<span style="color:red;">(审批通过)</span>';
                break;
            }elseif(isset($data[$value]) && $data[$value]=='2'){
                echo  '<span style="color:red;">(审批未通过)</span>';
                break;
            }
        }
    }

}