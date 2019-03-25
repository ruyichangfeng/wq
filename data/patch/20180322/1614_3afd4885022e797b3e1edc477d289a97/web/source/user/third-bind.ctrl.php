<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('user');
$do = safe_gpc_string($_GPC['do']);
$dos = array('display', 'validate_mobile', 'bind_mobile');
$do = in_array($do, $dos) ? $do : 'display';

if (in_array($do, array('validate_mobile', 'bind_mobile'))) {
	$user_table = table('users');
	$user_profile = $user_table->userProfile($_W['uid']);
	$mobile = trim($_GPC['mobile']);
	$mobile_exists = $user_table->userProfileMobile($mobile);

	if (empty($mobile)) {
		iajax(-1, '手机号不能为空');
	}
	if (!preg_match(REGULAR_MOBILE, $mobile)) {
		iajax(-1, '手机号格式不正确');
	}
	if (empty($type) && !empty($mobile_exists)) {
		iajax(-1, '手机号已存在');
	}
}

if ($do == 'validate_mobile') {
	iajax(0, '本地校验成功');
}

if ($do == 'bind_mobile') {
	if ($_W['isajax'] && $_W['ispost']) {
		$bind_info = OAuth2Client::create('mobile')->bind();
		if (is_error($bind_info)) {
			iajax(-1, $bind_info['message']);
		}
		iajax(0, '绑定成功', url('user/profile/bind'));
	} else {
		iajax(-1, '非法请求');
	}
}

if ($do == 'display') {
	$support_bind_urls = user_support_urls();
	$setting_sms_sign = setting_load('site_sms_sign');
	$bind_sign = !empty($setting_sms_sign['site_sms_sign']['register']) ? $setting_sms_sign['site_sms_sign']['register'] : '';
}
template('user/third-bind');