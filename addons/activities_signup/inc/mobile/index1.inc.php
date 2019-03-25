<?php
global $_W;  //先申明全局变量
global $_GPC;  //先申明全局变量
$sql = 'SELECT * FROM ' .tablename('activities_recording').' WHERE `uniacid`=:uniacid ORDER BY `id` DESC ';
$param = array(':uniacid'=>$_W['uniacid']);
$activity = pdo_fetch($sql,$param);

include $this->template('activity');