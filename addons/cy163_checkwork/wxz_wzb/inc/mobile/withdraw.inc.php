<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);

//更新旧数据兼容新版本
$user_amount = array();
$user_amount['uniacid'] = $_W['uniacid'];
pdo_update('wxz_wzb_viewer', $user_amount, array('uid'=>$uid,'rid'=>$rid));


$viewer = pdo_fetch('SELECT sum(amount) as amount,sum(deposit) as deposit FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid and uniacid=:uniacid', array(':uid' => $uid,':uniacid' => $_W['uniacid']) );

include $this->template('2/withdraw');
?>