<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
<div id="page0" class="ub ub-ver c-gra1">
	<form class="form-horizontal ub ub-f1 ub-ver" action="<?php  echo $this->createMobileUrl('regok', array())?>" method="post" onSubmit="return submit1()">
    <div class="ub-f1 ub ub-ver">
        <div class="ub ub-ver ub-ac ub-pc" style="height:8em">
        	<!--
        	<div class="uc-a50 c-gra ub-img1" style="height:4em; width:4em; background-image:url(<?php echo MODULE_URL;?>/template/mobile/images/default.jpg)"></div>
            -->
            <div class=" umar-t1 ulev2">账号注册</div>
        </div>
        
        
        <div class="uinn8 c-wh  ubt ubb b-bla01">
        	<div class="uinn ub ub-ac">
            	<div class="umar-r tx-r" style="min-width:4em">手机号码：</div>
                <input type="tel" name="mobile" id="mobile" placeholder="请填写手机号码" value="" style="width:100%" class="uinn uba b-bla01 ulev0 ub-f1 uc-a1" />
            </div>
            <div class="uinn ub ub-ac">
            	<div class="umar-r tx-r" style="min-width:4em">登录密码：</div>
                <input type="password" name="pwd" id="pwd" placeholder="请填写登录密码" value="" style="width:100%" class="uinn uba b-bla01 ulev0 ub-f1 uc-a1" />
            </div>
            <div class="uinn ub ub-ac">
            	<div class="umar-r tx-r" style="min-width:4em">确认密码：</div>
                <input type="password" name="rpwd" id="rpwd" placeholder="请填写确认密码" value="" style="width:100%" class="uinn uba b-bla01 ulev0 ub-f1 uc-a1" />
            </div>
            
          
            <?php  if($authen == 1) { ?>
            <div class="uinn ub ub-ac">
            	<div class="umar-r tx-r" style="min-width:4em">&nbsp;&nbsp;验证码：</div>
                <input type="text" name="code" id="code" placeholder="请填写验证码" value="" style="width:100%" class="uinn uba b-bla01 ulev0 ub-f1 uc-a1" />
            </div>
            
            <div id="on" class="kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem " >
				<input onClick="getCode()" type="button" id="btn" class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" value="免费获取验证码" />  
				<div class="clear"></div>
			</div>
            <?php  } ?>
            
        </div>

        <div class="c-wh ub-f1">
        	<div class="uinn"></div>
            <div class="uinn8 ub">
                <input name="submit" type="submit" value="注册" class="uinn211 c-org uc-a1 ub-f1 btnn ulev0 t-wh block tx-c" />
       		</div>
        </div>
        
        <div class="c-wh ub-f1">
            <div class="uinn3">
                <a href="<?php  echo $this->createMobileUrl('Login', array())?>">&nbsp;&nbsp;&nbsp;&nbsp;账号登录</a>
            </div>
        </div>
    </div>
    </form>
    
    
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script>
function submit1(){
	var mobile = document.getElementById('mobile').value;
	var pwd = document.getElementById('pwd').value;
	var rpwd = document.getElementById('rpwd').value;
	
	if(mobile == ''){
		alert('请输入手机号码！');
		return false;
	}
	if (!/^1[34578]{1}[0-9]{9}/.test(mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	if(pwd == ''){
		alert('请输入登录密码！');
		return false;
	}
	if(rpwd == ''){
		alert('请输入确认密码！');
		return false;
	}
	if(pwd != rpwd){
		alert('两次输入的密码不一致！');
		return false;
	}
	
}

function getCode(){

	var mobile = document.getElementById('mobile').value;
	if(mobile == ''){
		alert('请输入手机号码！');
		return false;
	}
	if (!/^1[34578]{1}[0-9]{9}/.test(mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('CodeOk', array());?>",
		type:"POST",
		data:{'mobile':mobile,'type':1},
		dataType:"json",
		success: function(res){
			//alert(res);
			if(res==1){
				var wait = "<?php  echo $timeout;?>";
				time(wait); 
				//document.getElementById('lable_text').innerHTML = '已发送';
				//document.getElementById('on').onclick = function(){}; 
			}else{
				alert('验证码发送失败！请重试');
				return false;
			}
		}
	});
}

function time(wait) {  
       if (wait == 0) {  
            document.getElementById("btn").removeAttribute("disabled");            
            document.getElementById("btn").value="免费获取验证码";  
            wait = "<?php  echo $timeout;?>";  
        } else {  
            document.getElementById("btn").setAttribute("disabled", true);  
            document.getElementById("btn").value="重新发送(" + wait + ")";  
            wait--;  
            setTimeout(function() {  
                time(wait)  
            },  
            1000)  
        }  
    } 
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
