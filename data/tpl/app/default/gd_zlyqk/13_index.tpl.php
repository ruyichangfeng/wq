<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("o_header", TEMPLATE_INCLUDEPATH)) : (include template("o_header", TEMPLATE_INCLUDEPATH));?>
<style>
    .other img{width: 30px;height: 30px;}
    .img img{border-radius: 17.5px;}
    .alert{position: fixed;left: 10%;width: 80%;top:80px;height: 300px;z-index: 9999;}
    .alert .title{height: 50px;line-height: 50px;text-align: center;background: #f08500;color:#fff;border-top-left-radius: 5px;border-top-right-radius: 5px;}
    .operate{position: relative;}
    .operate span{height: 35px;line-height: 35px;text-align: center;color: #fff;display: inline-block;}
    .admin_list{height: 200px;background: #fff;padding-top:10px;padding-bottom: 10px;overflow: scroll;padding-left:15px;}
    .searchs{height: 25px;border: 0;width: 60%;margin-left:5%;text-align: center;border-radius: 0;text-align: left;padding-left:10px}
    .buns{width: 20%;margin-left:5px;border: 0;background: #f08500;height:25px;color:#fff;border-radius: 0;padding-left:15px !important;padding-right:15px !important;}

    .sp1{display:inline-block;width: 40%;height: 30px;float: left;text-align: left;color:#818181;font-size: 15px;line-height: 30px;}
    .sp2{display:inline-block;width: 35%;height: 30px;float: left;text-align: left;color:#818181;font-size: 15px;line-height: 30px;}
    .btn-choose{height: 30px;float: left;width: 20%;text-align: center;border:0;background:none;color:#818181;font-size:15px;line-height: 30px;}
    .box li{width: 100%;clear: both;line-height: 25px;}
    .box li img{width: 27px;}
    .cSelect{color:#fff;background: #e22f42;border-radius: 5px;}

    .no_border:before{border:0 !important;}
    .yes_border:before{border-top: 1px solid #e5e5e5;}
</style>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("notice", TEMPLATE_INCLUDEPATH)) : (include template("notice", TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="<?php echo MODULE_URL;?>/static/weui/css/loaders.css"/>
<link rel="stylesheet" href="<?php echo MODULE_URL;?>/static/mp3/css/audioplayer.css" />
<style>
    .weui-cells__tips{line-height: 25px;}
    .weui-cell{background: #FFFFFF !important;color:#999999}
    .topimg img{width: 100%;}
    .layui-m-anim-scale{background: none}
    .layui-m-layerchild{box-shadow: none}
    #stop_rd,#close_rd{    top: 90px;  padding-left: 0;padding-right: 0;font-size: 13px;}
</style>
<div class="page__bd them-page" style="min-height: 100%;" >
    <div class="weui-tab them-tab">
        <div class="weui-tab__panel" style="padding-bottom: 70px;">
            <div>
                <?php  if($appInfo['cover']) { ?>
                <div class="topimg">
                    <img src="<?php  echo $appInfo['cover'];?>">
                </div>
                <?php  } ?>
            <form method="post" id="form" action="<?php  echo $this->createMobileUrl('addInfo')?>">
            <?php  echo $html;?>
            </form>
            </div>
        </div>
        <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("them", TEMPLATE_INCLUDEPATH)) : (include template("them", TEMPLATE_INCLUDEPATH));?>
    </div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("menu", TEMPLATE_INCLUDEPATH)) : (include template("menu", TEMPLATE_INCLUDEPATH));?>
    <div class="alert alert-allot" style="display: none;z-index:999999;">
        <div class="box">
            <div class="title">选择处理人</div>
            <div class="search" style="background:#ddd !important;padding-top:5px;padding-bottom: 5px;">
                <input type="text" class="searchs" placeholder="处理人名字搜索">
                <a type="submit" class="buns" style="padding: 4px;font-size:13px;width:150px;">搜索</a>
            </div>
            <ul class="list admin_list">

            </ul>
            <div class="operate">
                <span href="javascript:" style="width: 50% !important;float: left;background: #f08500" class="btn btn-blue fp">确认</span>
                <span href="javascript:" style="width: 50% !important;float: left;background: #ccc !important;" class="btn btn-blue js_btn-cancle">取消</span>
            </div>
        </div>
    </div>
    <div id="tc" style="background:rgba(0,0,0,0.7);position:fixed;top:0;bottom: 0;width: 100%;z-index:99999;display: none">
    </div>
</div>
<script>
    var countdown=300;
    var types=0;
    $(".price_input").css("display","none");

    $(function(){
        $(".js-signature").on('touchstart',function(e){
            e.preventDefault();
        });

        $(".js-signature").on('touchend',function(e){
            $("body").css({
                "overflow-y": "auto"
            });
        });
    })

    if(price>0){
        $(".pay_text").text(tpls.replace(/#/, price));
    }
    $(".sms_code_get").click(function(){
        var mobile=$("#sms");
        if (mobile.val().length == 0) {
            mobile.focus();
            errorMsg("请填写手机号");
            return false;
        } else {
            if(isPhoneNo(mobile.val()) == false) {
                mobile.focus();
                errorMsg("手机号不正确");
                return false;
            }
        }
        //获取验证码
        $.post("<?php  echo $this->createMobileUrl('getCode')?>",{mobile:mobile.val()},function(response){
            if(response.code==2){
                continu =false;
                errorMsg(response.msg);
            }else{
                settime($(".sms_code_get"));
            }
        },"json");
    });
    function isPhoneNo(phone) {
        var pattern = /^1[34578]\d{9}$/;
        return pattern.test(phone);
    }

    function settime(obj) {
        if (countdown == 0) {
            obj.attr("disabled",false);
            obj.val("获取验证码");
            countdown = 300;
            return;
        } else {
            obj.attr("disabled", true);
            obj.val("重新发送(" + countdown + ")");
            countdown--;
        }
        setTimeout(function() {settime(obj) },1000)
    }

    //确定分配
    $(".fp").click(function(){
        var id = $(".admin_list").find(".slc").attr("data-id");
        var name = $(".admin_list").find(".slc").attr("data-name");
        if(id==undefined){
            errorMsg("请选择");
            $(".alert-allot").fadeOut(1);
            return false;
        }
        if(types==1){
            $("#s_user").val(name);
            $("#user_val").val(id);
        }else if(types==2){
            $("#s_group").val(name);
            $("#group_val").val(id);
        }
        $(".alert-allot").fadeOut(1);
        $("#tc").hide();
    });

    $("body").on('click','.btn-choose',function(){
        $(".btn-choose").find("img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/uncheck.png");
        $(".btn-choose").removeClass("slc");
        $(this).find("img").attr("src","<?php echo MODULE_URL;?>/static/mobile/images/check.png");
        $(this).addClass("slc");
    });

    $(".buns").click(function(){
        var key=$(".searchs").val();
        if(key==""){
            return false;
        }
        if(types==1){
            addAdminList(key);
        }else if(types==2){
            addGroupList(key)
        }
    });

    $(".js_btn-cancle").click(function(){
        $(".alert-allot").fadeOut(1);
        $("#tc").hide();
    });

    $(".view_user").click(function(){
        //初始化员工数据
        $("#tc").show();
        $(".alert-allot .title").html("选择处理人");
        $(".alert-allot").fadeIn(1);
        addAdminList("");
        types =1;
    });

    $(".view_group").click(function(){
        //初始化员工数据
        $("#tc").show();
        $(".alert-allot .title").html("选择会员组");
        $(".alert-allot").fadeIn(1);
        addGroupList("");
        types =2;
    });

    function addAdminList(keyword){
        var html="";
        var group = $(".view_user").attr("data-group");
        $.post('<?php  echo $this->createMobileUrl("search")?>',{keyword:keyword,group:group},function(response){
            var data = response.data;
            for(var i=0;i<data.length;i++){
                html += '<li>'+
                    '<span class="sp1">'+data[i].name+'</span>'+
                    '<span class="sp2">'+data[i].organize+'</span>'+
                    '<a href="javascript:" class="btn-choose " data-id="'+data[i].id+'" data-name="'+data[i].name+'"><img src="<?php echo MODULE_URL;?>/static/mobile/images/uncheck.png"> </a>'+
                    '</li>';
            }
            $(".admin_list").html(html);
        },"json");
    }

    function addGroupList(keyword){
        var html="";
        $.post('<?php  echo $this->createMobileUrl("gSearch")?>',{keyword:keyword},function(response){
            var data = response.data;
            for(var i=0;i<data.length;i++){
                html += '<li>'+
                    '<span class="sp1" style="width: 70%;padding-left:20px;">'+data[i].title+'</span>'+
                    '<a href="javascript:" class="btn-choose " data-id="'+data[i].groupid+'" data-name="'+data[i].title+'"><img src="<?php echo MODULE_URL;?>/static/mobile/images/uncheck.png"> </a>'+
                    '</li>';
            }
            $(".admin_list").html(html);
        },"json");
    }

    $(".child-group").on("click",".addimg",function(){
        var html='<div class="weui-cell weui-cell_vcode">'+
                '<div class="weui-cell__hd">'+
                '<input class="weui-input header" type="text" placeholder="列名" style="width:100px;" />'+
                '</div>'+
                '<div class="weui-cell__bd">'+
                '<input class="weui-input body" type="text"   placeholder="列值" />'+
                '</div>'+
                '<div class="weui-cell__ft" style="height:45px;">'+
                '<img class="addimg" src="/addons/gd_zlyqk/static/mobile/css/ad.png" style="width:25px;margin-top:10px;margin-right:20px;">'+
                '<img class="divimg" src="/addons/gd_zlyqk/static/mobile/css/div.png" style="width:25px;margin-top:10px;margin-right:10px;">'+
                '</div>'+
                '</div>';
        $(this).parent().parent().parent().append(html);
    });
    $(".child-group").on("click",".divimg",function(){
        $(this).parent().parent().remove();
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("o_footer", TEMPLATE_INCLUDEPATH)) : (include template("o_footer", TEMPLATE_INCLUDEPATH));?>
