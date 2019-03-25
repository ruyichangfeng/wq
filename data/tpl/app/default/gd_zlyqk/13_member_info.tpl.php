<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("o_header", TEMPLATE_INCLUDEPATH)) : (include template("o_header", TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("new_header", TEMPLATE_INCLUDEPATH)) : (include template("new_header", TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("notice", TEMPLATE_INCLUDEPATH)) : (include template("notice", TEMPLATE_INCLUDEPATH));?>
<style>
    .form_submit{margin-bottom: 30px !important;}
</style>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("thems", TEMPLATE_INCLUDEPATH)) : (include template("thems", TEMPLATE_INCLUDEPATH));?>
<header class="ui-header">
    <div class="ui-icon-left">
        <a href="javascript:void(0)" class="ui-icon icon-back"></a>
    </div>
    <div class="ui-title">注册</div>
</header>
<div class="weui-tab" style="margin-top:50px;">
<?php  if($needStep) { ?>
<div class="weui-navbar">
    <div class="weui-navbar__item weui-bar__item_on">
        <a href="<?php  echo $this->createMobileUrl('memberInfo')?>" style="color: #999999">基本信息</a>
    </div>
    <?php  if(is_array($stepList)) { foreach($stepList as $step) { ?>
    <div class="weui-navbar__item">
        <a href="<?php  echo $this->createMobileUrl('SaveStep')?>&sort=<?php  echo $step['sort'];?>" style="color: #999999"><?php  echo $step['name'];?></a>
    </div>
    <?php  } } ?>
</div>
<?php  } ?>
<div class="weui-tab__panel m_sig">
    <form method="post" id="form" action="<?php  echo $this->createMobileUrl('member')?>">
        <div class="page__bd" style="padding-bottom: 40px;" >
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label  class="weui-label">姓名</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input weiui-require" name="name" type="text" value="<?php  echo $memberInfo['name'];?>" placeholder="请输姓名" />
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label ">电话</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input weiui-require"  id="sms" datatype="n11-11" errormsg="电话不合法" nullmsg="请填写电话" name="mobile" type="number"  value="<?php  echo trim($memberInfo['mobile'])?>" placeholder="请输号码" />
                    </div>
                </div>
                <?php  if($config['member_code']) { ?>
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label  class="weui-label">验证码</label>
                    </div>
                    <div class="weui-cell__bd">
                        <input  class="weui-input weiui-require" style="font-size:15px;" name="sms_code" id="sms_code"   type="number" placeholder="输入验证码" />
                    </div>
                    <div class="weui-cell__ft"  style="width:100px;height:30px;padding-right:10px;">
                        <input type="button" class="weui-btn weui-btn_mini weui-btn_primary sms_code_get" value="获取验证码"  >
                    </div>
                </div>
                <?php  } ?>
                <?php  if($config['member_gp']) { ?>
                <div class="weui-cell weui-cell_select" style="padding-left: 15px;">
                    <div class="weui-cell__hd">
                        <label  class="weui-label">会员组</label>
                    </div>
                    <div class="weui-cell__bd">
                        <select class="weui-select" name="label" style="padding-left:0">';
                            <option  value="0">默认组</option>
                            <?php  if(is_array($groupList)) { foreach($groupList as $group) { ?>
                            <option  value="<?php  echo $group['id'];?>" <?php  if($group['id']==$memberInfo['label']) { ?>selected<?php  } ?>><?php  echo $group['label_name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <?php  } ?>
                <?php  if($config['member_app']) { ?>
                <?php  if($memberInfo['app_id']==0) { ?>
                <div class="weui-cell weui-cell_select" style="padding-left: 15px;">
                    <div class="weui-cell__hd">
                        <label  class="weui-label"><?php  echo $config['gs_lb'];?></label>
                    </div>
                    <div class="weui-cell__bd">
                        <select class="weui-select" name="app_id" style="padding-left:0">';
                            <?php  if(is_array($appList)) { foreach($appList as $app) { ?>
                            <option  value="<?php  echo $app['id'];?>"><?php  echo $app['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <?php  } ?>
                <?php  } ?>
                <?php  if($extInfo) { ?>
                <script>
                    var sortList="<?php  echo $sortList;?>";
                </script>
                <?php  if(is_array($extInfo)) { foreach($extInfo as $extInfo) { ?>
                <?php  echo $extInfo['html'];?>
                <?php  } } ?>
                <?php  } ?>
            </div>
            <?php  echo $submit;?>
        </div>
    </form>
</div>
</div>
<script>
    var countdown=300;
    $(".sms_code_get").click(function(){
    var mobile=$("#sms");
    if (mobile.val().length == 0) {
        mobile.focus();
        errorMsg("请填写手机号");
        return false;
    }else {
        if(isPhoneNo(mobile.val()) == false) {
            mobile.focus();
            errorMsg("手机号不正确");
            return false;
        }
    }
    function goUrl(url){
        location.href=url;
    }
    //获取验证码
    $.post("<?php  echo $this->createMobileUrl('getCode')?>",{mobile:mobile.val()},function(response){
        if(response.code==2){
            errorMsg(response.msg);
        }else{
            settime($(".sms_code_get"));
        }
    },"json");
    });
    function isPhoneNo(phone) {
        var pattern = /^1\d{10}$/;
        return pattern.test(phone);
    }

    $("document").ready(function(){
        if(typeof(sortList)!="undefined"){
            var url="<?php  echo $this->createMobileUrl('regData')?>";
            var slist=sortList.split(",");
            for(var i=0;i<slist.length;i++){
                url +="&sort="+slist[i];
                $.post(url,{},function(response){
                    if(response.data){
                        for(var x in response.data){
                            var obj = $("input[name='"+x+"']");
                            if(obj.length>0){
                                obj.val(response.data[x]);
                            }
                            var obj = $("textarea[name='"+x+"']");
                            if(obj.length>0){
                                obj.val(response.data[x]);
                            }
                        }
                    }
                },"json");
            }
        }
    });

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
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template("o_footer", TEMPLATE_INCLUDEPATH)) : (include template("o_footer", TEMPLATE_INCLUDEPATH));?>
