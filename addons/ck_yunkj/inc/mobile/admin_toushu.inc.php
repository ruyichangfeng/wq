<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "admin_common.php";

$urltk = $this->createMobileUrl('admin_toushu');

//修改为已阅读----
$list_wyd = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_toushu')." WHERE weid = '{$_W['uniacid']}' and readt = '0' ORDER BY dateline DESC, id DESC");
if (!empty($list_wyd)) {
	foreach ($list_wyd as &$row) {
		pdo_update('cwgl_user_toushu', array('readt' => 1), array('id' => $row['id'],'weid' => $_W['uniacid']));
	}
}
//-------------

//列表-------------------------
//排序
$ordersc = array($_GPC['ordersc']=>' selected');
if($_GPC['ordersc']){
	$ordersql = "ORDER BY id ".$_GPC['ordersc'];
}else{
	$ordersql = "ORDER BY id DESC";
}

$pindex = max(1, intval($_GPC['page']));
$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
if(!in_array($psize, array(20,50,100))) $psize = 20;
$perpages = array($psize => ' selected');

$where = '';

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_toushu')." WHERE weid = '{$_W['uniacid']}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_toushu')." WHERE weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
include $this->template('admin_toushu');