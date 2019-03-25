<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "staff_common.php";

$urltk = $this->createMobileUrl('staff_usershow');

//展示-------------------------
$id = intval($_GPC['id']);
$srdb = pdo_get('cwgl_user_list', array('id' => $id,'weid' => $_W['uniacid']));
if (empty($srdb)) {
	message('不存在或是已经被删除！', $this->createMobileUrl('staff_index'), 'success');
}
	
include $this->template('staff_usershow');