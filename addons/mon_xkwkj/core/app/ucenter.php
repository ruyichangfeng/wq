<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');








if (!empty($uc)) {

	$countSql = "select count(*) from " . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " o left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on o.kid=k.id where k.weid=:weid and o.openid=:openid and status=:status and k.pay_type=:pay_type";
	$waitePayCount = pdo_fetchcolumn($countSql, array(':weid'=> $this->weid, ":openid"=> $uc['openid'], ':status'=> $this::$KJ_STATUS_XD, ":pay_type" => self::PAY_TYPE_WX));



	$joinSql = "select count(*) from " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on u.kid=k.id where k.weid=:weid and u.openid=:openid";
	$joinCount = pdo_fetchcolumn($joinSql, array(':weid'=> $this->weid, ":openid"=> $uc['openid']));
	$helpSql = "select count(*) from " . tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " f left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on f.kid=k.id where k.weid=:weid and f.openid=:openid";
	$helpCount = pdo_fetchcolumn($helpSql, array(':weid'=> $this->weid, ":openid"=> $uc['openid']));
}

include $this->template('u_center');
