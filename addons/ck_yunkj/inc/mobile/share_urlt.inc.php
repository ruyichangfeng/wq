<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
$templateurl = "../addons/{$_GPC['m']}/template/mobile";
$cwgl_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));

//判断是否已经关注公众号
if(empty($_W['member']['uid'])){
	
	//标记邀请会员ID
	if($_GPC['tgid']){
		setcookie("tguid", $_GPC['tgid'], mktime()+1800);
	}
	
	if(empty($cwgl_config['gzh_logo'])){
		message('抱歉！您还未关注本站微信公众号！快去关注吧！');
	}else{
		//为关注跳转
		$urlp = "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz={$cwgl_config['gzh_logo']}%3D%3D&scene=110#wechat_redirect";
		header("Location: $urlp");
		exit;
	}
	
}else{
	
	//引用
	require "user_common.php";
	
	$urltk = $this->createMobileUrl('share_urlt')."&tgid=".$_GPC['tgid'];
	include $this->template('user_share_urlt');
	
}