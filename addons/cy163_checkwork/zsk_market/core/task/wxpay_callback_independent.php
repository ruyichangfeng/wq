<?php
//微信支付回调文件
$sys=explode('addons',__FILE__);
!defined('ROOT') && define('ROOT',$sys[0]);
!defined('ZSK_MODULE') && define('ZSK_MODULE',"zsk_market");
!defined('ZSK_PATH') && define('ZSK_PATH',ROOT."/");
!defined('ZSK_PREFIX') && define('ZSK_PREFIX','azsk_shop'); 
 
define('IN_IA', true);
define('IN_API', true);
if(intval($_GET['indebug'])==1){
    define('IN_DEBUG', true);
     ini_set("display_errors","OFF"); 
}else{
    define('IN_DEBUG', false); 
     ini_set("display_errors","ON");
} 
require_once ROOT."data/config.php";//微擎配置文件 
require_once ZSK_PATH."core/task/function.php";
require_once ZSK_PATH."libs/function.php"; 

class WeModuleWxapp{
	function func($s){
		return false;
	}
} 
class WeModuleSite{

}
if(!function_exists("load")){
	function load(){
		return new WeModuleWxapp;
	}
}
//避免发送邮件：load()->func()报错中断
require_once ZSK_PATH."core/task/pdo.class.php"; 
require_once ZSK_PATH."libs/wxpush.func.php"; 
require_once ZSK_PATH."libs/wechat.class.php"; 
require_once ZSK_PATH."libs/wxpay/wxpay.class.php"; 
require_once ZSK_PATH."core/wxapp/order.ctrl.php";

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$_XML=NULL;
if(empty($postStr)){
    $postStr=file_get_contents('php://input');
} 
if (!empty($postStr) ){ 
 	$_XML = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);   
}
 if (!empty($_XML)||isset($_GET['wxpay_no'])){  
	if(isset($_GET['wxpay_no'])){
		$order_no=trim($_GET['wxpay_no']);
	}else{ 
    	$order_no=$_XML->out_trade_no;
	}

    $model=Model("order");
    $order=$model->where("wxpay_no='".$order_no."'")->get();
    if(strlen($order['trade_state'])<3){
    	$_W=array(
			"uniacid"=>$order['uniacid']
		);
		$_GPC=array(
			"wxpay_no"=>$order['wxpay_no'],
			'openid'=>$order['openid']
		);  
		$ctrl=new Order();
		 $ctrl->payOrderSts(); 
    }
    
} else{
	die("非法请求！");
}
 

