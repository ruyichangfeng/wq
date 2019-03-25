<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";

$urltk = $this->createMobileUrl('staff_login');

//提交处理
if(checksubmit('bdsubmit')){
	
	$urlt = $this->createMobileUrl('staff_index');
	$name = trim($_GPC['name']);
	$password = md5($_GPC['password']);
	
	if(empty($name)){
		message('抱歉！您输入员工名称！', $urltk, 'success');
	}
	
	if(empty($password)){
		message('抱歉！您输入员工密码！', $urltk, 'success');
	}
	
	//判断是否存在
	$staff_show = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'name' => $name,'password' => $password));
	if(empty($staff_show)){
		message('抱歉！您输入员工名称或者密码错误！', $urltk, 'success');
	}
	
	pdo_update('cwgl_staff_list', array('uid' => $_W['member']['uid']), array('id' => $staff_show['id'],'weid' => $_W['uniacid']));
	message('绑定成功！', $urlt, 'success');
	
}
	
include $this->template('staff_login');