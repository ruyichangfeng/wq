<?php
global $_W,$_GPC;
		
$uniacid = $_W['uniacid'];
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = $_GPC['rid'];
$hb_id = $_GPC['sendid'];
$hb_msg = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uniacid` = :uniacid AND `id` = :hb_id AND `rid` = :rid', array(':uniacid' => $_W['uniacid'],':hb_id' => $hb_id,':rid' => $rid) );

$grouppacket = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_grouppacket') . ' WHERE `id` = :id', array(':id' => $hb_msg['gid']) );

$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$viewer = pdo_fetch("select * from ".tablename('wxz_wzb_viewer')." where rid=".$rid." and uid=".$user['id']);

$log = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_grouppacket_log')." WHERE rid = :rid AND uid = :uid AND uniacid = :uniacid AND hid = :hid AND comment_id = :comment_id", array(':rid' => $rid,':uid' => $uid,':comment_id' => $hb_msg['id'],':uniacid' => $_W['uniacid'],':hid' => $grouppacket['id']));

$moneys = iunserializer($hb_msg['samount']);

$redinfo['title'] = $grouppacket['remark'];
$redinfo['type'] = $grouppacket['type'];
$redinfo['money'] = $grouppacket['amount'];
$redinfo['num'] = $grouppacket['num'];
$res['redinfo'] = $redinfo;

if($log){
	$res['status']=2;
	$res['redlist'] = pdo_fetchAll("SELECT * FROM ".tablename('wxz_wzb_grouppacket_log')." WHERE rid = :rid AND uniacid = :uniacid AND hid = :hid AND comment_id = :comment_id", array(':rid' => $rid,':comment_id' => $hb_msg['id'],':uniacid' => $_W['uniacid'],':hid' => $grouppacket['id']));
	echo json_encode($res);
	exit();
}

if($hb_msg['num']==$hb_msg['send_num'] || empty($moneys)){
	$res['status']=0;
	echo json_encode($res);
	exit();
}

$fee = array_pop($moneys);
if($hb_msg['syifa']==''){
	$syifa = array('0'=>$fee);
}else{
	$syifa = iunserializer($hb_msg['syifa']);
	$syifa[] = $fee;
}

if($hb_msg['yifa_amount']>=$hb_msg['amount'] || $hb_msg['send_num']>=$hb_msg['num']){
	$res['status']=0;
	echo json_encode($res);
	exit();
}

if(intval($fee)>intval($hb_msg['amount'])){
	$res['status']=-1;
	$res['msg']='你的提现有点多';
	echo json_encode($res);
	exit();
}

$rec = array();
$rec['hid'] = $grouppacket['id'];
$rec['rid'] = $rid;
$rec['uid'] = $uid;
$rec['uniacid'] = $uniacid;
$rec['comment_id'] = $hb_msg['id'];
$rec['amount'] = $fee;
$rec['dateline'] = TIMESTAMP;
$rec['headimgurl'] = $user['headimgurl'];
$rec['nickname'] = $user['nickname'];
$rec['type'] = $grouppacket['type'];
pdo_insert('wxz_wzb_grouppacket_log', $rec);
$id=pdo_insertid();


$data=array(
	'uniacid'=>$_W['uniacid'],
	'uid'=>$uid,
	'type'=>2,
	'amount'=>$fee,
	'rid'=>$rid,
	'fromid'=>$id,
	'fromuid'=>$hb_msg['uid'],
	'fromnickname'=>$hb_msg['nickname'],
	'fromheadimgurl'=>$hb_msg['headimgurl'],
	'dateline'=>time()
);
pdo_insert('wxz_wzb_money_log', $data);

$user_amount['amount'] = ($fee)+$viewer['amount'];
pdo_update('wxz_wzb_viewer', $user_amount, array('uid'=>$uid,'rid'=>$rid));
pdo_update('wxz_wzb_comment', array('send_num'=>$hb_msg['send_num']+1,'yifa_amount'=>$hb_msg['yifa_amount']+$fee,'samount'=>iserializer($moneys),'syifa'=>iserializer($syifa)), array('id'=>$hb_msg['id']));
$res['redlist'] = pdo_fetchAll("SELECT * FROM ".tablename('wxz_wzb_grouppacket_log')." WHERE rid = :rid AND uniacid = :uniacid AND hid = :hid AND comment_id = :comment_id", array(':rid' => $rid,':comment_id' => $hb_msg['id'],':uniacid' => $_W['uniacid'],':hid' => $grouppacket['id']));
$res['status']=2;
echo json_encode($res);
?>