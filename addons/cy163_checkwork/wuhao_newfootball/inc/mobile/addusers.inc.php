<?php
global $_W,$_GPC;
if(checksubmit('addusers')){	
	$data['openid']=$_W['fans']['openid'];
    $data['nickname']=$_W['fans']['nickname'];
    $data['img']=$_W['fans']['headimgurl'];
    $data['name']=$_GPC['name'];
    $data['phone']=$_GPC['phone'];
    $data['groupname']=$_GPC['groupname'];
    $data['create_time']=date('Y-m-d H:i:s',time());
    $data['uniacid']=$_W['uniacid'];
    $data['joinnum']=0;
    $data['totalnum']=0;
    $data['chuqinratio']=0;

    $data_matches=pdo_fetchall("SELECT * FROM ".tablename('newfootball_matches')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
    foreach($data_matches as $key => $value){			
		if(strtotime($value['time1'])>time()){
			$data['totalnum']+=1;
		}
	}

    $res=pdo_insert('newfootball_players',$data);
    
	if($res){
		//添加成功
		message('添加球员成功，请重新报名',$this->createMobileUrl('baoming', array()),'success');
	}else{
		message('添加球员失败，请重新报名',$this->createMobileUrl('baoming', array()),'error');
	}
}else{
	include $this->template('addusers');
}
