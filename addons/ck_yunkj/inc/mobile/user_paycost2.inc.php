<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$op = $_GPC['op'];

if($user_show['payfees']>0){
	$paymoney = $user_show['payfees'];
}else{
	$paymoney = $cwgl_config['month_money'];
}

$userdbt = pdo_get('cwgl_user_paycost', array('uid' => $_W['member']['uid'],'weid' => $_W['uniacid'],'status' => 0,'renewal' => 1));
if (empty($userdbt)) {

	//添加
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'type' => 1,
		'renewal' => 1,
		'titlename' => '会员续交服务费',
		'message' => '会员续交服务费',
		'paymoney' => $paymoney,
		'dateline' => mktime()
	);
	pdo_insert('cwgl_user_paycost', $data);
	$id = pdo_insertid();
	
	$srdb = pdo_get('cwgl_user_paycost', array('uid' => $_W['member']['uid'],'weid' => $_W['uniacid'],'id' => $id));
}else{
	
	//修改
	$data = array(
		'paymoney' => $paymoney,
		'dateline' => mktime()
	);
	pdo_update('cwgl_user_paycost', $data, array('id' => $userdbt['id'],'weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
	$srdb = pdo_get('cwgl_user_paycost', array('uid' => $_W['member']['uid'],'weid' => $_W['uniacid'],'id' => $userdbt['id']));
}


include $this->template('user_paycost2');