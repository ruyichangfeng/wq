<?php
/**
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Wg_CallModuleReceiver extends WeModuleReceiver {
	public function receive() {
		$type = $this->message['type'];
	}
}