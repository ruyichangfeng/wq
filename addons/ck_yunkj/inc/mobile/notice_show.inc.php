<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "mn_common.php";

$urltk = $this->createMobileUrl('notice_show');

$id = intval($_GPC['id']);
$srdb = pdo_get('cwgl_notice_list', array('weid' => $_W['uniacid'],'id' => $id));
if (empty($srdb)) {
	message('不存在或是已经被删除！', $this->createMobileUrl('index'), 'success');
}

$hot = $srdb['hot'] + 1;

$result = pdo_query("UPDATE ".tablename('cwgl_notice_list')." SET hot = '{$hot}' WHERE weid = '{$_W['uniacid']}' and id = '{$id}'");

include $this->template('notice_show');