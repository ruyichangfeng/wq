<?php
/**
 * 余额充值提现模块微站定义
 *
 * @author 刘靜
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('MODULE_NAME','jing_cash');
define('CSS_PATH', '../addons/'.MODULE_NAME.'/template/style/css/');
define('JS_PATH', '../addons/'.MODULE_NAME.'/template/style/js/');
define('IMG_PATH', '../addons/'.MODULE_NAME.'/template/style/images/');
define('OSSURL', 'http://weimeizhan.oss-cn-shenzhen.aliyuncs.com/');
class Jing_cashModuleSite extends WeModuleSite {

	public function __construct(){
		global $_W;
		$setting = pdo_fetchcolumn("SELECT settings FROM ".tablename('uni_account_modules')." WHERE module = :module AND uniacid = :uniacid", array(':module' => 'jing_cash', ':uniacid' => $_W['uniacid']));
		$config = iunserializer($setting);
		$month_start = mktime(0,0,0,date('m'),1,date('Y'));
		$orders = pdo_fetchall("SELECT * FROM ".tablename('jing_cash_recharge')." WHERE sy > 0 AND status=1 AND lastfh < '{$month_start}' LIMIT 0,10");
		foreach ($orders as $key => $value) {
			$money = $value['zs'] / $value['fh'];
			$update = array(
				'sy' => $value['sy'] - $money,
				'lastfh' => time(),
				);
			pdo_update('jing_cash_recharge',$update,array('id'=>$value['id']));
			load()->model('mc');
			mc_credit_update(mc_openid2uid($value['openid']), 'credit2', $money, array('0'=>'1','1'=>'充值返现'));
			if (!empty($config['tpl3'])) {
				$mfirst = '尊敬的用户您好，您的一笔返现已到账。';
				$mfoot = '感谢你的使用，谢谢！';
				$murl = '';
				$mdata = array(
					'first' => array(
						'value' => $mfirst,
						'color' => '#ff510'
					),
					'keyword1' => array(
						'value' => sprintf("%.2f", $money),
						'color' => '#ff510'
					),
					'keyword2' => array(
						'value' => '充'. $value['money'].'元，返'.$value['zs'].'元（分'.$value['fh'].'月）',
						'color' => '#ff510'
					),
					'remark' => array(
						'value' => $mfoot ,
						'color' => '#ff510'
					),
				);
				$acc = WeAccount::create();
				$acc->sendTplNotice($value['openid'], $config['tpl3'], $mdata, $murl, $topcolor = '#FF683F');
			}
		}
		return true;
	}

	public function doMobileOauth(){
		global $_W,$_GPC;
		if (!empty($_GPC['code'])) {
			$code = $_GPC['code'];
			$config = $this->module['config'];
			$acid = $config['oauth'];
			$oauth_account = WeAccount::create($acid);
			$oauth = $oauth_account->getOauthInfo($code);
			$openid = $oauth['openid'];
			if (!empty($openid)) {
				header("Location:".$this->createMobileUrl($_GPC['state'],array('oauthopenid'=>$openid)));
			}else{
				message('非法访问.');
			}
		}else{
			message('非法访问.');
		}
	}
	public function doWebCashajax(){
		global $_GPC,$_W;
		load()->model('mc');
		$config = $this->module['config'];
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);
		$m = $_GPC['money'];
		$x = $_GPC['money1'];
		$b = $_GPC['balance'];
		$y = $_GPC['cz_amount'];
		if($m > $y){
			exit(json_encode(array('status'=>0,'msg'=>'提现金额超出押金余额,提现失败')));
		}
		if($x > $b){
			exit(json_encode(array('status'=>0,'msg'=>'提现金额超出闲书币余额,提现失败')));
		}
		$log = pdo_fetch("SELECT * FROM " . tablename('jing_cash_cash') . " WHERE `uniacid`=:uniacid AND `id`=:id", array(':uniacid'=>$_W['uniacid'], ':id'=>$id));
		if (empty($log)) {
			exit(json_encode(array('status'=>0,'msg'=>'抱歉，记录不存在，提现失败')));
		}
		if ($log['status'] == 1) {
			exit(json_encode(array('status'=>0,'msg'=>'该记录已经打款.')));
		}
		if ($type == 2) {//拒绝提现
			$result = mc_credit_update(mc_openid2uid($log['openid']), 'credit2', $log['money'], array('0'=>'1','1'=>'提现失败返还'));
			if($result == true){
				pdo_update('jing_cash_cash',array('status'=>-1),array('id'=>$id));
				exit(json_encode(array('status'=>1,'msg'=>'拒绝提现成功，余额已返还用户账户.')));
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'拒绝提现失败，失败原因：'.$result)));
			}
		}elseif ($type == 1) {//允许提现
			if ($config['oauth'] == 0) { //不借用权限
				$acid = $_W['acid'];
			}else{
				$acid = $config['oauth'];	
			}
			$account = account_fetch($acid);
			$uniacid = pdo_fetchcolumn("SELECT uniacid FROM ".tablename('account')." WHERE acid=:acid",array(':acid'=>$acid));
			$paysetting = uni_setting($uniacid, array('payment'));
			$wechatpay = $paysetting['payment']['wechat'];
			$wechat = array(
				'appid' => $account['key'],
				'mchid' => $wechatpay['mchid'],
				'apikey' => $wechatpay['apikey'],
				'pemname' => $config['pemname'],
				'ip' => $config['ip'],
				);
			$sendmoney = $log['money'] - $log['fee'];
			if ($config['sendtype'] == 1) {
				$payresult = $this->sendHongbao($wechat,$log['payopenid'],$sendmoney,$config['send_name'],$config['act_name'],$config['wishing']);
			}else{
				$payresult = $this->sendMoney($wechat,$log['payopenid'],$sendmoney,$config['paydesc']);
			}
			if ($payresult['result_code'] != 'SUCCESS') {
				if ($payresult['err_code'] == 'SYSTEMERROR') {
					if ($config['sendtype'] == 1) {
						$payresult = $this->sendHongbao($wechat,$log['payopenid'],$sendmoney,$config['send_name'],$config['act_name'],$config['wishing'],$payresult['trade_no']);
					}else{
						$payresult = $this->sendMoney($wechat,$log['payopenid'],$sendmoney,$config['paydesc'],$payresult['trade_no']);
					}
					pdo_update('jing_cash_cash',array('status'=>1),array('id'=>$id));
					exit(json_encode(array('status'=>1,'msg'=>'允许提现成功.')));
				}else{
					exit(json_encode(array('status'=>1,'msg'=>'提现失败，失败原因:'.$payresult['msg'].'请稍后重试！')));
				}
			} else{
				pdo_update('jing_cash_cash',array('status'=>1),array('id'=>$id));
				exit(json_encode(array('status'=>1,'msg'=>'允许提现成功.')));
			}
		}else{
			exit(json_encode(array('status'=>0,'msg'=>'非法操作.')));
		}
	}
	public function doMobileCashajax(){
		global $_GPC,$_W;

		$config = $this->module['config'];
		load()->model('mc');
		$result = mc_credit_fetch($_W['member']['uid']);
		$payopenid = $_GPC['payopenid'];
		$money = $_GPC['money'];
		$lastlog = pdo_fetch("SELECT * FROM " . tablename('jing_cash_cash') . " WHERE `uniacid`=:uniacid AND `openid`=:openid ORDER BY createtime DESC", array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid']));
		if (time() < $lastlog['createtime'] + $config['days'] * 86400) { //提现冷却时间
			exit(json_encode(array('status'=>0,'msg'=>'抱歉，您在'.$config['days'].'天内已经提现过')));
		}
		if ($config['minnum'] > $money) {
			exit(json_encode(array('status'=>0,'msg'=>'抱歉，单次提现至少'.$config['minnum'].'元，请重新填写金额')));
		}
		if ($result['credit2'] < $money) {
			exit(json_encode(array('status'=>0,'msg'=>'抱歉，您的余额少于提现金额，请重新填写金额')));
		}
		if ($config['fee'] > 0) {
			$truefee = $money * $config['fee'] * 0.01;
			if ($truefee < $config['minfee']) {
				$fee = $config['minfee'];
			}elseif ($truefee > $config['maxfee']) {
				$fee = $config['maxfee'];
			}else{
				$fee = $truefee;
			}
		}
		if ($config['ischeck'] == 1) {//需要审核
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $_W['openid'],
				'payopenid' => $payopenid,
				'money' => $money,
				'fee' => $fee,
				'status' => 0,
				'createtime' => TIMESTAMP
				);
			$result = mc_credit_update(mc_openid2uid($_W['openid']), 'credit2', '-'.$money, array('0'=>'1','1'=>'余额提现'));
			if($result == true){
				pdo_insert('jing_cash_cash',$insert);
				exit(json_encode(array('status'=>1,'msg'=>'提现成功，请等待管理员审核.')));
			}else{
				exit(json_encode(array('status'=>0,'msg'=>$result)));
			}
		}else{//无需审核，直接打款
			if ($config['oauth'] == 0) { //不借用权限
				$acid = $_W['acid'];
			}else{
				$acid = $config['oauth'];	
			}
			$account = account_fetch($acid);
			$uniacid = pdo_fetchcolumn("SELECT uniacid FROM ".tablename('account')." WHERE acid=:acid",array(':acid'=>$acid));
			$paysetting = uni_setting($uniacid, array('payment'));
			$wechatpay = $paysetting['payment']['wechat'];
			$wechat = array(
				'appid' => $account['key'],
				'mchid' => $wechatpay['mchid'],
				'apikey' => $wechatpay['apikey'],
				'pemname' => $config['pemname'],
				'ip' => $config['ip'],
				);
			$sendmoney = $money - $fee;
			if ($config['sendtype'] == 1) {
				$payresult = $this->sendHongbao($wechat,$payopenid,$sendmoney,$config['send_name'],$config['act_name'],$config['wishing']);
			}else{
				$payresult = $this->sendMoney($wechat,$payopenid,$sendmoney,$config['paydesc']);
			}
			// $payresult = $this->sendMoney($wechat,$payopenid,$sendmoney,'余额提现');
			if ($payresult['result_code'] != 'SUCCESS') {
				if ($payresult['err_code'] == 'SYSTEMERROR') {
					if ($config['sendtype'] == 1) {
						$payresult = $this->sendHongbao($wechat,$payopenid,$sendmoney,$config['send_name'],$config['act_name'],$config['wishing'],$payresult['trade_no']);
					}else{
						$payresult = $this->sendMoney($wechat,$payopenid,$sendmoney,$config['paydesc'],$payresult['trade_no']);
					}
					// $this->sendMoney($wechat,$payopenid,$sendmoney,'余额提现',$payresult['trade_no']);
					$status = 1;
					$msg = '提现成功，请稍后在零钱中查看余额.';
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $_W['openid'],
						'payopenid' => $payopenid,
						'money' => $money,
						'fee' => $fee,
						'status' => 1,
						'createtime' => TIMESTAMP
						);
					$result = mc_credit_update(mc_openid2uid($_W['openid']), 'credit2', '-'.$money, array('0'=>'1','1'=>'余额提现'));
					if($result == true){
						pdo_insert('jing_cash_cash',$insert);
						exit(json_encode(array('status'=>1,'msg'=>'提现成功.')));
					}else{
						exit(json_encode(array('status'=>0,'msg'=>$result)));
					}
				}else{
					$status = 0;
					$msg = '提现失败，失败原因:'.$payresult['msg'].'请稍后重试！';
				}
			} else{
				$status = 1;
				$msg = '提现成功，请稍后在零钱中查看余额.';
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $_W['openid'],
					'payopenid' => $payopenid,
					'money' => $money,
					'fee' => $fee,
					'status' => 1,
					'createtime' => TIMESTAMP
					);
				$result = mc_credit_update(mc_openid2uid($_W['openid']), 'credit2', '-'.$money, array('0'=>'1','1'=>'余额提现'));
				if($result == true){
					pdo_insert('jing_cash_cash',$insert);
					exit(json_encode(array('status'=>1,'msg'=>'提现成功.')));
				}else{
					exit(json_encode(array('status'=>0,'msg'=>$result)));
				}
			}
			exit(json_encode(array('msg'=>$msg)));
		}
	}

	private function sendHongbao($wechat,$openid,$money,$send_name = '余额提现',$act_name = '余额提现',$wishing = '祝您生活愉快',$trade_no='') {
		$money = $money * 100;
		$num = 1;
		$url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
		$pars = array();
		$pars['wxappid'] = $wechat['appid'];
		$pars['mch_id'] = $wechat['mchid'];
		$pars['nonce_str'] = random(32);
		$pars['mch_billno'] = empty($trade_no) ? $wechat['mchid'] . date('Ymd') . rand(1000000000,9999999999) : $trade_no;
		$pars['send_name'] = $send_name;
        $pars['re_openid'] = $openid;
        $pars['total_amount'] = $money;
        $pars['total_num'] = $num;
        $pars['wishing'] = $wishing;
        $pars['client_ip'] = isset($wechat['ip']) ? $wechat['ip'] : $_SERVER['SERVER_ADDR'];
        $pars['act_name'] = $act_name;
        $pars['remark'] = $act_name;
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$wechat['apikey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CURLOPT_CAINFO'] = ATTACHMENT_ROOT . '/cert/rootca.pem.' . $wechat['pemname'];
        $extras['CURLOPT_SSLCERT'] = ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $wechat['pemname'];
        $extras['CURLOPT_SSLKEY'] = ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $wechat['pemname'];
        load()->func('communication');
        $procResult = null;
        $response = ihttp_request($url, $xml, $extras);
        if ($response['code'] == 200) {
			$responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
			$responseObj = (array)$responseObj;
			$return['code'] =  $responseObj['return_code'];
			$return['result_code'] =  $responseObj['result_code'];
			$return['err_code'] =  $responseObj['err_code'];
			$return['msg'] =  $responseObj['return_msg'];
			$return['trade_no'] = $pars['mch_billno'];//返回订单号 用于重试
			return $return;
		}
	}

	private function sendMoney($wechat,$openid,$money,$desc,$trade_no='') {
		$desc = isset($desc) ? $desc : '余额提现';
		$money = $money * 100;
		$url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
		$pars = array();
		$pars['mch_appid'] = $wechat['appid'];
		$pars['mchid'] = $wechat['mchid'];
		$pars['nonce_str'] = random(32);
		$pars['partner_trade_no'] = empty($trade_no) ? $wechat['mchid'].date('Ymd') . rand(1000000000,9999999999) : $trade_no;
        $pars['openid'] = $openid;
        $pars['check_name'] = 'NO_CHECK';
        $pars['amount'] = $money;
        $pars['desc'] = $desc;
        $pars['spbill_create_ip'] = isset($wechat['ip']) ? $wechat['ip'] : $_SERVER['SERVER_ADDR'];
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$wechat['apikey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CURLOPT_CAINFO'] = ATTACHMENT_ROOT . '/cert/rootca.pem.' . $wechat['pemname'];
        $extras['CURLOPT_SSLCERT'] = ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $wechat['pemname'];
        $extras['CURLOPT_SSLKEY'] = ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $wechat['pemname'];

        load()->func('communication');
        $procResult = null;
        $response = ihttp_request($url, $xml, $extras);
        if ($response['code'] == 200) {
			$responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
			$responseObj = (array)$responseObj;
			$return['code'] =  $responseObj['return_code'];
			$return['result_code'] =  $responseObj['result_code'];
			$return['err_code'] =  $responseObj['err_code'];
			$return['msg'] =  $responseObj['return_msg'];
			$return['trade_no'] = $pars['partner_trade_no'];
			return $return;
		}
	}

	public function doMobilePay(){
		global $_GPC,$_W;
		$type = $_GPC['type'];
		$payopenid = $_GPC['payopenid'];
		$logid = intval($_GPC['logid']);
		$params = array(
			'module' => 'jing_cash',
			'type' => $type,
			'uniacid' => $_W['uniacid'],
			'acid' => $_W['acid'],
			'openid' => $_W['openid'],
			'payopenid' => $payopenid,
			'title' => '余额充值',
			'fee' => $_GPC['money'],
			'tid' => $logid
			);
		$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
		$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
		if ($type == 'wechat') {
			$config = $this->module['config'];
			if (!empty($config['rule'])) {
				$rule = iunserializer($config['rule']);
				foreach ($rule as $key => $value) {
					if ($value['cz'] == $_GPC['money']) {
						$zs = $value['zs'];
						$fh = isset($value['fh']) ? $value['fh'] : 1;
						break;
					}else{
						$zs = 0;
						$fh = 1;
					}
				}
			}
			if (empty($params['tid'])) {
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $_W['openid'],
					'money' => $_GPC['money'],
					'zs' => $zs,
					'fh' => $fh,
					'sy' => $zs,
					'lastfh' => 0,
					'createtime' => TIMESTAMP,
					);
				pdo_insert('jing_cash_recharge', $insert);
				$params['tid'] = pdo_insertid();
			}else{
				pdo_update('jing_cash_recharge', array('money' => $_GPC['money'], 'zs' => $zs, 'fh' => $fh, 'sy' => $zs, 'lastfh' => 0),array('id'=>$params['tid']));
			}

			if($_W['container'] != 'wechat'){
				exit(json_encode(array('status'=>0,'msg'=>'请在微信中使用.')));
			}
			if ($config['oauth'] == 0) { //不借用权限
				$setting = uni_setting($_W['uniacid'], array('payment'));
				$params['attach'] = $_W['uniacid'];
			}else{
				$acid = $config['oauth'];
				$account = account_fetch($acid);
				$uniacid = pdo_fetchcolumn("SELECT uniacid FROM ".tablename('account')." WHERE acid=:acid",array(':acid'=>$acid));
				$setting = uni_setting($uniacid, array('payment'));
				$params['attach'] = $uniacid;
			}
			
			if(!is_array($setting['payment'])) {
				exit(json_encode(array('status'=>0,'msg'=>'没有设定支付参数.')));
			}
			$wechat = $setting['payment']['wechat'];
			$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
			$row = pdo_fetch($sql, array(':acid' => $wechat['account']));
			$wechat['appid'] = $row['key'];
			$wechat['secret'] = $row['secret'];
			$wOpt = $this->wechat_build($params, $wechat);
			if (is_error($wOpt)) {
				if ($wOpt['message'] == 'invalid out_trade_no' || $wOpt['message'] == 'OUT_TRADE_NO_USED') {
					exit(json_encode(array('status'=>0,'msg'=>'抱歉，发起支付失败，系统已经修复此问题，请重新尝试支付。')));
				}
				exit(json_encode(array('status'=>0,'msg'=>'抱歉，发起支付失败，具体原因为：“'.$wOpt['errno'].':'.$wOpt['message'].'”。请及时联系站点管理员。')));
			}
			exit(json_encode(array('status'=>1,'wechat'=>$wOpt,'logid'=>$params['tid'])));
		}
	}

	public function payResult($params){
		global $_W;
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            $fee = intval($params['fee']);
            $data = array('status' => $params['result'] == 'success' ? 1 : 0);
            $paytype = array('credit' => '1', 'wechat' => '2', 'alipay' => '2', 'delivery' => '3');
            $data['paytype'] = $paytype[$params['type']];
            if ($params['type'] == 'wechat') {
                $data['transid'] = $params['tag']['transaction_id'];
            }
            $order = pdo_fetch("SELECT * FROM " . tablename('jing_cash_recharge') . " WHERE id = '{$params['tid']}'");
            if ($order['status'] != 1) {
            	if ($order['sy'] > 0 && $order['fh'] > 0) {
            		$fanhuan = $order['sy'] / $order['fh'];//首次返还
            		$data['sy'] = $order['sy'] - $fanhuan;
            		$data['lastfh'] = time();
            	}else{
            		$fanhuan = 0;
            	}
                pdo_update('jing_cash_recharge', $data, array('id' => $params['tid']));
                load()->model('mc');
                $money = $order['money'] + $fanhuan;
				$result = mc_credit_update(mc_openid2uid($order['openid']), 'credit2', $money, array('0'=>'1','1'=>'在线充值'));
				//处理闲书
				$this->processXs($params['tid']);
			}
        }
	}
	/*微信支付方法*/
	//
	public function wechat_build($params, $wechat) {
		global $_W;
		load()->func('communication');
		if (empty($wechat['version']) && !empty($wechat['signkey'])) {
			$wechat['version'] = 1;
		}
		$paylog = pdo_fetch("SELECT * FROM ".tablename('core_paylog')." WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid ",array(':uniacid'=>$params['uniacid'],':module'=>$params['module'],':tid'=>$params['tid']));
		if(!empty($paylog) && $paylog['status'] != '0') {
			return error(-1, '这个订单已经支付成功, 不需要重复支付.');
		}
		$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
		$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
		$fee = $params['fee'];
		if(!empty($paylog) && $paylog['status'] == '0') { //订单存在并且未支付，更新记录
			$fee = $params['fee'];
			$record = array();
			$record['fee'] = $fee;
			$record['uniontid'] = date('YmdHis').$moduleid.random(8,1);
			$record['card_fee'] = $fee;
			pdo_update('core_paylog', $record, array('tid'=>$params['tid'],'module'=>$params['module']));
		}
		if(empty($paylog)) {//订单不存在，加入记录
			$fee = $params['fee'];
			$record = array();
			$record['uniacid'] = $params['uniacid'];
			$record['openid'] = $params['openid'];
			$record['module'] = $params['module'];
			$record['type'] = $params['type'];
			$record['tid'] = $params['tid'];
			$record['uniontid'] = date('YmdHis').$moduleid.random(8,1);
			$record['fee'] = $fee;
			$record['status'] = '0';
			$record['is_usecard'] = 0;
			$record['card_id'] = 0;
			$record['card_fee'] = $fee;
			$record['encrypt_code'] = '';
			$record['acid'] = $params['acid'];
			pdo_insert('core_paylog', $record);
		}
		$params['uniontid'] = $record['uniontid'];
		$wOpt = array();
		if ($wechat['version'] == 1) {
			$wOpt['appId'] = $wechat['appid'];
			$wOpt['timeStamp'] = TIMESTAMP;
			$wOpt['nonceStr'] = random(8);
			$package = array();
			$package['bank_type'] = 'WX';
			$package['body'] = $params['title'];
			$package['attach'] = $params['attach'];
			$package['partner'] = $wechat['partner'];
			$package['out_trade_no'] = $params['uniontid'];
			$package['total_fee'] = $params['fee'] * 100;
			$package['fee_type'] = '1';
			$package['notify_url'] = $_W['siteroot'] . 'payment/wechat/notify.php';
			$package['spbill_create_ip'] = CLIENT_IP;
			$package['time_start'] = date('YmdHis', TIMESTAMP);
			$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
			$package['input_charset'] = 'UTF-8';
			ksort($package);
			$string1 = '';
			foreach($package as $key => $v) {
				if (empty($v)) {
					continue;
				}
				$string1 .= "{$key}={$v}&";
			}
			$string1 .= "key={$wechat['key']}";
			$sign = strtoupper(md5($string1));

			$string2 = '';
			foreach($package as $key => $v) {
				$v = urlencode($v);
				$string2 .= "{$key}={$v}&";
			}
			$string2 .= "sign={$sign}";
			$wOpt['package'] = $string2;

			$string = '';
			$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
			sort($keys);
			foreach($keys as $key) {
				$v = $wOpt[$key];
				if($key == 'appKey') {
					$v = $wechat['signkey'];
				}
				$key = strtolower($key);
				$string .= "{$key}={$v}&";
			}
			$string = rtrim($string, '&');

			$wOpt['signType'] = 'SHA1';
			$wOpt['paySign'] = sha1($string);
			return $wOpt;
		} else {
			$package = array();
			$package['appid'] = $wechat['appid'];
			$package['mch_id'] = $wechat['mchid'];
			$package['nonce_str'] = random(8);
			$package['body'] = $params['title'];
			$package['attach'] = $params['attach'];
			$package['out_trade_no'] = $params['uniontid'];
			$package['total_fee'] = $params['fee'] * 100;
			$package['spbill_create_ip'] = CLIENT_IP;
			$package['time_start'] = date('YmdHis', TIMESTAMP);
			$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
			$package['notify_url'] = $_W['siteroot'] . 'payment/wechat/notify.php';
			$package['trade_type'] = 'JSAPI';
			$package['openid'] = $params['payopenid'];
			ksort($package, SORT_STRING);
			$string1 = '';
			foreach($package as $key => $v) {
				if (empty($v)) {
					continue;
				}
				$string1 .= "{$key}={$v}&";
			}
			$string1 .= "key={$wechat['signkey']}";
			$package['sign'] = strtoupper(md5($string1));
			$dat = array2xml($package);
			$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
			if (is_error($response)) {
				return $response;
			}
			$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
			if (strval($xml->return_code) == 'FAIL') {
				return error(-1, strval($xml->return_msg));
			}
			if (strval($xml->result_code) == 'FAIL') {
				return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
			}
			$prepayid = $xml->prepay_id;
			$wOpt['appId'] = $wechat['appid'];
			$wOpt['timeStamp'] = TIMESTAMP . "";
			$wOpt['nonceStr'] = random(8);
			$wOpt['package'] = 'prepay_id='.$prepayid;
			$wOpt['signType'] = 'MD5';
			ksort($wOpt, SORT_STRING);
			foreach($wOpt as $key => $v) {
				$string .= "{$key}={$v}&";
			}
			$string .= "key={$wechat['signkey']}";
			$wOpt['paySign'] = strtoupper(md5($string));
			return $wOpt;
		}
	}

	public function processXs($tid){
		global $_W;
		if(!empty($tid)){
			$paylog = pdo_fetch("SELECT * FROM ".tablename('core_paylog')." WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid ",array(':uniacid'=>$_W['uniacid'],':module'=>'jing_cash',':tid'=>$tid));
			if(!empty($paylog) && $paylog['status'] == 1 ){
				//开始处理额度
				$userAccount = pdo_fetch("SELECT * FROM " . tablename('wx_school_bookaccount') . " where openid = :openid", array(':openid' => $paylog['openid']));

				$margin = pdo_fetch("SELECT * FROM " . tablename('wx_school_bookmargin'). " where type = 'book_cz'");
				$rate = $margin['couponAmount']/$margin['amount'];
				$cz_amount = $userAccount['cz_amount'] + $rate*$paylog['fee'];
				$balance = $userAccount['balance'] + $rate*$paylog['fee'];
				pdo_update('wx_school_bookaccount',array('cz_amount' => $cz_amount,'balance' => $balance),array('openid' => $paylog['openid']));
				//发送模板消息
                $balance1 = $userAccount['balance'];
                $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename('wx_school_myorder') . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $paylog['openid']));
                if($orders['orderPrice']){
                    $balance1 -= $orders['orderPrice'];
                }
                $trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename('wx_school_mytransferorder') . " where  orderStatus in (1,2,3,4,5) And (openid = '{$paylog['openid']}' or partybopenid = '{$paylog['openid']}')");
                if(count($trans_orders) > 0){
                    $orderPrice = 0;
                    foreach ($trans_orders as $trans_order){
                        if($paylog['openid'] == $trans_order['openid'] && $trans_order['inPrice'] > 0){
                            $orderPrice += $trans_order['inPrice'];
                        }
                        if($paylog['openid'] == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
                            if($trans_order['outPrice'] > $trans_order['inPrice']){
                                $orderPrice += ($trans_order['outPrice']-$trans_order['inPrice']);
                            }
                        }
                    }
                    $balance1 -= $orderPrice;
                }
                if($balance1 < 0){
                    $balance1 = 0;
                }
				$msgBody = array(
					'schoolid'   => 8,
					'weid'       => $_W['uniacid'],
					'orderId'    => 10000,
					'orderType'  => 'cz',
					'openid'     => $paylog['openid'],
					'amountData' => array(
						'preAmount'   => $balance1,
						'afterAmount' => $balance1+$rate*$paylog['fee'],
						'amount'      => sprintf('%0.2f',$rate*$paylog['fee'])
					)
				);
				$this->sendMobileXsedbdtz($msgBody);
				//添加日志
				$data = array(
					'amount' => sprintf('%0.2f',$rate*$paylog['fee']),
					'type'   => 'cz',
					'openid' => $paylog['openid'],
					'remark' => '充值赠送额度'
				);
				pdo_insert('wx_school_booklog',$data);
			}
		}
	}
	public function sendMobileXsedbdtz($params) {
		//$schoolid,$orderId, $weid, $orderType,$action = 'in',$amount = 0,$openid,$preamount=0
		if(empty($params['schoolid']) || empty($params['weid']) || empty($params['orderType']) || empty($params['amountData'])){
			return;
		}
		global $_GPC,$_W;
		$schoolid = $params['schoolid'];
		$weid     = $params['weid'];
		$orderType = $params['orderType'];
		$amountData = $params['amountData'];
		$openid = $params['openid'];
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename('wx_school_set')." WHERE :weid = weid", array(':weid' => $weid));
		$template_id = $msgtemplate['xsedbdtz'];//消息模板id 微信的模板idable_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $bzj['tid']));
		$ttime = date('Y').'年'.date('m').'月'.date('d').'日';
			if(empty($openid)){
				$openid = $_W['openid'];
			}
			$partyb = pdo_fetch("SELECT * FROM " . tablename('wx_school_user') . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
			$mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
			$unit = '';
			if($orderType == 'jz'){
				$orderTypeName = '集赞增额';
				$title = $mcInfo['nickname'].',恭喜小主的闲书币增额了，赶快来找找您想要的书吧！';
				$body = '点击详情，进入闲书地图找书。';
			}elseif($orderType == 'cz'){
				$orderTypeName = '充值增额';
				$title = $mcInfo['nickname'].',恭喜小主的闲书币增额了，赶快来找找您想要的书吧！';
				$body = '点击详情，进入闲书地图找书。';
			}elseif($orderType == 'tx'){
				$unit = '闲书币';
				$orderTypeName = '押金提现';
				$title = $mcInfo['nickname'].',您用闲书币兑回了押金'.$amountData['money'].'元，因而您的闲书币账户发生如下变动';
				$body = '点击详情，查看您的押金余额和变动明细。';
			}
			$datas1=array(
				'first'=>array('value'=>$title,'color'=>'#FF9E05'),
				'keyword1'=>array('value'=>$orderTypeName,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$amountData['amount'].$unit,'color'=>'#FF9E05'),
				'keyword3'=>array('value'=>$amountData['preAmount'].$unit,'color'=>'#FF9E05'),
				'keyword4'=>array('value'=>sprintf('%0.2f',$amountData['afterAmount']).$unit,'color'=>'#FF9E05'),
				'keyword5'=>array('value'=>$ttime,'color'=>'#FF9E05'),
				'remark' => array('value'=>$body,'color'=>'#1587CD'),
			);
			if($orderType == 'tx'){
				$url1 =  $_W['siteroot'] .'app/index.php?i=9&c=entry&do=index&m=jing_cash&schoolid='.$schoolid;
			}else{
				$url1 =  $_W['siteroot'] .'app/index.php?i=9&c=entry&do=bookmap&m=duola_club&schoolid='.$schoolid;
			}
			$data1=json_encode($datas1); //发送的消息模板数据
			if (!empty($template_id)) {
				$this->sendtempmsg($template_id, $url1, $data1, '#FF0000', $openid);
			}
		}
	public function sendtempmsg($template_id, $url, $data, $topcolor, $tousers = '') {
		global $_GPC,$_W;
		load()->func('communication');
		load()->classs('weixin.account');
		$accObj= WeixinAccount::create($_W['account']['acid']);
		$accObj->clearAccessToken();
		$access_token = $accObj->fetch_token();
		if(empty($access_token)) {
			return;
		}
		$postarr = '{"touser":"'.$tousers.'","template_id":"'.$template_id.'","url":"'.$url.'","topcolor":"'.$topcolor.'","data":'.$data.'}';
		$res = ihttp_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,$postarr);
		return true;
	}
}