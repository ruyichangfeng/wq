<?php
global $_W,$_GPC;

$uniacid = $_W['uniacid'];
load()->func('tpl');
$id = intval($_GPC['id']);
$rid = intval($_GPC['rid']);

$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_notice')." WHERE uniacid=:uniacid AND id=:id",array(':uniacid'=>$uniacid,':id'=>$id));
pdo_delete('wxz_wzb_notice',array('id'=>$id,'uniacid'=>$uniacid));

message('删除成功',$this->createWebUrl('noticelist',array('rid'=>$rid)),'success');