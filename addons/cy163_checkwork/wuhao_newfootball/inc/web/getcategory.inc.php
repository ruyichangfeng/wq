<?php
global $_W,$_GPC;


$data_groups=pdo_fetchall("SELECT * FROM ".tablename('newfootball_groups')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
if(!$data_groups){
	$data['uniacid']=$_W['uniacid'];
	$data['groupname']='all';
	$data['groupmaster']='all';
	$data['groupphone']='';	
	$data['expect_qiandaonum']=1000;
	$data['expect_baomingnum']=1000;		
	$data['create_time']=date('y-m-d h:i:s',time());
	$res=pdo_insert('newfootball_groups',$data,true);
	if($res){	
		$data_groups=array($data);
	}else{		
		message('添加群组失败',$this->createWebUrl('players',array()),'error');
	}	
}

echo json_encode($data_groups);

