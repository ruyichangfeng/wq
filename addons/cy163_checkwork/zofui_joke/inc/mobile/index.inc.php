<?php 
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo();
	$joke = model_joke::getAllJoke();

	

	$sharetitle = str_replace('{nick}', $userinfo['nickname'], $this->module['config']['sharetitle']);
	$sharedesc = str_replace('{nick}', $userinfo['nickname'], $this->module['config']['sharedesc']);
	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia($this->module['config']['shareimg']),
		'sharelink' => '',
		'do' => 'index',
		'title' => '整蛊大法',
		'uid' => $userinfo['openid'],
	);

	include $this->template ('index');
