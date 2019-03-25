<?php
global $_GPC,$_W;
$filed = array('sid', 'menu_name', 'menu_href', 'menu_logo', 'sort');
$action = $_GPC['action'];

if ($action == 'create') {
	$dat  = array();
	foreach ($_GPC as $key => $value) {
		if (in_array($key, $filed)) {
			$dat[$key] = $value;
		}
	}
	pdo_insert('tjtjtj_xxzt_account_menu', $dat);
	message('创建成功', $this->createWebUrl('usermenu'), 'success');
}
if ($action == 'edit') {
	$uid = intval($_GPC['uid']);
	$menu = pdo_get('tjtjtj_xxzt_account_menu', array('uid' => $uid));
	!$menu && message('菜单不存在', $this->createWebUrl('usermenu'), 'error');
}
if ($action == 'update') {
	$dat  = array();
	foreach ($_GPC as $key => $value) {
		if (in_array($key, $filed)) {
			$dat[$key] = $value;
		}
	}
	pdo_update('tjtjtj_xxzt_account_menu', $dat, array('uid' => $_GPC['uid']));
	message('更新成功', $this->createWebUrl('usermenu'), 'success');
}
if ($action == 'delete') {
	pdo_delete('tjtjtj_xxzt_account_menu', array('uid' => $_GPC['uid']));
	message('成功删除', $this->createWebUrl('usermenu'), 'success');
}
if ($action != '') {
	include_once $this->template('usermenu');
}

$menus = pdo_fetchall(
		'select * from '.tablename('tjtjtj_xxzt_account_menu').' where sid = :sid order by sort ASC',
		array(':sid' => $_W['uniacid'])
	);

include_once $this->template('usermenu');