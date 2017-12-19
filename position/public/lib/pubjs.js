function layer_close(){
            var index=parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        }
//只能输入数字
function clearNoNum(obj)
{
    //先把非数字的都替换掉，除了数字和.
    obj.value = obj.value.replace(/[^\d.-]/g,"");
    //必须保证第一个为数字而不是.
    obj.value = obj.value.replace(/^\./g,"");
    //保证只有出现一个.而没有多个.
    obj.value = obj.value.replace(/\.{2,}/g,".");
    //保证.只出现一次，而不能出现两次以上
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}

//只能输入负数
function myfunction(obj){
    var myreg = /^((-\d+(\.\d+)?)|(0+(\.0+)?))$/;
    if(!myreg.test($(obj).val())){
        $(obj).val('');
    }
}

/*
*预加载弹出框
 */
$(document).ready(function(){
    var tip = '	<div class="shake"></div> <div class="tip_box" id="tip_box"> <div class="tip_title"></div> <div class="cont_box"> </div> <div class="btn_box"> <a class="layui-layer-btn0">确定</a> <a class="layui-layer-btn1">取消</a></div> </div> ';
    $("body").append(tip);
})

/*
 * kpi修改
 * @param
 * datatype  必填  类型格式，text：普通字符串  float：数字类型  date：时间格式类型
 * table_name 必填 数据表表名
 * key_name  必填  键名
 * con  必填  原内容数据
 * type（1，2，3）  必填  1：有表序号id的情况； 2：无表序号id的情况，需要匹配查找定位修改
 * order_num  选填  表序号id (type为1时必填，其它情况下”“)
 * year  选填  年份（type为2时必填带值，为1时填”“）
 * month  选填  月份（type为2时填了年份此处必填，为1时填”“）
 */
function tip_function(datatype,table_name,key_name,con,type,order_num,year,month,store_id,class_name,class_value){			//弹窗修改总方法
    //弹框弹出动画
    $(".shake").show();			//背景层
    switch (datatype){				//判断需要什么类型格式的input属性
        case 'text':
            var inp = '<input type="text" class="add" value="">';
            break;
        case 'float':
            var inp = '<input type="text" class="add" value="" onkeyup="clearNoNum(this)">';
            break;
        case 'date':
            var inp = '<input type="date" class="add" value="">';
            break;
        case 'whether':
            var inp = '<select class="add"><option value="0">否</option><option value="1">是</option></select>';
            break;
        case 'negative':
            var inp = '<input type="text" class="add" value="" onchange="myfunction(this)">';
            break;
        case 'delete':
            var inp = "<div style='width: 80%;height: 50px;line-height:25px; color: red;border:none;box-shadow:none;'>是否确认修改车型，确认后会删除该条数据，请重新添加！";
            break;
    }
    $("#tip_box .tip_title").html('输入修改的新内容<div><i class="icon Hui-iconfont">&#xe706;</i></div>');
    $("#tip_box .cont_box").html(inp);
    $("#tip_box").removeClass("bounceOut").show().addClass("bounceIn");			//弹窗内容层的动画
    $(".cont_box > input.add").val($.trim(con));				//向新的输入框中赋予原内容的值
    $(".tip_title > div > i,a.layui-layer-btn1").click(function(){			//点击关闭或者取消按钮关闭弹出层
        close_tip();
        location.reload();
    });
    $(".layui-layer-btn0").click(function(){			//点击确认按钮提交新的修改内容
        var new_cont = $(".cont_box > .add").val();			//获取修改的内容
        if(new_cont == ''){
            layer.msg("请先填入内容！");
        }else{
            switch (type){
                case 1:
                    var str = '/kpi/index.php/func/Edit/comon_edit';
                    var data = 	{"datatype":datatype,"new_con":new_cont,"table_name":table_name,"key_name":key_name,"order_num":order_num};
                    break;
                case 2:
                    var str = '/kpi/index.php/func/Edit/comon_edit1';
                    var data = 	{"datatype":datatype,
                                "new_con":new_cont,
                                "table_name":table_name,
                                "key_name":key_name,
                                "year":year,            //年份
                                "month":month,          //月份
                                "store_id":store_id,        //门店id
                                "class_name":class_name ,    //分类名称
                                "class_value":class_value
                            };
                    break;
                case 3:
                    var str = '/kpi/index.php/func/Edit/comon_edit2'
                    var data = {
                        "table_name":table_name,
                        "order_num":order_num
                    }
            }

            $.ajax({
                type: 'POST',
                url: str,
                data:data,
                dataType: 'json',
                success: function(data){
                    if(data.status=='1'){
                        close_tip();
                        layer.msg(data.msg);
                        setTimeout("location.reload();",2000);
                    }
                    if(data.status=='0'){
                        close_tip();
                        layer.msg(data.msg);
                        setTimeout("location.reload();",2000);
                    }
                },
                error:function(data) {
                    close_tip();
                    layer.msg("请求修改失败");
                    //setTimeout("location.reload();",2000);
                }
            });
        }
    })
}

function close_tip(){		//关闭弹窗方法
    $(".shake").hide();
    $(".tip_box").removeClass("bounceIn").addClass("bounceOut");
    setTimeout(function(){
        $(".tip_box").hide();
    },400);
}

//清空数据
function clearbutton(){
    var store_name = $("#store_id").find("option:selected").text();

    $(".shake").show();			//背景层
    $("#tip_box .tip_title").html('清空数据<div><i class="icon Hui-iconfont">&#xe706;</i></div>');
    $("#tip_box .cont_box").html("<div style='width: 100%;height: 70px;line-height:70px;'>是否确认删除<span style='color: red;'>"+store_name+"</span>的数据?</div>");
    $("#tip_box").removeClass("bounceOut").show().addClass("bounceIn");			//弹窗内容层的动画
    $(".layui-layer-btn0").click(function(){    //确定删除执行的操作
        var store_id = $("#store_id").val();
        var table_name = $("#table_name").val();
        var str = '/kpi/index.php/func/Clear/'+table_name;
        $.ajax({
            type: 'POST',
            url: str,
            data:{"store_id":store_id},
            dataType: 'json',
            success: function(data){
                if(data.status=='1'){
                    close_tip();
                    layer.msg(data.msg);
                    setTimeout("location.reload();",2000);
                }
                if(data.status=='0'){
                    close_tip();
                    layer.msg(data.msg);
                    setTimeout("location.reload();",2000);
                }
            },
            error:function(data) {
                layer.msg("请求失败");
                //setTimeout("location.reload();",2000);
            }
        });
    });
    $(".tip_title > div > i,a.layui-layer-btn1").click(function(){			//点击关闭或者取消按钮关闭弹出层
        close_tip();
    });
}


//手机端
//			手机端代码
$(document).ready(function(){
    $(".m_search_bar").on("click",function(){
        $(this).fadeOut();
        $(".search_box").show().removeClass("bounceOutUp").addClass("bounceInDown");
    })
})
function cut_out(){
    $(".search_box").removeClass("bounceInDown").addClass("bounceOutUp");
    setTimeout(function(){
        $(".search_box").hide();
        $(".m_search_bar").fadeIn();
    },800)
}
