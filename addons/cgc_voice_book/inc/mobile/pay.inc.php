<?php
	global $_W, $_GPC;  
	$uniacid=$_W['uniacid'];
	$modulename=$this->modulename;
	$settings = $this->module['config'];
	$cgc_voice_book_pay = new cgc_voice_book_pay();
    $member = $this-> get_member();
    
    $class_id = $_GPC['class_id'];
    
    $class = pdo_get('cgc_voice_book_class', array ('uniacid' => $_W['uniacid'],'id'=>$class_id));
    
    if ($class){
    	$settings['fee'] = $class['price'];
    }
    
    $pay = pdo_get('cgc_voice_book_pay', array ('uniacid' => $_W['uniacid'],'openid' => $member['openid'],'class_id'=>$class_id));
    
    if ($pay){
	    if ($pay['is_pay']==1){
	    	$this->returnError('您已经支付过，请刷新页面');
	    }else{
	    	$tid = $pay['id'];
	    }
    }else{
    	$pay = array(
    			"uniacid" => $_W['uniacid'],
    			"openid" => $member['openid'],
    			"nickname" => $member['nickname'],
    			"headimgurl" => $member['headimgurl'],
    			"member_id" => $member['id'],
    			"fee" => $settings['fee'],
    			'class_id'=>$class_id,
    			'class_name'=>$class['name'],
    			"createtime" => TIMESTAMP,
    			"is_pay" => 0,
    			"ordersn" => time() . mt_rand(1, 10000),
    	);
    	
    	$tid = $cgc_voice_book_pay->insert($pay);
    }
    	
    if ($tid) {
    	$params['tid'] = $pay['ordersn'];
    	$params['user'] = $from_user;
    	$params['fee'] =$pay["fee"];
    	$params['title'] = $settings['name']."费用";
    	$params['ordersn'] = $pay['ordersn'];
    	
    	if (empty($settings['pay_type'])){
	    	//微信支付
	    	$pay_params = $this -> pay($params);
	    	$this -> returnSuccess('', base64_encode(json_encode($pay_params)));
    	
    	}else if ($settings['pay_type']==1){ //天工收银
    		define('TEE_CLIENT_ID', $settings['teegon_client_id']);
    		define('TEE_CLIENT_SECRET', $settings['teegon_client_secret']);
    		require_once(MODULE_ROOT.'/teegon/lib/teegon.php');
    		$srv = new TeegonService(TEE_API_URL);
    	
    		$param['order_no'] = $params['ordersn']; //订单号
    		$param['channel'] = 'wxpay_jsapi';
    		$param['return_url'] = $_W['siteroot'] . 'addons/cgc_voice_book/teegon/re_url.php';
    		$param['amount'] = $params['fee'];
    		$param['subject'] = $params['title'];
    		$param['metadata'] = "";
    		$param['notify_url'] = $_W['siteroot'] . 'addons/cgc_voice_book/teegon/no_url.php';;//支付成功后天工支付网关通知
    		$param['wx_openid'] = "";//$params['user'];
    		$sign = $srv->sign($param);
    		$param['sign'] = $sign;
    		echo $srv->pay($param, false);
    		exit();
    	}
    }
    	     
    
