<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "staff_common.php";

$urltk = $this->createMobileUrl('staff_profile');

//提交处理
if(checksubmit('save_submit')){
	
	$data = array(
		'name' => $_GPC['name'],
		'sex' => $_GPC['sex'],
		'xueli' => $_GPC['xueli'],
		'working_time' => $_GPC['working_time'],
		'phone' => $_GPC['phone'],
		'qq' => $_GPC['qq'],
		'WeChath' => $_GPC['WeChath'],
		'message' => $_GPC['message']
	);
	
	pdo_update('cwgl_staff_list', $data, array('id' => $staff_show['id'],'weid' => $_W['uniacid']));

	message('保存成功！', $urltk, 'success');
	
}
	
include $this->template('staff_profile');