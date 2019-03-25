<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['op'] = empty($_GPC['op'])?'fdefault':$_GPC['op'];
	
	$initParams = array(
		'op' => $_GPC['op'],
		'insertelem' => '.index_goodlist'
	);
	
	if($_GPC['op'] == 'fshop'){
		//分类
		$sortdata = model_sort::getAllSort();
		$allsort = $sortdata[0];		
		
		
		
	}		
	
	include $this->template('family');
?>