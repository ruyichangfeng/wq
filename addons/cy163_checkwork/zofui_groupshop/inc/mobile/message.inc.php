<?php 
	set_time_limit(0); //解除超时限制	
	$start = time();
	
	$cache = Util::getCache('queue','q');
	if( empty( $cache ) || $cache['time'] < ( time() - 40 ) ){
		Util::setCache('queue','q',array('time'=>time()));
		$queue = new queue;
		$queue -> queueMain($this);		

		$url = Util::createModuleUrl('message',array('op'=>1));
		$end = time();
		sleep( 10 -($end - $start) );

		Util::deleteCache('queue','q'); // 这个必须放在休眠后执行
		Util::httpGet($url,'', 1);

		//file_put_contents(ZOFUI_GROUPSHOP."/params.log", var_export(date('Y-m-d H:i:s'), true).PHP_EOL, FILE_APPEND);
	}

	die;
	
	
	

	
