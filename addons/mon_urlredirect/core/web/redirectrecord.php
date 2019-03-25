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
$where = '  r.weid =:weid';
$params = array();
$params[':weid'] = $this->weid;

if (isset($_GPC['redid']) && !empty($_GPC['redid'])) {
    $redid = $_GPC['redid'];

    $red = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $redid);

    $where .= ' AND r.redid =:redid';
    $params[':redid'] = $_GPC['redid'];
}

if (isset($_GPC['uid']) && !empty($_GPC['uid'])) {
    $uid = $_GPC['uid'];

    $red_url = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT_URL, $uid);


    $where .= ' AND r.redid =:redid';
    $params[':uid'] = $_GPC['uid'];
}


$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;




    $iv_time_get = $_GPC['iv_time'];// 结构为: array('start'=>?, 'end'=>?)
    $starttime = empty($iv_time_get['start']) ? strtotime('-1 month') : strtotime($iv_time_get['start']);
    $endtime   = empty($iv_time_get['end'])   ? TIMESTAMP : strtotime($iv_time_get['end']);

    if (!empty($iv_time_get)) {
        $where .= ' and r.createtime >=:starttime and r.createtime <=:endtime';
        $params[':starttime'] = $starttime;
        $params[':endtime'] = $endtime;

        $iv_time =  array(
            'start' => date("Y-m-d H:i", $starttime),
            'end'   => date("Y-m-d H:i", $endtime),
        );

    }


    $rname = "(select rname from ".tablename(DBUtil::$TABLE_URLREDIRECT)." red where red.id = r.redid) as rname";
    $urlnamne = "(select urlname from ".tablename(DBUtil::$TABLE_URLREDIRECT_URL)." u where u.id = r.uid) as urlname";
    $url = "(select url from ".tablename(DBUtil::$TABLE_URLREDIRECT_URL)." u2 where u2.id = r.uid) as url";
    $pindex = max(1, intval($_GPC['page']));

    $sql = "SELECT r.*,".$rname.", ".$url.",".$urlnamne." FROM "
        . tablename(DBUtil::$TABLE_URLREDIRECT_RECORD) . "  r WHERE " . $where .
        "  ORDER BY r.createtime DESC limit " . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_URLREDIRECT_RECORD) . " r  WHERE  " . $where, $params);
    $pager = pagination($total, $pindex, $psize);

} else if ($operation == 'delete') {
    $rid = $_GPC['rid'];
    pdo_delete(DBUtil::$TABLE_URLREDIRECT_RECORD, array("id" =>$rid));
    message('删除成功！', referer(), 'success');
}

include $this->template("web/record_list");
