<?php 
	global $_W,$_GPC;
	//$userinfo = model_user::initUserInfo();
	
	$joke = pdo_get('zofui_joke_joke',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

	if( empty( $joke ) ) message('整蛊不存在',$this->createMobileUrl('index'),'error');

	if( $_GPC['op'] == 'share' ){
		
		$isjoked = $_COOKIE[$_GPC['uid'].$joke['id']];
		$user = pdo_get('zofui_joke_user',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['uid']));
		
		if( empty( $isjoked ) ){



			setcookie( $_GPC['uid'].$joke['id'] ,'1231',time()+3600*24*365,'/');
			if( empty( $user ) ) message('整蛊不存在',$this->createMobileUrl('index'),'error');

			Util::addOrMinusOrUpdateData('zofui_joke_user',array('num'=>1),$user['id']);
			Util::addOrMinusOrUpdateData('zofui_joke_joke',array('num'=>1),$joke['id']);
			
		}
	}



	$title = empty( $joke['sharetitle'] ) ? $joke['title'] : $joke['sharetitle'];
	$sharetitle = str_replace('{nick}', $user['nickname'], $title);
	
	$desc = empty( $joke['sharedesc'] ) ? $joke['desc'] : $joke['sharedesc'];
	$sharedesc = str_replace('{nick}', $user['nickname'], $desc);

	$settings = array(
		'sharetitle' => $sharetitle,
		'sharedesc' => $sharedesc,
		'shareimg' => tomedia( $joke['thumb'] ),
		'sharelink' => Util::createModuleUrl('view',array('id'=>$joke['id'],'op'=>'share','uid'=>$_GPC['uid'])),
		'do' => 'view',
		'title' => $joke['desc'],
		'uid' => $_GPC['uid'],
		'level' => $_W['account']['level'],
		'jointype' => intval( $this->module['config']['jointype'] ),
	);

	include $this->template ('view');
