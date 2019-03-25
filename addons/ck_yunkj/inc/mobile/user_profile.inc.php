<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_profile');

//提交处理
if(checksubmit('save_submit')){
	
	$data = array(
		'compname' => $_GPC['compname'],
		'name' => $_GPC['name'],
		'message' => $_GPC['message']
	);
	
	pdo_update('cwgl_user_list', $data, array('id' => $user_show['id'],'weid' => $_W['uniacid']));

	message('保存成功！', $urltk, 'success');
	
}
	
include $this->template('user_profile');