<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_setting') . ' WHERE `uniacid` = :uniacid and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':rid' => $rid));
if(!$uid){
	$result = array('s'=>'-1','msg'=>'请关注公众号！');
	echo json_encode($result);
	exit;
}

$comments = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uniacid` = :uniacid AND `uid` = :uid and `rid` = :rid order by id desc', array(':uniacid' => $_W['uniacid'],':uid' => $uid,':rid' => $rid) );

if((time()-$comments['dateline'])<2){
	$result = array('s'=>'-1','msg'=>'歇2s再来评论吧');
	echo json_encode($result);
	exit;
}

$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$blacklist = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_blacklist') . ' WHERE `rid` = :rid AND `touid` = :touid and type = 1', array(':rid' => $rid,':touid' => $uid) );

if($blacklist){
	$pollingData = array(
		'rid'=>$rid,
		'type'=>2
	);
	pdo_insert('wxz_wzb_polling', $pollingData);
	$pid=pdo_insertid();
	$result = array('s'=>'-2','msg'=>'您已被禁言！','pid'=>$pid);
	
	echo json_encode($result);
	exit;
	
}

if($item['isallshutup']==1){
	$pollingData = array(
		'rid'=>$rid,
		'type'=>3
	);
	pdo_insert('wxz_wzb_polling', $pollingData);
	$pid=pdo_insertid();
	$result = array('s'=>'-2','msg'=>'全体禁言中','pid'=>$pid);
	
	echo json_encode($result);
	exit;
	
}

$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `rid` = :rid', array(':uid' => $uid,':rid' => $rid) );

if($viewer['isshutup']==1){
	$pollingData = array(
		'rid'=>$rid,
		'type'=>2
	);
	pdo_insert('wxz_wzb_polling', $pollingData);
	$pid=pdo_insertid();
	$result = array('s'=>'-2','msg'=>'您已被禁言！','pid'=>$pid);
	
	echo json_encode($result);
	exit;
	
}

if(!$user){
	$result = array('s'=>'-1','msg'=>'请关注公众号！');
	echo json_encode($result);
	exit;
}

$touser = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uniacid` = :uniacid AND `id` = :id and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':id' => $_GPC['toid'],':rid' => $rid) );


$data=array(
	'uniacid'=>$_W['uniacid'],
	'uid'=>$uid,
	'ip'=>$_W['clientip'],
	'is_auth'=>$item['is_auth']==1 ? 2 : 1,
	'nickname'=>$user['nickname'],
	'headimgurl'=>$user['headimgurl'],
	'rid'=>$rid,
	'content'=>$_GPC['content'],
	'toid'=>$_GPC['toid'],
	'touid'=>$touser['uid'],
	'tonickname'=>$touser['nickname'],
	'toheadimgurl'=>$touser['headimgurl'],
	'dateline'=>time()
);

pdo_insert('wxz_wzb_comment', $data);
$id=pdo_insertid();
$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_setting') . ' WHERE `uniacid` = :uniacid and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':rid' => $rid));


if($id){
	if($item['is_auth'] == '1'){
		$result = array('s'=>'1','msg'=>'提交成功，审核成功后显示','isshow'=>0);
	}else{
		
		$pollingData = array(
			'rid'=>$rid,
			'type'=>1,
			'comment_id'=>$id,
		);
		pdo_insert('wxz_wzb_polling', $pollingData);
		$pid=pdo_insertid();

		$result = array('s'=>'1','msg'=>'提交成功','pid'=>$pid,'isshow'=>1);
	}
	
}else{
	$result = array('s'=>'-2','msg'=>'提交失败，请联系管理员');
}

echo json_encode($result);
exit;

?>