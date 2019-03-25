<?php

defined('IN_IA') or exit('Access Denied');

class Xm_housekeepModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		if($content=='好')
		{
			$text="好好好";
		}
		
		if($content=='你好')
		{
			$text="你也好";
		}
		return($this->respText($text));
		
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
	}
}