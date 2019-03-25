<?php
ini_set('date.timezone','Asia/Shanghai');
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
if($_GET['ispay'] == 1){
	//服务商信息
	define('APPIDT', $_GET['par_appid']);
	define('MCHIDT', $_GET['par_mchid']);
	define('WXKEYT', $_GET['par_wxkey']);
	define('APPSECT', $_GET['par_appsec']);
	//子商户信息
	define('Sub_APPIDT', $_GET['appid']);
	define('Sub_MCHIDT', $_GET['mchid']);
	define('Sub_WXKEYT', $_GET['wxkey']);
	define('Sub_APPSECT', $_GET['appsecrect']);
}elseif($_GET['ispay'] == 0){
	//echo "独立支付系统";
	define('APPIDT', $_GET['appid']);
	define('MCHIDT', $_GET['mchid']);
	define('WXKEYT', $_GET['wxkey']);
	define('APPSECT', $_GET['appsecrect']);
	//子商户信息
	define('Sub_APPIDT',"");
	define('Sub_MCHIDT',"");
	define('Sub_WXKEYT',"");
	define('Sub_APPSECT',"");
}

require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';	


//var_dump($_GET);
$moudle = $_GET['moudle'];
$action = $_GET['action'];
$uniacid = $_GET['uniacid'];
$money = ($_GET['money']*100); //转换成 分 单位
$notice = $_GET['notice'];	
$prefix = $_GET['prefix'];	
$aid = $_GET['aid'];	

	
	
	//获取主域名
	$url_array = explode("/",$_W['siteroot']); 
	$url = $url_array[0]."//".$url_array[2]."/";
	
	
	
	
	
	$payresult = $url.'/addons/'.$moudle.'/notefy.php';
	
	 //初始化日志
	$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
	$log = Log::Init($logHandler, 15);


	//①、获取用户openid
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	

	//②、统一下单
	$input = new WxPayUnifiedOrder();
	$input->SetBody($notice);
	$input->SetAttach($notice);
	//$input->SetOut_trade_no($prefix."010".$uniacid.$aid.WxPayConfig::MCHID.date("YmdHis"));
	$input->SetOut_trade_no($prefix."020".$uniacid.$aid.date("YmdHis",time()).mt_rand(999,9999));
	//$input->SetOut_trade_no($ptorder);
	$input->SetTotal_fee($money);  //单位分,如果是元，在此处要换算
	$input->SetTime_start(date("YmdHis"));
	$input->SetTime_expire(date("YmdHis", time() + 600));
	$input->SetGoods_tag("test");
	$input->SetNotify_url($payresult);  
	$input->SetTrade_type("JSAPI");
	$input->SetOpenid($openId);
	$order = WxPayApi::unifiedOrder($input);
	$jsApiParameters = $tools->GetJsApiParameters($order);

	//获取共享收货地址js函数参数
	$editAddress = $tools->GetEditAddressParameters(); 
	?>
<script src="jquery-3.2.1.min.js"></script>
<script type="text/javascript">	
	 //调用微信JS api 支付,添加监听
	function jsApiCall() { 
        document.addEventListener('WeixinJSBridgeReady',function onBridgeReady() { 
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){ 
					WeixinJSBridge.log(res.err_msg);
					//alert(res.err_code+res.err_desc+res.err_msg); 
					if(res.err_msg == 'get_brand_wcpay_request:ok') {
						//alert("支付成功！");
					window.location.href="<?php echo $url;?>/payment/jsapi/notefy.php?money=<?php echo $money;?>&url=<?php echo $url;?>&uniacid=<?php echo $uniacid;?>&action=<?php echo $action;?>&moudle=<?php echo $moudle;?>&aid=<?php echo $aid;?>"; 
					}else if(res.err_msg == 'get_brand_wcpay_request:cancel'){
						alert("您取消了订单");
						WeixinJSBridge.invoke('closeWindow',{},function(res){
							alert(res.err_msg);
						}); 
					}else if(res.err_msg == 'get_brand_wcpay_request:fail'){
						alert('启动微信支付失败, 请联系管理员' + res.err_msg);
						WeixinJSBridge.invoke('closeWindow',{},function(res){
							alert(res.err_msg);
						}); 
					}				 

			});
        }, false); 
    } 	

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){				
				if(res.err_msg == 'get_brand_wcpay_request:ok') {				
				var value1 = res.proviceFirstStageName; //国标收货地址第一级地址 
				var value2 = res.addressCitySecondStageName; //国标收货地址第二级地址 
				var value3 = res.addressCountiesThirdStageName; //国标收货地址第三级地址
				var value4 = res.addressDetailInfo;    //详细收货地址信息
				var tel = res.telNumber;	//收货人电话
					alert(value1 + value2 + value3 + value4 + ":" + tel);			
				}else if(res.err_msg == 'get_brand_wcpay_request:cancel'){
					//alert("支付过程中，用户取消……");
				}else if(res.err_msg == 'get_brand_wcpay_request:fail') {
					alert('启动微信支付失败, 请检查你的支付参数. 详细错误为: ' + res.err_msg);
					WeixinJSBridge.invoke('closeWindow',{},function(res){
						alert(res.err_msg);
					});					
				}
				
				
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	
	</script>
	
<script>
	jsApiCall();
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<style>
body{background-color:rgba(0,0,0,0.5)}
.spinner{margin:100px auto;width:20px;height:20px;position:relative;}.container1 > div,.container2 > div,.container3 > div{width:8px;height:8px;background-color:#FFF5EE;border-radius:100%;position:absolute;-webkit-animation:bouncedelay 1.2s infinite ease-in-out;animation:bouncedelay 1.2s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both;}.spinner .spinner-container{position:absolute;width:100%;height:100%;}.container2{-webkit-transform:rotateZ(45deg);transform:rotateZ(45deg);}.container3{-webkit-transform:rotateZ(90deg);transform:rotateZ(90deg);}.circle1{top:0;left:0;}.circle2{top:0;right:0;}.circle3{right:0;bottom:0;}.circle4{left:0;bottom:0;}.container2 .circle1{-webkit-animation-delay:-1.1s;animation-delay:-1.1s;}.container3 .circle1{-webkit-animation-delay:-1.0s;animation-delay:-1.0s;}.container1 .circle2{-webkit-animation-delay:-0.9s;animation-delay:-0.9s;}.container2 .circle2{-webkit-animation-delay:-0.8s;animation-delay:-0.8s;}.container3 .circle2{-webkit-animation-delay:-0.7s;animation-delay:-0.7s;}.container1 .circle3{-webkit-animation-delay:-0.6s;animation-delay:-0.6s;}.container2 .circle3{-webkit-animation-delay:-0.5s;animation-delay:-0.5s;}.container3 .circle3{-webkit-animation-delay:-0.4s;animation-delay:-0.4s;}.container1 .circle4{-webkit-animation-delay:-0.3s;animation-delay:-0.3s;}.container2 .circle4{-webkit-animation-delay:-0.2s;animation-delay:-0.2s;}.container3 .circle4{-webkit-animation-delay:-0.1s;animation-delay:-0.1s;}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0);}40%{transform:scale(1.0);-webkit-transform:scale(1.0);}}
</style>
<div class="spinner">
  <div class="spinner-container container1">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
  <div class="spinner-container container2">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
  <div class="spinner-container container3">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
</div>
