<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$op = $_GPC['op'];

//判断是否是注册会员
if($user_show['type']!=1){
	message('抱歉！您还未成为正式会员不能享用该功能！如有需要该服务快去购买吧！', $this->createMobileUrl('user_payofficial'), 'error');
}

$urltk = $this->createMobileUrl('user_paycost');

if($op == "view"){
	
	//查看订单详情
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_paycost', array('id' => $id,'weid' => $_W['uniacid']));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	if($srdb['status']==1){
		$order_inom = pdo_get('cwgl_order_inom', array('weid' => $_W['uniacid'],'did' => $id,'type' => 'owe'));
	}
	
	include $this->template('user_paycost_view');

}else{

	//列表-------------------------
	//排序
	$ordersc = array($_GPC['ordersc']=>' selected');
	if($_GPC['ordersc']){
		$ordersql = "ORDER BY a.id ".$_GPC['ordersc'];
	}else{
		$ordersql = "ORDER BY a.id DESC";
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
	if(!in_array($psize, array(20,50,100))) $psize = 20;
	$perpages = array($psize => ' selected');
	
	$where = '';
	
	if ($_GPC['type']==1) {
		$where .= " and a.status = '1'";
	}else{
		$where .= " and a.status = '0'";
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_paycost')." AS a LEFT JOIN ".tablename('cwgl_order_inom')." AS b ON a.id=b.did WHERE a.weid = '{$_W['uniacid']}' and a.uid = '{$_W['member']['uid']}' and b.type='owe' {$where}" );
	if($total){
		$list = pdo_fetchall("SELECT a.id,a.titlename,a.type,a.dateline,b.paymoney FROM ".tablename('cwgl_user_paycost')." AS a LEFT JOIN ".tablename('cwgl_order_inom')." AS b ON a.id=b.did WHERE a.weid = '{$_W['uniacid']}' and a.uid = '{$_W['member']['uid']}' and b.type='owe' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
	include $this->template('user_paycost');
	
}