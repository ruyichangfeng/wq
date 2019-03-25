<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('copyright');
$do = in_array($do, $dos) ? $do : 'copyright';
$_W['page']['title'] = '站点设置 - 工具  - 系统管理';
$settings = $_W['setting']['copyright'];

if(empty($settings) || !is_array($settings)) {
	$settings = array();
} else {
	$settings['slides'] = iunserializer($settings['slides']);
}

if ($do == 'copyright') {
	
	if (checksubmit('submit')) {
		
		
			$data = array(
				'status' => $_GPC['status'],
				'reason' => $_GPC['reason'],
				'icp' => safe_gpc_string($_GPC['icp']),
				'mobile_status' => $_GPC['mobile_status'],
				'login_type' => $_GPC['login_type'],
				'log_status' => intval($_GPC['log_status']),
				'develop_status' => intval($_GPC['develop_status']),
				'bind' => $_GPC['bind'],
				'welcome_link' => intval($_GPC['welcome_link'])
			);
		

		$test = setting_save($data, 'copyright');

		

		itoast('更新设置成功！', url('system/site'), 'success');
	}
}

template('system/site');