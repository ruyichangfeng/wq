<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
$paystatus = $_GPC['paystatus'];
$id = $_GPC['id'];
$rid = $_GPC['rid'];
$uid = $_GPC['uid'];
$i = $_GPC['i'];

if($paystatus == 'success') {

	$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_setting') . ' WHERE `uniacid` = :uniacid and `rid` = :rid', array(':uniacid' => $i,':rid' => $rid));

	$site = WeUtility::createModuleSite('wxz_wzb');
	if(!is_error($site)) {
		pdo_update('wxz_wzb_paylog',array('status'=>'1'),array('id'=>$id));
		pdo_update('wxz_wzb_viewer', array('password'=>$item['password']), array('rid' => $rid,'uid' => $uid));
	}
}
header("location: http://".$_SERVER['HTTP_HOST']."/app/index.php?c=entry&time=1&rid=".$rid."&i=".$i."&do=index2&m=wxz_wzb");
