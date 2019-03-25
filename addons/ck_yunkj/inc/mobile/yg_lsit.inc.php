<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "mn_common.php";

$urltk = $this->createMobileUrl('yg_lsit');

$op = $_GPC['op'];

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

if (!empty($_GPC['type'])) {
	$where .= " AND a.type = ".intval($_GPC['type']);
	//获取分类名称
	$srdb = pdo_get('cwgl_staff_class', array('cid' => intval($_GPC['type']),'weid' => $_W['uniacid']));
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('cwgl_staff_list') . " AS a LEFT JOIN ".tablename('mc_members')." AS b on a.uid=b.uid WHERE a.weid = '{$_W['uniacid']}' and a.uid != '0' {$where}");
if($total){
	$list = pdo_fetchall("SELECT a.*,b.avatar,b.nickname FROM " . tablename('cwgl_staff_list') . " AS a LEFT JOIN ".tablename('mc_members')." AS b on a.uid=b.uid WHERE a.weid = '{$_W['uniacid']}' and a.uid != '0' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
include $this->template('yg_lsit');