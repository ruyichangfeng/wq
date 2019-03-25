<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function message_notice_read($id) {
	$id = intval($id);
	if (empty($id)) {
		return true;
	}
	pdo_update('message_notice_log', array('is_read' => MESSAGE_READ), array('id' => $id));
	return true;
}



function message_notice_record($content, $uid, $sign, $type, $extend_message = array()) {
	$message['message'] = $content;
	$message['uid'] = $uid;
	$message['sign'] = $sign;
	$message['type'] = $type;
	$message_notice_log = array_merge($message, $extend_message);
	$message_exists = message_validate_exists($message_notice_log);
	if (!empty($message_exists)) {
		return true;
	}
	if (empty($message_notice_log['create_time'])) {
		$message_notice_log['create_time'] = TIMESTAMP;
	}
	if (empty($message_notice_log['is_read'])) {
		$message_notice_log['is_read'] = MESSAGE_NOREAD;
	}
	$push_cloud_message_type = array(MESSAGE_ORDER_TYPE, MESSAGE_WORKORDER_TYPE, MESSAGE_REGISTER_TYPE);
	if (in_array($type, $push_cloud_message_type)) {
		message_notice_record_cloud($message_notice_log);
	}
	pdo_insert('message_notice_log', $message_notice_log);
	return true;
}


function message_validate_exists($message) {
	$message_exists = pdo_get('message_notice_log', $message);
	if (!empty($message_exists)) {
		return true;
	}
	return false;
}



function message_event_notice_list() {
	load()->model('user');
	global $_W;
	$message_table = table('message');
	$message_table->searchWithIsRead(MESSAGE_NOREAD);
	if (user_is_founder($_W['uid']) && !user_is_vice_founder($_W['uid'])) {
		$type = array(MESSAGE_ORDER_TYPE, MESSAGE_ACCOUNT_EXPIRE_TYPE, MESSAGE_REGISTER_TYPE, MESSAGE_WECHAT_EXPIRE_TYPE);
	} else {
		$type = MESSAGE_ACCOUNT_EXPIRE_TYPE;
	}
	$message_table->searchWithType($type);
	$message_table->searchWithPage(1, 10);
	$lists = $message_table->messageList();

	$message_table->searchWithIsRead(MESSAGE_NOREAD);
	$message_table->searchWithType($type);
	$total = $message_table->messageNoReadCount();
	if (!empty($lists)) {
		foreach ($lists as &$message) {
			$message['create_time'] = date('Y-m-d H:i:s', $message['create_time']);

			if ($message['type'] == MESSAGE_ORDER_TYPE) {
				$message['url'] = url('site/entry/orders', array('m' => 'store', 'direct'=>1, 'message_id' => $message['id']));
			}
			if ($message['type'] == MESSAGE_ACCOUNT_EXPIRE_TYPE) {
				$message['url'] = url('account/manage', array('account_type' => ACCOUNT_TYPE_OFFCIAL_NORMAL, 'message_id' => $message['id']));
			}
			if ($message['type'] == MESSAGE_WECHAT_EXPIRE_TYPE) {
				$message['url'] = url('account/manage', array('account_type' => ACCOUNT_TYPE_APP_NORMAL, 'message_id' => $message['id']));
			}

			if ($message['type'] == MESSAGE_WEBAPP_EXPIRE_TYPE) {
				$message['url'] = url('account/manage', array('account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL, 'message_id' => $message['id']));
			}

			if ($message['type'] == MESSAGE_REGISTER_TYPE && $message['status'] == USER_STATUS_CHECK) {
				$message['url'] = url('user/display', array('type' => 'check', 'message_id' => $message['id']));
			}

			if ($message['type'] == MESSAGE_REGISTER_TYPE && $message['status'] == USER_STATUS_NORMAL) {
				$message['url'] = url('user/display', array('message_id' => $message['id']));
			}
		}
	}
	return array(
		'lists' => $lists,
		'total' => $total
	);
}



function message_account_expire() {
	load()->model('account');
	if (!pdo_tableexists('message_notice_log')) {
		return true;
	}
	$account_table = table('account');
	$expire_account_list = $account_table->searchAccountList();
	if (empty($expire_account_list)) {
		return true;
	}
	foreach ($expire_account_list as $account) {
		$account_detail = uni_fetch($account['uniacid']);
		if (empty($account_detail['uid'])) {
			continue;
		}
		if ($account_detail['endtime'] > 0 && $account_detail['endtime'] < TIMESTAMP) {
			switch ($account_detail['type']) {
				case ACCOUNT_TYPE_APP_NORMAL:
					$type = MESSAGE_WECHAT_EXPIRE_TYPE;
					$account_name = '-小程序过期';
					break;
				case ACCOUNT_TYPE_WEBAPP_NORMAL:
					$type = MESSAGE_WEBAPP_EXPIRE_TYPE;
					$account_name = '-pc过期';
					break;
				default:
					$type = MESSAGE_ACCOUNT_EXPIRE_TYPE;
					$account_name = '-公众号过期';
					break;
			}
			$message = array(
				'end_time' => $account_detail['endtime']
			);
			message_notice_record($account_detail['name'] . $account_name, $account_detail['uid'], $account['uniacid'], $type, $message);
		}
	}
	return true;
}


function message_notice_worker() {
	global $_W;
	load()->func('communication');
	load()->classs('cloudapi');
	$api = new CloudApi();
	$table = table('message');
	$time = 0;
	$table->searchWithType(MESSAGE_WORKORDER_TYPE);
	$message_record = $table->messageRecord();

	if (!empty($message_record)) {
		$time = $message_record['create_time'];
	}
	$api_url = $api->get('system', 'workorder', array('do' => 'notload', 'time' => $time), 'json', false);
	if (is_error($api_url)) {
		return true;
	}

	$request_url = $api_url['data']['url'];
	$response = ihttp_get($request_url);
	$uid = $_W['config']['setting']['founder'];
	if ($response['code'] == 200) {
		$content = $response['content'];
		$worker_notice_lists = json_decode($content, JSON_OBJECT_AS_ARRAY);
		if (!empty($worker_notice_lists)) {
			foreach ($worker_notice_lists as $list) {
				message_notice_record($list['note'], $uid, $list['uuid'], MESSAGE_WORKORDER_TYPE, array('create_time' => strtotime($list['updated_at'])));
			}
		}
	}
	return true;
}


function message_notice_record_cloud($message) {
	load()->classs('cloudapi');
	$api = new CloudApi();
	$result = $api->post('system', 'notify', array('json' => $message), 'html', false);
	return $result;
}
