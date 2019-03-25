<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "admin_common.php";

$did = $_GPC['did'];
$uit = $_GPC['uit'];
$urltk = $this->createMobileUrl('admin_payofficial_fp')."&did=".$did."&uit=".$uit;

$op = $_GPC['op'];

//分类列表-------------
$category = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'yw' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category)) {
	$children = '';
	foreach ($category as $cid => $cate) {
		if (!empty($cate['pid'])) {
			$children[$cate['pid']][$cate['cid']] = array($cate['cid'], $cate['name']);
		}
	}
}

if(checksubmit('listsubmit')){
	
	$srdbt = pdo_get('cwgl_staff_list', array('id' => $_GPC['ygid']));
	$data = array(
		'ygid' => $_GPC['ygid'],
		'yguid' => $srdbt['uid']
	);
		
	if(!empty($_GPC['ygid']) && !empty($_GPC['did']) && !empty($_GPC['uit'])){
		pdo_update('cwgl_user_list', $data, array('id' => $_GPC['uit'],'weid' => $_W['uniacid']));
		pdo_delete('cwgl_user_payofficial', array('id' => $id,'weid' => $_W['uniacid']));
		message('分配成功！', $this->createMobileUrl('admin_payofficial'), 'success');
	}else{
		message('分配失败！');
	}
	
}

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
}

if (!empty($_GPC['id'])) {
	$where .= " AND id = ".intval($_GPC['id']);
}

if (!empty($_GPC['name'])) {
	$where .= " AND name LIKE '%{$_GPC['name']}%'";
}

if (!empty($_GPC['phone'])) {
	$where .= " AND phone LIKE '%{$_GPC['phone']}%' ";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_staff_list')."  WHERE weid = '{$_W['uniacid']}' and uid != '0' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_staff_list')."  WHERE weid = '{$_W['uniacid']}' and uid != '0' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
include $this->template('admin_payofficial_fp');