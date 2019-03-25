<?php
/**
 * [weliam] Copyright (c) 2016/3/23 
 * 会员model
 */

function getOpenid($openid='') {
	if($openid) return $openid;
	$userinfo = getInfo();
	//$userinfo = $this -> getInfo();
	return $userinfo['openid'];
} 

function getInfo() {
	global $_W, $_GPC;
	$userinfo = array();
	$debug = TRUE;
	load() -> model('mc');
	$userinfo = mc_oauth_userinfo();
	$uid = mc_openid2uid($userinfo['openid']);
	$member = mc_fetch($uid, array('nickname','avatar'));
	if(empty($member['nickname']) || empty($member['avatar'])){
		$result = mc_update($uid, array('nickname' => $userinfo['nickname'],'avatar' => $userinfo['avatar']));
	}
	if($debug == TRUE){
		if (empty($userinfo['openid'])) {
			die("<!DOCTYPE html>
            <html>
                <head>
                    <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                    <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
                </head>
                <body>
                <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
                </body>
            </html>");
		}
	}
	return $userinfo;
} 