<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "mn_common.php";

$urltk = $this->createMobileUrl('yg_show');

$id = intval($_GPC['id']);
$srdb = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'id' => $id));
if (empty($srdb)) {
	message('不存在或是已经被删除！', $this->createMobileUrl('yg_lsit'), 'success');
}

$my_members = pdo_get('mc_members', array('uniacid' => $_W['uniacid'],'uid' => $srdb['uid']));

//职位
$staff_zw_show = pdo_get('cwgl_staff_class', array('cid' => $srdb['type'],'weid' => $_W['uniacid']));

include $this->template('yg_show');