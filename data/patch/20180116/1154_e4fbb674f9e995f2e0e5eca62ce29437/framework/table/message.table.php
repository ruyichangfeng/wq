<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class MessageTable extends We7Table {

	public function messageList() {
		global $_W;
		if (!user_is_founder($_W['uid']) || user_is_vice_founder($_W['uid'])) {
			$this->query->where('uid', $_W['uid']);
		}
		return $this->query->from('message_notice_log')->orderby('id', 'DESC')->getall();
	}

	public function messageRecord() {
		return $this->query->from('message_notice_log')->orderby('id', 'DESC')->get();
	}

	public function searchWithType($type) {
		$this->query->where('type', $type);
		return $this;
	}

	public function searchWithIsRead($is_read) {
		$this->query->where('is_read', $is_read);
		return $this;
	}

	public function messageNoReadCount() {
		global $_W;
		if (!user_is_founder($_W['uid']) || user_is_vice_founder($_W['uid'])) {
			$this->query->where('uid', $_W['uid']);
		}
		return $this->query->from('message_notice_log')->where('is_read', MESSAGE_NOREAD)->count();
	}
}