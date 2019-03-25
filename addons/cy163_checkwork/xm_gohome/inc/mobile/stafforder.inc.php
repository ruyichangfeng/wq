<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('order1', 'order2', 'wait', 'del', 'noshow', 'order3', 'yes', 'priceok');
$foo = in_array($foo, $foos) ? $foo : 'order1';

if($foo == 'order1'){
	$merchant_state = intval($_GPC['merchant_state']);
	if($merchant_state == ''){
		$merchant_state = $this->getMerchantState($openid);
	}
	$id = intval($_GPC['id']);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_msglog')." where weid=".$this->weid." and openid='".$openid."' and state=0 order by addtime desc");
		
	$diygrab = $this->getBase('diygrab');
		
	include $this->template('staff/order/s_order1');
}

if($foo == 'order2'){
	$merchant_state = intval($_GPC['merchant_state']);
	if($merchant_state == ''){
		$merchant_state = $this->getMerchantState($openid);
	}
	$id = intval($_GPC['id']);

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and openid = '".$openid."' and (selected=0 or selected=3) order by addtime desc limit 0,100");
		
	include $this->template('staff/order/s_order2');
}

if($foo == 'wait'){	
	$offer 	  = $_GPC['offer'];
	$staff_id = intval($_GPC['staff_id']);
	$id 	  = intval($_GPC['id']);
	
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid = ".$this->weid." and id=".$id);
		
	$item_g = pdo_fetch("select * from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and staff_id=".$staff_id." and serve_type=".$item['serve_type']." and order_id=".$id);
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
		
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}
		
	if(!empty($item_g['random'])){
		$listimg = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item_g['random']);
	}
			
	include $this->template('staff/order/s_grabwait');
}

if($foo == "del"){
	$order_id = intval($_GPC['id']);
	$staff_id = intval($_GPC['staff_id']);
	$serve_type = intval($_GPC['serve_type']);

	$map['serve_type'] = $serve_type;
	$map['staff_id']   = $staff_id;
	$map['order_id']   = $order_id;
	$item = pdo_get('xm_gohome_grab', $map, array('id'));

	$data_u['selected']=3;
	$res = pdo_update('xm_gohome_grab', $data_u, array('id'=>$item['id']));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
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
	echo $msg;
}

if($foo == 'order3'){
	$merchant_state = intval($_GPC['merchant_state']);
	if($merchant_state == ''){
		$merchant_state = $this->getMerchantState($openid);
	}
	$id = intval($_GPC['id']);
	
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and openid = '".$openid."' and selected=1 order by addtime desc limit 0,100");
		
	include $this->template('staff/order/s_order3');
}

if($foo == 'yes'){
	$offer    = $_GPC['offer'];
	$staff_id = intval($_GPC['staff_id']);
	$id 	  = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid = ".$this->weid." and id=".$id);
		
	$item_g = pdo_fetch("select * from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and selected=1 and order_id=".$id);
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
		
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}
		
	if(!empty($item_g['random'])){
		$listimg = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item_g['random']);
	}
		
	$isCheck = pdo_fetch("select id,selected,suremoney from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$item['id']." and staff_id = ".$staff_id);
		
	$diyyes = $this->getBase('diyyes');
	
	include $this->template('staff/order/s_grabyes');
}

if($foo == 'priceok'){
	if(checksubmit('submit')){
		$openid = $_W['fans']['from_user'];
		$order_id = $_GPC['sorder_id'];
		if($_GPC['suremoney'] == ''){
			$suremoney = 0;
		}else{
			$suremoney = $_GPC['suremoney'];	
		}
		$item = pdo_fetch("select id,offer from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$order_id." and openid='".$openid."' and selected=1");
		$data['suremoney'] = $suremoney;
		$data['suretime'] = date('Y-m-d H:i:s');
		$res = pdo_update('xm_gohome_grab',$data,array('id'=>$item['id']));
		if($res){
			$item_m = pdo_fetch("SELECT wtmpmsg_id FROM ".tablename('xm_gohome_tempmessagedefault')." WHERE weid=".$this->weid);
			$oitem = pdo_fetch("select id,openid,serve_type,table_name,other_id,staff_id,ordernumber from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
			$sopenid    = $oitem['openid'];
			$serve_type = $oitem['serve_type'];
			$table_name = $oitem['table_name'];
			$other_id   = $oitem['other_id'];
			$staff_id   = $oitem['staff_id'];

			$orderItem = pdo_fetch("select * from ".tablename($table_name)." where id=".$other_id);
				
			if(!empty($item_m['wtmpmsg_id'])){
					
				$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=order&foo=orderinfo&id=".$order_id."&m=xm_gohome";
					
				load()->classs('weixin.account');
				$accObj= WeixinAccount::create($acid);
				$access_token = $accObj->fetch_token();
				$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
				
				$m_item = pdo_fetch("select msg_content from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and id=".$item_m['wtmpmsg_id']);
				$datavalue = base64_decode($m_item['msg_content']);
					
				$datavalue = str_replace("{url}", $jump, $datavalue);
				$datavalue = str_replace("{openid}", $sopenid, $datavalue);
					
				$datavalue = str_replace("{nickname}",$this->getMemberInfo($orderItem['openid'], 'nickname'), $datavalue);
				$datavalue = str_replace("{order}", $this->getServeType($serve_type), $datavalue);
				$datavalue = str_replace("{ordernumber}", $orderItem['ordernumber'], $datavalue);
				$datavalue = str_replace("{ftime}", str_replace('T',' ',$orderItem['ftime']), $datavalue);		
				$datavalue = str_replace("{username}",$orderItem['fname'], $datavalue);
				$datavalue = str_replace("{fmobile}", $orderItem['fmobile'], $datavalue);
				$datavalue = str_replace("{fadr}",$orderItem['fadr'], $datavalue);
				$datavalue = str_replace("{money}", $orderItem['dealprice'], $datavalue);
				$datavalue = str_replace("{addtime}",$orderItem['addtime'], $datavalue);
					
				$datavalue = str_replace("{offer}", $item['offer'], $datavalue);	
				$datavalue = str_replace("{suremoney}", $suremoney, $datavalue);	
				$datavalue = str_replace("{staff_name}", $this->getStaffInfo($staff_id,'staff_name'),$datavalue);
				$datavalue = str_replace("{staff_mobile}", $this->getStaffInfo($staff_id,'staff_mobile'),$datavalue);
			
				ihttp_post($url, $datavalue);
			}

			$msgbase = $this->getMessageBase();      //获取短信设置数据
			if($msgbase['message5'] == 1){
				$smstype  = $msgbase['platform'];
				$q = $msgbase['qianming'];
				$q = str_replace("【", '', $q);
				$q = str_replace("】", '', $q);
				$mobile  = $this->getMemberInfo($orderItem['openid'], 'mobile');

				if($smstype == 1){
					$msgcontent = $msgbase['message5_content'];
					$c = str_replace("{order}", $this->getServeType($serve_type), $msgcontent);
					$c = str_replace("{ftime}", str_replace('T',' ',$orderItem['ftime']), $c);
					$c = str_replace("{username}", $orderItem['fname'], $c);
					$c = str_replace("{nickname}", $this->getMemberInfo($orderItem['openid'], 'nickname'), $c);
					$c = str_replace("{fmobile}", $orderItem['fmobile'], $c);		
					$c = str_replace("{fadr}", $orderItem['fadr'], $c);
					$c = str_replace("{money}", $orderItem['dealprice'], $c);
					$c = str_replace("{addtime}", $orderItem['addtime'], $c);
					$c = str_replace("{staff_name}", $this->getStaffInfo($staff_id,'staff_name'),$c);
					$c = str_replace("{staff_mobile}", $this->getStaffInfo($staff_id,'staff_mobile'),$c);
					$c = str_replace("{offer}", $item['offer'], $c);
					$c = str_replace("{suremoney}", $suremoney, $c);
					$c = urlencode($c);
				}else{
					$tempid  = $msgbase['msg5_tempid'];
					$sms_arr = array(
						'to'		  => $mobile,
						'tmplid'      => $tempid,
						'order'       => $this->getServeType($serve_type),
						'ftime'       => str_replace('T',' ',$orderItem['ftime']),
						'username'    => $orderItem['fname'],
						'nickname'    => $this->getMemberInfo($orderItem['openid'], 'nickname'),
						'fadr'        => $orderItem['fadr'],
						'money'       => $orderItem['dealprice'],
						'addtime'     => $orderItem['addtime'],
						'staff_name'  => $this->getStaffInfo($staff_id,'staff_name'),
						'staff_mobile'=> $this->getStaffInfo($staff_id,'staff_mobile'),
						'offer'       => $item['offer'],
						'suremoney'   => $suremoney
					);
					$c = json_encode($sms_arr);
				}

				$data_sms['app']     = 'gohome';
				$data_sms['key'] 	 = $this->getBase('key_info');
				$data_sms['smstype'] = $smstype;
				$data_sms['u'] 		 = $msgbase['plat_name'];
				$data_sms['p'] 		 = $msgbase['plat_pwd'];
				$data_sms['m'] 		 = $mobile;
				$data_sms['q'] 		 = $q;
				$data_sms['c']       = $c;
					
				$this->post(SEND_SMS, $data_sms, 5);
			}
			header("Location:".$this->createMobileUrl('Validate', array()));
			//message('确认价格成功！', $this->createMobileUrl('Validate', array()), 'success');
		}else{
			message('确认价格失败，请稍后再试！');
		} 
	}
}

?>