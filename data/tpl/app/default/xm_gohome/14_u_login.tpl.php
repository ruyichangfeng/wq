<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div id="page0" class="ub ub-ver c-gra1">
    <div class="ub-f1 ub ub-ver">
        <div class="ub ub-ver ub-ac ub-pc" style="height:8em">
        	<!--
        	<div class="uc-a50 c-gra ub-img1" style="height:4em; width:4em; background-image:url(<?php echo MODULE_URL;?>/template/mobile/images/default.jpg)"></div>
            -->
            <div class=" umar-t1 ulev2">手机登录</div>
        </div>
        
        <form name="form1" action="<?php  echo $this->createMobileUrl('loginok',array())?>" method="post" onSubmit="return submit1()">
        <div class="uinn8 c-wh  ubt ubb b-bla01">
        	<div class="uinn ub ub-ac">
            	<div class="umar-r tx-r" style="min-width:4em">手机号码：</div>
                <input type="tel" name="mobile" id="mobile" placeholder="请填写手机号码" value="" style="width:100%" class="uinn uba b-bla01 ulev0 ub-f1 uc-a1" />
            </div>
            <div class="uinn ub ub-ac">
            	<div class="umar-r tx-r">登录密码：</div>
                <input type="password" name="password" id="password" placeholder="请填写登录密码" value="" style="width:100%" class="uinn uba b-bla01 ulev0 ub-f1 uc-a1" />
            </div>
            
        </div>

        <div class="c-wh ub-f1">
        	<div class="uinn"></div>
            <div class="uinn8 ub">
                <input name="submit" type="submit" value="登录" class="uinn211 c-org uc-a1 ub-f1 btnn ulev0 t-wh block tx-c" />
       		</div>
            
        </div>
        </form>
        
        <div class="c-wh ub-f1">
            <div class="uinn3">
                <a href="<?php  echo $this->createMobileUrl('reg',array())?>">&nbsp;&nbsp;&nbsp;&nbsp;免费注册</a>
            </div>
        </div>
    </div>
    </form>
    
    
</div>
<script>
function submit1(){
	var mobile = document.getElementById('mobile').value;
	var password = document.getElementById('password').value;
	if(mobile == ''){
		alert('请输入手机号码！');
		return false;
	}
	if (!/^1[34578]{1}[0-9]{9}/.test(mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	if(password == ''){
		alert('请输入登录密码！');
		return false;
	}
}
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
