<?php
/**
 * 青峰欢乐投票模块小程序接口定义
 *
 * @author qf_kf
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Qf_happyvoteModuleWxapp extends WeModuleWxapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
}