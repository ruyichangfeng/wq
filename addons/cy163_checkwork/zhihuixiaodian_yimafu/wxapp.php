<?php
/**
 * 银行通道一码付-智慧小店模块小程序接口定义
 *
 * @author 智慧小店
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Zhihuixiaodian_yimafuModuleWxapp extends WeModuleWxapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}
}