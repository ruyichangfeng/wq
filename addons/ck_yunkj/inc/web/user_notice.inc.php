<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

load()->func('tpl');
$uid = $_GPC['uid'];
$type = $_GPC['type'];
if (empty($uid)) {
	if($type == 1){
		message('抱歉！UID值为空不能访问！', $this->createWebUrl('user_list'), 'error');
	}else{
		message('抱歉！UID值为空不能访问！', $this->createWebUrl('staff_list'), 'error');
	}
}

$urlt = $this->createWebUrl('user_notice')."&uid=".$_GPC['uid']."&type=".$type;

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

include $this->template('user_notice');
?>