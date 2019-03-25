<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>

<body>
	<div class="ub ub-ver bga page" id="page0">
	  	<!--更换手机号码-->
		<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="javascript:;" method="post">
			<div class="recharge">
		  		<div class="bd c-wh">
		  			<div class="ub-f1 font-b ulev2 tx-c ub-ac ub-pc" style="padding-top:1rem">更换手机号码</div>
		  			<div class="weui_cells weui_cells_form ulev-1">
					    <div class="weui_cell">
					      	<div class="weui_cell_hd">
					        	<label class="weui_label">手机号码</label>
					      	</div>
					      	<div class="weui_cell_bd weui_cell_primary">
					        	<input class="weui_input" type="tel" name="mobile" id="mobile" placeholder="输入手机号码">
					      	</div>
					    </div>
					    <div class="weui_cell">
					      	<div class="weui_cell_hd">
					        	<label class="weui_label">验证码</label>
					      	</div>
					      	<div class="weui_cell_bd weui_cell_primary">
					        	<input class="weui_input" type="text" name="code" id="code" placeholder="输入验证码">
					      	</div>
					      	<div class="weui_cell_ft" onClick="getCode()">
					      		<input type="button" id="btn" class="weui_btn weui_btn_mini weui_btn_default" value="免费获取验证码" />
					      	<!--
					      	<a onClick="getCode()" class="weui_btn weui_btn_mini weui_btn_default">获取验证码</a> </div>
					      	-->
					    	</div>
						</div>
                        
		  			</div>
		  		
			  		<div class="umar-b1 umar-l umar-r umar-t1">
			  			<div onClick="submit1()" class="weui_btn weui_btn_primary pc_btn">确认更改</div> 
			  		</div>
		  		</div>
		  	</div>	
		</form>  	
	  	<!--手机端底部-->
	  	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('footer', TEMPLATE_INCLUDEPATH)) : (include template('footer', TEMPLATE_INCLUDEPATH));?>
	  	<!--手机端底部-->
	</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
function submit1(){
	var mobile = document.getElementById('mobile').value;
	var code   = document.getElementById('code').value;
			
	if(mobile == ''){
		alert("请输入手机号码");
		return false;
	}
	if (!/^1[34578]{1}[0-9]{9}/.test(mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	if(code == ''){
		alert("请输入获取的验证码");
		return false;
	}
			
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('myinfo', array('foo'=>'editmobileok'));?>",
		type:"POST",
		data:{"mobile":mobile,"code":code},
		dataType:"json",
		success: function(res){
			//alert(res);
			if(res == "1"){
				alert('手机号码修改成功！');
				window.location.href = "<?php  echo $this->createMobileUrl('myinfo', array('foo'=>'index'))?>"; 
			}else if(res == "2"){
				alert('手机号码更换失败！');
			}else if(res == "4"){
				alert('对不起,该手机号码已存在！');
			}else{
				alert('验证码错误或失效！'); 
			}
		}
	});
				
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
            wait = 60;  
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
