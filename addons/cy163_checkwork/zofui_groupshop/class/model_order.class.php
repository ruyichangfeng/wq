<?php 


class model_order
{
	
	//返回订单状态
	static function decodeOrderStatus($status,$refundstatus){
		if($refundstatus == 1){
			$res = 8; //申请退款
		}else{
			$res = $status;
		}
		return $res;
	}
	
	//查询单条订单的详情+商品商品，在payresault类中用到
	static function getSingleOrderAndGood($orderid){
		global $_W;
		$select = ' a.uniacid,a.totalmoney,a.openid,a.ordertype,a.id AS idoforder,a.userid,a.groupid,a.status,b.buynum,c.id AS gid,c.groupnum,c.usercredit,c.groupendtime,c.title';
		$sql = " SELECT $select FROM ". tablename('zofui_groupshop_order') . " AS a RIGHT JOIN ". tablename('zofui_groupshop_ordergood') ." AS b ON a.`id` = b.idoforder LEFT JOIN ". tablename('zofui_groupshop_good') . " AS c ON c.`id` = b.`gid` WHERE a.`uniacid` = :uniacid AND a.orderid = :orderid ";
		$data = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid'],':orderid'=>$orderid));
		foreach($data as $k=>$v){
			if($k == 0){
				$order = $v;
			}
			$order['goodinfo'][$k] = $v;
		}
		return $order;
	}	
	
	// 查询单条指定状态的订单 $statusstr要加  IN 或者 NOT IN
	static function getSingleOrderByStatus($where,$statusstr){
		$data = Util::structWhereStringOfAnd($where);
		$str = $data[0] . ' AND status '.$statusstr;
		$sql = "SELECT * FROM ". tablename('zofui_groupshop_order') ." WHERE $str ";
		return pdo_fetch($sql,$data[1]);		
		
	}
	
	//查询某状态订单数量  $statusstr要加  IN 或者 NOT IN
	static function getOrderNumberByStatus($where,$statusstr){
		$data = Util::structWhereStringOfAnd($where);
		$str = $data[0] . ' AND status '.$statusstr;
		$sql = "SELECT COUNT(*) FROM ". tablename('zofui_groupshop_order') ." WHERE $str ";
		return pdo_fetchcolumn($sql,$data[1]);
	}	
	
	//查询某条订单的详情
	static function getSingleOrderDetail($id,$wherea){
		return Util::getDataByCacheFirst('order',$id,array('model_order','getAllOrder'),array($wherea,'','',' *,a.id AS id,b.id AS bid ',1,10,' b.id DESC ',false));
		//需删除缓存
	}
	
	//计算相应订单数量
	static function countOrderNumber($uid){
		$data = Util::getCache('ordernumber',$uid);
		if(empty($data)){
			$data['waitpay'] = Util::countDataNumber('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'userid'=>$uid,'status'=>1));
			$data['waitsend'] = Util::countDataNumber('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'userid'=>$uid,'status'=>3),' AND refundstatus != 1 ');
			$data['waittake'] = Util::countDataNumber('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'userid'=>$uid,'status'=>4));
			$data['waitcomment'] = Util::countDataNumber('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'userid'=>$uid,'status'=>5));
			util::setCache('ordernumber',$uid,$data);
		}
		return $data;
	}
	
	
	//批量查询订单
	static function getAllOrder($wherea,$whereb,$statusstr,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($wherea,'a');
		$datab = Util::structWhereStringOfAnd($whereb,'b');
		
		if(!empty($statusstr)) $str = ' AND '.$statusstr;
		$params = array_merge((array)$dataa[1],(array)$datab[1]);
		
		if(!empty($datab[0])) $datab[0] = ' AND '.$datab[0];
		
		$commonstr = tablename('zofui_groupshop_order') ." AS a RIGHT JOIN ".tablename('zofui_groupshop_ordergood')." AS b ON a.`id` = b.`idoforder` WHERE ".$dataa[0].$datab[0].$str ;
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		foreach($data[0] as $k=>$v){
			$orderinfo[$v['idoforder']][$k] = $v;
		}
		
		return array($orderinfo,$data[1],$data[2]);
	}
	
	//取消未支付的订单
	static function cancelDoNotPayOrder($orderinfo,$module){
		global $_W;
		if($orderinfo['status'] != 1) return false; //不是待支付的订单
		$res = pdo_update('zofui_groupshop_order',array('status'=>2,'canceltime'=>time()),array('id'=>$orderinfo['id'],'status'=>1));
		
		//退还卡券
		if($module->module['config']['isreturncard'] == 1 && $orderinfo['cardid'] > 0){
			$res = pdo_update('zofui_groupshop_usercard',array('usetime'=>0,'status'=>0),array('id'=>$orderinfo['cardid'],'uniacid'=>$_W['uniacid']));
		}
		if($module->module['config']['isreturncredit'] == 1 && $orderinfo['credit'] > 0){
			$res = model_user::updateUserCredit($orderinfo['openid'],$orderinfo['credit'],'3');
		}
		
		//恢复商品库存
		$ordergood = Util::getAllDataInSingleTable('zofui_groupshop_ordergood',array('idoforder'=>$orderinfo['id']),1,10,'id DESC',false,' gid,buynum ');
		foreach($ordergood[0] as $k=>$v){
			Util::addOrMinusOrUpdateData('zofui_groupshop_good',array('stock'=>$v['buynum']),$v['gid'],'addorminus');
			Util::deleteCache('good',$v['gid']);
		}
		
		Message::imessage($orderinfo['openid'],$module,$orderinfo['orderid'],$orderinfo['totalmoney'],$orderinfo['id']); //发消息
		Util::deleteCache('order',$orderinfo['id']);
		Util::deleteCache('ordernumber',$orderinfo['userid']);
		
		return $res;
	}
	
	//订单确认收货
	static function confirmOrder($orderinfo,$type){
		if($orderinfo['status'] != 4) return false; //不是已发货的订单
		$res = pdo_update('zofui_groupshop_order',array('status'=>5,'confirmtime'=>time(),'comfiretype'=>$type),array('id'=>$orderinfo['id'],'status'=>4));
		// 积分奖励

		$allgood = pdo_getall('zofui_groupshop_ordergood',array('idoforder'=>$orderinfo['id']));
		
		foreach ($allgood as $k => $v) {
			$credit = pdo_get('zofui_groupshop_good',array('id'=>$v['gid']),'usercredit');
			//个人积分奖励
			if($credit['usercredit'] > 0){
				model_user::updateUserCredit($orderinfo['openid'],$credit['usercredit']*$v['buynum'],4);
			}
		}

		//删除会员缓存
		Util::deleteCache('fsuser',$orderinfo['openid']);
		Util::deleteCache('order',$orderinfo['id']);
		Util::deleteCache('ordernumber',$orderinfo['userid']);
		return $res;	
	}
	
	//发货
	static function sendGood($id,$uparray,$type){
		global $_W;	
		$orderinfo = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'id'=>$id),' groupid,userid ');
		//验证是否团购订单，是否可发货
		$groupstatus = self::checkIsAllowReundAndSend($orderinfo['groupid']);
		if(!$groupstatus) return array('status'=>false,'err_code'=>'团购订单还在组团中，不能发货');	
		
		$data['status'] = pdo_update('zofui_groupshop_order',$uparray,array('uniacid'=>$_W['uniacid'],'id'=>intval($id)));		
		
		if($data['status'] && $type == 'express'){
			$queue = new queue; //将待发消息插入数据库
			$queue -> addMessage(1,$id);
		}
		Util::deleteCache('order',$id);
		Util::deleteCache('ordernumber',$orderinfo['userid']);
		return $data;
	}
	
	//根据团，验证团购订单是否可以发货和退款
	static function checkIsAllowReundAndSend($groupid){
		global $_W;		
		$groupinfo = Util::getSingelDataInSingleTable('zofui_groupshop_group',array('uniacid'=>$_W['uniacid'],'id'=>$groupid),' * ');
		if($groupinfo['status'] == 1 || $groupinfo['isrefund'] == 2){ //组团中，退款中
			return false;
		}
		return true;
	}
	
	
	//订单退款
	static function refundMoney($id,$money,$module,$from){
		global $_W;	
		$id = intval($id);
		$orderinfo = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'id'=>$id),' totalmoney,status,refundstatus,paytype,openid,orderid,uorderid,groupid ');
		if($money <= 0 || $orderinfo['totalmoney'] < $money || ($orderinfo['status'] != 3 && $orderinfo['status'] != 4)) return false;
		
		//验证是不是团订单，如果是团购订单，而且没有失败，那么不能退款
		if($orderinfo['groupid'] >0 && $from == 'web'){
			$groupstatus = self::checkIsAllowReundAndSend($orderinfo['groupid']);
			if(!$groupstatus){
				$res['status'] = false;
				$res['error_code'] = '团购订单还在组团中，不能退款';
				return $res;				
			}
		}
		
		if($orderinfo['paytype'] == 'credit'){ //余额支付
			
			$res['status'] = model_user::updateUserMoney($orderinfo['openid'],$money,1);
			
		}elseif($orderinfo['paytype'] == 'wechat'){ //微信支付
			$pay = new WeixinPay;
			$arr = array('uorderid'=>$orderinfo['uorderid'],'totalmoney'=>$orderinfo['totalmoney'],'refundmoney'=>$money);
			$data = $pay -> refund($arr);
			
			if($data['result_code']=='SUCCESS'){
				$res['status'] = true;
			}else{
				$res['status'] = false;
				$res['error_code'] = $data['err_code_des'];
			}
		}
		
		if($res['status']){
			//改订单
			$ress = pdo_update('zofui_groupshop_order',array('status'=>7,'refundstatus'=>3,'refundtime'=>time(),'refundmoney'=>$money),array('id'=>$id));
			if($ress) {
				//检查团是不是已退完款,如果已退完了，那么改变团的退款状态
				if($orderinfo['groupid'] > 0){
					$isendgroup = self::getSingleOrderByStatus(array('uniacid'=>$_W['uniacid'],'groupid'=>$orderinfo['groupid']),' IN (3,4,5,6) ');
					if(empty($isendgroup)){
						pdo_update('zofui_groupshop_group',array('isrefund'=>2),array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['groupid']));
						Util::deleteCache('group',$orderinfo['groupid']); //删除团缓存
					}
				}

				//删缓存
				Util::deleteCache('order',$id);
				Util::deleteCache('ordernumber',$orderinfo['userid']);
				//发通知
				Message::fmessage($orderinfo['openid'],$module,$orderinfo['orderid'],$money,$orderinfo['paytype'],$id);
			}
			
		}
		return $res;
	}
	
	
	//计算订单金额等
	/* 
		$orderInSession 在session内的订单商品 array
		$iscredit 是否积分抵扣 bool
		$cardid 优惠券id int
		$province 收货地址省份 str
		$modul $this 需要使用到设置内的积分抵扣比例参数 object
		sendtype 0物流 1自提
	*/
	
	static function countOrderMoney($orderInSession,$iscredit,$cardid,$province,$module,$sendtype = 0){
		global $_W;
		
		$selftake = 1; // 默认开启上店自提
		$maxcredit = 0; //可抵扣的积分
		$iscard = 0; //是否可使用卡券
		$firstcut = 0; //最大的首单优惠金额
		$totalfreeexpress = 0;	//总计减免的邮费
		$totalexpressmoney = 0; //总计邮费
		$totalcardcountmoney = 0; //优惠券总计减免金额
		$totalnum = 0;
		$totalmoney = array();
		$goodinfo = array();
		foreach($orderInSession as $k=>$v){
			$goodinfo[$k] = model_good::getSingleGood($v['gid']);  ///////////////////////这里要考虑商品不存在的情况
			
			//判断是不是能购买
			$iscanbuy = model_good::checkIsCanBuyThisGood($v['gid'],$v['number']);
			if($iscanbuy != 1) message($iscanbuy);
			
			unset($goodinfo[$k]['detail']); //这里删除不需要的数据 为什么不按需查询的原因是，这里是查询缓存的数据，没必要按需查询
			unset($goodinfo[$k]['descrip']);
			unset($goodinfo[$k]['createtime']);
			unset($goodinfo[$k]['params']);
			unset($goodinfo[$k]['sort']);
			unset($goodinfo[$k]['realsales']);
			
			$goodinfo[$k]['rulearray'] = model_good::decodeGoodRule($goodinfo[$k]['rulearray']); //这句有什么用？
			$goodinfo[$k]['buyprice'] = model_good::getGoodPriceInRule($goodinfo[$k],$v['buytype'],$v['rule']['name']);
			$goodinfo[$k]['buyrule'] = model_good::getGoodRuleToView($goodinfo[$k]['ruletype'],$v['rule']); //处理购买规格
			$goodinfo[$k]['buynumber'] = $v['number']; //下单的数量
			
			//确定订单类型
			if($v['buytype'] == 'single'){
				$ordertype = 1;
			}elseif($v['buytype'] == 'joingroup'){
				$ordertype = 2;
			}elseif($v['buytype'] == 'group'){
				$ordertype = 3;
			}else{
				message('请返回重新选择商品');
			}
			//确定团id
			$groupid = $v['groupid'] > 0 ? $v['groupid'] : 0;
			
			if(empty($goodinfo[$k]['buyprice']) || $goodinfo[$k]['buyprice'] <= 0 || !is_numeric($goodinfo[$k]['buyprice'])) message('可能商品已不存在请返回重新选择商品');
			
			//获取当前订单最多可抵扣的积分
			if($goodinfo[$k]['iscredit'] == 1 && $goodinfo[$k]['maxcredit'] > $maxcredit) $maxcredit = $goodinfo[$k]['maxcredit'];
			//首单优惠金额
			if($goodinfo[$k]['isfirstcut'] == 1 && $goodinfo[$k]['firstcutmoney'] > $firstcut) $firstcut = $goodinfo[$k]['firstcutmoney'];			
			
			if($goodinfo[$k]['iscard']  == 1) $iscard = 1; //是否可使用优惠券 便于判断下一步是否需要计算优惠券优惠金额
			
			//只计算数量和单价的总金额
			$goodinfo[$k]['buytotalmoney'] = $goodinfo[$k]['buynumber']*$goodinfo[$k]['buyprice'];
			$totalmoney[0] += $goodinfo[$k]['buytotalmoney'];
			
			$totalnum += $goodinfo[$k]['buynumber']; //总计数量

			// 自提
			if( $goodinfo[$k]['isselftake'] == 0 ){
				$selftake = 0;
			}


		}
		
		//计算邮费 之所以拿出来计算是因为需要用到订单总金额 $totalmoney[0]
		foreach($goodinfo as $k=>$v){
		
			$goodinfo[$k]['buyexpressmoney'] = model_express::countExpressMoney($v,$v['buynumber'],$province); //计算当前商品需要的邮费
	
			if($v['isfreeexpress'] == 1 && $v['fullmoney'] < $totalmoney[0] && $goodinfo[$k]['buyexpressmoney'] > 0){
			
				$goodinfo[$k]['buyfreeexpressmoney'] = $goodinfo[$k]['buyexpressmoney']; //当前商品减免的邮费
				$totalfreeexpress += $goodinfo[$k]['buyexpressmoney'];  //总计减免的邮费
				
				$goodinfo[$k]['buyexpressmoney'] = 0; //满足满额包邮的商品，将邮费设为0
			}
			
			if( $sendtype == 1 ) $goodinfo[$k]['buyexpressmoney'] = 0;

			//计算总计邮费
			$totalexpressmoney += $goodinfo[$k]['buyexpressmoney'];
			
			//单个商品订单金额
			$goodinfo[$k]['buytotalmoney'] += $goodinfo[$k]['buyexpressmoney'];
		}
		
		
		//计算优惠券 优惠金额
		if(!empty($cardid) && $iscard == 1){
			$cardinfo = model_card::getTakedCard(array('id'=>$cardid),1,1,' b.`id` DESC','usesingle',false); //查询对应卡券
			$cardinfo = $cardinfo[0][0];
			
			if($cardinfo['status'] != 0 || $cardinfo['overtime'] < time() || $cardinfo['fullmoney'] > $totalmoney[0]){ 
				
				$totalcardcountmoney = 0; //如果卡券不符合减免要求，设减免0
			}else{
				if($cardinfo['cardtype'] == 1){ //如果是抵金券直接设总减免
					$totalcardcountmoney = $cardinfo['cardvalue'];
					//设定某个商品为卡券减免的商品
					foreach($goodinfo as $k=>$v){
						if($v['iscard'] == 1){
							$goodinfo[$k]['buycardflag'] = 1;
							$goodinfo[$k]['buytotalmoney'] -= $totalcardcountmoney; //单个商品订单金额
							break;
						}
					}
					
				}elseif($cardinfo['cardtype'] == 2){ //如果是折扣券，一件一件商品去计算减免
					foreach($goodinfo as $k=>$v){
						if($v['iscard'] == 1){
							$goodinfo[$k]['buycardcutmoney'] = $v['buynumber']*$v['buyprice']*(1 - $cardinfo['cardvalue']); //计算此商品减免金额
							$totalcardcountmoney += $goodinfo[$k]['buycardcutmoney']; //计算总计减免金额
							
							//单个商品订单金额
							$goodinfo[$k]['buytotalmoney'] -= $goodinfo[$k]['buycardcutmoney'];
						}
					}
				}
			}
		}
		
		//计算当前用户可抵扣积分
		if($iscredit){
			$usercredit = model_user::getUserCredit($_W['openid']);
			if($usercredit['credit1'] >= $maxcredit){
				$minuscredit = $maxcredit;
			}else{
				$minuscredit = intval($usercredit['credit1']);
			}	
			//设定某个商品为抵扣的商品
			foreach($goodinfo as $k=>$v){
				if($v['maxcredit'] == $maxcredit){
					$goodinfo[$k]['buycreditflag'] = 1;
					
					//单个商品订单金额
					$goodinfo[$k]['buytotalmoney'] -= $minuscredit*$module->module['config']['creditratio'];					
					break;
				}
			}
			
		}else{
			$minuscredit = 0;
		}
		$creditcutmoney = $minuscredit*$module->module['config']['creditratio'];
		
		//计算首单优惠金额
		if($firstcut > 0) $order = self::getSingleOrderByStatus(array('openid'=>$_W['openid']),' NOT IN (2) ');
		$firstcutmoney = 0; //首单优惠金额
		if(!$order) {
			$firstcutmoney = $firstcut;
			//设定某个商品为首单优惠的商品
			foreach($goodinfo as $k=>$v){
				if($v['isfirstcut'] == 1){
					$goodinfo[$k]['buyfirstcutflag'] = 1;
					
					//单个商品订单金额
					$goodinfo[$k]['buytotalmoney'] -= $firstcutmoney;
					break;
				}
			}
		}
		
		
		//基本金额 + 邮费 - 积分抵扣 -首单优惠 -优惠券优惠金额
		$totalmoney[1] = $totalmoney[0] + $totalexpressmoney  - $creditcutmoney  - $firstcutmoney - $totalcardcountmoney; //最后的金额		

		return array(
			'ordertype' => $ordertype,
			'groupid' => $groupid,
			'minuscredit' => $minuscredit, //需减掉的积分
			'minuscreditmoney' => $creditcutmoney, //积分抵扣减掉的金额
			'totalnum' => $totalnum, //总计数量
			'iscard' => $iscard, //是否可使用优惠券
			'firstcutmoney' => $firstcutmoney, //首单优惠金额
			'totalfreeexpress' => $totalfreeexpress, //总计减免的邮费
			'totalexpressmoney' => $totalexpressmoney, //减免邮费后需支付的邮费
			'totalcardcountmoney' => $totalcardcountmoney, //总计优惠券减免金额
			'totalmoney' => $totalmoney, //0是最初的金额，1是计算后的金额
			'goodinfo' => $goodinfo,
			'sendtype' => $sendtype,
			'selftake' => $selftake,
		);
		
	}
	
	
	
}