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
$i = $_GPC['i'];

if($paystatus == 'success') {
	
	$site = WeUtility::createModuleSite('wxz_wzb');
	if(!is_error($site)) {
		$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `dsid` = :dsid', array(':dsid' => $id));
		pdo_update('wxz_wzb_ds',array('status'=>'1'),array('id'=>$id));
		pdo_update('wxz_wzb_comment',array('dsstatus'=>'1'),array('dsid'=>$id));
	}

}

header("location: http://".$_SERVER['HTTP_HOST']."/app/index.php?c=entry&time=1&rid=".$rid."&i=".$i."&do=index2&m=wxz_wzb");
