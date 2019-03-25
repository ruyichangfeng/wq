<?php
global $_W,$_GPC;
$id = base64_decode($_GPC['id']);

$works = pdo_fetch("select type,psw from ".tablename($this->modulename.'_works')." where id='{$id}'");

if ($_W['isajax']){
	$_psw = $_GPC['psw'];
	if (empty($_psw)) die(json_encode(array($_psw,0)));
	$_psw = md5($_psw);
	if ($_psw==$works['psw']){
		setcookie('junsion_simpledaily_cookie'.$id, $_psw, time() + 300);
		die('1');
	}else{
		die('2');
	}
}

if ($works['type']!=2){
	header("location: ".$this->createMobileUrl('myworks',array('wid'=>base64_encode($id))));
}

$cfg = $this->module['config'];
include $this->template('preview');