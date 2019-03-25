<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$kid = $_GPC['kid'];
$uid = $_GPC['uid'];
$code = $_GPC ['code'];
$au = $_GPC['au'];
$tokenInfo = $this->oauth->getOauthAccessToken($code);
$userInfo = $this->oauth->getOauthUserInfo($tokenInfo['openid'], $tokenInfo['access_token']);
MonUtil::setClientCookieUserInfo($userInfo, $this::$USER_COOKIE_KEY . "" . $this->weid);//保存到cookie
$params = array();
$params['kid'] = $kid;
$params['au'] = $au;
$params['uid'] = $uid;
$params['openid'] = $tokenInfo['openid'];
$redirect_uri = $this->getRedirectUrl($au, $params);
header("location: $redirect_uri");