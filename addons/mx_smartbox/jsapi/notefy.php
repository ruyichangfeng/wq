<?php
	define('IN_MOBILE', true);
	require '../../framework/bootstrap.inc.php';
	
	$redirect =  $_GET['url'].'/app/index.php?i='.$_GET['uniacid'].'&aid='.$_GET['aid'].'&c=entry&do='.$_GET['action'].'&m='.$_GET['moudle'].'';
	
?>
<style>	
html{font-size:62.5%; /* 10÷16=62.5% */} 	
body{font-size:12px;font-size:1.2rem ; /* 12÷10=1.2 */} 	
.box{width:100%;padding-top:30%;}	
.im{width:100%;height:33px;margin:0 auto;text-align:Center;}	.it{width:100%;height:40px;line-height:40px;margin-top:20px;font-weight:700;text-align:center;font-size:1.2em;color:#666;}	.repay{width:350px;height:48px;background:#3f89ec;border:none;border-radius:2px;outline:none;cursor:pointer;font-size:16px;color:#FFF;margin:0 auto;margin-top:20px;text-align:Center;line-height:48px;}
</style>
<script>	
function isClose() {				
	/* WeixinJSBridge.invoke('closeWindow',{},function(res){
		   alert(res.err_msg);
	}); */ 
	window.location.href='<?php echo $redirect;?>';
		
} 	
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<div class="box">	 
<div class="im"><img src="pay_ico7.jpg"></div>	 
<div class="it">您已成功支付金额：￥<font color='red'><?php echo $_GET['money']/10/10; ?></font>元</div>	 	 
<div type="button" class="repay" onclick="isClose()">关闭页面</div></div>