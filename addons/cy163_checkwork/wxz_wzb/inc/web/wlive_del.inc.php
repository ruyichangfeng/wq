<?php

global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
$id = intval($_GPC['id']);
$rid = intval($_GPC['rid']);

$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_live_setting')." WHERE id=:id",array(':id'=>$id));
pdo_delete('wxz_wzb_live_setting',array('id'=>$id));


message('删除成功',$this->createWebUrl('category_list'),'success');
include $this->template('live_menu');