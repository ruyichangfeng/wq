<?php
global $_W,$_GPC;
$op = !empty($_GPC['op'])?$_GPC['op']:'display';
$status=array('申请中','微信提现','拒绝,金钱返还','拒绝不返回金额','手工提现');
if($op=='display'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$content ='';
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']);
	if (!empty($keyword)) {
		switch($type) {
			case 2 :
				$content .= " AND title LIKE '%{$keyword}%' ";
				break;
			case 3 :
				$content .= " AND nickname LIKE '%{$keyword}%' ";
				break;
			default :
				$content .= " AND realname LIKE '%{$keyword}%' ";
		}
	}
	$goods = pdo_fetchall("select * from".tablename("xuan_js_tixian")."where uniacid = {$_W['uniacid']} {$content} order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
	$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_xiaoche'));
	$settings = iunserializer($settings);
	foreach ($goods as $key => &$value) {
		$goods[$key]['sxf']= round($value['money']*(1-$settings['shouxufei']/100),2);
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xuan_js_tixian') . " WHERE uniacid = {$_W['uniacid']} {$content} ");
	

	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/tixian');
}elseif ($op=='option') {
	$order=pdo_fetch('select * from '.tablename('xuan_js_tixian').' where id=:id and uniacid=:uniacid',array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']));
	
	if ($order['status']!=0) {
		exit('非法操作');
	}
	$sta=intval($_GPC['status']);

	
	if ($sta) {
			switch($sta) {
				case 1:
					$data['status']=1;//微信提现
					/**获取用户openid**/
					$user=pdo_fetch('select openid,uid from '.tablename('mc_mapping_fans').' where uid='.$order['uid']);
					$result = pay($user['openid'], round($order['money']*(1-$settings['shouxufei']/100),2)*100, $trade_no, $desc . '余额提现');
					//var_dump($result);die;
					break;
				case 2:
					$data['status']=2;//拒绝提现（返回金额
					load()->model('mc');
					$result=mc_credit_update($order['uid'], 'credit2', $order['money'] , array(0, '集市拒绝提现返回金额'));
					$result=1;
					break;
				case 3:
					$data['status']=3;//拒绝提现
					$result=1;
					break;
				case 4:
					$data['status']=4;//人工提现
					$result=1;
					break;
			}
			if ($result==1) {
				if(pdo_update('xuan_js_tixian',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']))){
				message('操作成功！',$this->createWebUrl('tixian'),'success');
				
				}
			}else{
				message($result,$this->createWebUrl('tixian'),'error');
			}
			
		}	

}

 function pay($openid = '', $money = 0, $trade_no = '', $desc = '', $return = true) 
	{
		global $_GPC, $_W;
		if (empty($openid)) 
		{
			return error(-1, 'openid不能为空');
		}
		
		
		$setting = uni_setting($_W['uniacid'], array('payment'));
		if (!is_array($setting['payment'])) 
		{
			return error(1, '没有设定支付参数');
		}
		

		$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
		$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_js'));
		$settings = iunserializer($settings);

		$sec['cert']=$settings['weixin_cert'];
		$sec['key']=$settings['weixin_key'];
		$sec['root']=$settings['weixin_root'];

		$wechat = $setting['payment']['wechat'];

		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
		$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
		$certs = $sec;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		$pars = array();
		$pars['mch_appid'] = $row['key'];
		$pars['mchid'] = $wechat['mchid'];
		$pars['nonce_str'] = random(32);
		$pars['partner_trade_no'] = ((empty($trade_no) ? time() . random(4, true) : $trade_no));
		$pars['openid'] = $openid;
		$pars['check_name'] = 'NO_CHECK';
		$pars['amount'] = $money;
		$pars['desc'] = ((empty($desc) ? '现金提现' : $desc));
		$pars['spbill_create_ip'] = gethostbyname($_SERVER['HTTP_HOST']);
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach ($pars as $k => $v ) 
		{
			$string1 .= $k . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		$errmsg = '未上传完整的微信支付证书!';
		if (is_array($certs)) 
		{
			if (empty($certs['cert']) || empty($certs['key']) || empty($certs['root'])) 
			{
				if ($return) 
				{
					if ($_W['ispost']) 
					{
						show_json(0, array('message' => $errmsg));
					}
					die($errmsg);
				}
				else 
				{
					return error(-1, $errmsg);
				}
			}
			$certfile ='../addons/xuan_js/cert/' . random(128);
			file_put_contents($certfile, $certs['cert']);
			$keyfile =  '../addons/xuan_js/cert/' . random(128);
			file_put_contents($keyfile, $certs['key']);
			$rootfile =  '../addons/xuan_js/cert/' . random(128);
			file_put_contents($rootfile, $certs['root']);
			$extras['CURLOPT_SSLCERT'] = $certfile;
			$extras['CURLOPT_SSLKEY'] = $keyfile;
			$extras['CURLOPT_CAINFO'] = $rootfile;
		}
		else if ($return) 
		{
			if ($_W['ispost']) 
			{
				show_json(0, array('message' => $errmsg));
			}
			die($errmsg);
		}
		else 
		{
			return error(-1, $errmsg);
		}
		load()->func('communication');
		$resp = ihttp_request($url, $xml, $extras);
		@unlink($certfile);
		@unlink($keyfile);
		@unlink($rootfile);
		if (is_error($resp)) 
		{
			return  $resp['message'];
		}
		if (empty($resp['content'])) 
		{
			return '网络错误';
		}
		$arr = json_decode(json_encode(simplexml_load_string($resp['content'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if (($arr['return_code'] == 'SUCCESS') && ($arr['result_code'] == 'SUCCESS')) 
		{
			return 1;
		}
		if ($arr['return_msg'] == $arr['err_code_des']) 
		{
			$error = $arr['return_msg'];
		}
		else 
		{
			$error = $arr['return_msg'] . ' | ' . $arr['err_code_des'];
		}
		return $error;
	}



