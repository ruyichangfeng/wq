<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$oid = $_GPC['oid'];
$orderInfo = DBUtil::findById(DBUtil::$TABLE_XKWJK_ORDER, $oid);
MonUtil::emtpyMsg($orderInfo, "订单删除或不存在");

$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $orderInfo['uid']);
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $orderInfo['kid']);
$userInfo = $this->getClientUserInfo($xkwkj['id']);
$this->toPayTemplate($user, $orderInfo, $xkwkj);
