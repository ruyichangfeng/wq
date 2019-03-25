<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


load()->model('webapp');
$account_info = permission_user_account_num();

$do = safe_gpc_belong($do, array('create', 'list', 'create_display'), 'list');

if($do == 'create') {
	if(!checksubmit()) {
		echo '非法提交';
		return;
	}
	if (!webapp_can_create($_W['uid'])) {
		itoast('创建PC个数已满', url('webapp/manage/list'));
	}
	$data = array(
		'name' => safe_gpc_string($_GPC['name']),
		'description' => safe_gpc_string($_GPC['description'])
	);

	$webapp = table('webapp');
	$uniacid = $webapp->createWebappInfo($data, $_W['uid']);
	if($uniacid){
		itoast('创建成功', url('webapp/manage/list'));
	}
}

if($do == 'create_display') {
	if(!webapp_can_create($_W['uid'])) {
		itoast('', url('webapp/manage/list'));
	}
	template('webapp/create');
}

if($do == 'list') {

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$account_table = table('webapp');
	$account_table->searchWithType(array(ACCOUNT_TYPE_WEBAPP_NORMAL));

	$keyword = trim($_GPC['keyword']);
	if (!empty($keyword)) {
		$account_table->searchWithKeyword($keyword);
	}

	$account_table->accountRankOrder();
	$account_table->searchWithPage($pindex, $psize);
	$list = $account_table->searchAccountList();
	$total = $account_table->getLastQueryTotal();

	$pager = pagination($total, $pindex, $psize);

	if (!empty($list)) {
		foreach ($list as &$account) {
			$account = uni_fetch($account['uniacid']);
			$account['switchurl'] = url('webapp/home/switch', array('uniacid' => $account['uniacid']));
		}
	}

	template('webapp/list');
}