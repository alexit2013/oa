<?php
namespace Home\Model;
use Think\Model;

class ChannelModel extends CommonModel{

    protected $tableName = 'target_channel';

    // protected $autoCheckFields  =  false;   // 是否自动检测数据表字段信息

    //自动验证
    protected $_validate = array(
        array('channel_name','require','验证码必须',1) //必须验证
        );

    public function channelList(){
        return $this -> where("is_del=0")->select();
    }
    
    //验证品牌唯一
    public function OnlyChannel($channel_name){
        $Allchannel=$this -> where(array('channel_name'=>$channel_name,'is_del'=>0))->select();
        return $Allchannel;

    }
    //查找单条信息
    public function Singleinfo($id=null){
        if(empty($id)){

            return false;
        }
        return $this -> find($id);
    }

}