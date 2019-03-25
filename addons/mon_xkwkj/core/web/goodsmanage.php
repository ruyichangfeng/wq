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

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_GOODS) . " WHERE weid =:weid  ORDER BY createtime asc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->weid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_GOODS) . " WHERE weid =:weid ", array(':weid' => $this->weid));
	$pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
	$gid = $_GPC['gid'];

	$countSql = "select count(*) from " . tablename(DBUtil::$TABLE_XKWKJ) . " where gid=:gid";
	$total = pdo_fetchcolumn($countSql, array(':gid'=> $gid));
	if ($total > 0) {
		message('请先删除相关的活动后再删除商品哦', referer(), 'error');
	}
	pdo_delete(DBUtil::$TABLE_XKWKJ_GOODS, array("id" => $gid));
	message('删除成功！', referer(), 'success');
}

include $this->template("goods_manage");