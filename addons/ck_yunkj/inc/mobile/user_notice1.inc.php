<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

//判断是否是注册会员
if($user_show['type']!=1){
	message('抱歉！您还未成为正式会员不能享用该功能！如有需要该服务快去购买吧！', $this->createMobileUrl('user_payofficial'), 'error');
}

$op = $_GPC['op'];
$urltk = $this->createMobileUrl('user_notice1');

//修改为已阅读----
$list_wyd = pdo_fetchall("SELECT * FROM ".tablename('cwgl_notice')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and readt = '0' and type = 'owe' ORDER BY dateline DESC, id DESC");
if (!empty($list_wyd)) {
	foreach ($list_wyd as &$row) {
		pdo_update('cwgl_notice', array('readt' => 1), array('id' => $row['id'],'weid' => $_W['uniacid']));
	}
}//-------------

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_notice', array('id' => $id,'uid' => $_W['member']['uid'],'weid' => $_W['uniacid']));
		message('删除成功', $urltk, 'success');
	}else{
		message('删除失败', $urltk, 'error');
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

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_notice')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and type = 'owe' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_notice')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and type = 'owe' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
include $this->template('user_notice1');