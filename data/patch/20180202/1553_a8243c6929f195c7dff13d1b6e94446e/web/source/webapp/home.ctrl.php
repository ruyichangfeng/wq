<?php

/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('webapp');
load()->model('account');

$dos = array('switch', 'display');
$do = in_array($do , $dos) ? $do : 'display';

if($do == 'switch') {
	$uniacid = intval($_GPC['uniacid']);
	if (empty($uniacid)) {
		itoast('', url('webapp/manage/list'), 'info');
	}
	webapp_save_switch($uniacid);
	itoast('', url('webapp/home/display'));
}

if($do == 'display') {
	$last_uniacid = uni_account_last_switch();
	if (empty($last_uniacid)) {
		itoast('', url('webapp/manage/list'), 'info');
	}
	if (!empty($last_uniacid) && $last_uniacid != $_W['uniacid']) {
		webapp_switch($last_uniacid);
	}

	$account = uni_fetch($last_uniacid);
	$modulelist = uni_modules(false);
	if (!empty($modulelist)) {
		foreach ($modulelist as $name => &$row) {
			if (!empty($row['issystem']) || $row['webapp_support'] != 2 || (!empty($_GPC['keyword']) && !strexists ($row['title'], $_GPC['keyword'])) || (!empty($_GPC['letter']) && $row['title_initial'] != $_GPC['letter'])) {
				unset($modulelist[$name]);
				continue;
			}
		}
		$modules = $modulelist;
	}
	template('webapp/home');
}


