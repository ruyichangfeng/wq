<?php
/**
 * 活动系统模块小程序接口定义
 *
 * @author ProtobiaTech
 * @url http://www.protobia.net
 */
defined('IN_IA') or exit('Access Denied');

class Protech_activitysystemModuleWxapp extends WeModuleWxapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
}