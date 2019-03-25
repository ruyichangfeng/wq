<?php
global $_W,$_GPC;
$lists = array();
$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_configs'));


if (checksubmit('submit')) {
	$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_configs'));

	$data = array();
	$data['accessid'] = $_GPC['accessid'];
	$data['accesskey'] = $_GPC['accesskey'];
	$data['tisid'] = $_GPC['tisid'];

	if(!empty($list)){
		pdo_update('wxz_wzb_configs',$data,array('id'=>$list['id']));
	}else{
		pdo_insert('wxz_wzb_configs',$data);
	}
	message('配置成功',$this->createWebUrl('tissave'),'success');
}
include $this->template('tissave');