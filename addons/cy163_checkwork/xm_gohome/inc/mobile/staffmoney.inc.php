<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'merchantindex', 'chu', 'merchantchu', 'log');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		$id = $this->getStaffForId($openid);
	}
	$item = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
	if($item['company_flag'] == 1){
		$s_item = pdo_fetchall("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and openid='".$item['openid']."' and company_mge=0");
		$idStr = '';
		foreach($s_item as $value){
			$idStr .= $value['id'].',';
		}
		$idStr = rtrim($idStr,',');
		if(empty($idStr)){
			$idStr = 0;
		}
		$list = pdo_fetchall("select * from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and staff_id in(".$idStr.") order by addtime desc limit 0,300");
	}else{
		$list = pdo_fetchall("select * from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and staff_id=".$id." order by addtime desc limit 0,300");
	}
		
	include $this->template('staff/money/s_money');
}

if($foo == "merchantindex"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		$id = $this->getStaffForId($openid);
	}
	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and staff_id=".$id);
	if(empty($item)){
		message("未查询到商铺数据信息！");
		exit();
	}
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takepaylog')." where weid=".$this->weid." and merchant_id=".$item['id']." order by id desc limit 0,300");

	include $this->template('staff/money/s_money_merchant');
}

if($foo == "chu"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		$id = $this->getStaffForId($openid);
	}

	$item = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
	if($item['company_flag'] == 1){
		$s_item = pdo_fetchall("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and openid='".$item['openid']."' and company_mge=0");
		$idStr = '';
		foreach($s_item as $value){
			$idStr .= $value['id'].',';
		}
		$idStr = rtrim($idStr,',');
		if(empty($idStr)){
			$idStr = 0;
		}
		$list = pdo_fetchall("select * from ".tablename('xm_gohome_companygetmoney')." where weid=".$this->weid." and staff_id in (".$idStr.") order by addtime desc limit 0,300");
	}else{
		$list = pdo_fetchall("select * from ".tablename('xm_gohome_companygetmoney')." where weid=".$this->weid." and staff_id=".$id." order by addtime desc limit 0,300");
	}
		
	include $this->template('staff/money/s_money1');
}

if($foo == "merchantchu"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		$id = $this->getStaffForId($openid);
	}
	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and staff_id=".$id);
	if(empty($item)){
		message("未查询到商铺数据信息！");
		exit();
	}
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_companygetmoney_merchant')." where weid=".$this->weid." and merchant_id=".$item['id']." order by addtime desc limit 0,300");

	include $this->template('staff/money/s_money1_merchant');
}

if($foo == "log"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		$id = $this->getStaffForId($openid);
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_rechargelog')." where weid=".$this->weid." and staff_id=".$id." order by addtime desc limit 0,100");
		
	include $this->template('staff/money/s_money2');
}

?>