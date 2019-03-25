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
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	

	
		$types = $type = !empty($_GPC['type']) ? intval($_GPC['type']) : MESSAGE_ACCOUNT_EXPIRE_TYPE;
	

	if ($type == MESSAGE_ACCOUNT_EXPIRE_TYPE) {
		$types = array(MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE, MESSAGE_WEBAPP_EXPIRE_TYPE);
	}
	$is_read = !empty($_GPC['is_read']) ? trim($_GPC['is_read']) : '';

	$message_table = table('message');

	if (!empty($is_read)) {
		$message_table->searchWithIsRead($is_read);
	}

	$message_table->searchWithType($types);
	$message_table->searchWithPage($pindex, $psize);
	$lists = $message_table->messageList();

	if (!empty($lists)) {
		foreach($lists as &$list) {
			$list['create_time'] = date('Y-m-d H:i:s', $list['create_time']);
		}
	}
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
	message_account_expire();
	message_notice_worker();
	iajax(0, $message);

}
template('message/notice');