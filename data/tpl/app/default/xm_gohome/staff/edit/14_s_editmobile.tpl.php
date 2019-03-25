<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:2rem 0rem 3rem 0rem ">
    	<div class="umar-t ulev1 t-yel">
            <div class="tx-c">更换新手机号码</div>
            <div class="tx-c ulev-2"> </div>
        </div>
    </div>
    <div class="ub-f1">
    	<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="javascript:;" method="post">
        <input type="hidden" id="id" value="<?php  echo $item['id'];?>" >

        <div class="uinn8 umar-t1 tx-c">
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 tx-c ">
                            使用手机号码：<?php  echo $item['staff_mobile'];?>
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-phone ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="tel" name="mobile" id="mobile" placeholder="手机号码" value="" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-nan ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub-f1 ub ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="tel" name="code" id="code" placeholder="输入获取的验证码" value=""  class="uinn ulev0 block ub-f1" style="" />
                        </div>
                    </div>
                    <div id="on" class="kk-check t-gra" style="padding:0.5rem 0.5rem 0.1rem 0.5rem " onClick="getCode()">
                    <!--
                        <label class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" id="lable_text" >获取验证码<i class="iconfont ulev0 t-org"></i></label>
                    -->
                        <input type="button" id="btn" class="block uinn3 uba b-gra umar-b umar-r ufl ulev-1 uc-a15" value="免费获取验证码" />  
                        <div class="clear"></div>
                    </div>
                </li>
            </ul>   
    	</div>

        <div class="uinn8 ub">
            <button onClick="submit1()" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh" style="margin-bottom:0.5em; padding:0.75rem 3rem;" type="submit">
                <span class="ulev0 t-wh">提交</span>
            </button>
        </div>
        </form>
    </div>    
</div>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript">
function submit1(){
	var id     = document.getElementById('id').value;
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
		url: "<?php  echo $this->createMobileUrl('staffedit', array('foo'=>'staffmobileok'));?>",
		type:"POST",
		data:{"id":id,"mobile":mobile,"code":code},
		dataType:"json",
		success: function(res){
			//alert(res);
			if(res == "0"){
				alert('修改失败，验证码错误或已失效！');
			}else if(res == "2"){
				alert('修改失败，请重试！');
			}else if(res == "3"){
				alert('修改失败，验证码错误！');
			}else if(res == "4"){
				alert('修改失败，该手机号码已存在，请输入新的号码！');
			}else{
				alert('修改成功！');
				window.location.href = "<?php  echo $this->createMobileUrl('Validate', array())?>";
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
		data:{'mobile':mobile,'type':2},
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
