<?php
namespace app\login\controller;
use think\Controller;

class Weixin extends Controller{
     /*
    * 微信回调
    */
    public function wechat() {
        // $sVerifyMsgSig = HttpUtils.ParseUrl("msg_signature");      
        $sVerifyMsgSig = input('param.msg_signature');
        $sVerifyTimeStamp = input('param.timestamp');
        $sVerifyNonce = input('param.nonce');
        $sVerifyEchoStr = input('param.echostr');               
        // 需要返回的明文，官方给出的，实际没用的参数，最终输出是$sEchoStr
        include_once $_SERVER['DOCUMENT_ROOT'].'/Application/Common/Common/wx/WXBizMsgCrypt.php';
        $EchoStr = "";
        $wxcpt = new \WXBizMsgCrypt(Config("wx_config.token"), Config("wx_config.encodingAesKey"), Config("wx_config.corpid"));
        $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        if ($errCode == 0) {
            echo $sEchoStr;
        } else {
            print("ERR: " . $errCode . "\n\n");
        }
    }

    /*
     * 微信回调登录
     */
    public function wxlogin() {
        $appid = Config('wx_config.corpid');
        $biao = input('param.biao');
        $danju_id = input('param.danju_id');
        $flow_log_id = input('param.flow_log_id');
        $yiban = input('param.yiban');
        $store_id = input('param.store_id');
        $url_str= request()->domain()."/kpi/index.php/login/weixin/wxcallback/biao/".$biao;
        if(!empty($danju_id)){
            $url_str = $url_str."/danju_id/".$danju_id;
        }
        if(!empty($flow_log_id)){
            $url_str = $url_str."/flow_log_id/".$flow_log_id;
        }
        if(!empty($yiban)){
            $url_str = $url_str."/yiban/".$yiban;
        }
        if(!empty($store_id)){
            $url_str = $url_str."/store_id/".$store_id;
        }
        $redirect_url = urlencode($url_str);
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_url.'&response_type=code&scope=snsapi_base&state=kpi#wechat_redirect';
	header("Location:".$url);
        exit;
    }
    public function wxcallback() {
        $biao = input('param.biao');
        $danju_id = input('param.danju_id');
        $log_id = input('param.flow_log_id');
        $store_id = input('param.store_id');
        $user = tp_wxcallback();
        $loginname = $user["UserId"];

        $Login_m = new \app\login\model\Login();
        $res = $Login_m->check_weixin($loginname); //登录
        if($res){
            $this->redirect_url($biao,$danju_id,$log_id,$store_id);
        }  else {
            $this->error("登录失败！");
        }
    }
    /*
    * kpi跳转地址
    * @param $data 跳转参数： 
    */
    private function redirect_url($biao,$danju_id='',$log_id='',$store_id=''){
        switch ($biao){
            case '0': //发起审批
                $this->redirect('workflow/flow/add');
                break;
            case '1': //代办
                $this->redirect('workflow/flow/pend');
                break;
            case '2': //已办
                $this->redirect('workflow/flow/finish');
                break;
            case '3': //我的审批
                $this->redirect('workflow/flow/read'); 
                break;
            case '4':   //查看单据
                $this->redirect('func/check/win2',['id'=>$danju_id,'flow_log_id'=>$log_id]);
                break;
            case '5':   //我的审批单据详情
                $this->redirect('func/check/win1',['flow_id'=>$danju_id]);
                break;
            case '11': //月毛利率预算表
                $this->redirect('chart/marginbudget/index');
                break;
            case '12': //费用预算表
                $this->redirect('chart/costbudget/index');
                break;
            case '13': //利润预算表
                $this->redirect('chart/profitbudget/index');
                break;
            case '14': //月毛利率预算表带门店
                $this->redirect('chart/marginbudget/index',['store_id'=>$store_id]);
                break;
            case '15':  //管理报表
                $this->redirect('func/chart/index');
                break;
            case '16': //售后重点经营指标
                $this->redirect('chart/runtarget/index');
                break;
            case '17': //市占率与满意度
                $this->redirect('chart/marketsatisfield/index');
                break;
            case '18': //费用预算表带门店
                $this->redirect('chart/costbudget/index',['store_id'=>$store_id]);
                break;
            case '19': //利润预算表带门店
                $this->redirect('chart/profitbudget/index',['store_id'=>$store_id]);
                break;
            case '20': //市占率与满意度带门店
                $this->redirect('chart/marketsatisfield/index',['store_id'=>$store_id]);
                break;
            case '21': //售后重点经营指标带门店
                $this->redirect('chart/runtarget/index',['store_id'=>$store_id]);
                break;
            case '22': //厂家任务带门店
                $this->redirect('chart/vendor/index',['store_id'=>$store_id]);
                break;
            case '23': //车型库龄表带门店
                $this->redirect('chart/carseriesposage/index',['store_id'=>$store_id]);
                break;
            case '24': //返利计算表带门店
                $this->redirect('chart/rebate/index',['store_id'=>$store_id]);
                break;
            case '25': //三个月滚动库存(整车)带门店
                $this->redirect('chart/threerollcar/index',['store_id'=>$store_id]);
                break;
            case '26': //整车毛利测算表
                $this->redirect('chart/carprofit/index',['store_id'=>$store_id]);
                break;
            case '27': //三个月滚动库存(配件)带门店
                $this->redirect('chart/threerollparts/index',['store_id'=>$store_id]);
                break;
            case '28': //市场营销预算带门店
                $this->redirect('chart/marketbudget/index',['store_id'=>$store_id]);
                break;
            case '29': //车辆费用带门店
                $this->redirect('chart/vehiclecost/index',['store_id'=>$store_id]);
                break;
            case '30': //税金测算表带门店
                $this->redirect('chart/targetmeasure/index',['store_id'=>$store_id]);
                break;
            case '31': //应收账款账龄表带门店
                $this->redirect('chart/account/index',['store_id'=>$store_id]);
                break;
            default :
                $this->redirect('home/index/index');
                break;
        }
    }
}
