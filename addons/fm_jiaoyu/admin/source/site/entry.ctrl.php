<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn$
 */
defined('IN_IA') or exit('Access Denied');
$eid = intval($_GPC['eid']);
if(!empty($eid)) {
	$sql = 'SELECT * FROM ' . tablename('modules_bindings') . ' WHERE `eid`=:eid';
	$entry = pdo_fetch($sql, array(':eid' => $eid));
} else {
	$sql = 'SELECT * FROM ' . tablename('modules_bindings') . ' WHERE module = :module AND do = :do';
	$entry = pdo_fetch($sql, array(':module' => trim($_GPC['m']), ':do' => trim($_GPC['do'])));
	if (empty($entry)) {
		$entry = array(
			'module' => $_GPC['m'],
			'do' => $_GPC['do'],
			'state' => $_GPC['state'],
			'direct' => $_GPC['direct']
		);
	}
}
if(empty($entry) || empty($entry['do'])) {
	message('非法访问.');
}
if(!$entry['direct']) {
	checkclerklogin();
	load()->model('module');
	$module = module_fetch($entry['module']);
	if(empty($module)) {
		message("访问非法, 没有操作权限1. (module: {$entry['module']})");
	}
}

$_GPC['__entry'] = $entry['title'];
$_GPC['__state'] = $entry['state'];

if(!empty($_W['modules'][$entry['module']]['handles']) && (count($_W['modules'][$entry['module']]['handles']) > 1 || !in_array('text', $_W['modules'][$entry['module']]['handles']))) {
	$handlestips = true;
}
$site = WeUtility::createModuleSite($entry['module']);
define('IN_MODULE', $entry['module']);
if(!is_error($site)) {
	$sysmodule = system_modules();
	if(in_array($m, $sysmodule)) {
		$site_urls = $site->getTabUrls();
	}
	$method = 'doWeb' . ucfirst($entry['do']);
	exit($site->$method());
}

exit("访问的方法 {$method} 不存在.");
