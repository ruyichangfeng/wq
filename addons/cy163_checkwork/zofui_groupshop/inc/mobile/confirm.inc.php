<?php
	global $_W,$_GPC;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['op'] = 'confirm';
	
	$initParams = array(
		'op' => 'confirm',
		'insertelem' => '.index_goodlist',
		'sharedata' => array(
			'title' => $this->module['config']['sharetitle'],
			'desc' => $this->module['config']['sharedesc'],
			'link' => '',
			'imgUrl' => tomedia($this->module['config']['sharepic'])
		)		
	);	
	$title = '确认订单';
	
	if(empty($_SESSION['order'])) message('您还没有选择商品', '' ,'error');
	
	$orderinfo = model_order::countOrderMoney($_SESSION['order'],true,'','',$this,1);
	
	
	
	//查询用户可使用优惠券
	if($orderinfo['iscard'] == 1){
		$where = array('openid'=>$_W['openid'],'overtime>' => time(),'fullmoney'=>$orderinfo['totalmoney'][0], 'status'=>0);
		$cardinfo = model_card::getTakedCard($where,30,1,' b.`id` DESC','canuse',false);
		$cardinfo = $cardinfo[0];
	}
	
	include $this->template('confirm');
?>