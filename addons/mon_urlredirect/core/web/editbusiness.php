<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/3/22
 * Time: 23:22
 */

defined('IN_IA') or exit('Access Denied');


$bid = $_GPC['bid'];

$business = DBUtil::findById(DBUtil::$TABLE_COUPON_BUSINESS, $bid);


if (checksubmit('submit')) {

	$data = array(
		'weid' => $this->weid,
		'title' => $_GPC['title'],
		'lng' => $_GPC['lng'],
		'lat' => $_GPC['lat'],
		'address' => $_GPC['baddress'],
		'location_p' => $_GPC['location_p'],
		'location_c' => $_GPC['location_c'],
		'location_a' => $_GPC['location_a'],
		'tel' => $_GPC['tel'],
		'display_order' => $_GPC['display_order'],
		'createtime' => TIMESTAMP
	);



	if (empty($business)) {
		$opFlagAdd = true;
		$data['createtime'] = TIMESTAMP;
		DBUtil::create(DBUtil::$TABLE_COUPON_BUSINESS, $data);
	} else {
		DBUtil::updateById(DBUtil::$TABLE_COUPON_BUSINESS, $data, $bid);

	}

	if ($opFlagAdd) {
		message('新增商家！', $this->createWebUrl('businessManger', array(
			'op' => 'display',
		)), 'success');
	} else {
		message('修改商城信息！', $this->createWebUrl('businessManger', array(
			'op' => 'display',
		)), 'success');
	}

} else {

	load()->func('tpl');
	include $this->template("web/editbusiness" );
}