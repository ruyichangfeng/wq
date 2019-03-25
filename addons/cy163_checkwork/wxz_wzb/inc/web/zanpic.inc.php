<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$rid = $_GPC['rid'];
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$gift = pdo_fetchall("SELECT * FROM ".tablename('wxz_wzb_zanpic')." WHERE uniacid=:uniacid and rid=:rid  ORDER BY dateline DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':uniacid'=>$uniacid,':rid'=>$rid));
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wxz_wzb_zanpic') . " WHERE uniacid=:uniacid and rid=:rid", array(':uniacid'=>$uniacid,':rid'=>$rid));
$pager = pagination($total, $pindex, $psize);
include $this->template('zanpic_list');