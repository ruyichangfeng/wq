<?php
global $_W,$_GPC;

$res=pdo_delete('newfootball_matches',array('matchid'=>$_GPC['matchid'],'uniacid'=>$_W['uniacid']));
if($res){
	message("删除比赛成功！",$this->createWebUrl('listallmatches', array()),'success');
}else{
	message("删除比赛失败！",$this->createWebUrl('listallmatches', array()),'error');
}


