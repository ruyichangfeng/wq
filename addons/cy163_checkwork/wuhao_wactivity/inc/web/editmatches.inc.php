<?php
global $_W,$_GPC;
if(checksubmit('submit')){
	$data['uniacid']=$_W['uniacid'];
	$data['title']=$_GPC['title'];
	$data['time']=$_GPC['time'];
	$data['timebaoming_start']=$_GPC['timebaoming_start'];
	$data['timebaoming_end']=$_GPC['timebaoming_end'];
	$data['timeqiandao_start']=$_GPC['timeqiandao_start'];
	$data['timeqiandao_end']=$_GPC['timeqiandao_end'];
	$data['place']=$_GPC['place'];
	$data['peoplenum']=$_GPC['peoplenum'];
	
	$data['price']=$_GPC['price'];
	$data['content']=$_GPC['content'];
	$data['create_time']=date('y-m-d h:i:s',time());
	$data['img']=$_GPC['img'];
	$data['matchid']=$_GPC['matchid'];
	
	$result=pdo_update('wactivity_matches', $data, array('matchid' => $data['matchid'],'uniacid'=>$data['uniacid']));
	if($result){
		message('更新活动成功',$this->createWebUrl('listallmatches',array()),'success');
	}else{
		message('更新活动失败',$this->createWebUrl('listallmatches',array()),'error');
	}
}else{
	$matches=pdo_fetch("SELECT * FROM ".tablename('wactivity_matches')." WHERE `uniacid`=:uniacid AND `matchid`=:matchid",array(':uniacid'=>$_W['uniacid'],':matchid'=>$_GPC['matchid']));
	include $this->template('editmatches');
}
