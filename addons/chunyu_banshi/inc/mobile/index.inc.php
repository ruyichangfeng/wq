<?php

global $_W, $_GPC;

$base=$this->get_base(); 

$title=$base['title'];

$mid=$this->get_mid();

$type=pdo_fetchall("SELECT * FROM ".tablename('chunyu_banshi_type')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));

include $this -> template('index');
