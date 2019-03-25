<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/2/16
 * Time: 21:36
 */

defined('IN_IA') or exit('Access Denied');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$jid = $_GPC['jid'];
if ($operation == 'display') {
	$where = 's.jid =:jid';
	$params[':jid'] = $jid;

	$uid = $_GPC['uid'];
	if ($uid !='' && $uid != 0) {
		$where .= ' and s.uid =:uid';
		$params[':uid'] = $uid;
	}

	$share_time_get = $_GPC['share_time'];// 结构为: array('start'=>?, 'end'=>?)
	$starttime = empty($share_time_get['start']) ? strtotime('-1 month') : strtotime($share_time_get['start']);
	$endtime   = empty($share_time_get['end'])   ? TIMESTAMP : strtotime($share_time_get['end']);

	if (!empty($share_time_get)) {
		$where .= ' and createtime >=:starttime and createtime <=:endtime';
		$params[':starttime'] = $starttime;
		$params[':endtime'] = $endtime;

		$share_time =  array(
			'start' => date("Y-m-d H:i", $starttime),
			'end'   => date("Y-m-d H:i", $endtime),
		);

	}
	$psize = 20;
	$sqlNickname = "(select nickname from ".tablename(DBUtil::$TABLE_XKJT_USER)." u1 where u1.id = s.uid) as nickname";
	$sqlheadImageurl = "(select headimgurl from ".tablename(DBUtil::$TABLE_XKJT_USER)." u2 where u2.id = s.uid) as headimgurl";

	$pindex = max(1, intval($_GPC['page']));
	$list = pdo_fetchall("SELECT s.*,".$sqlNickname.", ".$sqlheadImageurl." FROM "
		. tablename(DBUtil::$TABLE_XKJT_SHARE) .
		"  s WHERE " . $where . "  ORDER BY createtime DESC limit " . ($pindex - 1) * $psize . ',' . $psize, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKJT_SHARE) . " s  WHERE  " . $where, $params);
	$pager = pagination($total, $pindex, $psize);
} else if ($operation == 'delete') {
	$id = $_GPC['sid'];
	pdo_delete(DBUtil::$TABLE_XKJT_SHARE, array("id" => $id));
	message('删除成功！', referer(), 'success');
}

include $this->template("web/share_list");