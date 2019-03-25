<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$rid = $_GPC['rid'];
$isweixin = 1;
$blacklist = pdo_fetchAll('SELECT touid,id,nickname,headimgurl FROM ' . tablename('wxz_wzb_blacklist') . ' WHERE `rid` = :rid and type=1', array(':rid' => $rid) );
$shutlist = array();
foreach($blacklist as $key=>$v){
	$shutlist[$key] = 'user_'.$v['touid'];
}
$result = array('s'=>'1','msg'=>json_encode($shutlist),'list'=>$blacklist,'isweixin'=>$isweixin);
echo json_encode($result);
exit;
?>