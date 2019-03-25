<?php

defined('IN_IA') or exit('Access Denied');
load()->model('phoneapp');
load()->model('account');

$_W['page']['title'] = 'APP列表';

$do = safe_gpc_belong($do, array('display', 'switch', 'home'), 'display');

if ($do == 'switch') {
	$uniacid = intval($_GPC['uniacid']);

	if (!empty($uniacid)) {
		$phoneapp_info = phoneapp_fetch($uniacid);
		if (empty($phoneapp_info)) {
			itoast('APP不存在', referer(), 'error');
		}
	}

	$module_name = safe_gpc_string($_GPC['module']);
	$version_id = !empty($_GPC['version_id']) ? intval($_GPC['version_id']) : $wxapp_info['version']['id'];
	if (!empty($module_name) && !empty($version_id)) {
		$version_info = phoneapp_version($version_id);
		$module_info = array();
		if (!empty($version_info['modules'])) {
			foreach ($version_info['modules'] as $key => $module_val) {
				if ($module_val['name'] == $module_name) {
					$module_info = $module_val;
				}
			}
		}
		if (empty($version_id) || empty($module_info)) {
			itoast('版本信息错误');
		}
		$url = url('home/welcome/ext/', array('m' => $module_name));
		if (!empty($module_info['account']['uniacid'])) {
			uni_account_switch($module_info['account']['uniacid'], $url);
		} else {
			$url .= '&version_id=' . $version_id;
			uni_account_switch($version_info['uniacid'], $url, PHONEAPP_TYPE_SIGN);
		}
	}
	phoneapp_update_last_use_version($uniacid, $version_id);
	uni_account_switch($uniacid, url('phoneapp/version/home', array('version_id' => $version_id)), PHONEAPP_TYPE_SIGN);
	exit;

}

if ($do == 'home') {
	$last_uniacid = uni_account_last_switch();
	$url = url('phoneapp/display');
	if (empty($last_uniacid)) {
		itoast('', $url, 'info');
	}
	if (!empty($last_uniacid) && $last_uniacid != $_W['uniacid']) {
		uni_account_switch($last_uniacid, '', PHONEAPP_TYPE_SIGN);
	}
	$permission = permission_account_user_role($_W['uid'], $last_uniacid);
	if (empty($permission)) {
		itoast('', $url, 'info');
	}
	$last_version = phoneapp_fetch($last_uniacid);
	if (!empty($last_version)) {
		$url = url('phoneapp/version/home', array('version_id' => $last_version['version']['id']));
	}
	itoast('', $url, 'info');
}

if ($do == 'display') {
		$account_info = permission_user_account_num();

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;

	$account_table = table('phoneapp');
	$account_table->searchWithType(array(ACCOUNT_TYPE_PHONEAPP_NORMAL));

	$keyword = safe_gpc_string($_GPC['keyword']);
	if (!empty($keyword)) {
		$account_table->searchWithKeyword($keyword);
	}

	$account_table->searchWithPage($pindex, $psize);
	$phoneapp_lists = $account_table->searchAccountList();
	$total = $account_table->getLastQueryTotal();

	if (!empty($phoneapp_lists)) {
		foreach ($phoneapp_lists as &$account) {
			$account = uni_fetch($account['uniacid']);
			$account['versions'] = phoneapp_get_some_lastversions($account['uniacid']);
			if (!empty($account['versions'])) {
				foreach ($account['versions'] as $version) {
					if (!empty($version['current'])) {
						$account['current_version'] = $version;
					}
				}
			}
		}
	}

	$pager = pagination($total, $pindex, $psize);
	template('phoneapp/display');
}