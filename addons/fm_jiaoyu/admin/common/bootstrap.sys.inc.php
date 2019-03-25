<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn$
 */
load()->model('user');
load()->func('tpl');
$_W['token'] = token();
if(IMS_VERSION >= '1.4.4'){
	$session = json_decode(authcode($_GPC['__session']), true);
}else{
	$session = json_decode(base64_decode($_GPC['__session']), true);
}
if(is_array($session)) {
	$user = user_single(array('uid'=>$session['uid']));
	if(is_array($user) && $session['hash'] == md5($user['password'] . $user['salt'])) {
		$_W['uid'] = $user['uid'];
		$_W['username'] = $user['username'];
		$user['currentvisit'] = $user['lastvisit'];
		$user['currentip'] = $user['lastip'];
		$user['lastvisit'] = $session['lastvisit'];
		$user['lastip'] = $session['lastip'];
		$_W['user'] = $user;
		$founders = explode(',', $_W['config']['setting']['founder']);
		$_W['isfounder'] = in_array($_W['uid'], $founders);
		unset($founders);
	} else {
		isetcookie('__session', false, -100);
	}
	unset($user);
}
unset($session);

if(!empty($_GPC['__uniacid'])) {
	$_W['uniacid'] = intval($_GPC['__uniacid']);
	$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
	$_W['acid'] = $_W['account']['acid'];
	$_W['weid'] = $_W['uniacid'];
	if(!empty($_W['uid'])) {
		$_W['role'] = uni_permission($_W['uid'], $_W['uniacid']);
	}
}
$_W['template'] = 'default';
if(!empty($_W['setting']['basic']['template'])) {
	$_W['template'] = $_W['setting']['basic']['template'];
}

if(!empty($_W['modules'][$entry['module']]['handles']) && (count($_W['modules'][$entry['module']]['handles']) > 1 || !in_array('text', $_W['modules'][$entry['module']]['handles']))) {
	$handlestips = true;
}
$modules = uni_modules();
$_W['current_module'] = $modules['fm_jiaoyu'];
$site = WeUtility::createModuleSite('fm_jiaoyu');
define('IN_MODULE', 'fm_jiaoyu');

load()->func('compat.biz');
