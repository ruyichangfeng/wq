<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn: pro/web/index.php : v 14b9a4299104 : 2015/09/11 10:44:21 : yanghf $
 */
define('IN_SYS', true);
require '../../../framework/bootstrap.inc.php';
define('FM_JIAOYUL_ROOT', dirname(dirname(__FILE__)));
define('IS_OPERATOR', true);
require FM_JIAOYUL_ROOT . '/admin/common/bootstrap.sys.inc.php';
require FM_JIAOYUL_ROOT . '/admin/common/template.func.php';
require FM_JIAOYUL_ROOT . '/admin/common/common.func.php';
$urls = parse_url($_W['siteroot']);
$arr = explode('/', $urls['path']);
if(in_array('addons', $arr)) {
	do {
		$val = array_pop($arr);
	} while ($val != 'addons');
}
$path = implode('/', $arr);
if(substr($path, -1) != '/') {
	$path .= '/';
}
$urls['path'] = $path;
$_W['siteroot'] = $urls['scheme'].'://'.$urls['host'].((!empty($urls['port']) && $urls['port']!='80') ? ':'.$urls['port'] : '').$urls['path'];

$acl = array(
	'user' => array(
		'default' => 'login',
		'direct' => array(
			'login',
			'register',
			'logout',
		),
	),
);
if (($_W['setting']['copyright']['status'] == 1) && empty($_W['isfounder']) && $controller != 'cloud' && $controller != 'utility') {
	$_W['siteclose'] = true;
	if ($controller == 'user' && $action == 'login') {
		if (checksubmit()) {
			require _forward($controller, $action);
		}
		template('user/login');
		exit;
	}
	isetcookie('___shop_session___', '', -10000);
	message('站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason'], '', 'info');
}

$controllers = array();
$handle = opendir(FM_JIAOYUL_ROOT . '/admin/source/');
if(!empty($handle)) {
	while($dir = readdir($handle)) {
		if($dir != '.' && $dir != '..') {
			$controllers[] = $dir;
		}
	}
}
if(!in_array($controller, $controllers)) {
	$controller = 'user';
}
$init = FM_JIAOYUL_ROOT . "/admin/source/{$controller}/__init.php";
if(is_file($init)) {
	require $init;
}
$actions = array();
$handle = opendir(FM_JIAOYUL_ROOT . '/admin/source/' . $controller);
if(!empty($handle)) {
	while($dir = readdir($handle)) {
		if($dir != '.' && $dir != '..' && strexists($dir, '.ctrl.php')) {
			$dir = str_replace('.ctrl.php', '', $dir);
			$actions[] = $dir;
		}
	}
}

if(!in_array($action, $actions)) {
	$action = $acl[$controller]['default'];
}
if(!in_array($action, $actions)) {
	$action = $actions[0];
}

if(is_array($acl[$controller]['direct']) && in_array($action, $acl[$controller]['direct'])) {
	require _forward($controller, $action);
	exit;
}

checkLogin();
if (empty($_W['uniacid'])) {
	message('非法参数！', '', 'error');
}
if(!defined('IN_GW')) {
	checkaccount();
	if(!in_array($_W['role'], array('manager', 'operator', 'founder', 'clerk'))) {
		message('您的账号没有访问此公众号的权限.');
	}
}
require _forward($controller, $action);

function _forward($c, $a) {
	$file = FM_JIAOYUL_ROOT . '/admin/source/' . $c . '/' . $a . '.ctrl.php';
	return $file;
}