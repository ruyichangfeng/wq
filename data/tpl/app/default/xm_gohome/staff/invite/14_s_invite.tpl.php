<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('staff/header', TEMPLATE_INCLUDEPATH)) : (include template('staff/header', TEMPLATE_INCLUDEPATH));?>

</head>
<body>
<div id="page0" class="ub ub-ver bga">
    <div class="c-gre3 ub ub-ver ub-ac ub-pc" style=" padding:1rem 0rem 1rem 0rem ">
    	<div class="umar-t ulev1 t-yel">邀请码设置</div>
    </div>
    
    <div class="ub-f1">
    	<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="javascript:;" method="post">
            <div class="uinn8 umar-t1 tx-c">
                
                <ul class="userlist c-wh uc-a15 umar-b">
                    <li class="ub ub-ac">
                        <div style="width:3.5rem">
                            <i class="iconfont icon-nan ulev2 umar-r1 umar-l1 t-gre1"></i>
                        </div>
                        <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                            <div class="ub ulev0 ub-f1 ">
                                <input type="text" name="invite" id="invite" placeholder="邀请码" value="<?php  echo $item_i['invite'];?>" class="uinn ulev0 ub-f1 block" />
                            </div>
                            <div class="">
                                <a href="" class="block uba b-gre1 ulev-4 t-gre1 uc-a15" style="padding:0.2rem 0.5rem">修改</a>
                            </div>
                        </div>
                    </li>
                </ul>
                
        	</div>
            <div class="uinn8 ub">
                <button onClick="submit1()" class="c-gre3 ub-f1 uc-a1 btnn block tx-c t-wh" style="margin-bottom:0.5em; padding:0.75rem 3rem;" type="submit"><span class="ulev0 t-wh">提交</span></button>
            </div>
        </form>
    </div> 
    
    <div class=" ub ub-ver ub-ac ub-pc" style=" padding:1rem 0rem 1rem 0rem ">
    	<div class="umar-t ulev1">加入伙伴</div>
    </div>
    <div class="ub-f1">
    	<form class="form-horizontal ub ub-f1 ub-ver" id="form1" action="javascript:;" method="post">
        <div class="uinn8 umar-t1 tx-c">
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-phone ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="tel" name="mobile2" id="mobile2" placeholder="邀请人手机号码" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
            <ul class="userlist c-wh uc-a15 umar-b">
                <li class="ub ub-ac">
                    <div style="width:3.5rem">
                        <i class="iconfont icon-nan ulev2 umar-r1 umar-l1 t-gre1"></i>
                    </div>
                    <div class="ub ub-f1 ub-ac ubb ubl b-bla01 uinn">
                        <div class="ub ulev0 ub-f1 ">
                            <input type="text" name="invite2" id="invite2" placeholder="邀请码" class="uinn ulev0 ub-f1 block" />
                        </div>
                    </div>
                </li>
            </ul>
            
    	</div>
        <div class="uinn8 ub">
            <button class="c-gre3 ub ub-pc uc-a1 ub-f1 btnn block" onClick="submit2()" style="margin-bottom:0.5em;padding:0.75rem 3rem" type="submit"><span class="ulev0 t-wh">确定加入</span></button>
        </div>
        </form>
    </div>  
    
    <div class="" style="height:3.125rem"></div>
    <div id="footer" class="fix0 c-foot" style="width:100%; bottom:0; z-index:999">
        <div class="ub">
            <a href ="<?php  echo $this->createMobileUrl('invite', array('foo'=>'myinvite'))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-nan ulev1"></i> 
                    <span class="block ulev-1" style="">我邀请的伙伴</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('validate', array())?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-shouye ulev1"></i> 
                    <span class="block ulev-1" style="">首页</span>
                </div>
            </a>
            <a href ="<?php  echo $this->createMobileUrl('invite', array('foo'=>'myattend'))?>" class="ub ub-pc block" style="width:33.33%">
                <div class="ub ub-ver ub-ac ub-pc">
                    <i class="iconfont icon-nan ulev1"></i> 
                    <span class="block ulev-1" style="">我加入的伙伴</span>
                </div>
            </a>
        </div>
    </div>
    
</div>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('public/footerjs', TEMPLATE_INCLUDEPATH)) : (include template('public/footerjs', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript">
function submit1(){
	var openid = "<?php  echo $openid;?>";
	var mobile = "<?php  echo $mobile;?>";
	var id = "<?php  echo $item_i['id'];?>";
	
	var invite = document.getElementById('invite').value;	
	if(invite == ''){
		alert('请设置专属邀请码！');
		return false;
	}			
			
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('invite', array('foo'=>'inviteok'));?>",
		type:"POST",
		data:{"id":id,"openid":openid,"mobile":mobile,"invite":invite},
		dataType:"json",
		success: function(res){
			//alert(res);
			if(res == "1"){
				alert('邀请码设置成功！');
				//WeixinJSBridge.call('closeWindow'); 
				window.location.href = "<?php  echo $this->createMobileUrl('Validate', array())?>"; 
			}else{
				alert('对不起,邀请码设置错误！');
			}
		}
	});
				
}

function submit2(){
	var mobile = document.getElementById('mobile2').value;	
	if(mobile == ''){
		alert('请输入邀请人手机号码！');
		return false;
	}
	if (!/^1[358]{1}[0-9]{9}/.test(mobile)) {
		alert('请输入正确的手机号码！');
		return false;
	}
	
	var invite = document.getElementById('invite2').value;	
	if(invite == ''){
		alert('请输入邀请码！');
		return false;
	}			
			
	$.ajax({
		url: "<?php  echo $this->createMobileUrl('invite', array('foo'=>'attendok'));?>",
		type:"POST",
		data:{"mobile":mobile,"invite":invite},
		dataType:"json",
		success: function(res){
			//alert(res);
			if(res == "0"){
				alert('你输入的邀请人手机号码或邀请码错误，加入失败！');
				return false;
			}
			if(res == "1"){
				alert('加入伙伴成功！');
				window.location.href = "<?php  echo $this->createMobileUrl('Validate', array())?>"; 
			}
			if(res == "2"){
				alert('加入伙伴失败，请重试！');
				return false;
			}
			if(res == "3"){
				alert('你已用该邀请码加入成功，不能重复加入！');
				return false;
			}
			if(res == "4"){
				alert('不可任性，不能自己加入自己！');
				return false;
			}
		}
	});
				
}
</script>

<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=14&c=utility&a=visit&do=showjs&m=xm_gohome"></script></body>
</html>
