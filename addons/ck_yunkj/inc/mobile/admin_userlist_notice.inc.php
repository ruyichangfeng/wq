<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

require "public.php";
require "admin_common.php";

load()->func('tpl');
$uid = $_GPC['uid'];
$idt = $_GPC['idt'];
$type = $_GPC['type'];
if (empty($uid)) {
	message('抱歉！UID值为空不能访问！', $this->createMobileUrl('admin_userlist',array('op' => 'view','id' => $idt)), 'error');
}

$urlt = $this->createMobileUrl('admin_userlist_notice')."&uid=".$_GPC['uid']."&idt=".$idt;

//修改
if(checksubmit('add_submit')){
	
	$data = array(
		'weid' => $_W['uniacid'],
		'uid' => $_GPC['uid'],
		'type' => 'system',
		'message' => $_GPC['message'],
		'dateline' => mktime()
	);
	
	 $result = pdo_insert('cwgl_notice', $data);
	
	 if (!empty($result)) {
		$idd = pdo_insertid();
		message('发布成功', $urlt, 'success');
	 }else{
		message('发布失败', $urlt, 'success');
	 }
	
}

include $this->template('admin_userlist_notice');
?>