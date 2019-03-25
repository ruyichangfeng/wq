<?php

global $_W, $_GPC;

$base=$this->get_base(); 

$mid=$this->get_mid();

$share=$this->get_share();

$lid=$_GPC['lid'];

if($lid){
	$yewu=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_yewu')."WHERE uniacid=:uniacid AND lid=:lid",array(':uniacid'=>$_W['uniacid'],':lid'=>$lid));
	include $this -> template('show');
}
