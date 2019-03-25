<?php 
	global $_W,$_GPC;

	if($_GPC['op'] == 'deletecache'){ 
		$res = cache_clean('zfjoke');
		if($res) die('1'); die('2');
	}

	elseif($_GPC['op'] == 'checkqueue'){ //检查计划任务
		
		$cache = Util::getCache('queue','q');
		$draw = Util::getCache('draw','status');
		
		if( empty( $cache ) ){
			$res['queue']['status'] = 201;
		}else{
			$res['queue']['status'] = 200;
		}

		if( empty( $draw ) ){
			$res['draw']['status'] = 201;
		}elseif( $draw == 1 ){
			$res['draw']['status'] = 200;
		}else{
			$res['draw']['status'] = 202;
			$res['draw']['res'] = $draw;
		}

		Util::echoResult(200,'好',$res);
	}
	
	elseif( $_GPC['op'] == 'queue'){

		for( $i = 0;$i<3;$i++ ){
			$cache = Util::getCache('queue','q');
			if( empty( $cache ) || $cache['time'] < ( time() - 40 ) ){
				if( $i == 2 ){
					$url = Util::createModuleUrl('message',array('op'=>1));
					$res = Util::httpGet($url,'', 1);
					die('2');
				}
				sleep(1);
			}else{
				die('1');
			}			
			
		}

	}
	
	// 拉黑
	elseif ($_GPC['op'] == 'edituser') {

		$userid = intval($_GPC['id']);
		$type = intval($_GPC['type']);
		if( !in_array($type, array(0,1)) ) die('2');
		$userinfo = pdo_get('zofui_timeredbag_user',array('uniacid'=>$_W['uniacid'],'id'=>$userid));
		if(empty($userinfo)) die('2');

		$res = pdo_update('zofui_timeredbag_user',array('status'=>$type),array('uniacid'=>$_W['uniacid'],'id'=>$userid));
		if($res) {
			Util::deleteCache('u',$userinfo['openid']);
			die('1');
		}
		
	}

	elseif ($_GPC['op'] == 'editmoney') {
		
		$userid = intval($_GPC['uid']);
		$money = sprintf('%.2f',$_GPC['money']);
		
		$userinfo = pdo_get('zofui_timeredbag_user',array('uniacid'=>$_W['uniacid'],'id'=>$userid));
		if($money == 0 || empty($userinfo)) {
			Util::echoResult(201,'会员不存在');
		}

		if( $money < 0 && $userinfo['money'] < -$money ) {
			Util::echoResult(201,'会员余额不够，请修改数值');
		}

		$res = Util::addOrMinusOrUpdateData('zofui_timeredbag_user',array('money'=>$money),$userid);
		if($res) {
			Util::deleteCache('u',$userinfo['openid']);
			Util::echoResult(200,'修改成功');
		}
		Util::echoResult(201,'修改失败');
		
	}