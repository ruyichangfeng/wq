<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/8/6
 * Time: 14:55
 */
/**
 * Created by wanglu on 2017/8/6.
 */
defined('IN_IA') or exit('Access Denied');
$redid = $_GPC['redid'];
$redirect = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $redid);



$where = ' where redid = :redid';
$params = array();
$params[':redid'] = $redid;

if (isset($_GPC['keyword'])) {
    $where .= ' AND `urlname` LIKE :keywords';
    $params[':keywords'] = "%{$_GPC['keyword']}%";
}


$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_URLREDIRECT_URL)  . $where . " ORDER BY createtime  desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_URLREDIRECT_URL)  . $where, $params);
    $pager = pagination($total, $pindex, $psize);

} else if ($operation == 'delete') {
    $uid = $_GPC['uid'];
    pdo_delete(DBUtil::$TABLE_URLREDIRECT_RECORD, array("uid" =>$uid));
    pdo_delete(DBUtil::$TABLE_URLREDIRECT_URL, array("id" =>$uid));
    message('删除成功！', referer(), 'success');
}


include $this->template("web/redirect_url");
