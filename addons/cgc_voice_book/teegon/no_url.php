<?php
/* *
 * 功能：服务器异步通知页面
 */

require_once '../../../framework/bootstrap.inc.php';
load()->app('common');
load()->app('template');

$order_sn = $_POST['order_no'];
$sql = 'SELECT * FROM ' . tablename('cgc_voice_book_pay') . ' WHERE `ordersn`=:order_sn';
$pars = array();
$pars[':order_sn'] = $order_sn;
$record = pdo_fetch($sql, $pars);
if (empty($record)){
	WeUtility::logging('cgc_voice_book no_url', "record error");
	exit('fail');
}


$_W['uniacid'] = $record['uniacid'];

$site = WeUtility::createModuleSite('cgc_voice_book');

if(is_error($site)) {
	WeUtility::logging('cgc_voice_book re_url', "site error");
	exit('fail');
}

$setting = $site->module['config'];

define('TEE_CLIENT_ID', $setting['teegon_client_id']);
define('TEE_CLIENT_SECRET', $setting['teegon_client_secret']);

require_once("lib/teegon.php");

$srv = new TeegonService(TEE_API_URL);
//验签
$result = $srv->verify_post_return();
//验签成功
if ($result['status']=="0"){
	$param = $result['param'];
	if ($param['is_success']){
		
		$method = 'payResult';
		if (method_exists($site, $method)) {
			$ret = array();
			$ret['uniacid'] = $_W['uniacid'];
			$ret['result'] = 'success';
			$ret['type'] = "teegon_pay";
			$ret['from'] = 'notify';
			//异步请求
			$ret['sync'] = false;
			$ret['tid'] = $record['ordersn'];
			$ret['user'] = $record['openid'];
			$ret['fee'] = $param['real_amount'];
			$ret['transaction_id'] = $param['charge_id'];
			$site->$method($ret);
			exit('success');
		} else {
			WeUtility::logging('cgc_voice_book callback', "settings error");
			exit('fail');
		}
		
	}else{
		exit("支付失败");
	}
	
}else{
	exit($result['error_msg']);
}
