<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/8/15
 * Time: 22:15
 */


defined('IN_IA') or exit('Access Denied');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_CATEGORY) . " WHERE weid =:weid  ORDER BY display_sort asc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->weid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_CATEGORY) . " WHERE weid =:weid ", array(':weid' => $this->weid));
	$pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
	$id = $_GPC['cid'];
	pdo_delete(DBUtil::$TABLE_XKWKJ_CATEGORY, array("id" => $id));
	message('删除成功！', referer(), 'success');
}

include $this->template("category_manage");