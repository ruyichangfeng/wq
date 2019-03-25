<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['do'] = 'hexiao';
	
	if( !empty( $_GPC['id'] ) ){


		$order = pdo_get('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'orderid'=>$_GPC['id'],'sendtype'=>1));

		if( empty( $order ) ) message('未找到需核销的订单');

		$wherea = array('id'=>intval($order['id']),'uniacid'=>$_W['uniacid']);
		
		if( $_W['openid'] != $this->module['config']['adminopenid'] ) message('你不是管理员');
		
		$data = model_order::getSingleOrderDetail(intval($order['id']),$wherea);
		
		$orderinfo = $data[0];
		foreach($orderinfo as $k=>$v){
			foreach($v as $kk => $vv){
				$datainfo = $vv;
				$datainfo['ostatus'] = model_order::decodeOrderStatus($datainfo['status'],$datainfo['refundstatus']);
				break;
			}
			break;
		}

	}
	
	
	$initParams = array(
		'do' => 'hexiao',
		'orderid' => $order['orderid'],
		'sharedata' => array(
			'title' => $this->module['config']['sharetitle'],
			'desc' => $this->module['config']['sharedesc'],
			'link' => '',
			'imgUrl' => tomedia($this->module['config']['sharepic'])
		)		
	);	
	$title = '核销订单';
	
	
	include $this->template('hexiao');