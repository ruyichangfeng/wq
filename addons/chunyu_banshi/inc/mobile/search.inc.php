<?php

global $_W, $_GPC;

$base=$this->get_base(); 

$mid=$this->get_mid();

if($_GPC['keyword']){

	$kd=$_GPC['keyword'];

	$yewulist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_yewu')."WHERE uniacid=:uniacid AND lname LIKE :kd",array(':uniacid'=>$_W['uniacid'],':kd'=>"%$kd%"));

	include $this -> template('search');

}else{
	message('抱歉，请输入关键字！', $this -> createMobileUrl('index'), 'error');
}