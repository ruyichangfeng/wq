<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";

$urltk = $this->createMobileUrl('fw_lsit');

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
	$where .= " AND type = ".intval($_GPC['type']);
	//获取分类名称
	$srdb = pdo_get('cwgl_staff_class', array('cid' => intval($_GPC['type'])));
}

if (!empty($_GPC['keyword'])) {
	$where .= " AND ( (titlename LIKE '%{$_GPC['keyword']}%') OR (jianjie LIKE '%{$_GPC['keyword']}%') OR (content LIKE '%{$_GPC['keyword']}%') )";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_list')."  WHERE weid = '{$_W['uniacid']}' and shelves = '1' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_list')."  WHERE weid = '{$_W['uniacid']}' and shelves = '1' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
include $this->template('fw_lsit');