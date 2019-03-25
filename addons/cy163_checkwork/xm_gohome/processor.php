<?php
/**
 * 悦媒到家模块处理程序
 *
 * @author MrLi
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Xm_gohomeModuleProcessor extends WeModuleProcessor {
	
	//这里定义此模块进行消息处理时的具体过程
	public function respond() {
		global $_W,$_GPC;
		
		$content = $this->message['content'];
		if($content=='openid')
		{
			$text = $_W['fans']['from_user'];
		}
		return($this->respText($text));
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
	}
	
	/*
	public function respond() {
 
		$content = $this->message['content'];
		
		if($this->message['type'] == 'text'){
			if($content=='好')
			{
				$text="好好好";
			}
			return $this->respText($text);	
		}
		
		if($this->message['type'] == 'trace'){
			return $this->respText('trace: '. json_encode($this->message));
		}
 
		if($this->message['type'] == 'location'){
			return $this->respText('location: '. json_encode($this->message));
		}
		
		//return $this->respText($this->message['location_x'].','.$this->message['location_y']);
	}
	 */
}