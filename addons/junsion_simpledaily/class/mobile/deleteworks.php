<?php
global $_W,$_GPC;

if ($_W['ispost']){
	$wid = $_GPC['wid'];
	$res = pdo_delete($this->modulename.'_works',array('id'=>$wid,'openid'=>$_W['fans']['from_user']));
	if ($res) die('1');
	else die('0');
}