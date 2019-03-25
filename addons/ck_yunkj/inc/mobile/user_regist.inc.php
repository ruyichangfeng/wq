<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

$cwgl_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));

$urltk = $this->createMobileUrl('user_regist');
$url_sms = $this->createMobileUrl('sms');

//判断是否已经关注公众号
if(empty($_W['member']['uid'])){
	
	//标记邀请会员ID
	if($_GPC['jluid']){
		setcookie("jluid", $_GPC['jluid'], mktime()+1800);
	}
	
	if(empty($cwgl_config['gzh_logo'])){
		message('抱歉！您还未关注本站微信公众号！快去关注吧！');
	}else{
		//为关注跳转
		$urlp = "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz={$cwgl_config['gzh_logo']}%3D%3D&scene=110#wechat_redirect";
		header("Location: $urlp");
		exit;
	}
	
}

//判断是否已经绑定
$user_yg_show = pdo_get('cwgl_user_employees', array('weid' => $_W['uniacid'],'yguid' => $_W['member']['uid']));
if(!empty($user_yg_show)){
	message('抱歉！您的公众号已经绑定过！', $this->createMobileUrl('user_index'), 'success');
}

//提交处理
if(checksubmit('bdsubmit')){
	
	$urlt = $this->createMobileUrl('index');
	$name = trim($_GPC['name']);
	$phone = intval($_GPC['phone']);
	$code = trim($_GPC['code']);
	$mobile_code = trim($_GPC['mobile_code']);
	
	if(empty($name)){
		message('抱歉！员工姓名不能为空！', $urltk, 'success');
	}
	
	if(empty($phone)){
		message('抱歉！手机号不能为空！', $urltk, 'success');
	}
	
	//验证员工邀请码
	if(empty($code)){
		message('抱歉！员工邀请码不能为空！', $urltk, 'success');
	}
	if($_GPC['uidt']){
		$uid = $_GPC['uidt'];
	}else{
		$uid = $_COOKIE['jluid'];
	}
	$srdbt = pdo_get('cwgl_user_employees', array('weid' => $_W['uniacid'],'uid' => $uid,'code' => $code));
	if (empty($srdbt)) {
		message('抱歉！您输入员工邀请码不存在！', $urlt, 'success');
	}
	if($srdbt['shiyong']==1){
		message('抱歉！您输入员工邀请码已经被使用！', $urlt, 'success');
	}
	
	//手机验证码
	if($cwgl_config['sms_open']) {
		if($phone!=$_SESSION['mobile'] or $mobile_code!=$_SESSION['mobile_code'] or empty($phone) or empty($mobile_code)){
			message('手机验证码输入错误！', $urltk, 'success');
		}
	}
	
	$data = array(
		'name' => $name,
		'phone' => $phone,
		'yguid' => $_W['member']['uid'],
		'shiyong' => 1
	);
	
	pdo_update('cwgl_user_employees', $data, array('id' => $srdbt['id'],'weid' => $_W['uniacid']));
	
	//清空------------
	$_SESSION['mobile'] = '';
	$_SESSION['mobile_code'] = '';
	setcookie("jluid", '', mktime());
	//----------------


	message('注册成功！', $urlt, 'success');

}

//随机生成
$_SESSION['send_code'] = random(6,1);

include $this->template('user_regist');