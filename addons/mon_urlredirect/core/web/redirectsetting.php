<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/7/24
 * Time: 12:28
 */
/**
 * Created by wanglu on 2017/7/24.
 */

defined('IN_IA') or exit('Access Denied');

$where = ' weid=:weid';
$params = array();
$params[':weid'] = $this->weid;

if (isset($_GPC['keyword'])) {
    $where .= ' AND a.`title` LIKE :keywords';
    $params[':keywords'] = "%{$_GPC['keyword']}%";
}


$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_URLREDIRECT) . " where " . $where . " ORDER BY createtime  desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);

    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_URLREDIRECT) . " WHERE " . $where, $params);
    $pager = pagination($total, $pindex, $psize);

} else if ($operation == 'delete') {
    $redid = $_GPC['redid'];
    pdo_delete(DBUtil::$TABLE_URLREDIRECT, array("id" =>$redid));
    pdo_delete(DBUtil::$TABLE_URLREDIRECT_URL, array("redid" =>$redid));
    pdo_delete(DBUtil::$TABLE_URLREDIRECT_RECORD, array("redid" =>$redid));
    message('删除成功！', referer(), 'success');
}

include $this->template("web/redirect");