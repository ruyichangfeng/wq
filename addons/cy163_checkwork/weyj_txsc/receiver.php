<?php
/**
 * 图像上传(赢+微擎演示模块)模块订阅器
 *
 * @author 赢+
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Weyj_txscModuleReceiver extends WeModuleReceiver {
	public function receive() {
		$type = $this->message['type'];
		//这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
	}
}