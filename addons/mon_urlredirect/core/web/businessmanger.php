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
	$where .= ' AND `title` LIKE :keywords';
	$params[':keywords'] = "%{$_GPC['keyword']}%";
}
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_COUPON_BUSINESS) . " WHERE weid =:weid " . $where . " ORDER BY createtime DESC, display_order asc  LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON_BUSINESS) . " WHERE weid =:weid " . $where, $params);
	$pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
	$bid = $_GPC['bid'];
	$couponCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " WHERE bid=:bid", array(':bid' => $bid));
	if ($couponCount > 0 ) {
		message("请先删除优惠券再删除此商家信息");
	}
	pdo_delete(DBUtil::$TABLE_COUPON_BUSINESS, array("id" =>$id));
	message('删除成功！', referer(), 'success');
}

include $this->template("web/business_manage");
