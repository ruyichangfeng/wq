<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
$id = intval($_GPC['id']);
$rid = intval($_GPC['rid']);
$gift = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_gift')." WHERE uniacid=:uniacid and rid=:rid AND id=:id",array(':uniacid'=>$uniacid,':rid'=>$rid,':id'=>$id));
if(empty($gift)){
	$gift = array(
		'isshow'=>1,
	);
}
if (checksubmit('submit')) {
		
	$data = array();
	$data['uniacid'] = $uniacid;
	$data['name'] = $_GPC['name'];
	$data['pic'] = tomedia($_GPC['pic']);
	$data['amount'] = $_GPC['amount'];
	$data['rid'] = $_GPC['rid'];
	$data['isshow'] = intval($_GPC['isshow']);
	$data['sort'] = intval($_GPC['sort']);
	if(!empty($id)){
		pdo_update('wxz_wzb_gift',$data,array('id'=>$id,'uniacid'=>$uniacid,'rid'=>$rid));
		message('编辑成功',$this->createWebUrl('gift_list',array('rid'=>$rid)),'success');
	}else{
		$data['dateline'] = time();
		pdo_insert('wxz_wzb_gift',$data);
		message('新增成功',$this->createWebUrl('gift_list',array('rid'=>$rid)),'success');
	}
}
include $this->template('gift_edit');