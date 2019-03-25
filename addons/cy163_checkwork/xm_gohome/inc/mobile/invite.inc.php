<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'inviteok', 'attend', 'attendok', 'myinvite', 'getmyinvite', 'myattend', 'getmyattend', 'jiechuok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}
	$item = pdo_fetch("select id,openid,staff_mobile from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and  delstate=1 and id=".$id);
	$mobile = $item['staff_mobile'];
	
	$item_i = pdo_fetch("select * from ".tablename('xm_gohome_invite')." where weid=".$this->weid." and openid='".$item['openid']."'");
		
	include $this->template('staff/invite/s_invite');
}

if($foo == 'inviteok'){
	$id = $_GPC['id'];
	$openid = $_GPC['openid'];
	$mobile = $_GPC['mobile'];
			
	$data['openid'] = $openid;
	$data['mobile'] = $mobile;
	$data['invite'] = $_GPC['invite'];
	$data['addtime'] = date('Y-m-d H:i:s');
	if(empty($id)){
		$data['weid'] = $this->weid;
		$res = pdo_insert('xm_gohome_invite', $data);
	}else{
		$res = pdo_update('xm_gohome_invite', $data, array('id'=>$id));
	}
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == 'attend'){

	include $this->template('staff/invite/s_attend');
}

if($foo == 'attendok'){
	$openid = $_W['fans']['from_user'];
	$mobile = $_GPC['mobile'];
	$invite = $_GPC['invite'];
		
	$check = pdo_fetch("select id,openid from ".tablename('xm_gohome_invite')." where weid=".$this->weid." and mobile='".$mobile."' and invite='".$invite."'");
	if(empty($check['id'])){
		echo 0;
	}else{
		if($check['openid'] == $openid){
			echo 4;
		}else{
			$check1 = pdo_fetch("select id from ".tablename('xm_gohome_attend')." where weid=".$this->weid." and yopenid='".$check['openid']."' and jopenid='".$openid."'");
			if(empty($check1)){
				$data['weid'] = $this->weid;
				$data['yopenid'] = $check['openid'];
				$data['jopenid'] = $openid;
				$data['state'] = 1;
				$data['invite'] = $invite;
				$data['addtime'] = date('Y-m-d H:i:s');
				$res = pdo_insert('xm_gohome_attend', $data);
				if($res){
					echo 1;
				}else{
					echo 2;
				}
			}else{
				echo 3;
			}
		}
	}
}

if($foo == 'myinvite'){

	include $this->template('staff/invite/s_myinvite');
}

if($foo == 'getmyinvite'){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_attend')." where weid=".$this->weid." and yopenid='".$openid."' order by addtime desc limit ".$startCount.",".$pageSize."");
		
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$item = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$value['jopenid']."'");
			$staff_id = $item['id'];
			if($this->getStaffInfo($staff_id,'avatar') == ''){
					$avatar = MODULE_URL.'/template/mobile/images/bb.jpg';
				}else{
					if(substr($this->getStaffInfo($staff_id,'avatar'),0,6) == 'images'){
						$avatar = $_W['attachurl'].$this->getStaffInfo($staff_id,'avatar');
					}else{
						$avatar = $_W['attachurl'].'gohome/avatar/'.$this->getStaffInfo($staff_id,'avatar');
					}
				}
				$pro = $this->getStaffPro($staff_id);
				$staff_name = $this->getStaffInfo($staff_id,'staff_name');
				$invite = $value['invite'];
					
				$idStr .= '{"id":"'.$id.'","avatar":"'.$avatar.'","pro":"'.$pro.'","staff_name":"'.$staff_name.'","invite":"'.$invite.'"},';
			}
			$idStr = rtrim($idStr,',');
			$end = ']';
			$json = $start.$idStr.$end;
			
			echo $json;
		}
}

if($foo == 'myattend'){

	include $this->template('staff/invite/s_myattend');
}

if($foo == 'getmyattend'){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_attend')." where weid=".$this->weid." and jopenid='".$openid."' order by addtime desc limit ".$startCount.",".$pageSize."");
		
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$item = pdo_fetch("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$value['jopenid']."'");
			$staff_id = $item['id'];
			if($this->getStaffInfo($staff_id,'avatar') == ''){
				$avatar = MODULE_URL.'/template/mobile/images/bb.jpg';
			}else{
				if(substr($this->getStaffInfo($staff_id,'avatar'),0,6) == 'images'){
					$avatar = $_W['attachurl'].$this->getStaffInfo($staff_id,'avatar');
				}else{
					$avatar = $_W['attachurl'].'gohome/avatar/'.$this->getStaffInfo($staff_id,'avatar');
				}
			}
			$pro = $this->getStaffPro($staff_id);
			$staff_name = $this->getStaffInfo($staff_id,'staff_name');
			$invite = $value['invite'];
			$addtime = substr($value['addtime'],5,11);
					
			$idStr .= '{"id":"'.$id.'","avatar":"'.$avatar.'","pro":"'.$pro.'","staff_name":"'.$staff_name.'","invite":"'.$invite.'","addtime":"'.$addtime.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
			
		echo $json;
	}
}

if($foo == 'jiechuok'){
	$id = intval($_GPC['id']);
	$res = pdo_delete('xm_gohome_attend', array('id'=>$id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

?>