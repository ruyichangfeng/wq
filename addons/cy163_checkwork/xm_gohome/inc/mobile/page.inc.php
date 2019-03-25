<?php
global $_W, $_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}
	
$foo = $_GPC['foo'];
$foos = array('index', 'show');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_curry')." where id=".$id);
	$images = unserialize($item['images']);
	$idStr = '';
	foreach ($images as $key => $value) {
		$pic = $_W["attachurl"].$images[$key];
		$idStr .= '<div class="swiper-slide"><img src="'.$pic.'" width="285" height="190"></div>';
	}

	$all =  pdo_fetchcolumn("select count(*) from ".tablename('xm_gohome_takeorder')." where weid=".$_W['uniacid']." and openid='".$openid."'");
	
	include $this->template('takeout/show');
}

if($foo == 'show'){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_curry')." where id=".$id);
	
	include $this->template('takeout/pageshow');
}

?>
