<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_payofficial');

$op = $_GPC['op'];

//获取
$srdb = pdo_get('cwgl_user_payofficial', array('uid' => $_W['member']['uid'],'weid' => $_W['uniacid'],'status' => 0));
if($srdb['status']==1){
	message('您已经购买成为服务会员，正在分配会计中，敬请等待！', $this->createMobileUrl('user_index'), 'error');
}

//存入订单
if($op == 'order'){
	
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'paymoney' => $cwgl_config['month_money'],
		'message' => '购买成为正式会员',
		'dateline' => mktime()
	);
	
	if($srdb){
		pdo_update('cwgl_user_payofficial', $data, array('id' => $srdb['id'],'weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
		$orderid = $srdb['id'];
	}else{
		pdo_insert('cwgl_user_payofficial', $data);
		$orderid = pdo_insertid();
	}
	
	//判断已经支付操作过
	$order_inom = pdo_get('cwgl_order_inom', array('weid' => $_W['uniacid'],'did' => $orderid,'type' => 'gm'));
	if (empty($order_inom)) {
	
		$data = array(
			'weid' => $_W['uniacid'],
			'did' => intval($orderid),
			'type' => 'gm',
			'paymoney' => $cwgl_config['month_money']
		);
		pdo_insert('cwgl_order_inom', $data);
		$tid = pdo_insertid();
		
	}else{
	
		$tid = $order_inom['id'];
		if ($order_inom['status'] != '0') {
			message('抱歉，您的欠费信息已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('user_paycost'), 'error');
		}
		
	}
	
	$params['tid'] = $tid;
	$params['user'] = $_W['fans']['from_user'];
	$params['fee'] = $cwgl_config['month_money'];
	$params['title'] = "购买成为正式会员";
	$params['ordersn'] = date('md') . random(4, 1);
	$params['virtual'] = false;
	
	include $this->template('pay3');
	
}else{

	
	include $this->template('user_payofficial');
	
}