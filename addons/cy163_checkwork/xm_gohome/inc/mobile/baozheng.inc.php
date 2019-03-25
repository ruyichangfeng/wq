<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'ok', 'info');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到ID");
		exit();
	}

	$item = pdo_fetch("select id,openid,grade_id,grade_money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_grade')." where weid=".$this->weid." and delstate=1 order by grade_money asc");
		
	include $this->template($this->temp1.'_baozheng');
}

if($foo == 'info'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到ID");
		exit();
	}
	
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_grade')." where weid=".$this->weid." and delstate=1 order by grade_money asc");
		
	include $this->template($this->temp1.'_bzdingji');
}

if($foo == 'ok'){
	$staff_id     = intval($_GPC['staff_id']);
	$grade_id_old = intval($_GPC['grade_id']);
	$grade_money  = $_GPC['grade_money'];
		
	$arr = explode("@", $_GPC['money']);
	$grade_id = $arr[0];
	
	if($grade_id_old == ''){
		$fee = $arr[1];
		$fee = floatval($fee);
	}
		
	if($grade_id_old == $arr[0]){
		message('你没有升级您的保证等级！');
		exit();
	}
		
	if($grade_id_old > $arr[0]){
		message('保证等级不能降低！');
		exit();
	}
		
	if($grade_id_old < $arr[0]){
		$getMoney = $arr[1];
		$fee = $getMoney - $grade_money;
		$fee = floatval($fee);
	}
	
	if($fee <= 0) {
		message('支付错误, 金额小于0');
	}

	$pay = $this->getBase('pay');
	if($pay){
		$body = '保证金充值';
		$attach = urlencode("D#".$_W['uniacid']."#".$_W['siteroot']."#".$openid."#".$fee."#".$body."#".$this->generate_code(8)."#".$staff_id."#".$grade_id);
		$jump   = urlencode($_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=validate&m=xm_gohome");
		$url    = MODULE_URL.'pay/jsapi.php?attach='.$attach.'&jump='.$jump.'&appid='.$this->getBase("appid").'&mch_id='.$this->getBase("mch_id").'&apikey='.$this->getBase("apikey").'&appsecret='.$this->getBase("appsecret");
		header("Location:".$url);
	}else{
		$params = array(
			'tid' => 'D#'.$openid.'#'.$fee.'#'.$staff_id.'#'.$grade_id.'#'.$this->generate_code(5),
			'ordersn' => $this->generate_code(8),
			'title' => '保证金充值',
			'fee' => $fee,
			'user' => $_W['member']['uid'],
		);		
		$this->pay($params);
	}
}


?>