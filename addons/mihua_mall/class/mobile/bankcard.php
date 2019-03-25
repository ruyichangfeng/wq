<?php
$uniacid = $_W['uniacid'];
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
$rule = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_rule') . " WHERE `uniacid` = :uniacid ", array(':uniacid' => $_W['uniacid']));
if (empty($from_user)) {
	message('你想知道怎么加入么?', $rule['gzurl'], 'sucessr');
	exit;
}
$id = $profile['id'];
if (empty($profile['id'])) {
	include $this->template('forbidden');
	exit;
}
if (empty($profile)) {
	message('请先注册', $this->createMobileUrl('register'), 'error');
	exit;
}
if ($op == 'edit') {
	$data = array('bankcard' => $_GPC['bankcard'], 'banktype' => $_GPC['banktype'], 'alipay' => $_GPC['alipay'], 'wxhao' => $_GPC['wxhao']);
	if (!empty($data['bankcard']) && !empty($data['banktype'])) {
		pdo_update('mihua_mall_member', $data, array('from_user' => $from_user));
		if ($_GPC['opp'] == 'complated') {
			echo 3;
			exit;
		}
		echo 1;
	} else {
		echo 0;
	}
	exit;
}
include $this->template('bankcard');