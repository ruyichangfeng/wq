<?php
global $_W,$_GPC;
$page = $_GPC['page'];
//$page初始值为  0
if($page == 0){
	$page = 1;
}

$sql = "SELECT * FROM ".tablename('activity_signup_recording')." WHERE `uniacid`=:uniacid "." LIMIT ".(($page-1)*5).",5";
$res = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));

include $this->template('signuprecording');