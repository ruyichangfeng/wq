<?php

global $_W,$_GPC;
$rid = intval($_GPC['rid']);
$id = intval($_GPC['id']);
$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_pic') . ' WHERE `uniacid` = :uniacid and id=:id', array(':uniacid' => $_W['uniacid'],':id' => $id));
if(isset($_GPC['item']) && $_GPC['item'] == 'ajax' && $_GPC['key'] == 'setting'){
	$data=array(
		'content'=>$_POST['content'],
		'title'=>$_GPC['title']
	);
	pdo_update('wxz_wzb_live_pic',$data, array('id' => $id));
	message('编辑成功', $this->createWebUrl("livePic",array('rid'=>$rid)), 'success');
}
include $this->template('ds_edit');