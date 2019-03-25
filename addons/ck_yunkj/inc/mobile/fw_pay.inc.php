<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";
require "user_common.php";


checkAuth();
$orderid = intval($_GPC['orderid']);
$order = pdo_fetch("SELECT * FROM " . tablename('cwgl_service_order') . " WHERE id = :id AND weid = :weid", array(':id' => $orderid, ':weid' => $_W['uniacid']));
if ($order['paystatus'] != '0') {
	message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('user_order'), 'error');
}

//判断已经支付操作过
$order_inom = pdo_get('cwgl_order_inom', array('weid' => $_W['uniacid'],'did' => $orderid,'type' => 'fw'));
if (empty($order_inom)) {

	$data = array(
		'weid' => $_W['uniacid'],
		'did' => intval($orderid),
		'type' => 'fw',
		'paymoney' => $order['paymoney']
	);
	pdo_insert('cwgl_order_inom', $data);
	$tid = pdo_insertid();
	
}else{

	$tid = $order_inom['id'];
	if ($order_inom['status'] != '0') {
		message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('user_order'), 'error');
	}
	
}



// 服务名称
$sql = 'SELECT `titlename` FROM ' . tablename('cwgl_service_list') . " WHERE `id` = :id";
$goodsTitle = pdo_fetchcolumn($sql, array(':id' => $order['sid']));

$params['tid'] = $tid;
$params['user'] = $_W['fans']['from_user'];
$params['fee'] = $order['paymoney'];
$params['title'] = "购买".$goodsTitle;
$params['ordersn'] = $order['orderid'];
$params['virtual'] = false;

include $this->template('pay');
