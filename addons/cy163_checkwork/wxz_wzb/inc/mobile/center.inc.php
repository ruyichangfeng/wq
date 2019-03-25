<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );
$income = pdo_fetchcolumn('SELECT sum(amount) FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid and uniacid =:uniacid', array(':uid' => $uid,':uniacid' => $_W['uniacid']) );
$browse = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('wxz_wzb_viewer') . ' as a inner join ' . tablename('wxz_wzb_live_setting') . ' as b on a.rid = b.rid WHERE a.`uid` = :uid', array(':uid' => $uid) );

$manage = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('wxz_wzb_viewer') . ' as a inner join ' . tablename('wxz_wzb_live_setting') . ' as b on a.rid = b.rid WHERE a.`uid` = :uid and role !=0', array(':uid' => $uid) );

include $this->template('2/center');
?>