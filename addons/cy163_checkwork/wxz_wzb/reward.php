<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
$input = file_get_contents('php://input');
if (!empty($input) && empty($_GET['out_trade_no'])) {
	if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $input)) {
		exit('fail');
	}
	libxml_disable_entity_loader(true);
	$obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$data = json_decode(json_encode($obj), true);
	if (empty($data)) {
		exit('fail');
	}
	if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
				exit('fail');
	}
	$get = $data;
} else {
	$get = $_GET;
}
require '../../framework/bootstrap.inc.php';
$_W['uniacid'] = $_W['weid'] = $get['attach'];

ksort($get);
$string1 = '';
foreach($get as $k => $v) {
	if($v != '' && $k != 'sign') {
		$string1 .= "{$k}={$v}&";
	}
}
$setting = uni_setting($_W['uniacid'], array('payment'));
if($setting['payment']['wechat']['switch']==2){
	$setting = uni_setting($setting['payment']['wechat']['borrow'], array('payment'));
}
$wechat = $setting['payment']['wechat'];
$wechat['signkey'] = ($wechat['version'] == 1) ? $wechat['key'] : $wechat['signkey'];
$sign = strtoupper(md5($string1 . "key={$wechat['signkey']}"));
if($sign == $get['sign']) {
	
	$site = WeUtility::createModuleSite('wxz_wzb');
	if(!is_error($site)) {
		$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_ds') . ' WHERE `id` = :id', array(':id' => substr($get['out_trade_no'],16)));
		$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $item['uniacid'],':uid' => $item['uid']) );
		$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `rid` = :rid AND `uid` = :uid', array(':rid' => $item['rid'],':uid' => $item['touid']) );
		pdo_update('wxz_wzb_ds',array('status'=>'1'),array('id'=>substr($get['out_trade_no'],16)));
		
		
		$comment = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uid` = :uid and dsid=:dsid and rid=:rid', array(':uid' => $user['id'],':dsid' => $item['id'],':rid' => $item['rid']));
		
		if(empty($comment)){

			$data=array(
				'uniacid'=>$item['uniacid'],
				'uid'=>$user['id'],
				'ip'=>$_W['clientip'],
				'is_auth'=>1,
				'nickname'=>$user['nickname'],
				'headimgurl'=>$user['headimgurl'],
				'rid'=>$item['rid'],
				'content'=>'´òÉÍ',
				'dsid'=>$item['id'],
				'dsamount'=>$item['fee'],
				'dsstatus'=>1,
				'dateline'=>time()
			);
			$pollingData['type'] = 6;
			if($item['touid']>0){
				$touser = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $item['uniacid'],':uid' => $item['touid']) );
				if(!empty($touser)){
					$data['touid'] = $touser['id'];
					$data['tonickname'] = $touser['nickname'];
					$data['toheadimgurl'] = $touser['headimgurl'];
					if($touser['role']==1){
						$pollingData['type'] = 7;
					}
				}else{
					$data['tonickname'] = $item['tonickname'];
					$data['toheadimgurl'] = $item['toheadurl'];
					$pollingData['type'] = 7;
				}
				
			}
			pdo_insert('wxz_wzb_comment', $data);
			$id=pdo_insertid();
			if($item['touid']>0){
				$data=array(
					'uniacid'=>$item['uniacid'],
					'uid'=>$data['touid'],
					'type'=>1,
					'amount'=>$data['dsamount'],
					'rid'=>$data['rid'],
					'fromid'=>$id,
					'fromuid'=>$data['uid'],
					'fromnickname'=>$data['nickname'],
					'fromheadimgurl'=>$data['headimgurl'],
					'dateline'=>time()
				);
				pdo_insert('wxz_wzb_money_log', $data);
			}
			$pollingData['rid'] = $item['rid'];
			$pollingData['comment_id'] = $id;
			
			pdo_insert('wxz_wzb_polling', $pollingData);
			pdo_update('wxz_wzb_viewer',array('amount'=>$viewer['amount']+$item['fee']),array('uid'=>$item['touid'],'rid'=>$item['rid']));
		}
		
		$method = 'payResult';
		if (method_exists($site, $method)) {
			$ret = array();
			$ret['weid'] = $_W['weid'];
			$ret['uniacid'] = $_W['uniacid'];
			$ret['result'] = 'success';
			$ret['type'] = 'wechat';
			$ret['from'] = 'notify';
			$ret['tid'] = $get['out_trade_no'];
			$ret['user'] = $get['openid'];
			$ret['fee'] = $get['total_fee'] / 100;
			$ret['tag'] = array('transaction_id'=>$get['transaction_id']);
			$site->$method($ret);
		}
	}
	exit('success');
}
exit('fail');