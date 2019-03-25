<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'ok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到用户ID");
		exit();
	}

	include $this->template('staff/recharge/s_recharge');
}

if($foo == "ok"){
	$staff_id = intval($_GPC['staff_id']);
	$fee      = floatval($_GPC['money']);
	if($fee <= 0) {
		message('支付错误, 金额小于0');
	}

	$pay = $this->getBase('pay');
	if($pay){
		$body = '充值余额';
		$attach = urlencode("C#".$_W['uniacid']."#".$_W['siteroot']."#".$openid."#".$fee."#".$body."#".$this->generate_code(8)."#".$staff_id);
		$jump   = urlencode($_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=validate&m=xm_gohome");
		$url    = MODULE_URL.'pay/jsapi.php?attach='.$attach.'&jump='.$jump.'&appid='.$this->getBase("appid").'&mch_id='.$this->getBase("mch_id").'&apikey='.$this->getBase("apikey").'&appsecret='.$this->getBase("appsecret");
		header("Location:".$url);
	}else{
		$params = array(
			'tid' => 'C#'.$staff_id.'#'.$openid.'#'.$fee.'#'.$this->generate_code(5),
			'ordersn' => $this->generate_code(8),
			'title' => '充值余额',
			'fee' => $fee,
			'user' => $_W['member']['uid'],
		);
		$this->pay($params);
	}
}

?>