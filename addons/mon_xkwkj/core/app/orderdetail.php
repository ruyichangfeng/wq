<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$kid = $_GPC['kid'];
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);
MonUtil::emtpyMsg($xkwkj, "砍价活动删除或不存在");
MonUtil::emtpyMsg($goods, "商品删除或不存在");
$orderInfo = $this->findOrderInfoByOpenid($kid, $uc['openid']);
$uac =$this->findUserAc($kid, $uc['openid'] );


if (empty($orderInfo['lq_type'])) {
	$lq_type = self::LQ_TYPE_KD;
} else {
	$lq_type = $orderInfo['lq_type'];
}

MonUtil::emtpyMsg($orderInfo, "您还未提交订单");
if ($xkwkj['pay_type'] == self::PAY_TYPE_WX) {
	$jsApi = new JsApi_pub($this->xkkjSetting);
	$jsApi->setOpenId($uc['openid']);
	$unifiedOrder = new UnifiedOrder_pub($this->xkkjSetting);
	$unifiedOrder->setParameter("openid", $uc['openid']);//商品描述

	$unifiedOrder->setParameter("body", "砍价商品" . $goods['p_name']);//商品描述
	$out_trade_no = date('YmdHis', time()). "o".$orderInfo['id'];
	$unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号
	//$orderInfo['total_price']
	//$unifiedOrder->setParameter("total_fee", 1);//总金额
	$unifiedOrder->setParameter("total_fee", $orderInfo['total_price']*100);//总金额
	$notifyUrl = $_W['siteroot'] . "addons/" . MON_XKWKJ . "/notify.php";
	$unifiedOrder->setParameter("notify_url", $notifyUrl);//通知地址
	$unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
	$prepay_id = $unifiedOrder->getPrepayId();
	$jsApi->setPrepayId($prepay_id);
	DBUtil::updateById(DBUtil::$TABLE_XKWJK_ORDER, array('outno' => $out_trade_no), $orderInfo['id']);
	$jsApiParameters = $jsApi->getParameters();
	//$gmCount = $this->getOrderCount($xkwkj['id'], $this::$KJ_STATUS_GM);
	$leftCount = $this->getLeftCount($xkwkj);
	//$leftCount = 3;
	$orderInfo = $this->findOrderInfoByOpenid($kid, $uc['openid']);
}

include $this->template('order_detail');