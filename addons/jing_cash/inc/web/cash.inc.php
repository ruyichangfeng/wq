<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
$config = $this->module['config'];
load()->model('mc');
$pindex = max(1, intval($_GPC['page']));
$psize = 20;
$list = pdo_fetchall("SELECT * FROM ".tablename('jing_cash_cash')." WHERE uniacid = '{$_W['uniacid']}' ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize);
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('jing_cash_cash') . " WHERE uniacid = '{$_W['uniacid']}'");
$pager = pagination($total, $pindex, $psize);
include $this->template('cash');
?>