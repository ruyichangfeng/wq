<?php
defined('IN_IA') or exit ('Access Denied');
define('MB_ROOT', IA_ROOT . '/addons/cgc_voice_book');
require MB_ROOT . '/inc/util.php';
require MB_ROOT . '/inc/common.php';
define('TEE_SITE_URL', 'https://teegon.com/');
define('TEE_API_URL', 'https://api.teegon.com/');
session_start();
class cgc_voice_bookModuleSite extends WeModuleSite {
	
	
	//获得会员信息
	function get_member() {
		global $_W, $_GPC;
		$uniacid = $_W['uniacid'];
		$settings = $this->module['config'];
		$userinfo = getFromUser($settings, $this->modulename);
		$userinfo = json_decode($userinfo, true);
		WeUtility::logging('$userinfo', $userinfo);
		$from_user = $userinfo['openid'];
		if (empty($from_user) && empty($_GPC['test111'])) {
			message("非法访问");
		}
	
		$member = pdo_fetch("SELECT * FROM " . tablename('cgc_voice_book_member') . " WHERE uniacid=" . $uniacid . " and openid='{$userinfo['openid']}'");
	
		if (empty($member)) {
			$data = array('uniacid' => $uniacid, 'openid' => $userinfo['openid'], 'nickname' => $userinfo['nickname'], 'headimgurl' => $userinfo['headimgurl'], 'createtime' => TIMESTAMP);
			$ret = pdo_insert("cgc_voice_book_member", $data);
			if (empty($ret)) {
				$this->returnError('生成会员失败');
				exit();
			}
			$member = pdo_fetch("SELECT * FROM " . tablename('cgc_voice_book_member') . " WHERE uniacid=" . $uniacid . " and openid='{$userinfo['openid']}'");
				
		}
		return $member;
	}
	
	protected function pay($params = array(), $mine = array()){
	
		global $_W;
	
		if (!$this->inMobile) {
			message('支付功能只能在手机上使用');
		}
	
		$params['module'] = $this->module['name'];
	
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
	
		$pars = array();
	
		$pars[':uniacid'] = $_W['uniacid'];
	
		$pars[':module'] = $params['module'];
	
		$pars[':tid'] = $params['tid'];
	
		$log = pdo_fetch($sql, $pars);
	
		if (!empty($log) && $log['status'] == '1') {
	
			$this->returnError('这个订单已经支付成功, 不需要重复支付.');
	
		}
	
		if (empty($log)) {
			$log = array(
					'uniacid' => $_W['uniacid'],
					'acid' => $_W['acid'],
					'openid' => $params['openid'],
					'module' => $this->module['name'], //模块名称，请保证$this可用
					'tid' => $params['tid'],
					'fee' => $params['fee'],
					'card_fee' => $params['fee'],
					'status' => '0',
					'is_usecard' => '0',
			);
			pdo_insert('core_paylog', $log);
		}
	
		return $params;
	
	}
	
	function NoRand($begin = 0, $end = 9, $limit = 8) {
		global $_W, $_GPC;
		$rand_array = range($begin, $end);
		shuffle($rand_array); //调用现成的数组随机排列函数
		$r = array_slice($rand_array, 0, $limit); //截取前$limit个
		$r = implode($r);
		$the = pdo_get('cgc_invite_code', array (
			'uniacid' => $_W['uniacid'],
			'invite_code' => $r
		));
		if ($the) {
			return NoRand();
		}
		return $r;
	}
	
	
	public function payResult($params) {
		global $_W;
		$settings = $this->module['config'];
		if ($params['type'] == 'wechat') {
			$wechat_sn = $params['tag']['transaction_id'];
		}else if ($params['type'] == 'teegon_pay'){
			$teegon_sn = $params['transaction_id'];
		}
	
		$id = $params['tid'];
		$sale_pay = pdo_get('cgc_voice_book_pay', array('uniacid' => $_W['uniacid'], 'ordersn' => $id));
	
		if (empty ($sale_pay)) {
			message("没有找到订单");
		}
	
		if ($params['result'] == 'success' && ($params['from'] == 'notify' || $params['type'] == 'credit')) {
			if ($params['result'] == 'success') {
				if ($params['fee'] != $sale_pay['fee']) {
					message('非法操作！支付失败!');
				}
	
				pdo_update('cgc_voice_book_pay', array('wx_ordersn' => $wechat_sn,'teegon_ordersn' => $teegon_sn,'is_pay' => 1), array('ordersn' => $id));
				
				//pdo_update('cgc_voice_book_member', array('status' => 1), array('id' => $sale_pay['member_id']));
				
				$member_class =array(
						'class_id'=>$sale_pay['class_id'],
						'class_name'=>$sale_pay['class_name'],
						'status'=>1,
						'uniacid'=>$_W['uniacid'],
						'openid'=>$sale_pay['openid'],
						'nickname'=>$sale_pay['nickname'],
						'headimgurl'=>$sale_pay['headimgurl'],
						'createtime'=>TIMESTAMP
				);
				pdo_insert('cgc_voice_book_member_class', $member_class);
	
			}
		}
	
		if ($params['from'] == 'return') {
			if ($params['result'] == 'success') {
				$url = getSiteRoot($_W['siteroot']). "/" . 'app/' . substr($this->createMobileUrl('success', array('id' => $sale_pay['goods_id'], 'op' => 'pay')), 2);
			} else {
				$url = getSiteRoot($_W['siteroot']). "/" . 'app/' . substr($this->createMobileUrl('error', array('id' => $sale_pay['goods_id'], 'op' => 'pay')), 2);
			}
			header("location:" . $url);
			exit ();
		}
	}
	
	
	public function doWebQr()
    {
       global $_GPC;
       $raw = @base64_decode($_GPC['raw']);

		if (!empty($raw)) {

			include MB_ROOT . '/inc/phpqrcode.php';

			QRcode::png($raw, false, QR_ECLEVEL_Q, 4);

		}

	}

	function returnError($message, $data = '', $status = 0, $type = '') {
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array (
				'status' => $status,
				'info' => $message,
				'data' => $data
			);
			exit (json_encode($ret));
		} else {
			return $this->returnMessage($message, $data, 'error');
		}
	}

	function returnSuccess($message, $data = '', $status = 1, $type = '') {
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array (
				'status' => $status,
				'info' => $message,
				'data' => $data
			);
			exit (json_encode($ret));
		} else {
			return $this->returnMessage($message, $data, 'success');
		}
	}

	function returnMessage($msg, $redirect = '', $type = '') {
		global $_W, $_GPC;
		if ($redirect == 'refresh') {
			$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
		}
		if ($redirect == 'referer') {
			$redirect = referer();
		}
		if ($redirect == '') {
			$type = in_array($type, array (
				'success',
				'error',
				'info',
				'warn'
			)) ? $type : 'info';
		} else {
			$type = in_array($type, array (
				'success',
				'error',
				'info',
				'warn'
			)) ? $type : 'success';
		}
		if (empty ($msg) && !empty ($redirect)) {
			header('location: ' . $redirect);
			exit ();
		}
		$label = $type;
		if ($type == 'error') {
			$label = 'warn';
		}
		include $this->template('error');
		exit ();
	}
}