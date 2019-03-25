<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$type=$_GPC['type'];

include $this->template('2/history');
?>