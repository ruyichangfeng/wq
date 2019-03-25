<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$id = $_GPC['id'];
$rid = $_GPC['rid'];
load()->func('tpl');
$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `id` = :id', array(':id' => $id) );
if(!$viewer){
message('用户不存在',$this->createWebUrl('users',array('rid'=>$rid)),'error');
}
if (checksubmit('submit')) {
		
	$data = array();
	$data['amount'] = $viewer['amount']+intval($_GPC['amount']);

	if(!empty($id)){
		pdo_update('wxz_wzb_viewer',$data,array('id'=>$id));
		message('编辑成功',$this->createWebUrl('cz',array('id'=>$id,'rid'=>$rid)),'success');
	}
}
include $this->template('cz');