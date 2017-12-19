<?php 
/**
 * 日志类
 * @package_log    log
 * 调用方式
 * vendor('Log.Log');
 * \Log::wirter('日志文件');
 */
class Log 
{ 
    /**
     * 日志文件大小限制
     * @var int 字节数
     */
    private static $log_size = 1048576; // 1024 * 1024 * 5 = 5MB 
         
    /**
     * 设置单个日志文件大小限制
     * 
     * @param int $size 字节数
     */
    public static function set_size($size) 
    { 
        if( is_numeric($size) ){ 
            self::$log_size = $size; 
        } 
    } 
     
    /**
     * 写日志
     *
     * @param string $log_message 日志信息
     * @param string $log_type    日志类型
     */
    public static function writer($log_message, $log_type ,$path) 
    { 
        
        if(empty($log_type)){
            $log_type = 'log';
        }
        define('__LOG_PATH__', './Logs/'.ucwords($log_type)."/");
        // 检查日志目录是否可写 
       if(empty($path)){
            $path = __LOG_PATH__.'Public/';
        }else{
            $path = __LOG_PATH__.$path.'/';
        }
         if ( !file_exists($path) ) { 
            @mkdir($path,0777,true);      
        } 
        if (!is_writable($path)) exit('LOG_PATH is not writeable !'); 
        $s_now_time = date('[Y-m-d H:i:s]'); 
        $log_now_day  = date('Y_m_d'); 
        // 根据类型设置日志目标位置 
        $log_path   = $path; 
        switch($log_type) 
        { 
            case 'debug': 
                $log_path .= 'Out_' . $log_now_day . '.xml'; 
                break; 
            case 'error': 
                $log_path .= 'Err_' . $log_now_day . '.xml'; 
                break; 
            case 'log': 
                $log_path .= 'Log_' . $log_now_day . '.xml'; 
                break; 
            case 'every_page': 
                $log_path .= 'every_page_' . $log_now_day . '.xml'; 
                break;
            case 'quality': 
                $log_path .= 'quality_' . $log_now_day . '.xml'; 
                break;
            case 'pay_ok': 
                $log_path .= 'pay_ok_' . $log_now_day . '.xml'; 
                break;
            case 'pay_error': 
                $log_path .= 'pay_error' . $log_now_day . '.xml'; 
                break;
            default: 
                $log_path .= 'Log_' . $log_now_day . '.xml'; 
                break; 
        } 
             
        //检测日志文件大小, 超过配置大小则重命名 
        if (file_exists($log_path) && self::$log_size <= filesize($log_path)) {
            $s_file_name = substr(basename($log_path), 0, strrpos(basename($log_path), '.log')). '_' . time() . '.log'; 
            rename($log_path, dirname($log_path) . DS . $s_file_name);
        }
        clearstatcache();
        // 写日志, 返回成功与否 
        $log_message = is_array($log_message)?self::ToXml($log_message):$log_message;
        return error_log("$s_now_time\n $log_message\n\n", 3, $log_path); 
    } 
    
        /**
	 * 输出xml字符
	 * @throws WxPayException
	**/
	public static function ToXml($arr)
	{
		if(!is_array($arr) 
			|| count($arr) <= 0)
	      {
    		throw new Exception("数组数据异常！");
    	       }
               	$xml = "<xml>"."\n";
    	foreach ($arr as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="  <".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="  <".$key."><![CDATA[".$val."]]></".$key.">";
    		}
                $xml.="\n";
        }
        $xml.="</xml>";
        return $xml; 
        }

}