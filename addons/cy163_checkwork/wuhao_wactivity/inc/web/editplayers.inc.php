<?php
global $_W,$_GPC;
if(checksubmit('submit')){
	$data['uniacid']=$_W['uniacid'];
	$data['name']=$_GPC['name'];
	$data['phone']=$_GPC['phone'];
	$data['email']=$_GPC['email'];
	$data['clothesno']=$_GPC['clothesno'];
	$data['clothesnum']=$_GPC['clothesnum'];
	$data['position']=$_GPC['position'];
	$data['intime']=$_GPC['intime'];
	$data['birthday']=$_GPC['birthday'];
	$data['height']=$_GPC['height'];
	$data['weight']=$_GPC['weight'];
	$data['level']=$_GPC['level'];
	$data['idcard']=$_GPC['idcard'];
	$data['address']=$_GPC['address'];
	$data['weixin']=$_GPC['weixin'];
	$data['qq']=$_GPC['qq'];
	$data['account']=$_GPC['account'];
	$data['car']=$_GPC['car'];
	$data['openid']=$_GPC['openid'];
	//$data['img']=$_GPC['img'];
	$data['nickname']=$_GPC['nickname'];	
	$data['id']=$_GPC['id'];
	$data['groupname']=$_GPC['groupname'];	
	$data['create_time']=date('y-m-d h:i:s',time());

	
	$result=pdo_update('wactivity_players', $data, array('id' => $data['id'],'uniacid'=>$data['uniacid']));
	if($result){
		message('更新会员成功',$this->createWebUrl('listallplayers',array()),'success');
	}else{
		message('更新会员失败',$this->createWebUrl('listallplayers',array()),'error');
	}
}else{
	$players=pdo_fetch("SELECT * FROM ".tablename('wactivity_players')." WHERE `uniacid`=:uniacid AND `id`=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));

	include $this->template('editplayers');
}
