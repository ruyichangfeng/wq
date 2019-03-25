<?php
global $_W,$_GPC;

$res=pdo_delete('newfootball_players',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
if($res){
	message("删除球员成功！",$this->createWebUrl('listallplayers', array()),'success');
}else{
	message("删除球员失败！",$this->createWebUrl('listallplayers', array()),'error');
}
