<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no">
<title>注册页 - <?php  echo $cwgl_config['webtitle'];?></title>
<link href="<?php  echo $templateurl;?>/css/css.css" rel="stylesheet" type="text/css">
<link href="<?php  echo $templateurl;?>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php  echo $templateurl;?>/js/jquery.js"></script>
<script>
function phone_ckd(){					
	var compname = document.p_register.compname.value;
	if (compname == ""){
		alert("公司名称不能为空!");
		document.p_register.compname.focus();
		return false; 
	}
	var name = document.p_register.name.value;
	if (name == ""){
		alert("负责人姓名不能为空!");
		document.p_register.name.focus();
		return false; 
	}
	var phone = document.p_register.phone.value;
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	if(!myreg.test(phone)){
		alert("请输入有效的手机号码!");
		document.p_register.phone.focus();
		return false; 
	} 
}

//获取手机验证码
function get_mobile_code(pcode){
	$.post('<?php  echo $url_sms;?>', {mobile:jQuery.trim($('#mobile').val()),send_code:pcode}, function(msg) {
		alert(jQuery.trim(unescape(msg)));
		if(msg=='提交成功'){
			RemainTime();
		}
	});
};
var iTime = 59;
var Account;
function RemainTime(){
	document.getElementById('zphone').disabled = true;
	var iSecond,sSecond="",sTime="";
	if (iTime >= 0){
		iSecond = parseInt(iTime%60);
		iMinute = parseInt(iTime/60)
		if (iSecond >= 0){
			if(iMinute>0){
				sSecond = iMinute + "分" + iSecond + "秒";
			}else{
				sSecond = iSecond + "秒";
			}
		}
		sTime=sSecond;
		if(iTime==0){
			clearTimeout(Account);
			sTime='获取验证码';
			iTime = 59;
			document.getElementById('zphone').disabled = false;
		}else{
			Account = setTimeout("RemainTime()",1000);
			iTime=iTime-1;
		}
	}else{
		sTime='没有倒计时';
	}
	document.getElementById('zphone').value = sTime;
}
</script>
</head>
<body >
<div id="content01">
<div class="register">
   <h3 class="htit">企业注册</h3>
   <form name="p_register" action="<?php  echo $urltk;?>" method="post" onsubmit="return phone_ckd();">
   <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
   <div class="reg-content">
	    <div class="reg-message">
		  <i class="company"></i>
		  <input type="text" name="compname" value="" placeholder="公司名称"  class="ipucss"/>
		</div>
		<div class="reg-message">
		  <i class="fuzer"></i>
		  <input type="text" name="name" value="" placeholder="负责人"  class="ipucss"/>
		</div>
		<div class="reg-message">
		  <i class="tel"></i>
		  <input type="text" id="mobile" name="phone" value="" placeholder="手机号"  class="ipucss"/>
		</div>
		<?php  if($cwgl_config['sms_open']) { ?>
		<div class="reg-yzm clearFix">
		  <em>短信验证码</em>
		  <input type="txt" name="mobile_code" value="" class="inpyzm">
		  <input id="zphone" type="button" value="获取验证码 " onClick="get_mobile_code(<?php  echo $_SESSION['send_code'];?>);" class="yzm" style="border:0px;">
		</div>
		<?php  } ?>
   </div>
   <input type="submit" name="bdsubmit" value="注  册" class="submit">
   </form>
</div>
</div>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=ck_yunkj"></script></body>
</html>
