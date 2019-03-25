<?php
global $_W,$_GPC;

//checkauth();

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$foo = $_GPC['foo'];
$foos = array('order', 'order1', 'order2', 'getMerchantOrder', 'getMerchantOrder1', 'getMerchantOrder2', 'takeOrder', 'info', 'sure', 'sureOrder', 'success', 'replyComment');
$foo = in_array($foo, $foos) ? $foo : 'order';

if($foo == 'order'){
	$merchant_state = intval($_GPC['merchant_state']);
	if($merchant_state == ''){
		$merchant_state = $this->getMerchantState($openid);
	}
	$id = intval($_GPC['id']);

	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and staff_id=".$id." and delstate=1");

	include $this->template('staff/merchant/s_merchantorder');
}

if($foo == 'getMerchantOrder'){
	$merchantid = intval($_GPC['merchantid']);

	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_takeorder')." where weid=".$_W['uniacid']." and merchantid='".$merchantid."' and (state=3 or state=4) order by ctime desc limit ".$startCount.",".$pageSize."");

	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id       = $value['id'];
			$i_url    = $this->createMobileUrl('merchant',array('foo'=>'info', 'id'=>$id));
			$s_url    = $this->createMobileUrl('merchant',array('foo'=>'sure', 'id'=>$id));
			$nickname = $this->getMemberInfo($value['openid'], 'nickname');
			$avatar   = $this->getMemberInfo($value['openid'], 'avatar');
			$orderid  = $value['orderid'];
			$str = '';
			$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$value['orderid']."'");
			foreach ($list as $val) {
				$str .= $this->getCurryInfo($val['curryid'],'curry_name').' x'.$val['quantity'].';';
			}
			$money = $value['amount']+$value['song'];

			$idStr .= '{"id":"'.$id.'","i_url":"'.$i_url.'","s_url":"'.$s_url.'","nickname":"'.$nickname.'","avatar":"'.$avatar.'","orderid":"'.$orderid.'","str":"'.$str.'","money":"'.$money.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'order1'){
	$merchant_state = intval($_GPC['merchant_state']);
	if($merchant_state == ''){
		$merchant_state = $this->getMerchantState($openid);
	}
	$id = intval($_GPC['id']);

	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and staff_id=".$id." and delstate=1");

	include $this->template('staff/merchant/s_merchantorder1');
}

if($foo == 'getMerchantOrder1'){
	$merchantid = intval($_GPC['merchantid']);

	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
    
    $condition = '';
	$params = array();
	if (!empty($_GPC['state'])) {
		$condition .= " AND state =".$_GPC['state'];
	}
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_takeorder')." where weid=".$_W['uniacid']." and merchantid='".$merchantid."' ".$condition." order by gtime desc limit ".$startCount.",".$pageSize."");

	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id       = $value['id'];
			$i_url    = $this->createMobileUrl('merchant',array('foo'=>'info', 'id'=>$id));
			$s_url    = $this->createMobileUrl('merchant',array('foo'=>'sure', 'id'=>$id));
			$nickname = $this->getMemberInfo($value['openid'], 'nickname');
			$avatar   = $this->getMemberInfo($value['openid'], 'avatar');
			$orderid  = $value['orderid'];
			$str = '';
			$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$value['orderid']."'");
			foreach ($list as $val) {
				$str .= $this->getCurryInfo($val['curryid'],'curry_name').' x'.$val['quantity'].';';
			}
			$money = $value['amount']+$value['song'];

			$idStr .= '{"id":"'.$id.'","i_url":"'.$i_url.'","s_url":"'.$s_url.'","nickname":"'.$nickname.'","avatar":"'.$avatar.'","orderid":"'.$orderid.'","str":"'.$str.'","money":"'.$money.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'order2'){
	$merchant_state = intval($_GPC['merchant_state']);
	if($merchant_state == ''){
		$merchant_state = $this->getMerchantState($openid);
	}
	$id = intval($_GPC['id']);

	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and staff_id=".$id." and delstate=1");

	include $this->template('staff/merchant/s_merchantorder2');
}

if($foo == 'getMerchantOrder2'){
	$merchantid = intval($_GPC['merchantid']);

	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_takeorder')." where weid=".$_W['uniacid']." and merchantid='".$merchantid."' and (state=6 or state=7) order by stime desc limit ".$startCount.",".$pageSize."");

	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$i_url    = $this->createMobileUrl('merchant',array('foo'=>'success', 'id'=>$id));
			$nickname = $this->getMemberInfo($value['openid'], 'nickname');
			$avatar   = $this->getMemberInfo($value['openid'], 'avatar');
			$orderid  = $value['orderid'];
			$str = '';
			$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$value['orderid']."'");
			foreach ($list as $val) {
				$str .= $this->getCurryInfo($val['curryid'],'curry_name').' x'.$val['quantity'].';';
			}
			$money = $value['amount']+$value['song'];
			$state = $value['state'];

			$idStr .= '{"id":"'.$id.'","s_url":"'.$s_url.'","i_url":"'.$i_url.'","nickname":"'.$nickname.'","avatar":"'.$avatar.'","orderid":"'.$orderid.'","str":"'.$str.'","money":"'.$money.'","state":"'.$state.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'takeOrder'){
	$id   = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);
	if($item['state'] >= 5 ){
		echo 2;
	}else{
		$data = array(
			'weid'       => $this->weid,
			'merchantid' => $item['merchantid'],
			'orderid'    => $id,
			'money'      => $item['amount']+$item['song'],
			'ctime'      => time()
		);
		$res = pdo_insert('xm_gohome_takegetlog', $data);
		if($res){
			$u_info = array(
				'state' => 5,
				'gtime' => time()
			);
			pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$id));
			$jump = $_W['siteroot']."app/index.php?i=".$this->weid."&c=entry&do=takeorder&foo=myorder&m=xm_gohome";
			$this->send_taketmpmsg('utmpmsg_id',$item['openid'],$jump,$id);
			echo 1;
		}else{
			echo 0;
		}
	}
}

if($foo == 'info'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误:未获取到订单ID");
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");

	include $this->template('staff/merchant/s_merchantinfo');
}


if($foo == 'sure'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误:未获取到订单ID");
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");

	include $this->template('staff/merchant/s_merchantsure');
}

if($foo == 'sureOrder'){
	$id   = intval($_GPC['id']);
	$item = pdo_fetch("select openid,state from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);
	if($item['state'] > 5){
		echo 2;
		exit();
	}
	if($item['state'] == 5){
		$u_info = array(
			'state' => 6,
			'stime' => time()
		);
		$res = pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$id));
		if($res){
			$jump = $_W['siteroot']."app/index.php?i=".$this->weid."&c=entry&do=takeorder&foo=myorder&m=xm_gohome";
			$this->send_taketmpmsg('quetmpmsg_id',$item['openid'],$jump,$id);
			echo 1;
		}else{
			echo 0;
		}
	}
}

if($foo == 'success'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误:未获取到订单ID");
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");

	$item_c = pdo_fetch("select id,order_id,comment from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and order_id=".$item['id']." and type='takeout'");

	if(!empty($item_c)){
		$item_r = pdo_fetch("select * from ".tablename('xm_gohome_commentreply')." where weid=".$this->weid." and cid=".$item_c['id']);
	}

	include $this->template('staff/merchant/s_merchantsuccess');
}

if($foo == 'replyComment'){
	$cid      = intval($_GPC['cid']);
	$order_id = intval($_GPC['order_id']);
	$reply    = $_GPC['reply'];
	$item = pdo_fetch("select id from ".tablename('xm_gohome_commentreply')." where weid=".$this->weid." and cid=".$cid);
	if(empty($item)){
		$data = array(
			'weid'  => $this->weid,
			'cid'   => $cid,
			'reply' => $reply,
			'ctime' => time()
		);
		$res = pdo_insert('xm_gohome_commentreply', $data);
		if($res){
			$u_info = array(
				'rtime' => time()
			);
			pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$order_id));
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 2;
	}
}

?>