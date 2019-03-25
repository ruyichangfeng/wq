<?php
	global $_W,$_GPC;	
	$userinfo = model_user::initUserInfo(); //用户信息
	$_GPC['op'] = 'cart';
	$_GPC['do'] = 'cart';
	
	if($this->module['config']['shoptype'] == 1) die('页面不存在');
	
	$initParams = array(
		'op' => $_GPC['op'],
		'insertelem' => '.cart_good_list'
	);
	$title = '购物车';
	
	$cart = new Cart;
	$cartinfo = $cart->cartView(); //查询购物车商品
	
	if($cartinfo){
		foreach($cartinfo as $k=>$v){
			$goodinfo = model_good::getSingleGood($v['id']);
			$cartinfo[$k]['buyrule'] = model_good::getGoodRuleToView($goodinfo['ruletype'],$v['rule']); //将规格转成字符串
			
			$isinrule = model_good::checkBuyRuleIsInGoodRule($goodinfo['ruletype'],$v['rule'],$goodinfo['rulearray']); //验证规格是否在购物车中
			
			//如果商品不存在，或者下单规格已经被改变了,或者商品已下架将商品从购物车删除
			if(empty($goodinfo) || ($goodinfo['ruletype'] != 0 && empty($cartinfo[$k]['buyrule'])) || $goodinfo['status'] == 1 || !$isinrule){
				$cart->modifyCart($v['id'],'','','','clear'); 
				unset($cartinfo[$k]);
				continue;
			}
			
			$cartinfo[$k]['stock'] = $goodinfo['stock']; 
		}		
	}

	
	include $this->template('cart');
?>