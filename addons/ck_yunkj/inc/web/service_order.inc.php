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

$urlt = $this->createWebUrl('service_order');

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_order', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	//读取服务信息
	$service_show = pdo_get('cwgl_service_list', array('id' => $srdb['sid'],'weid' => $_W['uniacid']));
	
	//读取客户信息
	$kehu_show = pdo_fetchall("SELECT b.compname FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' and b.uid = '{$srdb['uid']}'");
	
	//领取会员信息
	$staff_show = pdo_get('cwgl_staff_list', array('id' => $srdb['ygid'],'weid' => $_W['uniacid']));
	//获取头像
	$usershow = pdo_get('mc_members', array('uid' => $srdb['yguid'],'uniacid' => $_W['uniacid']));
	
	//读取进度
	$list_progress = pdo_fetchall("SELECT a.name,b.* FROM ".tablename('cwgl_staff_list')." AS a LEFT JOIN ".tablename('cwgl_service_order_progress')." AS b on a.id=b.ygid  WHERE b.weid = '{$_W['uniacid']}' and b.oid='{$id}' ORDER BY b.id ASC");
	
}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_service_order', array('id' => $id,'weid' => $_W['uniacid']));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'success');
	}
}

//批量删除--------------------
if (checksubmit('listsubmit')) {
	if($_GPC['ids'] && is_array($_GPC['ids']) && $_GPC['optype']) {
		switch ($_GPC['optype']) {
			case '1':
				$ids = $_GPC['ids'];
				for($i=0;$i < count($ids); $i++){
					pdo_delete('cwgl_service_order', array('id' => $ids[$i],'weid' => $_W['uniacid']));
				}
				break;
		}
		message('批量删除成功', $urlt, 'success');
	}else{
		message('批量删除失败', $urlt, 'success');
	}
}//--------------------------

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

if (!empty($_GPC['keyword'])) {
	$where .= " AND a.titlename LIKE '%{$_GPC['keyword']}%'";
}

if (!empty($_GPC['orderid'])) {
	$where .= " AND b.orderid LIKE '%{$_GPC['orderid']}%'";
}

if (!empty($_GPC['uid'])) {
	$where .= " AND b.uid =".intval($_GPC['uid']);
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_list')." AS a LEFT JOIN ".tablename('cwgl_service_order')." AS b on a.id=b.sid  WHERE b.weid = '{$_W['uniacid']}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT a.titlename,b.* FROM ".tablename('cwgl_service_list')." AS a LEFT JOIN ".tablename('cwgl_service_order')." AS b on a.id=b.sid  WHERE b.weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize);

include $this->template('service_order');
?>