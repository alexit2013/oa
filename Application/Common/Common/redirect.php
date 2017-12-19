<?php
/*
 * 根据参数页面跳转方法
 * @param $data 跳转参数：0.发起申请 1.待审批 2.已审批 3.草稿箱 4.审批报告 5.参阅箱 6.已提交 20.审批通过，21.被否决 22.已审批单据，23抄送单据，24.审批意见单据,25.意见单据列表
 *                        30.读取发文,31.集团发文，32.集团公告，33.集团人事，34.集团办公室
 *                        41.车系金融基础三项指标表42.车系渗透率指标表43.车系ASP指标表44.车系台次指标表45.车系收费指标表
 */
function redirect_func($data,$id) {
           
    switch ($data){
        case '0':   //0.发起申请
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index");
            break;
        case '1':   //1.待审批
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=confirm");
            break;
        case '2':   //2.已审批
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=finish");
            break;
        case '3':   //3.草稿箱
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=darft");
            break;
        case '4':   //4.审批报告
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=report");
            break;
        case '5':   //5.参阅箱
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=receive");
            break;
        case '6':   //6.已提交
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=submit");
            break;
        case '20':  //20.审批通过
             header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=read&fid=confirm&id=".$id);
             break;
        case '21':  //21.被否决
             header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=read&fid=submit&id=".$id);
             break;
        case '22':  //22.已审批单据
             header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=read&fid=finish&id=".$id);
             break;
         case '23': //23抄送单据
             header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=read&fid=refer&id=".$id);
             break;
        case '24':  //24.审批意见单据
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=read&fid=suggestion&id=".$id);
            break; 
        case '25':  //25.意见单据列表
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=folder&fid=suggestion");
            break; 
        case '30':  //30.读取发文
             header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Info&a=read&id=".$id);
             break; 
         case '31': //31.集团发文
             header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=info&a=folder&fid=82");
             break;  
        case '32':  //32.集团公告
           header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=info&a=folder&fid=85");
           break; 
        case '33':  //33.集团人事
           header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=info&a=folder&fid=83");
           break;  
        case '34':  //34.集团办公室
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=info&a=folder&fid=84");
        case '41'://41.车系金融基础三项指标表
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=target&a=chart2");
            break;
        case '42'://42.车系渗透率指标表
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=target&a=chart3");
            break;
        case '43'://43.车系ASP指标表
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=target&a=chart4");
            break;
        case '44'://44.车系台次指标表
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=target&a=chart5");
            break;
        case '45'://45.车系收费指标表
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=target&a=chart6");
            break;
        case '46'://46.报表导航
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=target&a=nav");
            break;
        case '51'://51.异常
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index&type=1");
            break;
        case '52'://51.加班
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index&type=2");
            break;
        case '53'://51.调休
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index&type=3");
            break;
        case '54'://51.请假
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index&type=4");
            break;
        case '55'://51.公出
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index&type=5");
            break;
        case '56'://51.出差
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php?m=&c=Flow&a=index&type=6");
            break;
        default :
            header("Location:https://".$_SERVER['SERVER_NAME']."/index.php/Home/Index/index");
    }
}
