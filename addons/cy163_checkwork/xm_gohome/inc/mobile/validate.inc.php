<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('auth','index');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$staff = '';
	$item = pdo_fetch("select id,openid,staff_name,avatar,flag,company_name,company_flag,company_mge,stop,money,grade_id,grade_money,merchant_state from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and delstate=1");
	$staff_id = $item['id'];
	
	if($item['company_flag'] == 1){
		$item1 = pdo_fetch("select id,openid,avatar,company_name,stop,money,grade_id,grade_money,merchant_state from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and company_flag=1 and company_mge=1 and delstate=1");
		$staff_id = $item1['id'];
	}
		
	if(empty($item)){
		$isCheck = 0;
	}else{
		if($item['flag'] == 1){
			$isCheck = 1;
		}else{
			$isCheck = 2;
		}
		//充值
		$item_r =  pdo_fetch("select sum(money) as count from ".tablename('xm_gohome_rechargelog')." where weid=".$this->weid." and openid='".$openid."' and type!=3");
		if($item_r['count'] == NULL){
			$rcount = 0;
		}else{
			$rcount = number_format($item_r['count'],2);
		}

		//未结算
		$item_m = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and staff_id=".$staff_id);
		$merchant_id = 0;
		if(!empty($item_m['id'])){
			$merchant_id = $item_m['id'];
		}

		$idStr = $this->getStaffId($openid);
		$item_y1 =  pdo_fetch("select sum(getMoney) as yu from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and staff_id in (".$idStr.") and state=0 and type != 1");
		if($item_y1['yu'] == NULL){
			$yucount1 = 0;
		}else{
			$yucount1 = number_format($item_y1['yu'],2);
		}

		$item_y2 =  pdo_fetch("select sum(getMoney) as yu from ".tablename('xm_gohome_takepaylog')." where weid=".$this->weid." and merchant_id=".$merchant_id." and state=0 and type != 1");
		if($item_y2['yu'] == NULL){
			$yucount2 = 0;
		}else{
			$yucount2 = number_format($item_y2['yu'],2);
		}
		$yucount = $yucount1 + $yucount2;
	
		$item_w1 = pdo_fetch("select sum(yumoney) as w_money from ".tablename('xm_gohome_tixianlog')." where weid=".$this->weid." and openid='".$openid."'");
		if(empty($item_w1['w_money'])){
			$weicount1 = 0;
		}else{
			$weicount1 = number_format($item_w1['w_money'],2);
		}

		$item_w2 = pdo_fetch("select sum(yumoney) as w_money from ".tablename('xm_gohome_tixianlog_merchant')." where weid=".$this->weid." and openid='".$openid."'");
		if(empty($item_w2['w_money'])){
			$weicount2 = 0;
		}else{
			$weicount2 = number_format($item_w2['w_money'],2);
		}
		$weicount = $weicount1 + $weicount2;
			
		$ordercount =  pdo_fetchcolumn("select count(*) from ".tablename('xm_gohome_order')." where weid=".$this->weid." and staff_id in (".$idStr.") and state=2");
			
		$daystart = date('Y-m-d',time()).' 00:00:00';
		$dayend = date('Y-m-d',time()).' 23:59:59';
		$item_d =  pdo_fetch("select sum(getMoney) as count from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and staff_id in (".$idStr.") and addtime between '".$daystart."' and '".$dayend."'");
		if($item_d['count'] == ''){
			$daycount = 0;
		}else{
			$daycount = number_format($item_d['count'],2);
		}
	}
		
	include $this->template($this->temp1.'_index');
}

?>