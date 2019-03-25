<?php
global $_W, $_GPC;

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'getIndex', 'list', 'getList', 'page', 'pageinfo', 'setorder', 'setaddress', 'setaddressok', 'ordercar', 'orderpay', 'rate', 'getRate', 'info', 'keep', 'away', 'zan');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
	$adv = pdo_fetchall("select * from ".tablename('xm_gohome_adv')." where weid=".$this->weid." and stop = 1 and show_adr ='takeout' order by top asc");

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and stop=1 and delstate=1 order by id desc limit 0,8");

    include $this->template('takeout/index');
}

if($foo == 'getIndex'){
	$lat = $_GPC['lat'];
	$lng = $_GPC['lng'];
	if(empty($lat)){
		echo 0;
		exit();
	}
	$adrstr = $this->encode_geohash($lat,$lng,12);
	$adrstr = substr($adrstr,0,1);

	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
	
	if (!empty($_GPC['top1'])) {
		$arr = pdo_fetchall("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and stop=1 and state=1 and delstate=1 and top1 !=0 order by top1 desc, adrstr desc limit ".$startCount.",".$pageSize."");	
	}
	if (!empty($_GPC['top2'])) {
		$arr = pdo_fetchall("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and stop=1 and state=1 and delstate=1 and top2 !=0 order by top2 desc, adrstr desc limit ".$startCount.",".$pageSize."");	
	}
	
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$url = $this->createMobileUrl('takeout',array('foo'=>'page', 'id'=>$value['id']));
			if($value['coverpic'] == ''){
				$icon = MODULE_URL.'static/takeout/images/nopic.jpg ';
			}else{
				if (strstr($value['coverpic'],'images')){
					$icon = $_W['attachurl'].$value['coverpic'];
				}else{
					$icon = $_W['attachurl'].'gohome/coverpic/'.$value['coverpic'];
				}
			}
			$merchant_name 	   = $value['merchant_name'];
			$xing          	   = intval($value['xing']/$value['person']);
			$merchant_address  = $value['merchant_address'];
			$ordersum      	   = $value['ordersum'];
			$merchant_price    = $value['merchant_price'];
			$merchant_song     = $value['merchant_song'];
			$merchant_timelong = $value['merchant_timelong'];
			$new_disc		   = $value['new_disc'];
			$new_disc_money    = $this->getDiscInfo($id, 'new_disc');
			$man1_disc		   = $value['man1_disc'];
			$man1              = $this->getDiscInfo($id, 'man_1');
			$jian1              = $this->getDiscInfo($id, 'jian_1');
			$man2_disc		   = $value['man2_disc'];
			$man2              = $this->getDiscInfo($id, 'man_2');
			$jian2              = $this->getDiscInfo($id, 'jian_2');
			$man3_disc		   = $value['man3_disc'];
			$man3              = $this->getDiscInfo($id, 'man_3');
			$jian3              = $this->getDiscInfo($id, 'jian_3');
			$disc		       = $value['disc'];
			$disc_money              = $this->getDiscInfo($id, 'disc');

			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","icon":"'.$icon.'","merchant_name":"'.$merchant_name.'","xing":"'.$xing.'","merchant_address":"'.$merchant_address.'","ordersum":"'.$ordersum.'","merchant_price":"'.$merchant_price.'","merchant_song":"'.$merchant_song.'","merchant_timelong":"'.$merchant_timelong.'","new_disc":"'.$new_disc.'","new_disc_money":"'.$new_disc_money.'","man1_disc":"'.$man1_disc.'","man1":"'.$man1.'","jian1":"'.$jian1.'","man2_disc":"'.$man2_disc.'","man2":"'.$man2.'","jian2":"'.$jian2.'","man3_disc":"'.$man3_disc.'","man3":"'.$man3.'","jian3":"'.$jian3.'","disc":"'.$disc.'","disc_money":"'.$disc_money.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'list') {
	$type_id = intval($_GPC['type_id']);
	if(empty($type_id)){
		message('参数错误001');
	}

	$item = pdo_fetch("select type_name from ".tablename('xm_gohome_type')." where id=".$type_id);

	$list1 = pdo_fetchall("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and stop=1 and delstate=1 order by id desc");
	$list2 = pdo_fetchall("select * from ".tablename('xm_gohome_lido')." where weid=".$this->weid." and stop=1 and delstate=1 order by id desc");
	$list3 = pdo_fetchall("select * from ".tablename('xm_gohome_address')." where weid=".$this->weid." and stop=1 and delstate=1 order by id desc");

    include $this->template('takeout/list');
}

if($foo == 'getList'){
	$type_id = intval($_GPC['type_id']);
	$lido_id = intval($_GPC['lido_id']);
	$adr_id = intval($_GPC['adr_id']);
	$xiao = intval($_GPC['xiao']);

	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$condition = '';
	$params = array();
	/*if (!empty($_GPC['nickname'])) {
		$condition .= " AND nickname LIKE :nickname";
		$params[':nickname'] = "%{$_GPC['nickname']}%";
	}*/
	if (!empty($type_id)) {
		$condition .= " AND type_id =".$type_id;
	}
	if (!empty($adr_id)) {
		$condition .= " AND adr_id =".$adr_id;
	}
	if (!empty($lido_id)) {
		$condition .= " AND lido_id =".$lido_id;
	}
	if(!empty($xiao)){
		$arr = pdo_fetchall("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and stop=1 and state=1 and delstate=1 ".$condition." order by ordersum desc,addtime desc limit ".$startCount.",".$pageSize."");
	}else{
		$arr = pdo_fetchall("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and stop=1 and state=1 and delstate=1 ".$condition." order by addtime desc limit ".$startCount.",".$pageSize."");
	}

	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$url = $this->createMobileUrl('takeout',array('foo'=>'page', 'id'=>$value['id']));
			$merchant_name = $value['merchant_name'];
			if(empty($value['coverpic'])){
				$icon = MODULE_URL.'static/takeout/images/nopic.jpg ';
			}else{
				if (strstr($value['coverpic'],'images')){
					$icon = $_W['attachurl'].$value['coverpic'];
				}else{
					$icon = $_W['attachurl'].'gohome/coverpic/'.$value['coverpic'];
				}
			}
			$ordersum      	   = $value['ordersum'];
			$merchant_price = $value['merchant_price'];
			$merchant_song = $value['merchant_song'];
			$xing = intval($value['xing']/$value['person']);
			$new_disc		   = $value['new_disc'];
			$new_disc_money    = $this->getDiscInfo($id, 'new_disc');
			$man1_disc		   = $value['man1_disc'];
			$man1              = $this->getDiscInfo($id, 'man_1');
			$jian1              = $this->getDiscInfo($id, 'jian_1');
			$man2_disc		   = $value['man2_disc'];
			$man2              = $this->getDiscInfo($id, 'man_2');
			$jian2              = $this->getDiscInfo($id, 'jian_2');
			$man3_disc		   = $value['man3_disc'];
			$man3              = $this->getDiscInfo($id, 'man_3');
			$jian3              = $this->getDiscInfo($id, 'jian_3');
			$disc		       = $value['disc'];
			$disc_money              = $this->getDiscInfo($id, 'disc');
			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","icon":"'.$icon.'","merchant_name":"'.$merchant_name.'","ordersum":"'.$ordersum.'","merchant_price":"'.$merchant_price.'","merchant_song":"'.$merchant_song.'","xing":"'.$xing.'","new_disc":"'.$new_disc.'","new_disc_money":"'.$new_disc_money.'","man1_disc":"'.$man1_disc.'","man1":"'.$man1.'","jian1":"'.$jian1.'","man2_disc":"'.$man2_disc.'","man2":"'.$man2.'","jian2":"'.$jian2.'","man3_disc":"'.$man3_disc.'","man3":"'.$man3.'","jian3":"'.$jian3.'","disc":"'.$disc.'","disc_money":"'.$disc_money.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'page'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}
	
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and id=".$id." and delstate=1");
	if(empty($item)){
		message('未查询到数据');
	}
	$xing = intval($item['xing']/$item['person']);
	$disc = $item['disc'];
	$disc_zhe = $this->getDiscInfo($item['id'], 'disc')/10;
	
	$menuarr = pdo_fetchall("select * from ".tablename('xm_gohome_menu')." where weid=".$_W['uniacid']." and merchant_id=".$item['id']." and stop=1 and currysum>0 and delstate=1");
	$curryarr = pdo_fetchall("select * from ".tablename('xm_gohome_curry')." where weid=".$_W['uniacid']." and merchant_id=".$item['id']." and stop=1 and delstate=1");

	$all =  pdo_fetchcolumn("select count(*) from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and merchant_id=".$id." and delstate=1");
	
	include $this->template('takeout/page');
}

if($foo == "pageinfo"){
	//$id = intval($_GPC['id']);
	//$item = pdo_fetch("select * from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and id=".$id);

	include $this->template('takeout/pageinfo');
}

if($foo == 'setorder'){
	$openid = $_W['fans']['from_user'];  //openid
	$merchant_id = $_GPC['merchant_id']; //商铺id
	$curry_id    = $_GPC['curry_id'];    //多选数组【菜名id】
	$curry_sum   = $_GPC['curry_sum'];   //多选数组【每个菜的总数】
	$buysum   	 = $_GPC['buysum'];      //购买总数
	$pricesum    = $_GPC['pricesum'];    //总价
	$merchant_song    = $_GPC['merchant_song'];    //总价
	//$remark      = $_GPC['remark'];
	
	/*
	$m_openid = $this->getMerchantInfo($merchant_id, 'openid');
	if($m_openid == $openid){
		message("不能在自己商铺下单");
		exit();
	}
	*/

	//订单号
	$orderid = $this->createTakeoutOrder();
	//构造订单数据
	$order = array(
		'weid'    	  => $_W['uniacid'],
		'orderid' 	  => $orderid,
		'merchantid'  => $merchant_id,
		'openid'      => $openid,
		'amount'      => $pricesum,
		'normal'      => $pricesum,
		'quantity'    => $buysum,
		'song'    	  => $merchant_song,
		'ctime'       => time(),
		'state'       => 1,
		'remark'      => ''
	);
	//构造明细数据
	$items	   = array();
	//$ids  	 = explode(',', $curry_id);
	//$quantitys = explode(',', $curry_sum);
	$ids  	   = $curry_id;
	$quantitys = $curry_sum;
	foreach ($ids as $key => $id) {
		$id 	  = intval($id);
		$quantity = intval($quantitys[$key]);
		$items[] = array(
			'weid'     => $_W['uniacid'],
			'orderid'  => $orderid,
			'curryid'  => $id,
			'quantity' => $quantity,
			'price'	   => $this->getCurryInfo($id, 'price'),
			'ctime'    => time()
		);
	}
	//写入数据
	pdo_begin();
	$result1 = pdo_insert('xm_gohome_takeorder', $order);
	//循环写入明细
	$errors = 0;
	foreach ($items as $item) {
		$result = pdo_insert('xm_gohome_takeorderitem', $item);
		if($result === false){
			$errors += 1;
		}
	}
	//判断结果
	if($result1===false||$errors>0){
		pdo_rollback();
	}else{
		pdo_commit();
		header("Location:".$this->createMobileUrl('takeout',array('foo'=>'setaddress', 'orderid'=>$orderid)));
	}
}

if($foo == 'setaddress'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}
	$this->checkreg();

	$orderid = intval($_GPC['orderid']);
	if(empty($orderid)){
		message('参数错误001');
	}
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeaddress')." where weid=".$this->weid." and openid='".$openid."'");

	include $this->template('takeout/setaddress');
}

if($foo == 'setaddressok'){
	$orderid = intval($_GPC['orderid']);
	$adr_id = intval($_GPC['adr_id']);
	if(empty($orderid)){
		message('参数错误：订单ID未获取！');
		exit();
	}
	if(empty($adr_id)){
		message('参数错误：送单地址未获取！');
		exit();
	}
	//订单自增长id
	$id = $this->getOrderId($orderid);
	if(empty($id)){
		message('获取订单信息失败！');
		exit();
	}

	$check = pdo_fetch("select id,state from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);
	if($check['state'] == 1){
		$item = pdo_fetch("select * from ".tablename('xm_gohome_takeaddress')." where weid=".$this->weid." and id=".$adr_id);
		if($item['sex'] == 1){$sex='男';}else{$sex='女';}
		$data = array(
			'realname' => $item['realname'],
			'sex'      => $sex,
			'mobile'   => $item['mobile'],
			'address'  => $item['adr_city'].$item['adr_room'],
			'state'    => 2,
			'otime'    => time()
		);
		$res = pdo_update('xm_gohome_takeorder', $data, array('id'=> $id));
		if($res){
			header("Location:".$this->createMobileUrl('takeout',array('foo'=>'ordercar', 'orderid'=>$orderid)));
		}else{
			message('提交订单信息失败！');
		}
	}else{
		message('订单信息已提交，正在跳转到订单页面...',$this->createMobileUrl('takeout', array('foo'=>'myorder','id'=>$id)), 'success');
	}
}

if($foo == 'ordercar'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}

	$this->checkreg();

	$orderid = intval($_GPC['orderid']);
	if(empty($orderid)){
		message('参数错误：订单ID未获取！');
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and orderid='".$orderid."'");
	
	$sql = "select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$orderid."'";
	$list = pdo_fetchall($sql);
	//检测首单
	$check = pdo_fetch("select id from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and merchantid=".$item['merchantid']." and state>2 and openid='".$openid."'");
	$first = 1;
	if(!empty($check['id'])){
		$first = 0;
	}

	$amount = $item['amount'];
	
	$new_disc = $this->getMerchantInfo($item['merchantid'], 'new_disc');
	if($new_disc == 1 && $first == 1){
		$new_disc_money = $this->getDiscInfo($item['merchantid'], 'new_disc');
		$amount = $amount-$new_disc_money;
	}

	$disc = $this->getMerchantInfo($item['merchantid'], 'disc');
	if($disc == 1){
		$disc_zhe = $this->getDiscInfo($item['merchantid'], 'disc')/10;
	}

	$man1_disc = $this->getMerchantInfo($item['merchantid'], 'man1_disc');
	$man1 = $this->getDiscInfo($item['merchantid'], 'man_1');
	$jian1 = $this->getDiscInfo($item['merchantid'], 'jian_1');
	
	$man2_disc = $this->getMerchantInfo($item['merchantid'], 'man2_disc');
	$man2 = $this->getDiscInfo($item['merchantid'], 'man_2');
	$jian2 = $this->getDiscInfo($item['merchantid'], 'jian_2');

	$man3_disc = $this->getMerchantInfo($item['merchantid'], 'man3_disc');
	$man3 = $this->getDiscInfo($item['merchantid'], 'man_3');
	$jian3 = $this->getDiscInfo($item['merchantid'], 'jian_3');
	
	if($man1_disc == 1){
		if($man1 <= $amount){
			$amount = $amount - $jian1;
		}
	}
	if($man1_disc == 1 && $man2_disc == 1){
		if($man1 < $amount && $amount <= $man_2){
			$amount = $amount - $jian2;
		}
	}
	if($man1_disc == 1 && $man2_disc == 1 && $man3_disc == 1){
		if($man1 < $amount && $amount <= $man_2){
			$amount = $amount - $jian2;
		}
		if($man2 <= $amount && $amount < $man3){
			$amount = $amount - $jian2;
		}
		if($man3 <= $amount){
			$amount = $amount - $jian3;
		}
	}
	
	include $this->template('takeout/ordercar');
}

if($foo == 'orderpay'){
	$openid  = $_W['fans']['from_user'];
	$orderid = $_GPC['orderid'];
	$paytype = intval($_GPC['paytype']);

	$item = pdo_fetch("select id,openid,merchantid,orderid,state from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and orderid='".$orderid."'");
	if(empty($item['id'])){
		message('参数错误：未获取到订单数据');
		exit();
	}
	if($item['state'] > 2){
		message('该订单已支付！');
		exit();
	} 
	
	if($paytype == 2){
		$money = $_GPC['amount'];
		$u_info = array(
			'state'   => 3,
			'paytype' => 2,
			'ptime2'  => time()
		);
		pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$item['id']));
		
		$m_item = pdo_fetch("select openid,staff_id,type_id,gettype,bili_bai,bili_money,start,end from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and id=".$item['merchantid']);
		
		$jump = $_W['siteroot']."app/index.php?i=".$this->weid."&c=entry&do=merchant&foo=order&id=".$m_item['staff_id']."&m=xm_gohome";
		$this->send_taketmpmsg('ttmpmsg_id', $item['openid'], $jump, $item['id']);
		pdo_query("update ".tablename('xm_gohome_merchant')." set ordersum=ordersum+1 where id=".$item['merchantid']);
		$list = pdo_fetchall("select curryid,quantity from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");
		foreach ($list as $value) {
			pdo_query("update ".tablename('xm_gohome_curry')." set allsum=allsum+".$value['quantity']." where id=".$value['curryid']);
		}

		$msgbase = $this->getMessageBase();      //获取短信设置数据
		if($msgbase['message4'] == 1){
			$smstype  = $msgbase['platform'];
			$q = $msgbase['qianming'];
			$q = str_replace("【", '', $q);
			$q = str_replace("】", '', $q);
			$mobile  = $this->getMerchantInfo($item['merchantid'], 'merchant_mobile');
			//$mobile = "13469828762";

			if($smstype == 1){

				$c = $this->getBaoTakeout($item['id'], $msgbase['message4_content']);
			}else{
				$tempid  = $msgbase['msg4_tempid'];
				$c = $this->getAlidayuTakeout($tempid, $mobile, $item['id']);
			}
			$data_sms['app']     = 'gohome';
			$data_sms['key'] 	 = $this->getBase('key_info');
			$data_sms['smstype'] = $smstype;
			$data_sms['u'] 		 = $msgbase['plat_name'];
			$data_sms['p'] 		 = $msgbase['plat_pwd'];
			$data_sms['m'] 		 = $mobile;
			$data_sms['q'] 		 = $q;
			$data_sms['c']       = $c;
			$res = $this->post(SEND_SMS, $data_sms, 5); 
			//$res = json_decode($res);
		}

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
					'merchant_id'=> $item['merchantid'],
					'orderid'   => $orderid,
					'getmoney'   => $smoney,
					'type'       => 1,
					'way'        => 1
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);

			}else{
				$getMoney1 = $money;
				$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
				$data_g['money'] = $item_s['money'] - $m_item['bili_money'];
				pdo_update('xm_gohome_staff', $data_g, array('id' => $m_item['staff_id']));
				
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $item['merchantid'],
					'orderid'   => $orderid,
					'getmoney'   => $m_item['bili_money'],
					'type'       => 1,
					'way'        => 0
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
			}
			$data_p = array(
				'weid'     	  => $this->weid,
				'openid'   	  => $openid,
				'merchant_id' => $item['merchantid'],
				'money'    	  => $money,
				'orderid' 	  => $item['orderid'],
				'type'        => 'takeout',
				'paytype'	  => '2',
				'getmoney'    => $getMoney1
			);
			$res = pdo_insert('xm_gohome_takepaylog', $data_p);

			pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
		}else{
			$t_item = pdo_fetch("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and delstate=1 and id=".$m_item['type_id']);
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
						'merchant_id'=> $item['merchantid'],
						'orderid'   => $orderid,
						'getmoney'   => $smoney,
						'type'       => 1,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
					
				}else{
					$getMoney1 = $money;
					$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
					$data_g['money'] = $item_s['money'] - $t_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id' => $m_item['staff_id']));
					
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $item['merchantid'],
						'orderid'   => $orderid,
						'getmoney'   => $t_item['bili_money'],
						'type'       => 1,
						'way'        => 0
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				}
				$data_p = array(
					'weid'     	  => $this->weid,
					'openid'   	  => $openid,
					'merchant_id' => $item['merchantid'],
					'money'    	  => $money,
					'orderid' 	  => $item['orderid'],
					'type'        => 'takeout',
					'paytype'	  => '2',
					'getmoney'    => $getMoney1
				);
				$res = pdo_insert('xm_gohome_takepaylog', $data_p);

				pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
			}
		}
		
		message('订单已提交', $this->createMobileUrl('takeorder', array('foo'=>'myorder')));
	}else{
		$fee = floatval($_GPC['amount']);
		if($fee <= 0) {
			message('支付错误, 金额小于0');
		}
		$params = array(
			'tid' => 'G#'.$this->weid.'#'.$openid.'#'.$fee.'#'.$item['id'],
			'ordersn' => $this->generate_code(8),
			'title' => '外卖付款',
			'fee' => $fee,
			'user' => $_W['member']['uid']
		);
		$this->pay($params);
	}	
}

if($foo == 'rate'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}

	$this->checkreg();

	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and id=".$id);
	if(empty($item)){
		message('未查询到数据');
	}
	$xing = intval($item['xing']/$item['person']);

	include $this->template('takeout/rate');
}

if($foo == 'getRate'){
	$merchantid = $_GPC['merchantid'];
	$grade      = $_GPC['grade'];

	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
	
	$condition = '';
	$params = array();
	
	if (!empty($grade)) {
		$condition .= " AND grade =".$grade;
	}

	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$_W['uniacid']." and merchantid=".$merchantid." and type='takeout' ".$condition." order by addtime desc limit ".$startCount.",".$pageSize."");
	
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id       = $value['id'];
			$url      = $this->createMobileUrl('takeout',array('foo'=>'page', 'id'=>$value['id']));
			$avatar   = $this->getMemberInfo($value['openid'], 'avatar');
			$nickname = $this->getMemberInfo($value['openid'], 'nickname');
			$xing 	  = $value['xing'];
			$comment  = $value['comment'];
			$addtime  = $value['addtime'];
			$item = pdo_fetch("select reply from ".tablename('xm_gohome_commentreply')." where weid=".$this->weid." and cid=".$value['id']);
			$reply    = $item['reply'];
			$idStr .= '{"id":"'.$id.'","avatar":"'.$avatar.'","nickname":"'.$nickname.'","xing":"'.$xing.'","comment":"'.$comment.'","reply":"'.$reply.'","addtime":"'.$addtime.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'info'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}

	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and id=".$id);
	if(empty($item)){
		message('未查询到数据');
	}
	$xing = intval($item['xing']/$item['person']);

	include $this->template('takeout/info');
}

if($foo == 'keep'){
	$openid = $_W['fans']['from_user'];
	$id = intval($_GPC['id']);
	if(empty($id)){
		echo 0;
	}
	$item = pdo_fetch("select id from ".tablename('xm_gohome_takekeep')." where weid=".$this->weid." and merchantid=".$id." and openid='".$openid."'");
	if(empty($item)){
		$data = array(
			'weid'       => $this->weid,
			'openid'     => $openid,
			'merchantid' => $id,
			'ctime'      => time()
		);
		$res = pdo_insert('xm_gohome_takekeep', $data);
		if($res){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 2;
	}
}

if($foo == 'away'){
	$openid = $_W['fans']['from_user'];
	$id = intval($_GPC['id']);
	if(empty($id)){
		echo 0;
	}
	$item = pdo_fetch("select id from ".tablename('xm_gohome_takekeep')." where weid=".$this->weid." and merchantid=".$id." and openid='".$openid."'");
	if(!empty($item)){
		$res = pdo_delete('xm_gohome_takekeep', array('id'=>$item['id']));
		if($res){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 2;
	}
}

if($foo == 'zan'){
	$openid = $_W['fans']['from_user'];
	$id     = intval($_GPC['id']);

	$check = pdo_fetch("select id from ".tablename('xm_gohome_zanlog')." where weid=".$this->weid." and curry_id=".$id." and openid='".$openid."'");
	if(empty($check)){
		$data = array(
			'weid'     => $this->weid,
			'openid'   => $openid,
			'curry_id' => $id,
			'ctime'    => time()
  		);
  		$res = pdo_insert('xm_gohome_zanlog', $data);
  		if($res){
  			pdo_query("update ".tablename('xm_gohome_curry')." set zan=zan+1 where weid=".$this->weid." and id=".$id." and delstate=1");
  			echo 1;
  		}else{
  			echo 0;
  		}
	}else{
		echo 2;
	}
}

?>