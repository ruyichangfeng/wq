<?php
	global $_W, $_GPC;
	
	$settings = $this->module['config'];
	
	$aid = $_GPC['a_id'];
	if(!empty($aid)){
		$lzy_navigate_activity = new lzy_navigate_activity();
		$settings= $lzy_navigate_activity->getOne($aid);
	}
	
	if(!empty($settings['navigate'])){
		$settings['navigate']=unserialize($settings['navigate']);
		$navigate = $settings['navigate'];
	}
	
	if(!empty($settings['slide'])){
		$settings['slide']=unserialize($settings['slide']);
		$slide = $settings['slide'];
	}
	
	include $this->template('index');
	

	    
      
 



        
     