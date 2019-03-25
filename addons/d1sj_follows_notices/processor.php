<?php
/**
 * 微信用户关注发送消息管理员模块处理程序
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class D1sj_follows_noticesModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		if($content=='123'){
			return $this->respText($this->message['from']);exit;
		}
	}
}