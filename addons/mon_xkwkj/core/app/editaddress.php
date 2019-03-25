<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');

$kid = $_GPC['kid'];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'edit';

$aid = $_GPC['aid'];
if ($operation == 'edit') {


	if (empty($uc)) {
		$userUniData = array(
			'weid' => $this->weid,
			'openid' => $fansInfo['openid'],
			'nickname' => $fansInfo['nickname'],
			'headimgurl' => $fansInfo['headimgurl'],
			'uname' => $_GPC['funame'],
			'tel' => $_GPC['futel'],
			'createtime' => TIMESTAMP
		);

		DBUtil::create(DBUtil::$TABLE_XKWKJ_USER_INFO, $userUniData);//注册用户

		$unid = pdo_insertid();
	} else {
		$unid = $userUniData['id'];
	}

	$addressData = array(
		'weid' => $this->weid,
		'openid' => $fansInfo['openid'],
		'unid' => $unid,
		'is_default' => $_GPC['is_default'],
		'uname' => $_GPC['uname'],
		'tel' => $_GPC['tel'],
		'province' => $_GPC['prov'],
		'city' => $_GPC['city'],
		'county' => $_GPC['dist'],
		'address' => $_GPC['address'],
	);


	if ($addressData['is_default'] == 1) {
		pdo_query("update " . tablename(DBUtil::$TABLE_XKWKJ_USER_ADDRESS) . " set is_default = 0");
	}

	if (empty($aid)) {
		$addressData['createtime'] = TIMESTAMP;
		DBUtil::create(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, $addressData);
		$aid = pdo_insertid();
	} else {
		DBUtil::updateById(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, $addressData, $aid);
	}

	die(json_encode(array('code'=> 200, 'addid' => $aid)));
} else {
	if (!empty($aid)) {
		$address = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, $aid);
	}


	include $this->template('edit_address');
}




