<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";
require "user_common.php";


checkAuth();
$orderid = intval($_GPC['orderid']);
$youhui = intval($_GPC['youhui']);

$order = pdo_fetch("SELECT * FROM " . tablename('cwgl_user_paycost') . " WHERE id = :id AND weid = :weid", array(':id' => $orderid, ':weid' => $_W['uniacid']));
if ($order['status'] != '0') {
	message('抱歉，您的欠费信息已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('user_paycost'), 'error');
}

//计算支付金额----------
if($youhui == 1){
	//一个月	
	if($cwgl_config['cost_youhui1']){
		$discount_price = $order['paymoney']*$cwgl_config['cost_youhui1'];
	}else{
		$discount_price = $order['paymoney'];
	}
	$paymoney = $discount_price;
	
}elseif($youhui == 2){
	//三个月	
	if($cwgl_config['cost_youhui2']){	
		$discount_price = $order['paymoney']*$cwgl_config['cost_youhui2'];
	}else{
		$discount_price = $order['paymoney'];
	}
	$paymoney = $discount_price*3;
	
}elseif($youhui == 3){
	//半年
	if($cwgl_config['cost_youhui3']){	
		$discount_price = $order['paymoney']*$cwgl_config['cost_youhui3'];
	}else{
		$discount_price = $order['paymoney']*6;
	}
	$paymoney = discount_price*6;
}elseif($youhui == 4){
	//一年
	if($cwgl_config['cost_youhui4']){	
		$discount_price = $order['paymoney']*$cwgl_config['cost_youhui4'];
	}else{
		$discount_price = $order['paymoney'];
	}
	$paymoney = $discount_price*12;
}else{
	$paymoney = $discount_price = $order['paymoney'];
}
//-----------------

/*cwgl_user_paycost表 不需要更新更新单价，因为在cwgl_order_inom表有储存折扣后的总价
//更新支付单价金额
if($discount_price != $order['paymoney']){
	pdo_update('cwgl_user_paycost', array('paymoney'=>$discount_price), array('id' => $order['id'],'weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
}
*/

//判断已经支付操作过
$order_inom = pdo_get('cwgl_order_inom', array('weid' => $_W['uniacid'],'did' => $orderid,'type' => 'owe'));
if (empty($order_inom)) {

	$data = array(
		'weid' => $_W['uniacid'],
		'did' => intval($orderid),
		'type' => 'owe',
		'youhui' => intval($_GPC['youhui']),
		'paymoney' => $paymoney
	);
	pdo_insert('cwgl_order_inom', $data);
	$tid = pdo_insertid();
	
}else{
	
	$tid = $order_inom['id'];
	pdo_update('cwgl_order_inom', array('youhui' => intval($_GPC['youhui']),'paymoney' => $paymoney), array('weid' => $_W['uniacid'],'did' => $orderid,'type' => 'owe'));
	if ($order_inom['status'] != '0') {
		message('抱歉，您的欠费信息已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('user_paycost'), 'error');
	}
	
}

$params['tid'] = $tid;
$params['user'] = $_W['fans']['from_user'];
$params['fee'] = $paymoney;
$params['title'] = "支付服务费用";
$params['ordersn'] = date('md') . random(4, 1);
$params['virtual'] = false;

include $this->template('pay2');
