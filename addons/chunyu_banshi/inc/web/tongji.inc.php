<?php

global $_W, $_GPC;

load()->web('tpl'); 

$yewunum=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('chunyu_banshi_yewu')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));

$typenum=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('chunyu_banshi_type')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));

// $wangnum=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('chunyu_she_wang')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));

// $xiaonum=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('chunyu_she_xiao')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));

include $this->template('web/tongji');

?>