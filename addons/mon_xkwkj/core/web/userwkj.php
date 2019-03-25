<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$openid = $_GPC['openid'];
	$user = $this->findUniUserInfo($openid, $this->weid);

	$listSql = "select u.id as uid , k.id as kid, k.title, k.p_y_price, k.p_low_price,k.starttime, k.endtime,u.price as userprice, u.createtime as jointime from " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on u.kid=k.id where k.weid=:weid and u.openid=:openid order by k.index_sort asc limit 0," . $this::$PAGE_SIZE;


	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$params = array(':openid' => $openid, ":weid" => $this->weid);
	$list = pdo_fetchall($listSql, $params);
	$countSql = "select count(*) from " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u left join "
		. tablename(DBUtil::$TABLE_XKWKJ) . " k on u.kid=k.id where k.weid=:weid and u.openid=:openid";
	$total = pdo_fetchcolumn($countSql, $params);
	$pager = pagination($total, $pindex, $psize);


	include $this->template('user_wkj');
} else if ($operation == 'delete') {
	$uid = $_GPC['uid'];
	pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("uid" => $uid));
	pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array("uid" => $uid));
	pdo_delete(DBUtil::$TABLE_XKWKJ_USER, array("id" => $uid));
	message('删除成功！', referer(), 'success');
}


