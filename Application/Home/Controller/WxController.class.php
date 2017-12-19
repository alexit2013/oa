<?php

namespace Home\Controller;
use Think\Controller;

class WxController extends Controller {	
    /*
    * 微信回调
    */
    public function wechat() {
        // $sVerifyMsgSig = HttpUtils.ParseUrl("msg_signature");      
        $sVerifyMsgSig = I('get.msg_signature');
        $sVerifyTimeStamp = I('get.timestamp');
        $sVerifyNonce = I('get.nonce');
        $sVerifyEchoStr = I('get.echostr');               
        // 需要返回的明文，官方给出的，实际没用的参数，最终输出是$sEchoStr
        include_once './Index/Common/Common/wx/WXBizMsgCrypt.php';
        $EchoStr = "";
        $wxcpt = new \WXBizMsgCrypt(C("token"), C("encodingAesKey"), C("corpid"));
        $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        if ($errCode == 0) {
            // 验证URL成功，将sEchoStr返回
            // HttpUtils.SetResponce($sEchoStr);
            writerLogs($sEchoStr,'log','/sEchoStr/success');
            echo $sEchoStr;
        } else {
            writerLogs($errCode, 'log','/sEchoStr/error'); 
            //print("ERR: " . $errCode . "\n\n");
        }
    }
    public function index() {
        $this->show("afd");
    }
    
}
