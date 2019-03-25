<?php
global $_W,$_GPC;

$res=pdo_delete('newfootball_teams',array('teamid'=>$_GPC['teamid'],'uniacid'=>$_W['uniacid']));
if($res){
	message("删除球队成功！",$this->createWebUrl('listallteams', array()),'success');
}else{
	message("删除球队失败！",$this->createWebUrl('listallteams', array()),'error');
}

