<?php
	global $_GPC,$_W;
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC = Util::trimWithArray($_GPC);
	
	if(checksubmit('paygood')){
		
		//验证下是否有未支付的订单
		$ordernum = model_order::getOrderNumberByStatus(array('openid'=>$_W['openid']),' IN (1) ');
		if($ordernum >= 5) message('您未支付的订单太多了，先处理了再下单',$this->createMobileUrl('user',array('op'=>'order','status'=>1)),'error');
		
		$iscredit = false;
		if(intval($_GPC['credit']) > 0) $iscredit = true;
		$cardid = intval($_GPC['checkedcard']);
		$orderinfo = model_order::countOrderMoney($_SESSION['order'],$iscredit,$cardid,$_GPC['province'],$this,$_GPC['sendtype']);
		
		if($orderinfo['totalmoney'][1] <= 0) message('下单金额不能少于等于0');
		if(empty($orderinfo['goodinfo'])) message('请先选择商品');
		
		if( $orderinfo['selftake'] == 0 && $_GPC['sendtype'] == 1 ) message('不能选择');
		//是否有正在处理的订单
		
		
		$orderid = createOrderId($userinfo['id']);
		$data = array(
			'uniacid' => $_W['uniacid'],
			'userid' => $userinfo['id'],
			'openid' => $userinfo['openid'],
			'orderid' => $orderid,
			'ordertype' => $orderinfo['ordertype'],
			'groupid' => $orderinfo['groupid'],
			'firstcutmoney' => $orderinfo['firstcutmoney'],
			'totalfreeexpress' => $orderinfo['totalfreeexpress'],
			'totalexpress' => $orderinfo['totalexpressmoney'],
			'cardcutmoney' => $orderinfo['totalcardcountmoney'],
			'cardid' => $cardid,
			'creditcut' => $orderinfo['minuscreditmoney'],
			'credit' => $orderinfo['minuscredit'],
			'familycutmoney' => 0,  
			'totalmoney' => $orderinfo['totalmoney'][1],
			'totalnum' => $orderinfo['totalnum'],
			'name' => htmlspecialchars($_GPC['name']),
			'tel' => $_GPC['sendtype'] == 0 ? $_GPC['tel'] : $_GPC['mobile'],
			'address' => htmlspecialchars($_GPC['address']),
			'message' => htmlspecialchars($_GPC['ordermessage']),
			'status' => 1,
			'createtime' => time(),
			'sendtype' => $_GPC['sendtype'],
		);
		if($orderinfo['ordertype'] == 1) $data['iscomplete'] = 1; //根据此参数判断是否完成团，以便筛选发货
		
		$res = pdo_insert('zofui_groupshop_order',$data);
		$idoforder = pdo_insertid();
		if($res){
			foreach($orderinfo['goodinfo'] as $k => $v){
				$gooddata = array(
					'uniacid' => $_W['uniacid'],
					'idoforder' => $idoforder,
					'gid' => $v['id'],
					'pic' => $v['pic'][0],
					'title' => $v['title'],
					'rule' => $v['buyrule'],
					'buyprice' => $v['buyprice'],
					'buynum' => $v['buynumber'],
					'buyexpressmoney' => $v['buyexpressmoney'],
					'buyfreeexpressmoney' => $v['buyfreeexpressmoney'],
					'buycardcutmoney' => $v['buycardcutmoney'],
					'buyfamilycutmoney' => 0, 
					'buyfirstcutflag' => $v['buyfirstcutflag'],
					'buycreditflag' => $v['buycreditflag'],
					'buymoney' => $v['buytotalmoney'],
					'iscomment' => $v['iscomment']
				);
				$res = pdo_insert('zofui_groupshop_ordergood',$gooddata);
				
				Util::addOrMinusOrUpdateData('zofui_groupshop_good',array('stock'=>-$v['buynumber']),$v['id'],'addorminus'); //减少库存
				Util::deleteCache('good',$v['id']); //删除商品缓存
				$ordertitle = $v['title']; //获取订单标题
				
				$idarray[] = $v['id'];
			}
			
			$cart = new Cart; //删除购物车中商品
			$cart -> deleteManyCart($idarray);
		}
		//变更卡券 //扣除积分
		if($res){
			if(!empty($cardid)){ //变更卡券
				pdo_update('zofui_groupshop_usercard',array('status'=>1,'usetime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$cardid));
			}
			if($orderinfo['minuscredit'] > 0){ //扣除积分
				$uid = mc_openid2uid($_W['openid']);
				model_user::updateUserCredit($uid,-$orderinfo['minuscredit'],2);
			}
			unset($_SESSION['order']); //删除session中订单信息
			Util::deleteCache('ordernumber',$userinfo['id']); //删除订单数量数据缓存
			$params = returnPay($orderid,$orderinfo['totalmoney'][1],$ordertitle);
			
			$this->pay($params);
		}
		
		
	}elseif(checksubmit('resetpay')){
		$orderid = intval($_GPC['orderid']);
		
		$data = model_order::getSingleOrderDetail($orderid,array('id'=>$orderid,'status'=>1,'openid'=>$_W['openid']));
		if(empty($data[0])) message('此订单不可再支付');
		foreach($data[0] as $k=>$v){
			foreach($v as $kk => $vv){
				//验证商品是否可以购买
				$iscanbuy = model_good::checkIsCanBuyThisGood($vv['gid'],$vv['buynum'],false);
				if($iscanbuy != 1) message($iscanbuy);
				$orderinfo = $vv;
			}
		}
		
		//如果是参团订单,验证是否可以参团，
		if($orderinfo['groupid'] > 0){
			$res = model_group::checkIsAllowJoinGroup($orderinfo['groupid']);
			if($res != 1) message($res);
		}
		
		$params = returnPay($orderinfo['orderid'],$orderinfo['totalmoney'],$orderinfo['title']);
		
		$this->pay($params);
	}
	
	
	//生成订单号,gid商品id
	function createOrderId($uid){
		return date("YmdHis") . $_W['uniacid'] .$uid . rand(10000,99999);
	}
	
	function returnPay($orderid,$fee,$title){
		global $_W;
		$params['tid'] = $orderid;
		$params['user'] = $_W['openid'];
		$params['fee'] = $fee;
		$params['title'] = cutstr($title,40, false);
		$params['ordersn'] = $orderid;
		$params['module'] = "zofui_groupshop";		
		return $params;
	}
	
	