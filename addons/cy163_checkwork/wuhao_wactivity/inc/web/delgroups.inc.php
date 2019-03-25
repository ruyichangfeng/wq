<?php
global $_W,$_GPC;

$res=pdo_delete('wactivity_groups',array('groupid'=>$_GPC['groupid'],'uniacid'=>$_W['uniacid']));
if($res){
	message("删除群组成功！",$this->createWebUrl('listallgroups', array()),'success');
}else{
	message("删除群组失败！",$this->createWebUrl('listallgroups', array()),'error');
}

