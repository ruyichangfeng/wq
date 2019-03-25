<?php
global $_W,$_GPC;

$res=pdo_delete('wactivity_matches',array('matchid'=>$_GPC['matchid'],'uniacid'=>$_W['uniacid']));
if($res){
	message("删除活动成功！",$this->createWebUrl('listallmatches', array()),'success');
}else{
	message("删除活动失败！",$this->createWebUrl('listallmatches', array()),'error');
}


