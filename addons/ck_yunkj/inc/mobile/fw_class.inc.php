<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('fw_class');

//列表--------------------
$pindex = max(1, intval($_GPC['page']));
$psize = 12;

$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and pid=0 and type = 'fw'");
if($total){
	$list = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and pid=0 and type = 'fw' ORDER BY listorder ASC, cid DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
}
	
include $this->template('fw_class');