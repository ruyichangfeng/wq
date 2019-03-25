<?php
global $_W,$_GPC;


$rid = intval($_GPC['rid']);
$type = intval($_GPC['allshutup']);

$isweixin = 1;

pdo_update('wxz_wzb_live_setting',array('isallshutup'=>$type),array('rid'=>$rid));

$pollingData = array(
	'rid'=>$rid,
	'type'=>3,
	'live_id'=>$rid,
);
pdo_insert('wxz_wzb_polling', $pollingData);


$result = array('s'=>'1','msg'=>$msg);
echo json_encode($result);
exit;
?>