<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'checktixian', 'ok', 'list', 'merchantlist');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){
	$id = intval($_GPC['id']);

	$xianzhi = $this->getBase('xianzhi');
		
	include $this->template('staff/tixian/s_tixian');
}

if($foo == "checktixian"){
	$openid   = $_W['fans']['from_user'];
	$staff_id = intval($_GPC['staff_id']);
	$type     = intval($_GPC['type']);
	$start    = $_GPC['start'];
	$end      = $_GPC['end'];
	
	if($type == 1){
		$idStr = $this->getStaffId($openid);
		$item =  pdo_fetch("select sum(getMoney) as yu from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and type!=1 and staff_id in (".$idStr.") and addtime between '".$start."' and '".$end."' and state=0");
		if($item['yu'] == NULL){
			$yucount = 0;
		}else{
			$yucount = $item['yu'];
		}
		echo $yucount;
	}else{
		$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and staff_id=".$staff_id);
		if(empty($item)){
			echo 0;
		}else{
			$y_item =  pdo_fetch("select sum(getmoney) as yu from ".tablename('xm_gohome_takepaylog')." where weid=".$this->weid." and merchant_id=".$item['id']." and addtime between '".$start."' and '".$end."' and state=0");
			if($y_item['yu'] == NULL){
				$yucount = 0;
			}else{
				$yucount = $y_item['yu'];
			}
			echo $yucount;
		}
	}
}

if($foo == "ok"){
	$type     = intval($_GPC['type']);
	$staff_id = intval($_GPC['staff_id']);
	$money    = $_GPC['money'];
	$openid   = $_GPC['openid'];
	$start    = $_GPC['start'];
	$end      = $_GPC['end'];

	if($money <= 0){
		echo 0;
	}
	if($type == 1){
		$data['weid']    = $this->weid;
		$data['openid']  = $openid;
		$data['money']   = $money;
		$data['start']   = $start;
		$data['end']     = $end;
		$data['yumoney'] = $money;
		$data['famoney'] = 0;
		$data['staff_id'] = $staff_id;
		$res = pdo_insert('xm_gohome_tixianlog', $data);
		if($res){
			pdo_query("update ".tablename('xm_gohome_staff')." set money=money-".$money." where weid=".$this->weid." and id=".$staff_id);
				
			$idStr = $this->getStaffId($openid);
			pdo_query("update ".tablename('xm_gohome_paylog')." set state=1 where weid=".$this->weid." and staff_id in (".$idStr.") and type!=1 and addtime between '".$start."' and '".$end."'");
			echo 1;
		}else{
			echo 0;
		}
	}else{
		$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and staff_id=".$staff_id);
		$data['weid']    = $this->weid;
		$data['openid']  = $openid;
		$data['money']   = $money;
		$data['start']   = $start;
		$data['end']     = $end;
		$data['yumoney'] = $money;
		$data['famoney'] = 0;
		$data['merchant_id'] = $item['id'];
		$res = pdo_insert('xm_gohome_tixianlog_merchant', $data);
		if($res){
			pdo_query("update ".tablename('xm_gohome_staff')." set money=money-".$money." where weid=".$this->weid." and id=".$staff_id);
				
			pdo_query("update ".tablename('xm_gohome_takepaylog')." set state=1 where weid=".$this->weid." and merchant_id=".$item['id']." and addtime between '".$start."' and '".$end."'");
			echo 1;
		}else{
			echo 0;
		}
	}
}

if($foo == "list"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_tixianlog')." where weid=".$this->weid." and staff_id=".$id." order by addtime desc limit 0,300");
			
	include $this->template('staff/tixian/s_tixianlist');
}

if($foo == "merchantlist"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到工人ID");
		exit();
	}
	$item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and staff_id=".$id);
	if(empty($item)){
		message("未查询到商铺数据！");
		return false;
	}

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_tixianlog_merchant')." where weid=".$this->weid." and merchant_id=".$item['id']." order by addtime desc limit 0,300");
			
	include $this->template('staff/tixian/s_tixianlist_merchant');
}

?>