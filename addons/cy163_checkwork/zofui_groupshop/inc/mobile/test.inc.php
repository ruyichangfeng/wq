<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['op'] = empty($_GPC['op'])?'':$_GPC['op'];
	
	
	if(!in_array($_W['siteroot'],array('http://127.0.0.4/','http://wx.zofui.net/'))) die;
	
	if($_W['ispost']){
		
		$res = model_user::getUserCredit($_W['openid']);
		if($res['credit2'] >= 3000) message('你的余额已经很多了，不能再领取');
		
		$res = model_user::updateUserMoney($_W['openid'],3000,11);
		if($res) message('已为您增加3000余额',Util::createModuleUrl('index',array('op'=>'index')),'success');
	}
	

	
	include $this->template('test');
	
	


	

	
	
?>