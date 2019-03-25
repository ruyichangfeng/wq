<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$au = $_GPC['au'];
$kid = $_GPC['kid'];
$uid = $_GPC['uid'];
$params = array();
$params['kid'] = $kid;
$params['au'] = $au;
$params['uid'] = $uid;

//if (MonUtil::$DEBUG) {
//	$fansInfo = $this->getClientUserInfo();
//} else {
//	if (empty($_W['fans']['nickname'])) {
//		$fans = mc_oauth_userinfo();
//		$fansInfo = $fans;
//	} else {
//		$fansInfo = $_W['fans'];
//	}
//}
//
//
//MonUtil::setClientCookieUserInfo($fansInfo, $this::$USER_COOKIE_KEY . "" . $this->weid);//保存到cookie
//$params['openid'] = $fansInfo['openid'];

$redirect_uri = $this->getRedirectUrl($au, $params);


header("location: $redirect_uri");
exit;

/*
$userInfo = $this->getClientUserInfo();
if (empty($userInfo)) {//授权
	$redirect_uri = MonUtil::str_murl($this->createMobileUrl('Auth2', $params, true));
	$this->oauth->authorization_code($redirect_uri, Oauth2::$SCOPE_USERINFO, 1);//进行授权

} else {
	$params['openid'] = $userInfo['openid'];
	$redirect_uri = $this->getRedirectUrl($au, $params);
	header("location: $redirect_uri");
}*/