<?php 


//file_put_contents(ZOFUI_GROUPSHOP."/params.log", var_export($params, true).PHP_EOL, FILE_APPEND);

class payResult{
	
	//处理支付回调 $params支付参数 $module模块参数
	static function fshopPayResult($params,$module){
		global $_W;
		
		if($params['result'] == 'success' && $params['from'] == 'notify'){
			$orderinfo = model_order::getSingleOrderAndGood($params['tid']); //查询订单
			$_W['uniacid'] = $orderinfo['uniacid'];

			if($orderinfo['status'] == 1  && $orderinfo['totalmoney'] == $params['fee']){
				if($params['type'] == 'credit') $params['tag']['transaction_id'] = '';
				
				//是新建团单 先获取团id
				if($orderinfo['ordertype'] == 3 && empty($orderinfo['groupid'])){
					$groupdata = array(
						'uniacid'=>$_W['uniacid'],
						'gid' => $orderinfo['gid'],
						'status' => 1,
						'fullnumber' => $orderinfo['groupnum'],
						'lastnumber' => $orderinfo['groupnum'] - 1,
						'overtime' => $orderinfo['groupendtime']*3600 + time(),
						'createtime' => time(),
						'createrid' => $orderinfo['userid']
					);
					$res = pdo_insert('zofui_groupshop_group',$groupdata);
					$orderinfo['groupid'] = pdo_insertid(); //如果新建团，直接赋值给订单的groupid 这样如果是参团单的话，下步更新的时候也不会改变值
				}
				//改变订单状态
				$res = pdo_update('zofui_groupshop_order',array('paytime'=>time(),'paytype'=>$params['type'],'groupid'=>$orderinfo['groupid'],'status'=>3,'uorderid'=>$params['tag']['transaction_id']),array('id'=>$orderinfo['idoforder']));
				
				Util::deleteCache('order',$orderinfo['idoforder']); //删除订单缓存
				
				if($res){ //发支付成功通知 //发开团成功通知，//发团购快成功的通知
					if($orderinfo['ordertype'] == 1){
						
						Message::amessage($orderinfo['openid'],$module,$orderinfo['totalmoney'],$orderinfo['title'],$params['type'],$params['tid'],$orderinfo['idoforder']); //发支付成功通知
						
					}elseif($orderinfo['ordertype'] == 2){ //参团订单
						//更新团信息 剩余人数减1
						$res = Util::addOrMinusOrUpdateData('zofui_groupshop_group',array('lastnumber'=>-1),$orderinfo['groupid'],'addorminus');
						Util::deleteCache('groupmember',$orderinfo['groupid']); //删除成员缓存
						
						//判断团是否完成 这里已发参团成功通知 已删除缓存
						$isfinish = model_group::checkGroupIsFinished($orderinfo['groupid'],$orderinfo['openid'],$module);
						
						
					}elseif($orderinfo['ordertype'] == 3){
						
						Message::bmessage($orderinfo['openid'],$module,$orderinfo['title'],$orderinfo['totalmoney'],$orderinfo['groupnum'],$orderinfo['groupid']); //发开团成功通知
					}
					
					foreach($orderinfo['goodinfo'] as $k=>$v){
						//增加商品销量
						Util::addOrMinusOrUpdateData('zofui_groupshop_good',array('sales'=>$v['buynum'],'realsales'=>$v['buynum']),$v['gid'],'addorminus');
						Util::deleteCache('good',$v['gid']); //删除商品缓存	
						
					}
					
					//删除会员缓存
					Util::deleteCache('fsuser',$orderinfo['openid']);
					Util::deleteCache('ordernumber',$orderinfo['userid']);					
					
					//将发给管理员的消息插入数据库
					$queue = new queue; 
					$queue -> addMessage(5,$orderinfo['idoforder']);
				}					
				
			}
			
			
			
		}
		
		if($params['from'] == 'return') {
			
			if ($params['result'] == 'success') {
				$order = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('orderid'=>$params['tid']),' id,groupid,ordertype,uniacid ');//查询订单 
				$_W['uniacid'] = $order['uniacid'];
				
				if($order['ordertype'] == 1){
					
					message('支付成功！',Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$order['id'])),'success');
				}else{
					if($order['ordertype'] == 2) $notice = '参团成功!';
					if($order['ordertype'] == 3) $notice = '开团成功!';
					
					if(!empty($order['groupid'])) message($notice,Util::createModuleUrl('group',array('groupid'=>$order['groupid'],'toindex'=>1)),'success');
					
					//之所以这里跳到orderinfo页面是因为，若是余额支付的话，执行此方法的时候团还没有插入到数据中，查询不到团,orderinfo页面做了跳转
					message($notice,Util::createModuleUrl('user',array('op'=>'orderinfo','gogroup'=>1,'id'=>$order['id'])),'success');
				}
				
			} else {
				message('支付失败！',Util::createModuleUrl('user',array('op'=>'orderinfo','id'=>$order['id'])), 'error');
				
			}
		}			
	}
	

	
}



?>