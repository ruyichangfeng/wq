<?php
/**
 * 在线观影模块处理程序
 *
 * @author xiaoming
 * @url http://anonymous.orz.xyz/
 */
defined('IN_IA') or exit('Access Denied');

class Jy_onlinemvModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看九烨文档来编写你的代码
	}
}