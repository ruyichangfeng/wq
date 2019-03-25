<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');

$oid = $_GPC['oid'];
$order = DBUtil::findById(DBUtil::$TABLE_XKWJK_ORDER, $oid);
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $order['kid']);
$qrcode = $this->getScanCode($oid);
if ($order['status'] == $this::$KJ_STATUS_XD || $order['status'] == $this::$KJ_STATUS_GM) {
	$statusText = '未兑换';
}

if ($order['status'] == $this::$KJ_STATUS_YFH) {
	$statusText = '已兑换';
}
$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);
include $this->template("qrcode");
