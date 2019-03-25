<?php
global $_W,$_GPC;

$uniname = $_W['uniaccount']['name'];
$unilogo =  $_W['uniaccount']['logo'];
$outurl = $_W['siteroot'].$_W['script_name']."?c=home&a=welcome&do=platform&";


$conf = pdo_get('xc_sysconfig',array('uniacid'=>$_W['uniacid']));
$title = $conf['title'];

include $this->template('default');