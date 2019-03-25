<?php
global $_W,$_GPC;
$rid = intval($_GPC['rid']);
load()->func('tpl');
include $this->template('2/pictv');
?>