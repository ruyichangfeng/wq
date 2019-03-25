<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "staff_common.php";

$newtimes =  mktime();
$urltk = $this->createMobileUrl('staff_userlist');

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

if (!empty($_GPC['keyword'])) {
	$where .= " AND ( (compname LIKE '%{$_GPC['keyword']}%') OR (name LIKE '%{$_GPC['keyword']}%') OR (phone LIKE '%{$_GPC['keyword']}%') )";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_list')." WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_list')." WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
include $this->template('staff_userlist');