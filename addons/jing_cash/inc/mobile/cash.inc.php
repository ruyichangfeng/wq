<?php
/**
 * 餐饮商城模块微站定义
 *
 * @author 刘靜
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
load()->model('mc');
$result = mc_credit_fetch($_W['member']['uid']);
$config = $this->module['config'];
if ($config['closetx'] == 1) {
	message('提现业务暂时不可使用，请联系管理员');
}
$schoolid = $_GPC['schoolid'];
$weid = $_W['uniacid'];
$payopenid = $_GPC['oauthopenid'];
$op = $_GPC['op'] ? $_GPC['op'] : 'out';
if($op == 'out'){
	if (empty($payopenid)) {
		if ($config['oauth'] == 0) { //不借用权限
			if (empty($_W['openid'])) {
				message('无法获取到您的openid，请稍后重试');
			}else{
				$payopenid = $_W['openid'];
			}
		}else{
			$acid = $config['oauth'];
			$oauth = account_fetch($acid);
			$from = 'cash';
			$url = $_W['siteroot'].'app'.str_replace('./', '/', $this->createMobileUrl('oauth'));
			$callback = urlencode($url);
			$forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$oauth['key']."&redirect_uri=".$callback."&response_type=code&scope=snsapi_base&state=".$from."#wechat_redirect";
			header('Location: ' . $forward);
			exit();
		}
	}
	$lastlog = pdo_fetch("SELECT * FROM " . tablename('jing_cash_cash') . " WHERE `uniacid`=:uniacid AND `openid`=:openid ORDER BY createtime DESC", array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid']));
	$flag = 1;
//if (time() < $lastlog['createtime'] + $config['days'] * 86400) { //提现冷却时间
//	$flag = 0;
//}
//if ($result['credit2'] < $config['minnum']) {
//	$flag = 0;
//}
	$config['minfee'] = isset($config['minfee']) ? $config['minfee'] : 1;
	$config['maxfee'] = isset($config['maxfee']) ? $config['maxfee'] : 25;
//查询余额 wx_school_bookmargin
	$userAccount = pdo_fetch("SELECT * FROM " . tablename('wx_school_bookaccount') . " WHERE  `openid`=:openid ", array(':openid'=>$payopenid));
	$bookMargin = pdo_fetch("SELECT * FROM " . tablename('wx_school_bookmargin') . " WHERE  `type`='book_cz' ");
	if($bookMargin['amount'] > 0){
		$rate = sprintf('%0.2f',$bookMargin['couponAmount']/$bookMargin['amount']);
	}else{
		$rate = 3;
	}
    $balance1 = $userAccount['balance'];
    $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename('wx_school_myorder') . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $payopenid));
    if($orders['orderPrice']){
        $balance1 -= $orders['orderPrice'];
    }
    $trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename('wx_school_mytransferorder') . " where  orderStatus in (1,2,3,4,5) And (openid = '{$payopenid}' or partybopenid = '{$payopenid}')");
    if(count($trans_orders) > 0){
        $orderPrice = 0;
        foreach ($trans_orders as $trans_order){
            if($payopenid == $trans_order['openid'] && $trans_order['inPrice'] > 0){
                $orderPrice += $trans_order['inPrice'];
            }
            if($payopenid == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
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
	include $this->template('cash');
}elseif($op == 'tx'){
	if(empty($schoolid)){
		message('无法获取到您的schoolid，请稍后重试');
	}
		$paylog = pdo_fetch("SELECT * FROM " . tablename('jing_cash_cash') . " WHERE `uniacid`=:uniacid AND `openid`=:openid ORDER BY createtime DESC", array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid']));
		if(!empty($paylog)){
			//开始处理额度
			$userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $paylog['payopenid']));

			$margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_cz'");
			$rate = $margin['couponAmount']/$margin['amount'];
			$cz_amount = $userAccount['cz_amount'] - $rate*$paylog['money'];
			$balance = $userAccount['balance'] - $rate*$paylog['money'];
			pdo_update($this->table_bookaccount,array('cz_amount' => $cz_amount,'balance' => $balance),array('openid' => $paylog['payopenid']));
//			//发送模板消息
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
				'schoolid'   => $schoolid,
				'weid'       => $weid,
				'orderId'    => 10000,
				'orderType'  => 'tx',
				'amountData' => array(
					'preAmount'   => $balance1,
					'afterAmount' => $balance1-$rate*$paylog['money'],
					'amount'      => sprintf('%0.2f',$rate*$paylog['money']),
					'money'       => $paylog['money']
				)
			);
			$this->sendMobileXsedbdtz($msgBody);
			//添加日志
			$data = array(
				'amount' => sprintf('%0.2f',$rate*$paylog['money']),
				'type'   => 'tx',
				'openid' => $paylog['payopenid'],
				'remark' => '提现额度'
			);
			pdo_insert($this->table_booklog,$data);
		}
	die(json_encode(array(
		'result' => true,
		'msg'    => 'ok'
	)));
}

?>