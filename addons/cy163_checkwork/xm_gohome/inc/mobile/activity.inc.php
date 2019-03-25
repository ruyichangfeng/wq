<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

checkauth();

$foo = $_GPC['foo'];
$foos = array('index', 'addok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$staff_id    = intval($_GPC['id']);
	
	if(empty($staff_id)){
		message('参数错误：未获取到用户ID');
		exit();
	}

	if(empty($merchant_id)){
		$m_item = pdo_fetch("select id from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and staff_id=".$staff_id);
		if(empty($m_item)){
			message('访问异常：未获取到数据');
			exit();
		}
		$merchant_id = $m_item['id'];
	}

	$item = pdo_fetch("select * from ".tablename('xm_gohome_activity')." where weid=".$this->weid." and merchant_id=".$merchant_id);

	include $this->template('staff/activity/index');
}

if($foo == "addok"){
	$id = intval($_GPC['id']);

	$merchant_id = intval($_GPC['merchant_id']);
	$new_disc	 = $_GPC['new_disc'];
	$man_1		 = $_GPC['man_1'];
	$jian_1		 = $_GPC['jian_1'];
	$man_2		 = $_GPC['man_2'];
	$jian_2		 = $_GPC['jian_2'];
	$man_3		 = $_GPC['man_3'];
	$jian_3		 = $_GPC['jian_3'];
	$disc  	     = $_GPC['disc'];

	$data = array(
		'merchant_id' => $merchant_id,
		'new_disc' => $new_disc,
		'man_1'	   => $man_1,
		'jian_1'   => $jian_1,
		'man_2'	   => $man_2,
		'jian_2'   => $jian_2,
		'man_3'	   => $man_3,
		'jian_3'   => $jian_3,
		'disc'     => $disc
	);
	if(empty($id)){
		$data['weid'] = $this->weid;
		$res = pdo_insert('xm_gohome_activity', $data);
		if(!empty($new_disc)){
			$data_u['new_disc'] = 1;
		}else{
			$data_u['new_disc'] = 0;
		}
		if(!empty($man_1) && !empty($jian_1)){
			$data_u['man1_disc'] = 1;
		}else{
			$data_u['man1_disc'] = 0;
		}
		if(!empty($man_2) && !empty($jian_2)){
			$data_u['man2_disc'] = 1;
		}
		else{
			$data_u['man2_disc'] = 0;
		}
		if(!empty($man_3) && !empty($jian_3)){
			$data_u['man3_disc'] = 1;
		}else{
			$data_u['man3_disc'] = 0;
		}
		if(!empty($disc)){
			$data_u['disc'] = 1;
		}else{
			$data_u['disc'] = 0;
		}
		pdo_update('xm_gohome_merchant', $data_u, array('id'=>$merchant_id));
	}else{
		$res = pdo_update('xm_gohome_activity', $data);
		if(!empty($new_disc)){
			$data_u['new_disc'] = 1;
		}
		if(!empty($man_1) && !empty($jian_1)){
			$data_u['man1_disc'] = 1;
		}else{
			$data_u['man1_disc'] = 0;
		}
		if(!empty($man_2) && !empty($jian_2)){
			$data_u['man2_disc'] = 1;
		}
		else{
			$data_u['man2_disc'] = 0;
		}
		if(!empty($man_3) && !empty($jian_3)){
			$data_u['man3_disc'] = 1;
		}else{
			$data_u['man3_disc'] = 0;
		}
		if(!empty($disc)){
			$data_u['disc'] = 1;
		}else{
			$data_u['disc'] = 0;
		}
		pdo_update('xm_gohome_merchant', $data_u, array('id'=>$merchant_id));
	}
	
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}
?>