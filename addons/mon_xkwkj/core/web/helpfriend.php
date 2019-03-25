<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$kid = $_GPC['kid'];


$keyword = $_GPC['keywords'];
$where = '';
$params = array(
	':kid' => $kid

);


if (!empty($keyword)) {
	$where .= ' and f.nickname like :nickname';
	$params[':nickname'] = "%$keyword%";
}

if (!empty($_GPC['uid'])) {
	$where .= ' and f.uid=:uid';
	$params[':uid'] = $_GPC['uid'];
}

if ($operation == 'display') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("select * from " . tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " f where f.kid=:kid " . $where . " order by f.createtime desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " f where f.kid=:kid  " . $where, $params);
	$pager = pagination($total, $pindex, $psize);

} elseif ($operation == 'delete') {
	$id = $_GPC['id'];
	pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array('id' => $id));
	message('删除成功！', referer(), 'success');
}
include $this->template('kj_firends');