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

// 应用公共文件
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
/*
 * 获取当前人员部门id
 */
function get_dept_id($user_id = null) {
	if (empty(session('dept_id'))) {
		$where['id'] = array('eq', $user_id);
                $res = Db::name("User") -> where($where) ->field('dept_id')-> find();
                session('dept_id',$res['dept_id']);
                return $res['dept_id'];
        } else {
		return session('dept_id');
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
* @desc 根据两点间的经纬度计算距离 
* @param float $lat 纬度值 
* @param float $lng 经度值 
*/
function getDistance($lat1, $lng1, $lat2, $lng2) { 
    $earthRadius = 6367000; //地球半径
    $lat1 = ($lat1 * pi() ) / 180; 
    $lng1 = ($lng1 * pi() ) / 180; 

    $lat2 = ($lat2 * pi() ) / 180; 
    $lng2 = ($lng2 * pi() ) / 180; 
    $calcLongitude = $lng2 - $lng1; 
    $calcLatitude = $lat2 - $lat1; 
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
    $stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
    $calculatedDistance = $earthRadius * $stepTwo; 
    return round($calculatedDistance); 
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
/*获取门店*/
function get_comlist(){
    $user_id = get_user_id();
    $map['is_del'] = 0;
    $map['pid'] = 1;
    // $map['id']= ['<>',2];
    if($user_id != 1){
        $map['id'] = session('user.com_id');
    }
    $list = \think\Db::name('dept')->where($map)->select();
    return $list;
}