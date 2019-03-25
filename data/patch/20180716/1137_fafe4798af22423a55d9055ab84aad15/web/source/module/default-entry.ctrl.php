<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('wxapp');

$dos = array('display');
$do = in_array($do, $dos) ? $do : 'display';

$module_name = trim($_GPC['m']);
$modulelist = uni_modules(false);
$module = $_W['current_module'] = $modulelist[$module_name];
define('IN_MODULE', $module_name);
if(empty($module)) {
	itoast('抱歉，你操作的模块不能被访问！');
}
if(!permission_check_account_user_module()) {
	itoast('您没有权限进行该操作');
}

if ($do == 'display') {
	$menu_entries = module_entries($module_name, array('menu'));
	$menu_entries = $menu_entries['menu'];
	$uni_account_module_setting = table('module')->uniAccountModuleInfo($module_name);
	$default_entry_id = !empty($uni_account_module_setting['settings']) ? intval($uni_account_module_setting['settings']['default_entry']) : 0;
	if (checksubmit()) {
		$default_entry = intval($_GPC['default_entry_id']);
		$data = !empty($uni_account_module_setting['settings']) ? $uni_account_module_setting['settings'] : array();
		if (empty($default_entry)) {
			unset($data['default_entry']);
		} else {
			$data['default_entry'] = $default_entry;
		}
		if (empty($uni_account_module_setting)) {
			$insert_data['settings'] = iserializer($data);
			$insert_data['uniacid'] = $_W['uniacid'];
			$insert_data['module'] = $module_name;
			$insert_data['enabled'] = 1;
			pdo_insert('uni_account_modules', $insert_data);
		} else {
			pdo_update('uni_account_modules', array('settings' => iserializer($data)), array('uniacid' => $_W['uniacid'], 'module' => $module_name));
		}
		itoast('保存成功！');
	}
	template('module/default-entry');
}