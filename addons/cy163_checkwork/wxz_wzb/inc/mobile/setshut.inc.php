<?php
global $_W,$_GPC;

$openid = $_W['openid'];
$rid = intval($_GPC['rid']);
$type = intval($_GPC['type']);
$nickname = ($_GPC['nickname']);
$touid = array_pop(explode("_",($_GPC['user'])));

$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$isweixin = 1;
$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_blacklist') . ' WHERE `rid` = :rid AND `touid` = :touid', array(':rid' => $rid,':touid' => $touid) );
$touser = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `id` = :uid', array(':uid' => $touid) );

if(empty($user)){
	$data=array(
		'uniacid'=>$_W['uniacid'],
		'uid'=>$uid,
		'type'=>$type,
		'rid'=>$rid,
		'touid'=>$touid,
		'nickname'=>$nickname,
		'headimgurl'=>$touser['headimgurl'],
		'dateline'=>time()
	);
	pdo_insert('wxz_wzb_blacklist', $data);
	$id=pdo_insertid();
}else{
	pdo_update('wxz_wzb_blacklist',array('type'=>$type),array('id'=>$user['id']));
	$id=$user['id'];
}

$pollingData = array(
	'rid'=>$rid,
	'type'=>2,
	'black_id'=>$id,
);
pdo_insert('wxz_wzb_polling', $pollingData);

$msg = $type == 1? '禁言成功' : '取消禁言';
$result = array('s'=>'1','msg'=>$msg);
echo json_encode($result);
exit;
?>