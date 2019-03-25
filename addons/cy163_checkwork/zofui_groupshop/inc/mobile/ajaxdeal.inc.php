<?php 
	global $_GPC,$_W;
	$_GPC = Util::trimWithArray($_GPC);
	
	$userinfo = model_user::initUserInfo(); //用户信息
		
	if($_GPC['op'] == 'location'){
		$url = "http://api.map.baidu.com/geocoder?location=".$_GPC['latitude'].",".$_GPC['longitude']."&output=json&key=28bcdd84fae25699606ffad27f8da77b";
		$res = file_get_contents($url);
			
		echo $res;
		die;
	
	}elseif($_GPC['op'] == 'uploadimages'){ //上传图片
		load() -> model('account');
 		load()->func('communication');		
		
		$access_token = WeAccount::token();	
		$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$access_token.'&media_id='.$_GPC['serverId'];
		$resp = ihttp_get($url);
		
		$res = Util::uploadImageInWeixin($resp);
		echo $res; die;
		
	}elseif($_GPC['op'] == 'buygood'){ //下单
	
		$data['number'] = intval($_GPC['number']);
		$data['gid'] = intval($_GPC['gid']);		
		$data['buytype'] = $_GPC['buytype'];
		$data['rule'] = $_GPC['rule'];	
		$data['groupid'] = intval($_GPC['groupid']);			
		$goodinfo = model_good::getSingleGood($data['gid']);
		
		$isinrule = model_good::checkBuyRuleIsInGoodRule($goodinfo['ruletype'],$v['rule'],$goodinfo['rulearray']); //验证规格是否在购物车中
		if(!$isinrule) die('提交的商品规格异常');
		
		$goodinfo['rulearray'] = model_good::decodeGoodRule($goodinfo['rulearray']);
		
		//验证是否可以购买
		$iscanbuy = model_good::checkIsCanBuyThisGood($data['gid'],$data['number']);
		if($iscanbuy != 1){
			echo $iscanbuy;die;
		}
		
		//这验证开团的时候，商品库存要大于满团人数
		if($data['buytype'] == 'group'){
			if($goodinfo['stock'] < $goodinfo['groupnum']) die('商品库存不足'); //没有库存了
		}
		
		//参团，验证团是否存在，是否已结束，是否已满员 ,是否已参团
		if($data['buytype'] == 'joingroup'){
			$res = model_group::checkIsAllowJoinGroup($data['groupid']);
			if($res != 1){
				echo $res;die;
			}
		}
		
		//计算价格
		$price = model_good::getGoodPriceInRule($goodinfo,$data['buytype'],$data['rule']['name']);
		if($price <= 0 || !is_numeric($price)) die('价格存在异常');
		
		if($data['buytype'] == 'cart'){
			$cart = new Cart;
			$nownumber = $cart -> cartCount();
			if($nownumber >= 10 ) die('购物车最多10件，已满了');
			
			$res = $cart -> addCart($data['gid'],$goodinfo['title'],$price,$data['number'],$data['rule'],$goodinfo['pic'][0]);
			if($res) die('4');die('出现异常，请刷新本页面');
		}	
		
		unset($_SESSION['order']); //不能在方法里删除，否则循环的时候会删除之前设置的。
		structGoodSession($data,$data['buytype']); //设置商品session
		if(!empty($_SESSION['order'])) die('5');die('出现异常，请刷新本页面');
		
		
	}elseif($_GPC['op'] == 'cart'){ //购物车操作商品
		$id = intval($_GPC['id']);
		$cart = new Cart;
		if($_GPC['dealtype'] == 'delete'){
			$res = $cart -> modifyCart($id,'','','','clear');
			if($res) die('1');die('2');
		}
		
		if($_GPC['dealtype'] == 'clearall'){
			$res = $cart -> removeAll();
			if($res) die('1');die('2');
		}		
		
	
	}elseif($_GPC['op'] == 'cartconfirm'){ //购物车确定
		$cart = new Cart;
		$cartarray = $cart -> cartView();
		
		foreach($cartarray as $k=>$v){
			$cartid[$k] = $v['id'];
		}
		
		unset($_SESSION['order']); //不能在方法里删除，否则循环的时候会删除之前设置的。
		foreach($_GPC['data'] as $k=>$v){
			$data['gid'] = intval($v['gid']);
			$data['number'] = intval($v['number']);
			if(!in_array($data['gid'],$cartid)) die('您提交的商品不在购物车内'); //不在购物车内
		
			//验证商品是否可以购买
			$iscanbuy = model_good::checkIsCanBuyThisGood($data['gid'],$data['number']);
			if($iscanbuy != 1){
				echo $iscanbuy;die;
			}
			
			$data['rule'] = $cartarray[$data['gid']]['rule'];
			structGoodSession($data,'single'); //设置商品session
		}
		
		if(!empty($_SESSION['order'])) die('1');die('出现异常');
		
	
	}elseif($_GPC['op'] == 'exchangecard'){ //兑换个人优惠券
		
		$cardid = intval($_GPC['id']);
		$cardinfo = model_card::getSingleCard($cardid);

		if($cardinfo['status'] == 1 || $cardinfo['lastnum'] <= 0) die('此券已下架或被领完了'); //已经下架了或没有数量了。
		if($cardinfo['cardtype'] != 1 && $cardinfo['cardtype'] != 2) die('此券类型不对'); // 不是个人优惠券
		
		$credit = model_user::getUserCredit($_W['openid']);
		if($credit['credit1'] < $cardinfo ['needcredit']) die('您的积分不够，兑换此券需'.$cardinfo ['needcredit'].'积分'); 
		//积分不够,不能设置<=0,不然免费兑换的券就没法兑换。
		
		//查询已兑换数量
		$taked = model_card::selectTakedNum($userinfo['id'],$cardinfo['id']);
		if($taked >= $cardinfo['limitnum']) die('已达兑换上限');
		
		$res = model_user::updateUserCredit($_W['openid'],-$cardinfo['needcredit'],1);
		if($res){
			$data = array(
				'cardid' => $cardinfo['id'],
				'userid' => $userinfo['id'],
				'openid' => $userinfo['openid'],
				'status' => 0,
				'overtime' => time() + $cardinfo['expire']*24*3600,
				'taketime' => time()
			);
			
			$res = Util::inserData('zofui_groupshop_usercard',$data);
			if($res) $res = Util::addOrMinusOrUpdateData('zofui_groupshop_card',array('lastnum'=>-1,'takednum'=>1),$cardinfo['id'],'addorminus');
			
			if($res){
				Util::deleteCache('card',$cardinfo['id']);
				die('兑换成功');
			} 
		}
		die('兑换失败');
	
	
	}elseif($_GPC['op'] == 'refreshuser'){ //更新个人信息
		if(!empty($_COOKIE['fshopupdataed'])) die('更新太频繁，两分钟后再试');
		setcookie('fshopupdataed','1',time()+120,'/');
		Util::deleteCache('fsuser',$_W['openid']);
		Util::deleteCache('ordernumber',$userinfo['id']);
		die('更新成功');
		
	}elseif($_GPC['op'] == 'selectcard'){ //确认订单页面改变数据
		$cardid = intval($_GPC['cardid']);
		$credit = intval($_GPC['credit']);
		$sendtype = intval( $_GPC['sendtype'] );
		
		$orderinfo = model_order::countOrderMoney($_SESSION['order'],$credit,$cardid,$_GPC['province'],$this,$sendtype);
		if(!empty($orderinfo)){
			$orderinfo['status'] = 1;
		}else{
			$orderinfo['status'] = 0;
		}
		
		echo json_encode($orderinfo); die;
		
	
	}elseif($_GPC['op'] ==   'dealorder'){ //处理订单
	
		$id = intval($_GPC['orderid']);
		$orderinfo = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('id'=>$id,'openid'=>$_W['openid']));
		if(empty($orderinfo) || $orderinfo['openid'] != $_W['openid']) die; //这里提前判断的目的是下一步查询订单的时候不需要加openid了。可以共用方法
		
		if($_GPC['type'] == 'cancel'){  //取消未支付的订单
			$res = model_order::cancelDoNotPayOrder($orderinfo,$this);
			if($res) die('2');
			
		}elseif($_GPC['type'] == 'refund'){  //申请退款
			//不是已支付而且未申请退款的订单 只有已支付未发货的订单可以申请退款
			if($orderinfo['status'] != 3 || $orderinfo['refundstatus'] != 0 || $orderinfo['ordertype'] != 1 || $this->module['config']['iscanrefund'] == 2) die('此订单不能申请退款'); 
			$res = pdo_update('zofui_groupshop_order',array('refundstatus'=>1,'applyrefundtime'=>time()),array('id'=>$orderinfo['id'],'uniacid'=>$_W['uniacid']));
			Util::deleteCache('order',$orderinfo['id']);
			Util::deleteCache('ordernumber',$userinfo['id']);
			if($res) die('2');die('申请退款失败');
		
		}elseif($_GPC['type'] == 'cancelrefund'){ //取消申请退款
			if($orderinfo['refundstatus'] != 1) die('此订单不能取消申请退款'); //不是申请退款状态
			$res = pdo_update('zofui_groupshop_order',array('refundstatus'=>2,'cancelrefundtime'=>time()),array('id'=>$orderinfo['id'],'uniacid'=>$_W['uniacid']));
			Util::deleteCache('order',$orderinfo['id']);
			Util::deleteCache('ordernumber',$userinfo['id']);
			if($res) die('2');die('取消申请退款失败');
			
		}elseif($_GPC['type'] == 'confirm'){  //确认收货confirm
			$res = model_order::confirmOrder($orderinfo,1);
			if($res) die('2');die('确认收货失败');
		}
	
	
	}elseif($_GPC['op'] ==   'commentgood'){ //评价商品
		$data['idoforder'] = intval($_GPC['id']);
		$data['gid'] = intval($_GPC['gid']);
		
		$data['level'] = intval($_GPC['level']);
		$data['text'] = htmlspecialchars($_GPC['text']);
		$data['pic'] = iserializer($_GPC['pic']);
		$data['status'] = $this->module['config']['commentshow'] == 2 ? 0 : 1;
		$data['commenttime'] = time();
		$data['nickname'] = $userinfo['nickname'];
		$data['headimg'] = $userinfo['headimgurl'];
	
		$orderinfo = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('id'=>$data['idoforder'],'openid'=>$_W['openid']));
		$ordergood = Util::getSingelDataInSingleTable('zofui_groupshop_ordergood',array('idoforder'=>$data['idoforder'],'gid'=>$data['gid'],'iscomment'=>0));
		if($orderinfo['status'] != 5 || empty($ordergood)) die('不能对当前商品评价');
		
		$res = Util::inserData('zofui_groupshop_comment',$data);
		if($res){
			$res = pdo_update('zofui_groupshop_ordergood',array('iscomment'=>1),array('uniacid'=>$_W['uniacid'],'id'=>$ordergood['id']));
			Util::deleteCache('order',$orderinfo['id']);
			Util::deleteCache('ordernumber',$userinfo['id']);
			Util::deleteCache('commentnumber',$data['gid']); //删除当前商品评论数量
			
			//如果商品都评价了，改变订单状态为已评价
			$num = Util::getSingelDataInSingleTable('zofui_groupshop_ordergood',array('uniacid'=>$_W['uniacid'],'idoforder'=>$orderinfo['id'],'iscomment'=>0),' id ');
			if(empty($num)) pdo_update('zofui_groupshop_order',array('status'=>6),array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['id']));
		}
		if($res) die('2');die('评价失败');
	
	
	}elseif($_GPC['op'] ==   'selectexpress'){ // 查询快递信息
		
		//$res = model_express::getExpressInfo($_GPC['expressname'],$_GPC['expressnumber']);
		
		$info['ShipperCode'] = model_express::decodeExpress($_GPC['expressname']);
		$info['LogisticCode'] = $_GPC['expressnumber'];
		$info["EBusinessID"] = $this->module['config']['kdniaoid'];
		$info["AppKey"] = $this->module['config']['kdniaokey'];	
		
		$express = new SubExpress($info,1);
		$res = $express -> getOrderTracesByJson();
		$res = json_decode($res,true);
		$res['Traces'] = array_reverse($res['Traces']);
		
		$status = 0;
		if($res['Success']){
			$status = 1;
			$str = '<ul class="timeline">';
			
			foreach($res['Traces'] as $k=>$v){
				$str .= <<<div
					<li class="time-label"></li>
					<li>
						<i class="ti-truck ti nowclass"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> <font class="font_13px_999">{$v['AcceptTime']}</font></span>
							<div class="timeline-body font_13px_999">
								{$v['AcceptStation']}
							</div>
						</div>
					</li>
div;
			}
			$str .= '</ul>';
		}else{
			$str = empty($res['Reason'])?'查询失败，可能快递编号不正确':$res['Reason'];
		}
		
		echo json_encode(array('status'=>$status,'data'=>$str));die;
		
		
	}elseif( $_GPC['op'] == 'hexiao1' ){

		$order = pdo_get('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'orderid'=>$_GPC['id']));

		if( empty( $order ) ) Util::echoResult(201,'未找到订单');
		if( $order['status'] != 3 ) Util::echoResult(201,'订单状态不能核销');
		if( $order['sendtype'] != 1 ) Util::echoResult(201,'不是上店自提订单，不能核销');

		if( $_W['openid'] != $this->module['config']['adminopenid'] ) Util::echoResult(201,'你不是管理员');

		Util::echoResult(200,'好',array('url'=>$this->createMobileUrl('hexiao',array('id'=>$order['orderid']))));

	}elseif( $_GPC['op'] == 'hexiao2' ){

		$order = pdo_get('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'orderid'=>$_GPC['id']));

		if( empty( $order ) ) Util::echoResult(201,'未找到订单');
		if( $order['status'] != 3 ) Util::echoResult(201,'订单状态不能核销');
		if( $order['sendtype'] != 1 ) Util::echoResult(201,'不是上店自提订单，不能核销');

		if( $_W['openid'] != $this->module['config']['adminopenid'] ) Util::echoResult(201,'你不是管理员');

		pdo_update('zofui_groupshop_order',array('status'=>5,'confirmtime'=>TIMESTAMP),array('uniacid'=>$_W['uniacid'],'id'=>$order['id'],'status'=>3));
		Util::deleteCache( 'order',$order['id'] );
		
		Util::echoResult(200,'订单已核销完成');		

	}elseif($_GPC['op'] ==   'queue'){
		
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//设置商品session
	function structGoodSession($data,$type){
		if($type == 'single'){ //单独购买
			$_SESSION['order'][$data['gid']]['buytype'] = 'single';
		}elseif($type == 'group'){ //组团
			$_SESSION['order'][$data['gid']]['buytype'] = 'group';
		}elseif($type == 'joingroup'){ //组团
			$_SESSION['order'][$data['gid']]['buytype'] = 'joingroup';
			$_SESSION['order'][$data['gid']]['groupid'] = $data['groupid'];
		}
		
		$_SESSION['order'][$data['gid']]['gid'] = $data['gid'];
		$_SESSION['order'][$data['gid']]['rule'] = $data['rule'];
		$_SESSION['order'][$data['gid']]['number'] = $data['number'];		
		
	}
	
?>