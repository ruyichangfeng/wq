<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');






$status = $_GPC['status'];
$params  = array(":openid"=> $uc['openid'], ":weid" => $this->weid);
if (!empty($status)) {
	//待付款
	if ($status == 1) {

		$where.= " and o.status=:status";
		$params[":status"] =  self::$KJ_STATUS_XD;
		$where.= " and k.pay_type=:pay_type";
		$params[":pay_type"] = self::PAY_TYPE_WX;
	}


	// 待发货

	if ($status == 2) {
		$where.= " and ((k.pay_type=:p1 and status=:s1) or (k.pay_type=:p2  and status=:s2)) ";
		$params[":p1"] = self::PAY_TYPE_WX;
		$params[":s1"] = self::$KJ_STATUS_GM;

		$params[":p2"] = self::PAY_ZT;
		$params[":s2"] = self::$KJ_STATUS_XD;
	}

	if ($status == 3) {
		$where.= " and o.status=:status";
		$params[":status"] =  self::$KJ_STATUS_YFH;
	}
}


if (!empty($uc)) {

	$goods_name = "(select p_name from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_name";
	$goods_preview_pic = "(select p_preview_pic from ".tablename(DBUtil::$TABLE_XKWKJ_GOODS)." g where k.gid = g.id) as goods_preview_pic";


	$listSql = "select o.* ,o.createtime as ocreatetime, k.id as kid, ".$goods_name.", ".$goods_preview_pic.",  k.pay_type as pay_type from " . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " o left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on o.kid=k.id where k.weid=:weid and o.openid=:openid" . $where;
	$orders = pdo_fetchall($listSql, $params);
}

include $this->template('order');