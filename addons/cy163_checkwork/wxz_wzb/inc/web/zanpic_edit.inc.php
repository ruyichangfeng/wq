<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
$id = intval($_GPC['id']);
$rid = intval($_GPC['rid']);
$gift = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_zanpic')." WHERE uniacid=:uniacid and rid=:rid AND id=:id",array(':uniacid'=>$uniacid,':rid'=>$rid,':id'=>$id));
if(empty($gift)){
	$gift = array(
		'isshow'=>1,
	);
}
if (checksubmit('submit')) {
		
	$data = array();
	$data['uniacid'] = $uniacid;
	$data['pic'] = tomedia($_GPC['pic']);

	$data['rid'] = $_GPC['rid'];
	$data['isshow'] = intval($_GPC['isshow']);

	if(!empty($id)){
		pdo_update('wxz_wzb_zanpic',$data,array('id'=>$id,'uniacid'=>$uniacid,'rid'=>$rid));
		message('编辑成功',$this->createWebUrl('zanpic',array('rid'=>$rid)),'success');
	}else{
		$data['dateline'] = time();
		pdo_insert('wxz_wzb_zanpic',$data);
		message('新增成功',$this->createWebUrl('zanpic',array('rid'=>$rid)),'success');
	}
}
include $this->template('zanpic_edit');