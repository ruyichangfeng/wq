<?php
global $_W,$_GPC;
$rid = intval($_GPC['rid']);
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
if(empty($rid)){
	$result = array('s'=>'-1','msg'=>'直播不存在','isweixin'=>$isweixin);
	echo json_encode($result);exit;
}

$zan = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_zannum') . ' WHERE `rid` = :rid and uniacid = :uniacid and user_id = :user_id', array(':rid' => $rid,':uniacid' => $_W['uniacid'],':user_id' => $uid) );


if(empty($zan)){
	$num = 1;
	$data=array(
		'uniacid'=>$_W['uniacid'],
		'user_id'=>$uid,
		'rid'=>$rid,
		'num'=>$num
	);
	pdo_insert('wxz_wzb_zannum', $data);
}else{
	$num = $zan['num']+1;
	pdo_update('wxz_wzb_zannum', array('num'=>$num), array('id' => $zan['id']));
}

$total = pdo_fetchcolumn("SELECT sum(num) FROM ".tablename('wxz_wzb_zannum')." where `rid` = :rid and uniacid = :uniacid", array(':rid' => $rid,':uniacid' => $_W['uniacid']) );

$result['s'] = 1;
$result['num'] = $total;
echo json_encode($result);exit;
?>