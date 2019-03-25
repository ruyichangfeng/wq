<?php
global $_W, $_GPC;
$weid = $_W['uniacid'];
$op = $_GPC['op'];
$id = $_GPC['id'];
if ($op == 'pay') {
	$msg = "支付成功";
	$err_title = "支付成功";
	$label = 'success';
$redirect=$_W['siteroot'] . 'app/' . substr($this->createMobileUrl('index', array()), 2);	include $this->template('error');
	exit();
}
