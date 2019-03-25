<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/12/18
 * Time: 21:45
 */
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;
$where = '';
$params = array();
$params[':weid'] = $this->weid;

if (isset($_GPC['keyword'])) {
	$where .= ' AND a.`title` LIKE :keywords';
	$params[':keywords'] = "%{$_GPC['keyword']}%";
}

$bid = $_GPC['bid'];
if ($bid !='' && $bid != 0) {
	$where .= ' and a.bid =:bid';
	$params[':bid'] = $bid;
}

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT a.*, b.title as btitle FROM " . tablename(DBUtil::$TABLE_COUPON_ACTIVITY) . " a left join ". tablename(DBUtil::$TABLE_COUPON_BUSINESS)." b on a.bid = b.id WHERE a.weid =:weid " . $where . " ORDER BY a.display_sort  asc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);


	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON_ACTIVITY) . " a WHERE a.weid =:weid " . $where, $params);
	$pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
	$aid = $_GPC['aid'];
	$coupon = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " WHERE aid=:aid", array(':aid' => $aid));
	if ($coupon > 0) {
		message("请先删除活动优惠券,再删除此活动!");
	}

	pdo_delete(DBUtil::$TABLE_COUPON_ACTIVITY, array("id" =>$aid));
	message('删除成功！', referer(), 'success');
}

include $this->template("web/acmanage");
