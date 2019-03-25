<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('welcome');
load()->model('cloud');
load()->func('communication');
load()->func('db');
load()->model('extension');
load()->model('module');
load()->model('system');
load()->model('user');
load()->model('wxapp');

$dos = array('platform', 'system', 'ext', 'get_fans_kpi', 'get_last_modules', 'get_system_upgrade', 'get_upgrade_modules', 'get_module_statistics', 'get_ads', 'get_not_installed_modules');
$do = in_array($do, $dos) ? $do : 'platform';

if ($do == 'get_not_installed_modules') {
	$data = array();
	$not_installed_modules = module_get_all_unistalled('uninstalled', false);
	$not_installed_modules = $not_installed_modules['modules']['uninstalled'];
	$data['app_count'] = count($not_installed_modules['app']);
	$data['wxapp_count'] = count($not_installed_modules['wxapp_count']);
	$not_installed_modules['app'] = is_array($not_installed_modules['app']) ? array_slice($not_installed_modules['app'], 0, 4) : array();
	$not_installed_modules['wxapp'] = is_array($not_installed_modules['wxapp']) ? array_slice($not_installed_modules['wxapp'], 0, 4) : array();
	$data['module'] = array_merge($not_installed_modules['app'], $not_installed_modules['wxapp']);
	if (is_array($data['module']) && !empty($data['module'])) {
		foreach ($data['module'] as &$module) {
			if ($module['app_support'] == 2) {
				$module['link'] = url('module/manage-system/not_installed', array('account_type' => ACCOUNT_TYPE_OFFCIAL_NORMAL));
			} else {
				$module['link'] = url('module/manage-system/not_installed', array('account_type' => ACCOUNT_TYPE_APP_NORMAL));
			}
		}
	}
	iajax(0, $data);
}


	if ($do == 'ext') {
		if (!empty($_GPC['version_id'])) {
			$version_info = wxapp_version($_GPC['version_id']);
		}
		$account_api = WeAccount::create();
		if (is_error($account_api)) {
			message($account_api['message'], url('account/display'));
		}
		$check_manange = $account_api->checkIntoManage();
		if (is_error($check_manange)) {
			$account_display_url = $account_api->accountDisplayUrl();
			itoast('', $account_display_url);
		}
	}




if ($do == 'platform') {
	$last_uniacid = uni_account_last_switch();
	if (empty($last_uniacid)) {
		itoast('', url('account/display'), 'info');
	}
	if (!empty($last_uniacid) && $last_uniacid != $_W['uniacid']) {
		uni_account_switch($last_uniacid,  url('home/welcome'));
	}
	define('FRAME', 'account');
	if (empty($_W['account']['endtime']) && !empty($_W['account']['endtime']) && $_W['account']['endtime'] < time()) {
		itoast('公众号已到服务期限，请联系管理员并续费', url('account/manage'), 'info');
	}
		$notices = welcome_notices_get();

	template('home/welcome');
} elseif ($do == 'system') {
	define('FRAME', 'system');
	$_W['page']['title'] = '欢迎页 - 系统管理';
	if(!$_W['isfounder'] || user_is_vice_founder()){
		header('Location: ' . url('account/manage', array('account_type' => 1)), true);
		exit;
	}
	$reductions = system_database_backup();
	if (!empty($reductions)) {
		$last_backup = array_shift($reductions);
		$last_backup_time = $last_backup['time'];
		$backup_days = welcome_database_backup_days($last_backup_time);
	} else {
		$backup_days = 0;
	}
	template('home/welcome-system');
} elseif ($do =='get_module_statistics') {
	$uninstall_modules = module_get_all_unistalled('uninstalled');
	$account_uninstall_modules_nums = $uninstall_modules['app_count'];
	$wxapp_uninstall_modules_nums = $uninstall_modules['wxapp_count'];

	$account_modules = user_module_by_account_type('account');
	$wxapp_modules = user_module_by_account_type('wxapp');

	$account_modules_total = count($account_modules) + $account_uninstall_modules_nums;
	$wxapp_modules_total = count($wxapp_modules) + $wxapp_uninstall_modules_nums;

	$module_statistics = array(
		'account_uninstall_modules_nums' => $account_uninstall_modules_nums,
		'wxapp_uninstall_modules_nums' => $wxapp_uninstall_modules_nums,
		'account_modules_total' => $account_modules_total,
		'wxapp_modules_total' => $wxapp_modules_total
	);
	iajax(0, $module_statistics, '');
} elseif ($do == 'ext') {
	$modulename = $_GPC['m'];
	if (!empty($modulename)) {
		$_W['current_module'] = module_fetch($modulename);
	}
	define('FRAME', 'account');
	define('IN_MODULE', $modulename);
	if ($_GPC['system_welcome'] && $_W['isfounder']) {
		$frames = buildframes('system_welcome');
	} else {
		$site = WeUtility::createModule($modulename);
		if (!is_error($site)) {
			$method = 'welcomeDisplay';
			if(method_exists($site, $method)){
				define('FRAME', 'module_welcome');
				$entries = module_entries($modulename, array('menu', 'home', 'profile', 'shortcut', 'cover', 'mine'));
				$site->$method($entries);
				exit;
			}
		}
		$frames = buildframes('account');
	}
	$uni_account_module = table('module')->uniAccountModuleInfo($modulename);
	foreach ($frames['section'] as $secion) {
		foreach ($secion['menu'] as $menu) {
			if (!empty($menu['url'])) {
				if (!empty($uni_account_module['settings']['default_entry']) && !strpos($menu['url'], '&eid=' . $uni_account_module['settings']['default_entry'])) {
					continue;
				}
				header('Location: ' . $_W['siteroot'] . 'web/' . $menu['url']);
				exit;
			}
		}
	}
	template('home/welcome-ext');
} elseif ($do == 'get_fans_kpi') {
	uni_update_week_stat();
		$yesterday = date('Ymd', strtotime('-1 days'));
	$yesterday_stat = pdo_get('stat_fans', array('date' => $yesterday, 'uniacid' => $_W['uniacid']));
	$yesterday_stat['new'] = intval($yesterday_stat['new']);
	$yesterday_stat['cancel'] = intval($yesterday_stat['cancel']);
	$yesterday_stat['jing_num'] = intval($yesterday_stat['new']) - intval($yesterday_stat['cancel']);
	$yesterday_stat['cumulate'] = intval($yesterday_stat['cumulate']);
		$today_stat = pdo_get('stat_fans', array('date' => date('Ymd'), 'uniacid' => $_W['uniacid']));
	$today_stat['new'] = intval($today_stat['new']);
	$today_stat['cancel'] = intval($today_stat['cancel']);
	$today_stat['jing_num'] = $today_stat['new'] - $today_stat['cancel'];
	$today_stat['cumulate'] = intval($today_stat['jing_num']) + $yesterday_stat['cumulate'];
	if($today_stat['cumulate'] < 0) {
		$today_stat['cumulate'] = 0;
	}
	iajax(0, array('yesterday' => $yesterday_stat, 'today' => $today_stat), '');
} elseif ($do == 'get_last_modules') {
		$last_modules = welcome_get_last_modules();
	if (is_error($last_modules)) {
		iajax(1, $last_modules['message'], '');
	} else {
		iajax(0, $last_modules, '');
	}
} elseif ($do == 'get_system_upgrade') {
		$upgrade = welcome_get_cloud_upgrade();
	iajax(0, $upgrade, '');
} elseif ($do == 'get_upgrade_modules') {
		$account_upgrade_modules = module_upgrade_new('account');
	$account_upgrade_module_nums = count($account_upgrade_modules);
	$wxapp_upgrade_modules = module_upgrade_new('wxapp');
	$wxapp_upgrade_module_nums = count($wxapp_upgrade_modules);

	$account_upgrade_module_list = array_slice($account_upgrade_modules, 0, 4);
	$wxapp_upgrade_module_list = array_slice($wxapp_upgrade_modules, 0, 4);
	$upgrade_module_list = array_merge($account_upgrade_module_list, $wxapp_upgrade_module_list);

	$upgrade_module = array(
		'upgrade_module_list' => $upgrade_module_list,
		'upgrade_module_nums' => array(
			'account_upgrade_module_nums' => $account_upgrade_module_nums,
			'wxapp_upgrade_module_nums' => $wxapp_upgrade_module_nums
		)
	);
	iajax(0, $upgrade_module, '');
} elseif ($do == 'get_ads') {
	$ads = welcome_get_ads();
	if (is_error($ads)) {
		iajax(1, $ads['message']);
	} else {
		iajax(0, $ads);
	}
}