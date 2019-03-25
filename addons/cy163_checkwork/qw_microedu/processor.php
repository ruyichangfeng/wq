<?php
/**
 * 微早教模块处理程序
 *
 * @author 泉微
 * @url http://www.leshuju.cn
 */
defined('IN_IA') or exit('Access Denied');
class Qw_microeduModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
        //jja
		return $this->respText('您触发了w模块');
	}
}