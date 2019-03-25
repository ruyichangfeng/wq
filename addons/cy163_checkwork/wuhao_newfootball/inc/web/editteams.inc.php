<?php
global $_W,$_GPC;
if(checksubmit('submit')){
	$data['uniacid']=$_W['uniacid'];
	$data['teamid']=$_GPC['teamid'];
	$data['teamname']=$_GPC['teamname'];
	$data['logo']=$_GPC['logo'];
	$data['teamplace']=$_GPC['teamplace'];
	$data['master']=$_GPC['master'];	
	$data['create_time']=date('y-m-d h:i:s',time());
	
	
	$result=pdo_update('newfootball_teams', $data, array('teamid' => $data['teamid'],'uniacid'=>$data['uniacid']));
	if($result){
		message('更新球队成功',$this->createWebUrl('listallteams',array()),'success');
	}else{
		message('更新球队失败',$this->createWebUrl('listallteams',array()),'error');
	}
}else{
	$teams=pdo_fetch("SELECT * FROM ".tablename('newfootball_teams')." WHERE `uniacid`=:uniacid AND `teamid`=:teamid",array(':uniacid'=>$_W['uniacid'],':teamid'=>$_GPC['teamid']));

	include $this->template('editteams');
}
