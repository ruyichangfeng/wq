<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_toushu');

if(checksubmit('save_submit')){
	
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'ygid' => $user_show['ygid'],
		'yguid' => $user_show['yguid'],
		'titlename' => $_GPC['titlename'],
		'content' => $_GPC['content'],
		'dateline' => mktime()
	);
	
	$result = pdo_insert('cwgl_user_toushu', $data);
	
	if (!empty($result)) {
		$idd = pdo_insertid();
		message('提交成功', $this->createMobileUrl('user_index'), 'success');
	}else{
		message('提交失败', $this->createMobileUrl('user_index'), 'success');
	}

}
	
include $this->template('user_toushu');