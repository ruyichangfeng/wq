<?php
	global $_W,$_GPC;
	$_GPC['op'] = empty($_GPC['op'])?'index':$_GPC['op'];
	
	
	if($_GPC['op'] == 'index'){
		if(empty($_GPC['id'])){
			$page = model_custom::getIndexPage();


		}else{
			$page = model_custom::getPage($_GPC['id']);
		}
			
		
		$share = json_decode($page['basicparams'],true);
		if(!empty($share)){	
			$sharedata = array(
				'title' => $share[0]['params']['title'],
				'desc' => $share[0]['params']['desc'],
				'link' => '',
				'imgUrl' => tomedia($this->module['config']['sharepic'])
			);			
		}else{
			echo '<p style="text-align: center;margin-top:20%">页面不存在</p>';die;
		}
	}
	


	$initParams = array(
		'do' => 'index',
		'op' => $_GPC['op'],
		'issetpage' => 1,
		'sharedata' => empty($sharedata) ? '""': $sharedata,
	);
	$title = $share[0]['params']['title'];
	
	
	include $this->template('index');