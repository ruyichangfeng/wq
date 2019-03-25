<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/12/18
 * Time: 21:45
 */
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$params = array();
$status = $_GPC['status'];

$aid = $_GPC['aid'];
$bid = $_GPC['bid'];
$params[':weid'] = $this -> weid;

$params[':bid'] = $bid;
$params[':aid'] = $aid;

$business = DBUtil::findById(DBUtil::$TABLE_COUPON_BUSINESS, $bid);

if (isset($_GPC['keyword'])) {
	$where .= ' AND c.`coupon_num` LIKE :keywords';
	$params[':keywords'] = "%{$_GPC['keyword']}%";
}

if (!empty($status)) {
	$where .= " and c.status =:status";
	$params[":status"] = $status;
}

 if (isset($aid)) {
	 $where .= " and c.aid =:aid";
	 $params[":aid"] = $aid;
 }

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$sqlNickName = "(select nickname from " . tablename(DBUtil::$TABLE_COUPON_USER) .
		" u where u.id = c.uid ) as nickname";

	$list = pdo_fetchall("SELECT c.*, a.title as atitle, ".$sqlNickName." FROM " . tablename(DBUtil::$TABLE_COUPON) . "
	 c left join ".tablename(DBUtil::$TABLE_COUPON_ACTIVITY)." a on c.aid=a.id WHERE c.bid =:bid" .
		$where . " ORDER BY createtime DESC  LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);


	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " c WHERE weid =:weid " . $where, $params);
	$pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
	$cid = $_GPC['cid'];
	$userCouponCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON_USER_COUPON) . "WHERE cid=:cid", array(':cid' => $cid));
	if ($userCouponCount > 0 ) {
		message("请先删除用户领取的优惠券信息再删除此优惠券");
	}
	pdo_delete(DBUtil::$TABLE_COUPON, array("id" => $cid));
	message('删除成功！', referer(), 'success');
}


include $this->template("web/coupon_manage");
