<?php
global $_W,$_GPC;
session_start();

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'rechargeok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	load()->model('mc');
	$item = mc_credit_fetch($_W['member']['uid'],array('credit1','credit2','credit3'));
		
	$page = 'my';
		
	include $this->template($this->temp.'_recharge');
}

if($foo == "rechargeok"){
	$fee = floatval($_GPC['money']);
	if($fee <= 0) {
		message('支付错误, 金额小于0');
	}
	
	$pay = $this->getBase('pay');
	if($pay){
		$body  = '系统充值余额';
		$attach = urlencode("A#".$_W['uniacid']."#".$_W['siteroot']."#".$openid."#".$fee."#".$body."#".$this->generate_code(8)."#".$_W['member']['uid']);
		$jump   = urlencode($_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=myinfo&m=xm_gohome");
		$redurl = urlencode(MODULE_URL.'pay/');

		$url    = MODULE_URL.'pay/jsapi.php?attach='.$attach.'&jump='.$jump.'&redurl='.$redurl.'&appid='.$this->getBase("appid").'&mch_id='.$this->getBase("mch_id").'&apikey='.$this->getBase("apikey").'&appsecret='.$this->getBase("appsecret");
		//echo $url;
		header("Location:".$url);
	}else{
		$params = array(
			'tid' => 'A#'.$_W['member']['uid'].'#'.$openid.'#'.$fee.'#'.$this->generate_code(5),     
			'ordersn' => $this->generate_code(8),  
			'title' => '系统充值余额',          
			'fee' => $fee,   
			'user' => $_W['member']['uid'],  
		);
		//调用pay方法
		$this->pay($params);
	}
}

?>