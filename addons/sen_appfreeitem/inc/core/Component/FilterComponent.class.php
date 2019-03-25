<?php
/*
过滤器
*/
class FilterComponent
{
	static $words = array();

	/*检查词汇*/
	static function init($word)
	{
		if(intelligent_kindergartenModuleSite::$_SET['filter'] !='open')
		{
			return array();
		}
		// 空白字符清空
		$word = str_replace(array(' ',' '), array('',''), $word);
		// 获取词
		$words = self::getContent();

		$container = array();
		
		foreach($words as $item)
		{
			if(strpos($word, $item) !== false)
			{
				$container[] = $item;
			}
		}
		// 将出现的非法词汇进行标记返回
		return $container;
	}

	/*读取词汇字符串并将其作为数组返回*/
	static function getContent()
	{
		global $_W;
		if(self::$words)
		{
			return self::$words;
		}
		$file_path = dirname(dirname(dirname(__FILE__))).'/intelligent_kindergarten_config/filter/'.$_W['uniacid'].'_filter.inc';
		if(file_exists($file_path)) {
			$content = file_get_contents($file_path);	
		}
		
		// 如果没有自定义，将获取模块内置
		if(!$content) {
			$content = file_get_contents(dirname(dirname(__FILE__)).'/config/filter.inc');
		}
		$words = explode("，", trim($content,'，'));
		self::$words = $words;
		return $words;
	}

	/*加载所有非法词汇*/
	static function readFilterInc()
	{
		global $_W;
		$file_path = dirname(dirname(dirname(__FILE__))).'/intelligent_kindergarten_config/filter/'.$_W['uniacid'].'_filter.inc';
		if(file_exists($file_path)) {
			$content = file_get_contents($file_path);	
		}
		// 如果没有自定义，将获取模块内置
		if(!$content) {
			$content = file_get_contents(dirname(dirname(__FILE__)).'/config/filter.inc');
		}
		return $content;
	}
}