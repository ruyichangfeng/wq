<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";

$urltk = $this->createMobileUrl('fw_lsit_index');

//推荐类型列表-------------------------
$category = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'fw' and tj = '1' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category)) {
	foreach ($category as &$row) {
		$row['list_fw'] = pdo_fetchall('SELECT * FROM ' . tablename('cwgl_service_list') . " WHERE weid = '{$_W['uniacid']}' and type='{$row[cid]}' and shelves = '1' ORDER BY  id DESC LIMIT 0,2");
	}
}
		
include $this->template('fw_lsit_index');