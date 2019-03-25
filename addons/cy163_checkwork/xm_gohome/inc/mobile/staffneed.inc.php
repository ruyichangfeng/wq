<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('order1', 'grab', 'grabok', 'order2', 'wait', 'noshow', 'order3', 'yes', 'priceok');
$foo = in_array($foo, $foos) ? $foo : 'order1';

if($foo == 'order1'){
	$id = intval($_GPC['id']);

	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and openid='".$openid."'");
	if(empty($item)){
		$merchant_id = 0;
	}else{
		$merchant_id = $item['id'];
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_needmsglog')." where weid=".$this->weid." and merchant_id=".$merchant_id." and state=0 order by addtime desc");
		
	include $this->template('staff/needs/s_order1');
}

if($foo == 'grab'){
	$id  	  	 = intval($_GPC['id']);
	$m_id        = intval($_GPC['m_id']);
	$order_id 	 = intval($_GPC['order_id']);
	$merchant_id = intval($_GPC['merchant_id']);

	if(empty($order_id)){
		message("参数错误：未获取到订单ID！");
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$order_id);
	if(empty($item)){
		message("未获取到订单数据！");
	}

	$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item['random']);

	$random = $this->generate_code(6);

	include $this->template('staff/needs/s_grab');
}

if($foo == "grabok"){
	$id          = intval($_GPC['id']);
	$m_id        = intval($_GPC['m_id']);
	$offer       = $_GPC['offer'];
	$order_id    = $_GPC['order_id'];
	$merchant_id = $_GPC['merchant_id'];
	$random      = $_GPC['suiji'];
	$remark      = $_GPC['remark'];
		
	$item = pdo_fetch("select id from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and order_id=".$order_id." and merchant_id=".$merchant_id." and openid='".$openid."'");
	if(!empty($item['id'])){
		$msg = '0';
	}else{
		$data = array(
			'weid' 		  => $this->weid,
			'openid' 	  => $openid,
			'order_id' 	  => $order_id,
			'merchant_id' => $merchant_id,
			'offer'       => $offer,
			'random' 	  => $random,
			'remark' 	  => $remark,
			'selected'    => 0
		);
		$res = pdo_insert('xm_gohome_needgrab', $data);
		if($res){
			$data_m['state'] = 1;
			pdo_update('xm_gohome_needmsglog', $data_m, array('id'=>$m_id));

			$o_item = pdo_fetch("select id,openid from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$order_id);
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=needs&foo=select&id=".$order_id."&m=xm_gohome";
			$this->send_needtmpmsg('grabtmpmsg_id', $order_id, $o_item['openid'], $jump, $offer, $merchant_id);
			
			$msgbase = $this->getMessageBase();
			if($msgbase['message2'] == 1){
				$uitem = pdo_fetch("select uid from ".tablename('mc_mapping_fans')." where uniacid=".$this->weid." and openid='".$o_item['openid']."'");
				$item_m = pdo_fetch("select mobile from ".tablename('mc_members')." where uid=".$uitem['uid']);
				$mobile = $item_m['mobile'];
				
				$msg2_content = $this->getMsgContent($serve_type,$oitem['table_name'],$oitem['other_id'],$staff_id,$offer,$msgbase['message2_content']);
				$c = urlencode($msgbase['qianming'].$msg2_content);
		
				$data_modesms['app'] = 'gohome';
				$data_modesms['key'] = $this->getBase('key_info');
				$data_modesms['u'] = $msgbase['plat_name'];
				$data_modesms['p'] = $msgbase['plat_pwd'];
				$data_modesms['m'] = $mobile;
				$data_modesms['c'] = $c;
					
				$posturl = POSTURL.'sendsms.php';
				$this->post($posturl, $data_modesms, 5);
			}
			
			$msg = 1;
		}else{
			$msg = 2;
		}
	}
	echo $msg;
}

if($foo == 'order2'){
	$id = intval($_GPC['id']);

	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and openid='".$openid."'");
	if(empty($item)){
		$merchant_id = 0;
	}else{
		$merchant_id = $item['id'];
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and merchant_id = ".$merchant_id." and selected=0 order by addtime desc limit 0,100");
		
	include $this->template('staff/needs/s_order2');
}

if($foo == 'wait'){
	$id 	  = intval($_GPC['id']);
	$m_id     = intval($_GPC['m_id']);
	$offer 	  = $_GPC['offer'];
	$merchant_id = intval($_GPC['merchant_id']);
	$order_id = intval($_GPC['order_id']);
	
	$item = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid = ".$this->weid." and id=".$order_id);
		
	$item_g = pdo_fetch("select * from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and id=".$m_id);
		
	$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item['random']);
	
	$listimg = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item_g['random']);
			
	include $this->template('staff/needs/s_grabwait');
}

if($foo == 'noshow'){
	$id = $_GPC['id'];
	$data['selected'] = 2;
	$res = pdo_update('xm_gohome_grab',$data,array('id'=>$id));
	if($res){
		$msg = '1';
	}else{
		$msg = '0';
	}
	return $msg;
}

if($foo == 'order3'){
	$id = intval($_GPC['id']);
	
	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and openid='".$openid."'");
	if(empty($item)){
		$merchant_id = 0;
	}else{
		$merchant_id = $item['id'];
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and merchant_id = ".$merchant_id." and selected=1 order by addtime desc limit 0,100");
		
	include $this->template('staff/needs/s_order3');
}

if($foo == 'yes'){
	$id 	  = intval($_GPC['id']);
	$m_id     = intval($_GPC['m_id']);
	$offer 	  = $_GPC['offer'];
	$merchant_id = intval($_GPC['merchant_id']);
	$order_id = intval($_GPC['order_id']);

	$item = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid = ".$this->weid." and id=".$order_id);
		
	$item_g = pdo_fetch("select * from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and selected=1 and id=".$m_id);
	
	$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item['random']);
	
	$listimg = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item_g['random']);
	
	include $this->template('staff/needs/s_grabyes');
}

?>