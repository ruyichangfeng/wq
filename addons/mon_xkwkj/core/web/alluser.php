<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
	$keyword = $_GPC['keyword'];
	$where = '';
	$params = array(
		':weid' => $this->weid
	);

	if (!empty($keyword)) {
		$where .= ' and (nickname like :nickname)';
		$params[':nickname'] = "%$keyword%";

	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER_INFO) . " WHERE weid =:weid " . $where . "  ORDER BY createtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_USER_INFO) . " WHERE weid =:weid  " . $where, $params);
	$pager = pagination($total, $pindex, $psize);

} else if ($operation == 'delete') {
	$uid = $_GPC['uid'];
	pdo_delete(DBUtil::$TABLE_XKWKJ_USER_INFO, array("id" => $uid));
	message('删除成功！', referer(), 'success');
}

include $this->template("all_user_list");