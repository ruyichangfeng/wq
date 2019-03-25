<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
session_start();

global $_W, $_GPC;

require "public.php";

$urltk = $this->createMobileUrl('user_login');
$url_sms = $this->createMobileUrl('sms');

//提交处理
if(checksubmit('bdsubmit')){
	
	$urlt = $this->createMobileUrl('index');
	$compname = trim($_GPC['compname']);
	$name = trim($_GPC['name']);
	$phone = trim($_GPC['phone']);
	$mobile_code = trim($_GPC['mobile_code']);
	
	if(empty($compname)){
		message('抱歉！您输入公司名称！', $urltk, 'success');
	}
	
	if(empty($name)){
		message('抱歉！您输入负责人姓名！', $urltk, 'success');
	}
	
	if(empty($phone)){
		message('抱歉！您输入手机号！', $urltk, 'success');
	}
	
	//手机验证码
	if($cwgl_config['sms_open']) {
		if($phone!=$_SESSION['mobile'] or $mobile_code!=$_SESSION['mobile_code'] or empty($phone) or empty($mobile_code)){
			message('手机验证码输入错误！', $urltk, 'success');
		}
	}
	
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'compname' => $compname,
		'name' => $name,
		'phone' => $phone,
		'tguid' => $_COOKIE['tguid']
	);
	
	$result = pdo_insert('cwgl_user_list', $data);
					
	if (!empty($result)) {
	
		//清空------------
		$_SESSION['mobile'] = '';
		$_SESSION['mobile_code'] = '';
		setcookie("tguid", '', mktime());
		//----------------
	
		$idd = pdo_insertid();
		message('注册成功！', $urlt, 'success');
	}else{
		message('注册失败！', $urlt, 'success');
	}
	
}

//随机生成
$_SESSION['send_code'] = random(6,1);
	
include $this->template('user_login');