<?php 

class queue {
	
	private $islock = array('value'=>0,'expire'=>0);
	private $expiretime = 900; //锁过期时间，秒
	
	//初始赋值
	public function __construct(){
		$lock = Util::getCache('queuelock','first');
		if(!empty($lock)) $this->islock = $lock;
	}
	
	//加锁
	private function setLock(){
		$array = array('value'=>1,'expire'=>time());
		Util::setCache('queuelock','first',$array);
		$this->islock = $array;
	}
	
	//删除锁
	private function deleteLock(){
		Util::deleteCache('queuelock','first');
		$this->islock = array('value'=>0,'expire'=>time());
	}	
	
	//检查是否锁定
	public function checkLock(){
		$lock = $this->islock;	
		if($lock['value'] == 1 && $lock['expire'] < (time() - $this->expiretime )){ //过期了，删除锁
			$this->deleteLock();
			return false;
		}
		if(empty($lock['value'])){
			return false;
		}else{
			return true;
		}
	}
	
	public function queueMain($module){
		if($this->checkLock()){
			return false; //锁定的时候直接返回
		}else{
			$this->setLock(); //没锁的话锁定
		}
		
		//do something
		$this->sendMessage($module); //发消息
		$this->checkGroup($module); //改变失败团状态
		$this->autoDealOrder($module); //自动处理订单
		
		$this->deleteLock(); //执行完删除锁
	}
	
	
/************以下是自动处理订单*****************/	
	
	//自动处理订单
	static function autoDealOrder($module){
		global $_W;			
		
		//自动取消订单
		$autocancelordertime = intval( $module->module['config']['autocancelordertime'] ) <= 0 ? 10 : $module->module['config']['autocancelordertime'];
		$canceltime = time() - $autocancelordertime*60;
		$orderwhere = array('uniacid'=>$_W['uniacid'],'status'=>1,'createtime<' => $canceltime);
		$orderdata = Util::getAllDataInSingleTable('zofui_groupshop_order',$orderwhere,1,50,'id ASC',false,' openid,status,id,cardid,credit,userid,orderid,totalmoney ');		
		foreach($orderdata[0] as $k=>$v){
			model_order::cancelDoNotPayOrder($v,$module);
		}
		
		//自动完成订单
		$autofinishordertime = intval( $module->module['config']['autofinishordertime'] ) <= 0 ? 60 : $module->module['config']['autofinishordertime'];

		$confirmtime = time() - $autofinishordertime*60;
		$orderwhere = array('uniacid'=>$_W['uniacid'],'status'=>4,'sendtime<' => $confirmtime);
		$orderdata = Util::getAllDataInSingleTable('zofui_groupshop_order',$orderwhere,1,50,'id ASC',false,' openid,status,id,userid,orderid ');		
		foreach($orderdata[0] as $k=>$v){
			model_order::confirmOrder($v,2);
			//发完成通知
			Message::hmessage($v['openid'],$module,$v['orderid'],$v['id']);
		}	
		
		//发未支付提醒消息
		if($module->module['config']['remindmessagetime'] > 0){
			
			$time = time() - $module->module['config']['autocancelordertime']*60 + $module->module['config']['remindmessagetime']*60;
			$orderwhere = array('uniacid'=>$_W['uniacid'],'status'=>1,'isremind'=>0,'createtime<' => $time);
			$orderdata = Util::getAllDataInSingleTable('zofui_groupshop_order',$orderwhere,1,100,'id ASC',false,' openid,id,orderid,totalmoney,createtime ');		
			foreach($orderdata[0] as $k=>$v){
				$res = Message::kmessage($v['openid'],'',$module,$v['totalmoney'],'点击此处查看详情',$v['createtime'],$v['orderid'],$v['id']);
				
				if($res){
					pdo_update('zofui_groupshop_order',array('isremind'=>1),array('id'=>$v['id']));
					Util::deleteCache('order',$v['id']);
				} 
			}
			
		}		
		
	}
	
	
	
	
/*************以下是自动处理团*****************/	
	
	function checkGroup($module){
		global $_W;		
		
		$whereb = array('uniacid'=>$_W['uniacid'],'status'=>1,'overtime<'=>time(),'lastnumber>'=>0.1);
		$data = model_group::getAllGroup('',$whereb,'',' a.title,b.id,b.fullnumber ',1,50,'b.id ASC',false);
		
		//失败的团 变成 已失败状态
		foreach($data[0] as $k => $v){
			$res = pdo_update('zofui_groupshop_group',array('status'=>2),array('uniacid'=>$_W['uniacid'],'id'=>$v['id']));
			Util::deleteCache('group',$v['id']);
			
			$orderwhere = array('uniacid'=>$_W['uniacid'],'groupid'=>$v['id'],'status'=>3);
			$orderdata = Util::getAllDataInSingleTable('zofui_groupshop_order',$orderwhere,1,200,'id ASC',false,' openid,id,totalmoney ');
			foreach($orderdata[0] as $kk=>$vv){
				//发失败通知
				Message::gmessage($vv['openid'],$module,$v['title'],$v['fullnumber'],$v['id']);			
				//自动退款
				if($module->module['config']['isautorefundgroup'] == 1) model_order::refundMoney($vv['id'],$vv['totalmoney'],$module,'queue');
			}
		}
		
		
		// 待退款的团
		$where = array('uniacid'=>$_W['uniacid'],'isrefund'=>1);
		$data = model_group::getAllGroup('',$where,'',' b.id ',1,50,'b.id ASC',false);
		foreach($data[0] as $k => $v){
			$orderwhere = array('uniacid'=>$_W['uniacid'],'groupid'=>$v['id'],'status'=>3);
			$orderdata = Util::getAllDataInSingleTable('zofui_groupshop_order',$orderwhere,1,200,'id ASC',false,' openid,id,totalmoney ');
			foreach($orderdata[0] as $kk=>$vv){
				model_order::refundMoney($vv['id'],$vv['totalmoney'],$module,'queue');
			}
		}

		//file_put_contents(ZOFUI_GROUPSHOP."/params.log", var_export(date('Y-m-d H:i:s'), true).PHP_EOL, FILE_APPEND);

	}
	
	
	
/*************以下是发消息******************/	

	//增加待发消息
	public function addMessage($type,$str){
		global $_W;
		$data = array(
			'uniacid' => $_W['uniacid'],
			'type' => $type,
			'str' => $str
		);
		$res = pdo_insert('zofui_groupshop_waitmessage',$data);
		return $res;
	}
	
	//删除消息队列
	public function deleteMessage($id){
		global $_W;		
		pdo_delete('zofui_groupshop_waitmessage',array('uniacid'=>$_W['uniacid'],'id'=>$id),'AND');
	}
	
	//查询需要发消息的记录
	public function getNeedMessageItem(){
		global $_W;
		$array = array(':uniacid'=>$_W['uniacid']);
		return pdo_fetchall("SELECT * FROM ".tablename('zofui_groupshop_waitmessage')." WHERE `uniacid` = :uniacid ORDER BY `id` ASC ",$array);
	}
	
	//发消息
	public function sendMessage($module){
		$message = $this->getNeedMessageItem();
		
		foreach($message as $k=>$v){
			if($v['type'] == 1){ //发货消息
				$this->sendgoodMessage($v['str'],$module);
			}
			if($v['type'] == 2){ 
				echo 222;
			}			
			
			if($v['type'] == 4){ //团完成了通知
				$this->GroupDoneMessage($v['str'],$module);
			}
			if($v['type'] == 5){ //发给管理员的下单通知
				$id = intval($v['str']);
				$order = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('id'=>$id),' totalmoney ');
				Message::jmessage($module,'点击此处查看详情',$order['totalmoney'],$id);
			}
			
			$this->deleteMessage($v['id']); //删除已发的
		}
	}
	
	//发货通知
	public function sendgoodMessage($id,$module){
		global $_W;	
		$id = intval($id);	
		if(empty($id)) return false;
		$order = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('id'=>$id),' openid,expressname,expressnumber,address ');
		if(empty($order)) return false;
		Message::emessage($order['openid'],$module,'点击此处查看订单详情',$order['expressname'],$order['expressnumber'],$order['address'],$id);
	}	
	
	//团完成通知
	public function GroupDoneMessage($groupid,$module){
		global $_W;	
		$groupid = intval($groupid);
		if(empty($groupid)) return false;

		$sql = "SELECT openid,orderid,id FROM ".tablename('zofui_groupshop_order')." WHERE `uniacid` = :uniacid AND `status` = :status AND `groupid` = :groupid ORDER BY `id` DESC";
		$openidarray = pdo_fetchall($sql,array(':uniacid'=> $_W['uniacid'],':status' => 3,':groupid' => $groupid));
		
		if(empty($openidarray)) return false;
		
		foreach($openidarray as $k=>$v){
			Message::dmessage($v['openid'],$module,$v['orderid'],$v['id']);
		}
		
	}	
	
}

