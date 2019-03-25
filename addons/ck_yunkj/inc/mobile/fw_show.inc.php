<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
//require "user_common.php";

$urltk = $this->createMobileUrl('fw_show');

$id = intval($_GPC['id']);
$srdb = pdo_get('cwgl_service_list', array('weid' => $_W['uniacid'],'id' => $id));
if (empty($srdb)) {
	message('不存在或是已经被删除！', $this->createMobileUrl('fw_lsit'), 'success');
}


	
include $this->template('fw_show');