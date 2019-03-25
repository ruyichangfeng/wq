<?php
global $_W,$_GPC;
		
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid=$_GPC['rid'];
if(!$rid){
	$result = array('type'=>'1','msg'=>'分享成功');echo json_encode($result);exit;
}
if(!$uid){
	$result = array('type'=>'-1','msg'=>'请关注');echo json_encode($result);exit;
}

$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `rid` = :rid', array(':uid' => $uid,':rid' => $rid) );


$setting = $this->getRedP($rid);
$item = pdo_fetch("select * from ".tablename('wxz_wzb_live_setting')." where rid=".$rid." and uniacid = ".$_W['uniacid']);
$set = pdo_fetch("select * from ".tablename('wxz_wzb_setting')." where rid=".$rid." and uniacid = ".$_W['uniacid']);
if(!$user || $user['sub_openid'] ==""){
	$result = array('type'=>'-1','msg'=>'请关注');echo json_encode($result);exit;
}
$auth = $this->ipAuth($set['getip_addr'],$set['getip'],$rid,$user['ip']);
if($item['reward']== 1 && $setting['type']== 1 && $viewer['share']==0 && ($setting['pool_amount']-$setting['send_amount'])>=100 && $auth){
	if($viewer['ispay']==0){
		$data=array(
			'share'=>'1',
			'amount'=>rand($setting['min'],$setting['max'])
		);
		if($data['amount']>($setting['pool_amount']-$setting['send_amount'])){
			$data['amount'] = $setting['pool_amount']-$setting['send_amount'];
		}
		pdo_update('wxz_wzb_live_red_packet',array('send_amount'=>$setting['send_amount']+$data['amount']),array('id' => $setting['id'])); 
		$res = pdo_update('wxz_wzb_viewer', $data, array('uid'=>$uid,'rid'=>$rid));

		$setting['send_name'] = $setting['sname'];
		$setting['act_name'] = $setting['actname'];
		$setting['logo_imgurl'] = tomedia($setting['logo']);
		$setting['remark'] = '恭喜恭喜，您的' . (($viewer['amount'] - $viewer['deposit'])/100) . '元红包已经发放，请注意查收';;
		$setting['re_openid'] = $user['openid'];
		$setting['total_amount'] = ($viewer['amount'] - $viewer['deposit'])/100;
		$setting['min_value'] = ($viewer['amount'] - $viewer['deposit'])/100;
		$setting['max_value'] = ($viewer['amount'] - $viewer['deposit'])/100;

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
		$result = $this->sendReward($setting);

		if($r['type']== 1 ){
			$result = array('type'=>'1','msg'=>'分享成功');
		}else{
			$result = array('type'=>'-1','msg'=>$r['msg']);
		}
	}else{
		$result = array('type'=>'1','msg'=>'分享成功');
	}
}else{
	$data=array(
		'share'=>'1'
	);
	$res = pdo_update('wxz_wzb_viewer', $data, array('uid'=>$uid,'rid'=>$rid));
	$result = array('type'=>'1','msg'=>'分享成功');
}
echo json_encode($result);exit;
?>