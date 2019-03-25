<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['op'] = empty($_GPC['op'])?'default':$_GPC['op'];	
	$_GPC['do'] = 'user';
	
	
	if($_GPC['op'] == 'default'){
		$credit = model_user::getUserCredit($_W['openid']); //积分
		$number = model_order::countOrderNumber($userinfo['id']); //计算相应订单数量
		$title = '个人中心';
	}elseif($_GPC['op'] == 'orderinfo'){
		
		$wherea = array('id'=>intval($_GPC['id']),'uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']);
		
		if($_W['openid'] == $this->module['config']['adminopenid'] && $_GPC['isadmin'] == 1) unset($wherea['openid']);
		
		$data = model_order::getSingleOrderDetail(intval($_GPC['id']),$wherea);
		
		$orderinfo = $data[0];
		foreach($orderinfo as $k=>$v){
			foreach($v as $kk => $vv){
				$datainfo = $vv;
				$datainfo['ostatus'] = model_order::decodeOrderStatus($datainfo['status'],$datainfo['refundstatus']);
				break;
			}
			break;
		}
		
		if($_GPC['gogroup'] == 1 && !empty($datainfo['groupid'])) { //来自payresult的跳转，
			echo '<script>location.href = "'.Util::createModuleUrl('group',array('groupid'=>$datainfo['groupid'],'toindex'=>1)).'"</script>';die;
		}
		$title = $datainfo['title'];

		if( $datainfo['sendtype'] == 1 ){
			$url = Util::createModuleUrl('hexiao',array('id'=>$datainfo['orderid']));
			$img = $this->createMobileUrl('img',array('url' => urlencode( $url ) ));
		}
	}
	

	$initParams = array(
		'do' => 'user'.$_GPC['op'],
		'op' => $_GPC['op'],
		'status' => $_GPC['status'],
		'insertelem' => '.index_goodlist',
		'isreturncard' => $this->module['config']['isreturncard'],
		'isreturncredit' => $this->module['config']['isreturncredit'],
		'issetpage' => in_array($_GPC['op'],  array('order','mygroup') )  ? 1 : 0,
	);		
	
	
	include $this->template('user');
?>