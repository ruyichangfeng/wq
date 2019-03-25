<?php
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
global $_GPC, $_W;
//checkauth();

if ($_W['container'] != 'wechat') {
	$appid = $_W['account']['key'];
	$secret = $_W['account']['secret'];
	if (empty($appid) || empty($secret)) {
		message('微信公众号没有配置公众号AppId和公众号AppSecret!');
	}
	$url = $_W['siteroot'] . $this->createMobileUrl('checkopenid');
	$oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=0#wechat_redirect";
	header("location:$oauth2_code");	
}

load()->model('mc');
$fansinfo = mc_fansinfo($_W['fans']['from_user']);
if(empty($fansinfo['nickname'])){
	$fansinfo = mc_oauth_userinfo();
	//if(is_error($fansinfo)){
	//	message($fansinfo['message']);
	//}
}

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$rid = intval ($_GPC['rid']);
	if (empty($rid)){
		message ( '活动已取消...');
	}
	$reply = pdo_fetch("SELECT * FROM " . tablename ("cx_tcbd_form") . " WHERE rid = :rid ORDER BY `id` DESC", array (':rid' => $rid));	
	// 增加浏览次数
	$uid = $_W['member']['uid'];
	$openid = $_W['fans']['from_user'];
	$fans = pdo_fetch ( "SELECT * FROM " . tablename ("cx_tcbd_fans") . " WHERE rid = " . $rid . " and openid='" . $openid . "' limit 1" );
	if ($fans == false) {
		$insert = array (
				'rid' => $rid,
				'uniacid' => $_W['uniacid'],
				'uid' => $uid,
				'openid' => $openid,
				'totalnum' => 0,
				'createtime' => time () 
		);
		$temp = pdo_insert("cx_tcbd_fans", $insert );
		if ($temp == false) {
			message ( '抱歉，操作数据失败！', '', 'error' );
		}
		pdo_update ('cx_tcbd_form', array ('fansnum' => $reply ['fansnum'] + 1,'viewnum' => $reply ['viewnum'] + 1 ), 
						array ('id' => $reply ['id']) );		
	}else{
		pdo_update ( 'cx_tcbd_form', array ('viewnum' => $reply ['viewnum'] + 1), array ('id' => $reply ['id']) );		
	}
	$cx_tcbd_sid = $_SESSION['cx_tcbd_sid'] = mt_rand(1000, 9999);
	include $this->template ( 'index' );
} elseif ($operation == 'post') {
	$rid = intval ($_GPC['rid']);
	if (empty($rid)){
		message ( '活动已取消...');
	}
	if($_GPC['cx_tcbd_sid'] != '' && $_GPC['cx_tcbd_sid'] == $_SESSION['cx_tchbd_sid'])
	{
		unset($_SESSION['cx_tcbd_sid']);
	}else{
		message('',$this->createMobileUrl ( 'index', array ('op' => 'display','rid'=>$rid) ));
	}
	$reply = pdo_fetch("SELECT * FROM " . tablename ("cx_tcbd_form") . " WHERE rid = :rid ORDER BY `id` DESC", array (':rid' => $rid));	
	$uid = $_W['member']['uid'];
	$openid = $_W['fans']['from_user'];	
	$fans = pdo_fetch ( "SELECT * FROM " . tablename ("cx_tcbd_fans") . " WHERE rid = " . $rid . " and openid='" . $openid . "' limit 1" );
	if ($fans == false) {
		$insert = array (
				'rid' => $rid,
				'uniacid' => $_W['uniacid'],
				'nickname' => $fansinfo['nickname'],
				'uid' => $uid,
				'openid' => $openid,
				'totalnum' => 0,
				'createtime' => time () 
		);
		pdo_insert("cx_tcbd_fans", $insert );
		$fans ['id'] = pdo_insertid ();
		$fans ['totalnum'] = 0;
	}
	$submit_times = $reply["submit_times"];
	$fans_times = $fans['totalnum'];
	if ($submit_times > 0 && $fans_times >= $submit_times){
		message ( '超过参与次数！');
	}
	pdo_update ( 'cx_tcbd_fans', array ('totalnum' => $fans ['totalnum'] + 1), array ('id' => $fans ['id']) );	
	//文件上传
	$json = $_GPC['inputs'];
	//文件上传完毕
	$insert = array (
			'rid' => $rid,
			'uniacid' => $_W['uniacid'],
			'uid' => $uid,
			'openid' => $openid,
			'nickname' => $fansinfo['nickname'],
			'fields' => $json,
			'createtime' => time () 
	);
	pdo_insert("cx_tcbd_order", $insert );
	message ( $reply['success_prompt'], $this->createMobileUrl ( 'index', array ('op' => 'mine','rid'=>$rid) ), 'success' );
}elseif ($operation == 'mine') {
	$rid = intval ($_GPC['rid']);
	if (empty($rid)){
		message ( '活动已取消...');
	}
	$uid = $_W['member']['uid'];
	$openid = $_W['fans']['from_user'];
	$reply = pdo_fetch("SELECT * FROM " . tablename ("cx_tcbd_form") . " WHERE rid = :rid ORDER BY `id` DESC", array (':rid' => $rid));	
	$orders = pdo_fetchall("SELECT * FROM " . tablename ("cx_tcbd_order") . " WHERE rid = :rid AND uniacid = :uniacid AND openid = :openid ORDER BY `id` DESC", array (':rid' => $rid,':openid'=>$openid,':uniacid'=>$_W['uniacid']));	
	include $this->template ( 'mine' );
}
?>