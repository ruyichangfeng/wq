<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

//$urltk = $this->createMobileUrl('fw_show');
//
//$id = intval($_GPC['id']);
//$srdb = pdo_get('cwgl_service_list', array('weid' => $_W['uniacid'],'id' => $id));
//if (empty($srdb)) {
//	message('不存在或是已经被删除！', $this->createMobileUrl('fw_lsit'), 'success');
//}

//保存
if (checksubmit('do_submit')) {

	$sid = $_GPC['sid'];
	$price = $_GPC['price'];
	
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'orderid' => date('md') . random(4, 1),
		'price' => $price,
		'number' => 1,
		'paymoney' => $price,
		'paystatus' => 0,
		'sid' => intval($sid)
	);
	pdo_insert('cwgl_service_order', $data);
	$orderid = pdo_insertid();
	
	message('提交订单成功,现在跳转到付款页面...', $this->createMobileUrl('fw_pay', array('orderid' => $orderid)), 'success');
	
}