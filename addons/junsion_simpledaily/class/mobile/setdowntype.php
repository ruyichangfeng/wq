<?php
global $_W,$_GPC;
if ($_W['ispost']){
	pdo_update($this->modulename.'_works',array('special'=>$_GPC['downtype']),array('id'=>$_W['wid']));
}