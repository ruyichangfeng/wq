<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'change_read_status', 'event_notice');
$do = in_array($do, $dos) ? $do : 'display';
load()->model('message');

$_W['page']['title'] = '系统管理 - 消息提醒 - 消息提醒';

if ($do == 'display') {
	$message_id = safe_gpc_int($_GPC['message_id']);
	message_notice_read($message_id);

	$types = $type = safe_gpc_int($_GPC['type']);
	$pindex = safe_gpc_int($_GPC['page'], 1);
	$psize = 10;

	$message_table = table('message');
	$is_read = !empty($_GPC['is_read']) ? safe_gpc_int($_GPC['is_read']) : '';

	if (!empty($is_read)) {
		$message_table->searchWithIsRead($is_read);
	}

	if ($type == MESSAGE_ACCOUNT_EXPIRE_TYPE) {
		$types = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE);
	}

	

	
		if (empty($type) && !user_is_founder($_W['uid'])){
			$types = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE, MESSAGE_USER_EXPIRE_TYPE, MESSAGE_WXAPP_MODULE_UPGRADE);
		}
	

	if (!empty($types)) {
		$message_table->searchWithType($types);
	}
	$message_table->searchWithPage($pindex, $psize);
	$lists = $message_table->messageList($type);

	$lists = message_list_detail($lists);

	$total = $message_table->getLastQueryTotal();
	$pager = pagination($total, $pindex, $psize);
}

if ($do == 'change_read_status') {
	$id = $_GPC['id'];
	message_notice_read($id);
	iajax(0, '成功');
}

if ($do == 'event_notice') {
	if (!pdo_tableexists('message_notice_log')) {
		iajax(-1);
	}
	$message = message_event_notice_list();
	$cookie_name = $_W['config']['cookie']['pre'] . '__notice';
	if (empty($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] < TIMESTAMP) {
		message_account_expire();
		message_notice_worker();
		message_sms_expire_notice();
		message_user_expire_notice();
		message_wxapp_modules_version_upgrade();
	}
	iajax(0, $message);

}
template('message/notice');