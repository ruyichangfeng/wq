<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";

$urltk = $this->createMobileUrl('admin_login');

//提交处理
if(checksubmit('bdsubmit')){
	
	$urlt = $this->createMobileUrl('admin_index');
	$username = trim($_GPC['username']);
	$password = md5($_GPC['password']);
	
	if(empty($username)){
		message('抱歉！请输入用户名！', $urltk, 'success');
	}
	
	if(empty($password)){
		message('抱歉！请输入密码！', $urltk, 'success');
	}
	
	//判断是否存在
	$admin_show_t = pdo_get('cwgl_admin', array('weid' => $_W['uniacid'],'username' => $username,'password' => $password));
	if(empty($admin_show_t)){
		message('抱歉！用户名或者密码错误！', $urltk, 'success');
	}
	
	pdo_update('cwgl_admin', array('uid' => $_W['member']['uid']), array('id' => $admin_show_t['id'],'weid' => $_W['uniacid']));
	message('绑定成功！', $urlt, 'success');
	
}
	
include $this->template('admin_login');