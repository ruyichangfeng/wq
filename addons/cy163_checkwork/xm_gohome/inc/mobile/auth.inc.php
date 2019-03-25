<?php
global $_W,$_GPC;

checkauth();
$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$foo = $_GPC['foo'];
$foos = array('index', 'staffAuth', 'staffAuthOk', 'merchantAuth', 'merchantAuthOk');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'staffAuth'){

	include $this->template($this->temp1.'_auth');
}

if($foo == 'staffAuthOk'){
	$mobile = $_GPC['mobile'];
	$pwd = $_GPC['pwd'];
	$sql = "select id,staff_mobile from ".tablename('xm_gohome_staff')." where staff_mobile = '".$mobile."' and pwd='".$pwd."' and delstate=1 and weid=".$this->weid;
	$item = pdo_fetch($sql);
	if(empty($item)){
		$msg = '0';
	}else{
		$data = array(
			'openid'=>$openid,
			'updatetime'=>date('Y-m-d H:i:s')
		);
		$res = pdo_update('xm_gohome_staff', $data, array('id' => $item['id']));
		if($res){
			$msg = '1';	
		}else{
			$msg = '0';
		}
	}
	echo $msg;
}

if($foo == 'merchantAuth'){

	include $this->template($this->temp1.'_merchantauth');
}

if($foo == 'merchantAuthOk'){
	$mobile = $_GPC['mobile'];
	$pwd    = $_GPC['pwd'];
	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and mobile = '".$mobile."' and password='".$pwd."'");
	if(empty($item)){
		$msg = '0';
	}else{
		$data = array(
			'openid'=> $openid,
			'flag'  => 1,
			'updatetime'=>date('Y-m-d H:i:s')
		);
		$res = pdo_update('xm_gohome_merchant', $data, array('id' => $item['id']));
		if($res){
			$msg = '1';	
		}else{
			$msg = '0';
		}
	}
	echo $msg;
}

?>