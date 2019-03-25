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
$op = $_GPC['op'];

$urlt = $this->createWebUrl('admin_list');

//修改
if(checksubmit('add_submit') || checksubmit('edit_submit')){
	
	$data = array(
		'weid' => $_W['uniacid'],
		'type' => $_GPC['type'],
		'username' => $_GPC['username']
	);
	
	if(!empty($_GPC['password'])){
		$data['password'] = md5($_GPC['password']);
	}
	
	//保存头像-----------
	if($_GPC['uid'] && $_GPC['avatar']){
		pdo_update('mc_members', array('avatar' => $_GPC['avatar'],'uid' => $_GPC['uid']), array('uniacid' => $_W['uniacid'],'uid' => $_GPC['uid']));
	}
	//------------------
	
	//添加
	if(checksubmit('add_submit')){
		
		 $result = pdo_insert('cwgl_admin', $data);
		
		 if (!empty($result)) {
			$idd = pdo_insertid();
			message('保存成功', $urlt, 'success');
		 }else{
			message('添加失败', $urlt, 'success');
		 }
		 
	}
	
	//修改
	if(checksubmit('edit_submit')){
		
		if(!empty($_GPC['id'])){
	
			pdo_update('cwgl_admin', $data, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
			message('修改成功！', $urlt, 'success');
			
		}else{
			message('修改失败！');
		}
		
	}
	
}

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_admin', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	//绑定公众号后读取头像
	if($srdb['uid']){
		$profile = pdo_get('mc_members', array('uniacid' => $_W['uniacid'],'uid' => $srdb['uid']));
	}
}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_admin', array('id' => $id));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'success');
	}
}

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

if (!empty($_GPC['type'])) {
	$where .= " AND type = ".intval($_GPC['type']);
}

if (!empty($_GPC['id'])) {
	$where .= " AND id = ".intval($_GPC['id']);
}

if (!empty($_GPC['name'])) {
	$where .= " AND username LIKE '%{$_GPC['username']}%'";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_admin')."  WHERE weid = '{$_W['uniacid']}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_admin')."  WHERE weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize);

include $this->template('admin_list');
?>