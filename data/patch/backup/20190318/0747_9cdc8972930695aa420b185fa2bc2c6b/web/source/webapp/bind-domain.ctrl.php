<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('bind_domain', 'delete', 'default_module');
$do = in_array($do, $dos) ? $do : 'bind_domain';

$_W['page']['title'] = '域名访问设置';


if ($do == 'bind_domain') {
	
	$modulelist = uni_modules();
	if (!empty($modulelist)) {
		foreach ($modulelist as $key => $module_val) {
			if (!empty($module_val['issystem']) || $module_val['webapp_support'] != MODULE_SUPPORT_WEBAPP) {
				unset($modulelist[$key]);
				continue;
			}
		}
	}
	template('webapp/bind-domain');
}

if ($do == 'delete') {
	uni_setting_save('bind_domain', '');
	itoast('删除成功！', referer(), 'success');
}


if ($do == 'default_module') {
	$module_name = safe_gpc_string($_GPC['module_name']);
	if (empty($module_name)) {
		iajax(-1, '请选择一个模块！');
	}
	$modulelist = array_keys(uni_modules());
	if (!in_array($module_name, $modulelist)) {
		iajax(-1, '模块不可用！');
	}
	uni_setting_save('default_module', $module_name);
	iajax(0, '修改成功！', referer());
}