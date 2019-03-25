<?php

global $_W, $_GPC;

$base=$this->get_base(); 

$mid=$this->get_mid();

$tid=$_GPC['tid'];

if($tid){

	$yewulist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_yewu')."WHERE uniacid=:uniacid AND tid=:tid",array(':uniacid'=>$_W['uniacid'],':tid'=>$tid));
	$type=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_type')."WHERE uniacid=:uniacid AND tid=:tid",array(':uniacid'=>$_W['uniacid'],':tid'=>$tid));
	include $this -> template('list');
}