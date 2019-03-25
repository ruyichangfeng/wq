<?php
global $_W, $_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('scanlist', 'index', 'addok', 'order', 'getorder', 'select', 'getselected', 'selectedsure', 'orderinfo', 'payok' , 'delorder', 'look');
$foo = in_array($foo, $foos) ? $foo : 'index';


if($foo == "scanlist"){
	$barcode_number = $_GPC['barcode_number'];
	if(empty($barcode_number)){
		$barcode_number = 0;
	}

	$list1 = pdo_fetchall("select * from ".tablename('xm_gohome_curry')." where weid=".$_W['uniacid']." and stop=1 and delstate=1 and barcode_number != '' and barcode_number='".$barcode_number."' order by top asc");

	include $this->template('needs/scanlist');
}

if($foo == 'index'){
	
	load()->model('mc');
	$members = mc_fetch($_W['member']['uid'], array('realname', 'mobile', 'gender'));
	
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_curry')." where weid=".$_W['uniacid']." and id=".$id." and delstate=1");
	if(empty($item)){
		message('未查询到数据');
	}

	$random = $this->generate_code(8);
	$page = 'index';
	
	include $this->template('needs/index');
}

if($foo == "addok"){
	$lat 	  = $_GPC['lat'];
	$lng      = $_GPC['lng'];
	$realname = $_GPC['realname'];
	$gender	  = $_GPC['gender'];
	$mobile   = $_GPC['mobile'];
	$fadr	  = $_GPC['fadr'].$_GPC['flou'];
	$random	  = $_GPC['random'];
	$curry_name = $_GPC['curry_name'];
	$curry_id = $_GPC['curry_id'];
	$barcode_number = $_GPC['barcode_number'];
	$yuprice  = $_GPC['yuprice'];
	$size     = $_GPC['size'];
	$gettime  = $_GPC['gettime'];
	$remark   = $_GPC['remark'];
	
	//订单号
	$orderid = $this->createNeedsOrder();
	$check = pdo_fetch("select id from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and random=".$random." and openid='".$openid."'");
	if(empty($check['id'])){
		//构造订单数据
		$order = array(
			'weid'    	  => $_W['uniacid'],
			'orderid' 	  => $orderid,
			'openid'      => $openid,
			'realname'    => $realname,
			'gender'	  => $gender,
			'mobile'	  => $mobile,
			'address'	  => $fadr,
			'random'	  => $random,
			'curry_name'  => $curry_name,
			'curry_id'    => $curry_id,
			'barcode_number'=>$barcode_number,
			'yuprice'     => $yuprice,
			'size'		  => $size,
			'gettime'	  => $gettime,
			'remark'	  => $remark,
			'state'	      => 0,
			'lat'		  => $lat,
			'lng'		  => $lng
		);
		$res = pdo_insert('xm_gohome_needorder', $order);
		$newId = pdo_insertid();
		if($res){
			$adrstr = $this->encode_geohash($lat, $lng, 12);
			$adrstr = substr($adrstr, 0, 2);
			$list = pdo_fetchall("select id,merchant_id from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and barcode_number='".$barcode_number."' and barcode_number!='' and stop=1 and delstate=1 and adrstr like '".$adrstr."%' limit 0,100");	

			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=staffneed&m=xm_gohome";
			for($k=0;$k<count($list);$k++){
				$merchant_id = $list[$k]['merchant_id'];
				$data = array(
					'weid'   	  => $this->weid,
					'merchant_id' => $merchant_id,
					'ordernumber' => $orderid,
					'order_id'    => $newId,
					'state'	      => 0,
				);
				pdo_insert('xm_gohome_needmsglog', $data);
			}

			for($m=0;$m<count($list);$m++){
				$merchant_id = $list[$m]['merchant_id'];
				$s_openid = $this->getMerchantInfo($merchant_id, 'openid');
				$this->send_needtmpmsg('needtmpmsg_id', $newId, $s_openid, $jump, 0, 0);
			}
			
			$msgbase = $this->getMessageBase();      //获取短信设置数据
			if($msgbase['message1'] == 1 && $res>0){
				$posturl = POSTURL.'sendsms.php';
				$idStr = '';
				foreach($list as $value){
					$idStr .= $this->getMerchantInfo($value['merchant_id'], 'merchant_mobile').',';
				}
				$idStr = rtrim($idStr,',');
				
				$msg_content = $this->getMsgContent($serve_type,$table_name,$other_id,$staff_id,'0',$msgbase['message1_content']);
				$c = urlencode($msgbase['qianming'].$msg_content);
					
				$data_sms['app'] = 'gohome';
				$data_sms['key'] = $this->getBase('key_info');
				$data_sms['type'] = $msgbase['platform'];
				$data_sms['u'] = $msgbase['plat_name'];
				$data_sms['p'] = $msgbase['plat_pwd'];
				$data_sms['m'] = $phone_list;
				$data_sms['c'] = $c;
				
				$this->post($posturl, $data_sms, 5);
			}
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 2;
	}
}

if($foo == "order"){

	include $this->template('needs/order');
}

if($foo == 'getorder'){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and openid = '".$openid."' and delstate=1 order by addtime desc limit ".$startCount.",".$pageSize."");
	
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$s_url = $this->createMobileUrl('needs', array('foo'=>'select', 'id'=>$value['id']));
			$i_url = $this->createMobileUrl('needs', array('foo'=>'orderinfo', 'id'=>$value['id']));
			$d_url = $this->createMobileUrl('order', array('foo'=>'deleteinfo', 'id'=>$value['id']));
			if($this->getCurryCode($value['barcode_number'], 'pic') == ''){
				$icon = $_W['siteroot'].'addons/xm_gohome/static/takeout/images/nopic.jpg';
			}else{
				$icon = $_W['attachurl'].'gohome/currypic/'.$this->getCurryCode($value['barcode_number'], 'pic');
			}
			$curry_name = $value['curry_name'];
			$yuprice 	= $value['yuprice'];
			$address 	= $value['address'];
			$state 	    = $value['state'];
			$size       = $value['size'];
			$gettime	= $value['gettime'];
			$delstate   = $value['delstate'];

			$idStr .= '{"id":"'.$id.'","s_url":"'.$s_url.'","i_url":"'.$i_url.'","d_url":"'.$d_url.'","icon":"'.$icon.'","curry_name":"'.$curry_name.'","yuprice":"'.$yuprice.'","address":"'.$address.'","state":"'.$state.'","size":"'.$size.'","gettime":"'.$gettime.'","delstate":"'.$delstate.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == "select"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到订单ID！");
		exit();
	}

	$list = pdo_fetchall("select selected from ".tablename('xm_gohome_needgrab')." where weid = ".$this->weid." and order_id=".$id);
		
	$idStr = '';
	foreach($list as $value){
		$idStr .= $value['selected'].',';
	}
	$idStr = rtrim($idStr,',');
	$idStr = explode(",", $idStr); 
	if(empty($idStr)){
		$idStr = '';
	}

	include $this->template('needs/select');
}

if($foo == 'getselected'){
	$id = $_GPC['id'];
	$forumPage = $_GPC['forumPage'];
	$pageSize = 100;
    $startCount=($forumPage-1)*$pageSize;
	
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and order_id = '".$id."' order by addtime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id          = $value['id'];
			$merchant_id = $value['merchant_id'];
			$url      = $this->createMobileUrl('catch',array('foo'=>'staffinfo', 'id'=>$value['staff_id']));
			$coverpic = $this->getMerchantInfo($merchant_id, 'coverpic');
			if(empty($coverpic)){
				$coverpic = $_W['attachurl'].'static/takeout/images/nopic.jpg';
			}else{
				if(substr($coverpic,0,6) == 'images'){
					$coverpic = $_W['attachurl'].$coverpic;
				}else{
	                $coverpic = $_W['attachurl'].'gohome/coverpic/'.$coverpic;
	            }	
			}
			$merchant_name = $this->getMerchantInfo($merchant_id, 'merchant_name');
			$merchant_address = $this->getMerchantInfo($merchant_id, 'merchant_address');
			$offer  = $value['offer'];
			$remark = $value['remark'];
			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","merchant_id":"'.$merchant_id.'","coverpic":"'.$coverpic.'","merchant_name":"'.$merchant_name.'","merchant_address":"'.$merchant_address.'","offer":"'.$offer.'","remark":"'.$remark.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'selectedsure'){
	$order_id = intval($_GPC['order_id']);
	$radio_v  = $_GPC['radio_v'];
	$arr      = explode('|',$radio_v);
		
	$id          = $arr[0];
	$merchant_id = $arr[1];

	$data['selected'] = 1;
	$data['selectedtime'] = date('Y-m-d H:i:s');
	pdo_update('xm_gohome_needgrab', $data, array('id'=>$id));
	
	$data_o['state'] = 1;
	$data_o['merchant_id'] = $merchant_id;
	$data_o['selecttime'] = date('Y-m-d H:i:s');
	$res = pdo_update('xm_gohome_needorder', $data_o, array('id'=>$order_id));
	if($res){
		pdo_query("update ".tablename('xm_gohome_needmsglog')." set state=2 where weid=".$this->weid." and state=0 and order_id=".$order_id);
		
		$g_item = pdo_fetch("select offer from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and order_id=".$order_id." and merchant_id=".$merchant_id);
		$offer    = $g_item['offer'];
		$s_openid = $this->getMerchantInfo($merchant_id, 'openid');
		
		$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=staffneed&foo=order3&m=xm_gohome";
		$this->send_needtmpmsg('suretmpmsg_id', $order_id, $s_openid, $jump, $offer, $merchant_id);
		
		$msgbase = $this->getMessageBase();
		if($msgbase['message3'] == 1){
			$mobile = $this->getMerchantInfo($merchant_id, 'merchant_mobile');
				
			$msg_content = $this->getMsgContent($serve_type,$oitem['table_name'],$oitem['other_id'],$staff_id,'0',$msgbase['message3_content']);
			$c = urlencode($msgbase['qianming'].$msg_content);
			$data_modesms['app'] = 'gohome';
			$data_modesms['key'] = $this->getBase('key_info');
			$data_modesms['type'] = $msgbase['platform'];
			$data_modesms['u'] = $msgbase['plat_name'];
			$data_modesms['p'] = $msgbase['plat_pwd'];
			$data_modesms['m'] = $mobile;
			$data_modesms['c'] = $c;
				
			$posturl = POSTURL.'sendsms.php';
			$this->post($posturl, $data_modesms, 5);
		}	
		include $this->template('needs/selectok');
	}else{
		message("选择竞价人失败！");
	}
}

if($foo == "look"){
	$order_id = intval($_GPC['id']);

	$item = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$order_id);

	$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item['random']);

	include $this->template('needs/showinfo');
}

if($foo == 'delorder'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		echo 0;
	}else{
		$data1['delstate'] = 0;
		pdo_update("xm_gohome_needorder", $data1, array('id'=>$id));
		$data2['state'] = 3;
		$res = pdo_update("xm_gohome_needmsglog", $data2, array('order_id'=>$id));
		if($res){
			echo 1;
		}else{
			echo 0;
		}
	}
}

if($foo == "orderinfo"){
	$order_id = intval($_GPC['id']);

	$item = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$order_id);

	$item_g = pdo_fetch("select * from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and selected=1 and order_id=".$order_id);

	$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item['random']);
	
	$listimg = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item_g['random']);

	include $this->template('needs/orderinfo');
}

if($foo == "payok"){
	$order_id = intval($_GPC['order_id']);
	$merchant_id = intval($_GPC['merchant_id']);
	$money = $_GPC['money'];
	$zf_type = $_GPC['zf_type'];

	$item = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$order_id);
	if($item['state']>2){
		message("此订单已支付");
		exit();
	}
	$orderid  = $item['orderid'];
	$staff_id = $this->getMerchantInfo($merchant_id, 'staff_id');

	if($zf_type == 1){
		$data['state'] = 3;
		$data['paytime'] = date('Y-m-d H:i:s');
		pdo_update('xm_gohome_needorder', $data, array('id'=>$order_id));

		$m_item = pdo_fetch("select openid,staff_id,type_id,gettype,bili_bai,bili_money,start,end from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and id=".$merchant_id);
		pdo_query("update ".tablename('xm_gohome_merchant')." set ordersum=ordersum+1 where id=".$merchant_id);
		pdo_query("update ".tablename('xm_gohome_curry')." set allsum=allsum+1 where id=".$item['curry_id']);

		//结算计算
		if(!empty($m_item['gettype'])){
			if($m_item['gettype'] == 1){
				$getMoney = ($money*$m_item['bili_bai'])/100;
				
				$smoney = $getMoney;
				if($getMoney<=$m_item['start']){
					$smoney = $m_item['start'];
				}
				if($getMoney>=$m_item['end'] && $m_item['end']!=0){
					$smoney = $m_item['end'];
				}
				$getMoney1 = $money-$smoney;
				//平台流水日志
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $merchant_id,
					'orderid'    => $orderid,
					'getmoney'   => $smoney,
					'type'       => 1,
					'way'        => 1
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);

			}else{
				$getMoney1 = $money;
				$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
				$data_g['money'] = $item_s['money'] - $m_item['bili_money'];
				pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
				
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $merchant_id,
					'orderid'    => $orderid,
					'getmoney'   => $m_item['bili_money'],
					'type'       => 1,
					'way'        => 0
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
			}
			$data_p = array(
				'weid'     	  => $this->weid,
				'openid'   	  => $openid,
				'merchant_id' => $merchant_id,
				'money'    	  => $money,
				'orderid' 	  => $orderid,
				'type'        => 'takeout',
				'paytype'	  => '3',
				'getmoney'    => $money
			);
			$res = pdo_insert('xm_gohome_takepaylog', $data_p);

		}else{
			$t_item = pdo_fetch("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and delstate=1 and id=".$type_id);
			if(!empty($t_item['gettype'])){
				if($t_item['gettype'] == 1){
					$getMoney = ($money*$t_item['bili_bai'])/100;
					
					$smoney = $getMoney;
					if($getMoney<=$t_item['start']){
						$smoney = $t_item['start'];
					}
					if($getMoney>=$t_item['end'] && $t_item['end']!=0){
						$smoney = $t_item['end'];
					}
					$getMoney1 = $money-$smoney;
					//平台流水日志
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $merchant_id,
						'orderid'    => $orderid,
						'getmoney'   => $smoney,
						'type'       => 1,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
					
				}else{
					$getMoney1 = $money;
					$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
					$data_g['money'] = $item_s['money'] - $t_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
					
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $merchant_id,
						'orderid'    => $orderid,
						'getmoney'   => $t_item['bili_money'],
						'type'       => 1,
						'way'        => 0
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				}
				$data_p = array(
					'weid'     	  => $this->weid,
					'openid'   	  => $openid,
					'merchant_id' => $merchant_id,
					'money'    	  => $money,
					'orderid' 	  => $item['orderid'],
					'type'        => 'takeout',
					'paytype'	  => '3',
					'getmoney'    => $money
				);
				$res = pdo_insert('xm_gohome_takepaylog', $data_p);
			}
		}
		
		message('支付完成', $this->createMobileUrl('needs', array('foo'=>'order')));
	}

	if($zf_type == 2){
		$fee = floatval($money);
		if($fee <= 0) {
			message('支付错误, 金额小于0');
		}
		
		$pay = $this->getBase('pay');
		if($pay){
			$body = '订单付款';
			$attach = urlencode("H#".$_W['uniacid']."#".$_W['siteroot']."#".$openid."#".$fee."#".$body."#".$this->generate_code(8)."#".$order_id."#".$merchant_id);
			$jump   = urlencode($_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=needs&foo=showok&m=xm_gohome');
			$url    = MODULE_URL.'pay/jsapi.php?attach='.$attach.'&jump='.$jump.'&appid='.$this->getBase("appid").'&mch_id='.$this->getBase("mch_id").'&apikey='.$this->getBase("apikey").'&appsecret='.$this->getBase("appsecret");
			header("Location:".$url);
		}else{
			$params = array(
				'tid' => 'H#'.$openid.'#'.$fee.'#'.$order_id.'#'.$merchant_id.'#'.$this->generate_code(4),
				'ordersn' => $this->generate_code(8),
				'title' => '订单付款',
				'fee' => $fee,
				'user' => $_W['member']['uid'],
			);
			$this->pay($params);
		}
	}

	if($zf_type == 3){

		$item = mc_credit_fetch($_W['member']['uid'],array('credit2'));
		if($item['credit2'] < $money){
			message('您的余额不足！');
		}else{
			$data['state'] = 3;
			$data['paytime'] = date('Y-m-d H:i:s');
			pdo_update('xm_gohome_needorder', $data, array('id'=>$order_id));

			$m_item = pdo_fetch("select openid,staff_id,type_id,gettype,bili_bai,bili_money,start,end from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and id=".$merchant_id);
			pdo_query("update ".tablename('xm_gohome_merchant')." set ordersum=ordersum+1 where id=".$merchant_id);
			pdo_query("update ".tablename('xm_gohome_curry')." set allsum=allsum+1 where id=".$item['curry_id']);

			//结算计算
			if(!empty($m_item['gettype'])){
				if($m_item['gettype'] == 1){
					$getMoney = ($money*$m_item['bili_bai'])/100;
					
					$smoney = $getMoney;
					if($getMoney<=$m_item['start']){
						$smoney = $m_item['start'];
					}
					if($getMoney>=$m_item['end'] && $m_item['end']!=0){
						$smoney = $m_item['end'];
					}
					$getMoney1 = $money-$smoney;
					//平台流水日志
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $merchant_id,
						'orderid'    => $orderid,
						'getmoney'   => $smoney,
						'type'       => 1,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);

				}else{
					$getMoney1 = $money;
					$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
					$data_g['money'] = $item_s['money'] - $m_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
					
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $merchant_id,
						'orderid'    => $orderid,
						'getmoney'   => $m_item['bili_money'],
						'type'       => 1,
						'way'        => 0
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				}
				$data_p = array(
					'weid'     	  => $this->weid,
					'openid'   	  => $openid,
					'merchant_id' => $merchant_id,
					'money'    	  => $money,
					'orderid' 	  => $orderid,
					'type'        => 'takeout',
					'paytype'	  => '3',
					'getmoney'    => $money
				);
				$res = pdo_insert('xm_gohome_takepaylog', $data_p);
				if($res){
					$credit2 = number_format($item['credit2'] - $money,2);
					$data_f['credit2'] = $credit2;
					pdo_update('mc_members', $data_f, array('uid' => $_W['member']['uid']));

					pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
				}else{
					message("支付失败！");
				}
			}else{
				$t_item = pdo_fetch("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and delstate=1 and id=".$type_id);
				if(!empty($t_item['gettype'])){
					if($t_item['gettype'] == 1){
						$getMoney = ($money*$t_item['bili_bai'])/100;
						
						$smoney = $getMoney;
						if($getMoney<=$t_item['start']){
							$smoney = $t_item['start'];
						}
						if($getMoney>=$t_item['end'] && $t_item['end']!=0){
							$smoney = $t_item['end'];
						}
						$getMoney1 = $money-$smoney;
						//平台流水日志
						$data_get = array(
							'weid'       => $this->weid,
							'merchant_id'=> $merchant_id,
							'orderid'    => $orderid,
							'getmoney'   => $smoney,
							'type'       => 1,
							'way'        => 1
						);
						pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
						
					}else{
						$getMoney1 = $money;
						$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
						$data_g['money'] = $item_s['money'] - $t_item['bili_money'];
						pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
						
						$data_get = array(
							'weid'       => $this->weid,
							'merchant_id'=> $merchant_id,
							'orderid'    => $orderid,
							'getmoney'   => $t_item['bili_money'],
							'type'       => 1,
							'way'        => 0
						);
						pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
					}
					$data_p = array(
						'weid'     	  => $this->weid,
						'openid'   	  => $openid,
						'merchant_id' => $merchant_id,
						'money'    	  => $money,
						'orderid' 	  => $item['orderid'],
						'type'        => 'takeout',
						'paytype'	  => '3',
						'getmoney'    => $money
					);
					$res = pdo_insert('xm_gohome_takepaylog', $data_p);
					if($res){
						$credit2 = number_format($item['credit2'] - $money,2);
						$data_f['credit2'] = $credit2;
						pdo_update('mc_members', $data_f, array('uid' => $_W['member']['uid']));

						pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
					}else{
						message("支付失败！");
					}
				}
			}
		}
	}

}


if($foo == "showok"){
	
	include $this->template('needs/payok');
}

?>