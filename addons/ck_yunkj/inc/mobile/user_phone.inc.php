<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
session_start();
global $_W, $_GPC;

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_phone');
$url_sms = $this->createMobileUrl('sms');

//提交处理
if(checksubmit('save_submit')){

	$phone = intval($_GPC['phone']);
	$mobile_code = trim($_GPC['mobile_code']);
	
	//手机验证码
	if($cwgl_config['sms_open']) {
		if($phone!=$_SESSION['mobile'] or $mobile_code!=$_SESSION['mobile_code'] or empty($phone) or empty($mobile_code)){
			message('手机验证码输入错误！', $urltk, 'success');
		}
	}
	
	$data = array('phone' => $_GPC['phone']);
	
	pdo_update('cwgl_user_list', $data, array('id' => $user_show['id'],'weid' => $_W['uniacid']));
	
	//清空------------
	$_SESSION['mobile'] = '';
	$_SESSION['mobile_code'] = '';
	//----------------

	message('修改成功！', $this->createMobileUrl('user_index'), 'success');
	
}

//随机生成
$_SESSION['send_code'] = random(6,1);
	
include $this->template('user_phone');