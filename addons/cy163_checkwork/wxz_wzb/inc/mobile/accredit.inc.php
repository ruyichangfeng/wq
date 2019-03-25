<?php
global $_W,$_GPC;

$uniacid = $_W['uniacid'];
$rid = $_GPC['rid'];
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `rid` = :rid', array(':uid' => $uid,':rid' => $rid) );
pdo_update('wxz_wzb_viewer', array('role'=>2), array('id' => $viewer['id']));
message('授权成功！',$this->createMobileUrl('index2',array('rid'=>$rid)),'success');
?>