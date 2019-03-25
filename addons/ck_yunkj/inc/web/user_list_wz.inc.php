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
$type = $_GPC['type'];

$urlt = $this->createWebUrl('user_list_wz');

$newtimes =  mktime();

$cwgl_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));

//修改
if(checksubmit('edit_submit')){
	
	$data = array(
		'name' => $_GPC['name'],
		'phone' => $_GPC['phone'],
		'compname' => $_GPC['compname'],
		'message' => $_GPC['message'],
		'payfees' => $_GPC['payfees'],
		'type' => $_GPC['type']
	);
	
	//注册会员期限
	if($_GPC['monthadd']){
		$data['deadline'] =  $_GPC['monthadd']*2592000 + $newtimes;
	}
	
	//保存头像-----------
	if($_GPC['uid'] && $_GPC['avatar']){
		pdo_update('mc_members', array('avatar' => $_GPC['avatar'],'uid' => $_GPC['uid']), array('uniacid' => $_W['uniacid'],'uid' => $_GPC['uid']));
	}
	//------------------
	
	//修改
	if(!empty($_GPC['id'])){
		
		pdo_update('cwgl_user_list', $data, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
		message('修改成功！', $urlt, 'success');
		
	}else{
		message('修改失败！');
	}
	
}

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	$usershow = pdo_get('mc_members', array('uid' => $srdb['uid']));
	
	//领取会员信息
	$staff_show = pdo_get('cwgl_staff_list', array('id' => $srdb['ygid']));
	//获取头像
	$usershow1 = pdo_get('mc_members', array('uid' => $srdb['yguid']));
}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_list', array('id' => $id));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'success');
	}
}

//列表-------------------------
//排序
$ordersc = array($_GPC['ordersc']=>' selected');
if($_GPC['ordersc']){
	$ordersql = "ORDER BY b.id ".$_GPC['ordersc'];
}else{
	$ordersql = "ORDER BY b.id DESC";
}

$pindex = max(1, intval($_GPC['page']));
$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
if(!in_array($psize, array(20,50,100))) $psize = 20;
$perpages = array($psize => ' selected');

$where = '';

if (!empty($_GPC['uid'])) {
	$where .= " AND b.uid = ".intval($_GPC['uid']);
}

if (!empty($_GPC['nickname'])) {
	$where .= " AND a.nickname LIKE '%{$_GPC['nickname']}%'";
}

if (!empty($_GPC['name'])) {
	$where .= " AND b.name LIKE '%{$_GPC['name']}%'";
}

if (!empty($_GPC['phone'])) {
	$where .= " AND b.phone LIKE '%{$_GPC['phone']}%'";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' AND b.type = '0' {$where}");
if($total){
	$list = pdo_fetchall("SELECT a.avatar,a.nickname,b.* FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' AND b.type = '0' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	
}
$pager = pagination($total, $pindex, $psize);

include $this->template('user_list_wz');
?>