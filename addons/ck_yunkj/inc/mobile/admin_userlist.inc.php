<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "admin_common.php";

$newtimes =  mktime();
$urltk = $this->createMobileUrl('admin_userlist');

$op = $_GPC['op'];

//保存修改
if(checksubmit('save_submit')){
	
	$data = array(
		'compname' => $_GPC['compname'],
		'name' => $_GPC['name'],
		'phone' => $_GPC['phone'],
		'message' => $_GPC['message']
	);
	
	if($_GPC['khid']){
		pdo_update('cwgl_user_list', $data, array('id' => $_GPC['khid'],'weid' => $_W['uniacid']));
		message('保存成功！', $urltk.'&op=view&id='.$_GPC['khid'], 'success');
	}else{
		message('保存失败！', $urltk.'&op=view&id='.$_GPC['khid'], 'success');
	}
	
}

//保存客户服务期限、月费
if(checksubmit('setup_submit')){
	
	$data = array(
		'payfees' => $_GPC['payfees']
	);
	
	//存客户服务期限
	if($_GPC['monthadd']){
		$data['deadline'] =  $_GPC['monthadd']*2592000 + $newtimes;
	}
	
	if($_GPC['khid']){
		pdo_update('cwgl_user_list', $data, array('id' => $_GPC['khid'],'weid' => $_W['uniacid']));
		message('保存成功！', $urltk.'&op=view&id='.$_GPC['khid'], 'success');
	}else{
		message('保存失败！', $urltk.'&op=view&id='.$_GPC['khid'], 'success');
	}
	
}

if($op == "view"){
	
	//查看订单详情
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	$usershow = pdo_get('mc_members', array('uid' => $srdb['uid']));
	
	if($srdb['yguid']){
		//领取会员信息
		$staff_show = pdo_get('cwgl_staff_list', array('id' => $srdb['ygid']));
		//获取头像
		$usershow1 = pdo_get('mc_members', array('uid' => $srdb['yguid']));
	}
	
	include $this->template('admin_userlist_view');

}elseif($op == 'delete'){

	//删除---------------
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_list', array('id' => $id));
		message('删除成功', $urltk.'&op=view&id='.$id, 'success');
	}else{
		message('删除失败', $urltk.'&op=view&id='.$id, 'success');
	}
	
}elseif($op == 'editor'){

	//修改
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk.'&op=view&id='.$id, 'success');
	}
	include $this->template('admin_userlist_editor');
	
}elseif($op == 'setup'){

	//设置服务期限、月费
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk.'&op=view&id='.$id, 'success');
	}
	include $this->template('admin_userlist_setup');
	
}else{

	//列表-------------------------
	//排序
	$ordersc = array($_GPC['ordersc']=>' selected');
	if($_GPC['ordersc']){
		$ordersql = "ORDER BY id ".$_GPC['ordersc'];
	}else{
		$ordersql = "ORDER BY id DESC";
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
	if(!in_array($psize, array(20,50,100))) $psize = 20;
	$perpages = array($psize => ' selected');
	
	$where = '';
	
	if (!empty($_GPC['keyword'])) {
		$where .= " AND ( (compname LIKE '%{$_GPC['keyword']}%') OR (name LIKE '%{$_GPC['keyword']}%') OR (phone LIKE '%{$_GPC['keyword']}%') )";
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_list')." WHERE weid = '{$_W['uniacid']}' and type = '1' {$where}");
	if($total){
		$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_list')." WHERE weid = '{$_W['uniacid']}' and type = '1' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
	include $this->template('admin_userlist');

}