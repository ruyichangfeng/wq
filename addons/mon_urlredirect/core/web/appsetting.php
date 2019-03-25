<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/8
 * Time: 23:33
 */

defined('IN_IA') or exit('Access Denied');
load()->func('tpl');

$appsetting = DBUtil::findUnique(DBUtil::$TABLE_COUPON_SETTING, array(':weid' => $this->weid));
if (checksubmit('submit')) {
	$data = array(
		'weid' => $this->weid,
		'appid' => trim($_GPC['appid']),
		'appsecret' => trim($_GPC['appsecret']),
		'follow_enable' => $_GPC['follow_enable'],
		'follow_title'=> $_GPC['follow_title'],
		'erweim' => $_GPC['erweim'],
		'follow_tip' => $_GPC['follow_tip'],
		'page_size' => $_GPC['page_size'],
		'coupon_help' =>  htmlspecialchars_decode($_GPC['coupon_help']),
		'app_icon' => $_GPC['app_icon'],
		'app_name' => $_GPC['app_name'],
		'contact_tel' => $_GPC['contact_tel'],
		'contact_wx' => $_GPC['contact_wx'],
		'copyright' => $_GPC['copyright'],
		'share_title'=> $_GPC['share_title'],
		'share_icon' => $_GPC['share_icon'],
		'share_content' => $_GPC['share_content'],
		'createtime' => TIMESTAMP
	);
	
	$accessToken = $this->findUserAccessToken();
	if (!empty($accessToken)) {
		$data['access_token'] = $accessToken;
	}

	if (!empty($appsetting)) {
		DBUtil::updateById(DBUtil::$TABLE_COUPON_SETTING, $data, $appsetting['id']);
	} else {
		DBUtil::create(DBUtil::$TABLE_COUPON_SETTING, $data);
	}
	message('设置成功！', $this->createWebUrl('AppSetting', array(
		'op' => 'display'
	)), 'success');
}


include $this->template("web/appsetting");