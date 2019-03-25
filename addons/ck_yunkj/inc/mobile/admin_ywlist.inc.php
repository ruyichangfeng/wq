<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "admin_common.php";

$urltk = $this->createMobileUrl('admin_ywlist');

$op = $_GPC['op'];

//分类列表-------------
$category = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'yw' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category)) {
	$children = '';
	foreach ($category as $cid => $cate) {
		if (!empty($cate['pid'])) {
			$children[$cate['pid']][$cate['cid']] = array($cate['cid'], $cate['name']);
		}
	}
}

if($op == "view"){
	
	//查看订单详情
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_ywlist', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//读取客户信息
	$kehu_show = pdo_fetchall("SELECT b.compname FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' and b.uid = '{$srdb['uid']}'");
	
	//获取接单信息
	if($srdb['yguid']){
		$profile_t = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $srdb['yguid']));
	}
	
	//读取订单进度
	$list_progress = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_ywlist_progress')." WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' and syid = '{$id}' ORDER BY dateline ASC,id ASC ");
	
	include $this->template('admin_ywlist_view');

}else{

	//列表-------------------------
	//排序
	$ordersc = array($_GPC['ordersc']=>' selected');
	if($_GPC['ordersc']){
		$ordersql = "ORDER BY a.id ".$_GPC['ordersc'];
	}else{
		$ordersql = "ORDER BY a.id DESC";
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
	if(!in_array($psize, array(20,50,100))) $psize = 20;
	$perpages = array($psize => ' selected');
	
	$where = '';
	
	if ($_GPC['type']==1) {
		$where .= " and a.yguid != '0' and a.succeed = '0'";
	}elseif($_GPC['type']==2){
		$where .= " and a.yguid != '0' and a.succeed = '1'";
	}else{
		$where .= " and a.yguid = '0'";
	}
	
	if (!empty($_GPC['keyword'])) {
		$where .= " AND ( (b.compname LIKE '%{$_GPC['keyword']}%') OR (a.content LIKE '%{$_GPC['keyword']}%') )";
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_ywlist')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE a.weid = '{$_W['uniacid']}' {$where}");
	if($total){
		$list = pdo_fetchall("SELECT a.*,b.compname FROM ".tablename('cwgl_service_ywlist')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid WHERE a.weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
	include $this->template('admin_ywlist');

}