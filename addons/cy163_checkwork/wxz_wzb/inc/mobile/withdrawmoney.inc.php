<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$viewer = pdo_fetch('SELECT sum(amount) as amount,sum(deposit) as deposit FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `uniacid` = :uniacid', array(':uid' => $uid,':uniacid' => $_W['uniacid']) );

if(($viewer['amount'] - $viewer['deposit'])<=0){
	$result['s']=-1;
	$result['msg']='您的余额已提完！';
	echo json_encode($result);exit;
}

$packetSetting = $this->getRedP($rid);
$packetSetting['send_name'] = $packetSetting['sname'];
$packetSetting['act_name'] = $packetSetting['actname'];
$packetSetting['logo_imgurl'] = tomedia($packetSetting['logo']);
$packetSetting['remark'] = '恭喜恭喜，您的' . (($viewer['amount'] - $viewer['deposit'])/100) . '元红包已经发放，请注意查收';;
$packetSetting['openid'] = $user['openid'];
$packetSetting['fee'] = ($viewer['amount'] - $viewer['deposit']);

$rec = array();
$rec['uid'] = $user['id'];
$rec['uniacid'] = $_W['uniacid'];
$rec['fee'] = floatval(($viewer['amount'] - $viewer['deposit'])/100);
$rec['dateline'] = TIMESTAMP;
$rec['status'] = 'created';
$rec['rid'] = $rid;
$rec['type'] = 1;
pdo_insert('wxz_wzb_packet_log', $rec);
$logid=pdo_insertid();
$result = $this->sendReward($packetSetting);

if($result['s']==-1){
	pdo_update('wxz_wzb_packet_log', array('status'=> $result['msg']), array('id'=>$logid));
	pdo_update('wxz_wzb_viewer', array('ispay'=>'2','rlog'=>$result['msg']), array('uid'=>$uid,'rid'=>$rid));
}else{
	pdo_update('wxz_wzb_packet_log', array('status'=>'success'), array('id'=>$logid));
	$r = pdo_fetchAll('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `uniacid` = :uniacid', array(':uid' => $uid,':uniacid' => $_W['uniacid']) );
	foreach($r as $key=>$v){
		$user_amount = array();
		$user_amount['deposit'] = (($v['amount'] - $v['deposit']))+$v['deposit'];
		pdo_update('wxz_wzb_viewer', $user_amount, array('id'=>$v['id']));
	}
}
echo json_encode($result);
?>