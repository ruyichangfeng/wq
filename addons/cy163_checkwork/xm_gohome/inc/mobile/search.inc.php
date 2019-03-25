<?php
global $_W,$_GPC;

$foo = $_GPC['foo'];
$foos = array('index', 'searchok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){
	$list = pdo_fetchall("select id,merchant_name from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and stop=1 and state=1 and delstate=1 and top3 !=0 order by top3 desc");

	include $this->template('takeout/search');
}

if($foo == "searchok"){
	$keyword = $_GPC['keyword'];
	
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and stop=1 and state=1 and delstate=1 and merchant_name like '%".$keyword."%' order by addtime desc");

	$list1 = pdo_fetchall("select * from ".tablename('xm_gohome_curry')." where weid=".$_W['uniacid']." and stop=1 and delstate=1 and curry_name like '%".$keyword."%' order by top asc");

	include $this->template('takeout/searchlist');
}

?>