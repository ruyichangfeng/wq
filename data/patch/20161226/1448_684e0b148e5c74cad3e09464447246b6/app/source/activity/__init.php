<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
checkauth();
load()->model('activity');
load()->model('mc');
load()->classs('coupon');
$coupon_api = new coupon();
$creditnames = array();
$unisettings = uni_setting($uniacid, array('creditnames', 'coupon_type', 'exchange_enable'));
if (!empty($unisettings) && !empty($unisettings['creditnames'])) {
	foreach ($unisettings['creditnames'] as $key=>$credit) {
		$creditnames[$key] = $credit['title'];
	}
}

$cardstatus = pdo_get('mc_card', array('uniacid' => $_W['uniacid']), array('status'));
$type_names = activity_coupon_type_label();
