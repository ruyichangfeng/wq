<?php
/**
 * 活动报名模块处理程序
 *
 * @author 洛杉矶豪哥
 * @url http://test.idouly.com
 */
defined('IN_IA') or exit('Access Denied');

class Hao_registerModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
	}
}