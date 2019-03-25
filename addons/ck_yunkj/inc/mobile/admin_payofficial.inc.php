<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "admin_common.php";

$newtimes =  mktime();
$urltk = $this->createMobileUrl('admin_payofficial');

$op = $_GPC['op'];

//列表-------------------------
//排序
$ordersc = array($_GPC['ordersc']=>' selected');
if($_GPC['ordersc']){
	$ordersql = "ORDER BY b.id ".$_GPC['ordersc'];
}else{
	$ordersql = "ORDER BY b.id DESC";
}

$pindex = max(1, intval($_GPC['page']));
$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
if(!in_array($psize, array(20,50,100))) $psize = 20;
$perpages = array($psize => ' selected');

$where = '';

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_list')." AS a LEFT JOIN ".tablename('cwgl_user_payofficial')." AS b on a.uid=b.uid WHERE b.weid = '{$_W['uniacid']}' and b.status = '1' and a.yguid = '0' {$where}");
if($total){
	$list = pdo_fetchall("SELECT a.compname,a.id AS uit,b.* FROM ".tablename('cwgl_user_list')." AS a LEFT JOIN ".tablename('cwgl_user_payofficial')." AS b on a.uid=b.uid WHERE b.weid = '{$_W['uniacid']}' and b.status = '1' and a.yguid = '0' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
include $this->template('admin_payofficial');