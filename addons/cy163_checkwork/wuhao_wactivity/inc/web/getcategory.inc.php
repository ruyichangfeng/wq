<?php
global $_W,$_GPC;


$data_groups=pdo_fetchall("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
echo json_encode($data_groups);

