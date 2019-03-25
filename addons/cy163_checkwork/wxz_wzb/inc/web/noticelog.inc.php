<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$tid = $_GPC['id'];
$rid = $_GPC['rid'];
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$banner = pdo_fetchall("SELECT * FROM ".tablename('wxz_wzb_notice_logs')." WHERE tid=:tid ORDER BY dateline DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':tid'=>$tid));
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wxz_wzb_notice_logs') . " WHERE tid=:tid", array(':tid'=>$tid));
$pager = pagination($total, $pindex, $psize);
include $this->template('notice_log');