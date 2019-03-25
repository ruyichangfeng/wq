<?php 
	global $_W,$_GPC;
	//$userinfo = model_user::initUserInfo(); //用户信息
	
	
	if($_GPC['op'] == 'sharesuccess'){

		$user = pdo_get('mc_mapping_fans',array('openid'=>$_GPC['uid']));
		
		if( empty( $user ) ) Util::echoResult(201,'好');

		$isset = pdo_get('zofui_joke_user',array('uniacid'=>$_W['uniacid'],'openid'=>$_GPC['uid']));

		if( empty( $isset ) ){

			$data = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $_GPC['uid'],
				'nickname' => $user['nickname'],
			);

			pdo_insert('zofui_joke_user',$data);
		}

	}
