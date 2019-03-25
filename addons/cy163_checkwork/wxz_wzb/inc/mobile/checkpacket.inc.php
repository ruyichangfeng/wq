<?php
global $_W,$_GPC;

$uniacid = $_W['uniacid'];
$rid = $_GPC['rid'];
$hb_id = $_GPC['sendid'];
$hb_msg = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uniacid` = :uniacid AND `id` = :hb_id AND `rid` = :rid', array(':uniacid' => $_W['uniacid'],':hb_id' => $hb_id,':rid' => $rid) );

$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];

$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$viewer = pdo_fetch("select * from ".tablename('wxz_wzb_viewer')." where rid=".$rid." and uid=".$user['id']);
$grouppacket = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_grouppacket') . ' WHERE `id` = :id', array(':id' => $hb_msg['gid']));
$log = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_grouppacket_log')." WHERE rid = :rid AND uid = :uid AND uniacid = :uniacid AND hid = :hid AND comment_id = :comment_id", array(':rid' => $rid,':uid' => $uid,':comment_id' => $hb_msg['id'],':uniacid' => $_W['uniacid'],':hid' => $grouppacket['id']));

$redinfo['title'] = $grouppacket['remark'];
$redinfo['type'] = $grouppacket['type'];
$redinfo['money'] = $grouppacket['amount'];
$redinfo['num'] = $grouppacket['num'];
$moneys = iunserializer($hb_msg['samount']);
$res['redinfo'] = $redinfo;

if($log){

	$res['status']=3;
	$res['redlist'] = pdo_fetchAll("SELECT * FROM ".tablename('wxz_wzb_grouppacket_log')." WHERE rid = :rid AND uniacid = :uniacid AND hid = :hid AND comment_id = :comment_id", array(':rid' => $rid,':comment_id' => $hb_msg['id'],':uniacid' => $_W['uniacid'],':hid' => $grouppacket['id']));
	echo json_encode($res);exit;
}

if($hb_msg['num']==$hb_msg['send_num'] || empty($moneys)){
	$res['status']=0;
	$res['redlist'] = pdo_fetchAll("SELECT * FROM ".tablename('wxz_wzb_grouppacket_log')." WHERE rid = :rid AND uniacid = :uniacid AND hid = :hid AND comment_id = :comment_id", array(':rid' => $rid,':comment_id' => $hb_msg['id'],':uniacid' => $_W['uniacid'],':hid' => $grouppacket['id']));

	echo json_encode($res);exit;
}

if($hb_msg['yifa_amount']>=$hb_msg['amount'] || $hb_msg['send_num']>=$hb_msg['num']){
	
	$res['status']=0;
	echo json_encode($res);exit;
}

if($fee>$hb_msg['amount']){
	$res['status']=-1;
	$res['msg']='你的提现有点多';
	echo json_encode($res);
	exit();
}
$res['status']=1;
echo json_encode($res);
exit();

?>