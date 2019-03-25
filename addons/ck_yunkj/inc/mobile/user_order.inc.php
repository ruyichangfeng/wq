<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_order');

$op = $_GPC['op'];

if($op == "view"){
	
	//查看订单详情
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_order', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//读取买家信息
	$usershow = pdo_get('cwgl_user_list', array('uid' => $srdb['uid'],'weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
	
	//读取购买的服务
	$service_show = pdo_get('cwgl_service_list', array('id' => $srdb['sid'],'weid' => $_W['uniacid']));
	
	include $this->template('user_order_view');

}elseif($op == "progress"){
	
	//订单进度管理
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_order', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//读取购买的服务
	$service_show = pdo_get('cwgl_service_list', array('id' => $srdb['sid'],'weid' => $_W['uniacid']));
	
	//读取订单进度
	$list_progress = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_order_progress')." WHERE weid = '{$_W['uniacid']}' and oid = '{$id}' ORDER BY dateline ASC,id ASC ");
	
	include $this->template('user_order_progress');
		
}elseif($op == "delete"){
	
	//删除未付款的订单
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_service_order', array('id' => $id,'weid' => $_W['uniacid']));
		pdo_delete('cwgl_order_inom', array('did' => $id,'type' => 'fw','weid' => $_W['uniacid']));
		message('删除成功', $urltk, 'success');
	}else{
		message('删除失败', $urltk, 'success');
	}
		
}elseif($op == "qrsh"){
	
	//确认收货
	$id = intval($_GPC['id']);
	if (empty($id)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//存入
	pdo_update('cwgl_service_order', array('qrgoods' => 1), array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
	
	message('操作成功！', $urltk, 'success');
		
}elseif($op == "wypj"){
	
	//评价订单
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_order', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//获取接单信息
	$profile_t = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $srdb['yguid']));
	
	//添加
	if(checksubmit('save_submit')){
		
		$data = array(
			'weid' => $_W['uniacid'],
			'uid' => $_W['member']['uid'],
			'ygid' => $profile_t['id'],
			'yguid' => $profile_t['uid'],
			'did' => $id,
			'sid' => $srdb['sid'],
			'pfscore' => intval($_GPC['pfscore']),
			'fwattitude' => intval($_GPC['fwattitude']),
			'fwspeed' => intval($_GPC['fwspeed']),
			'content' => $_GPC['content'],
			'dateline' => mktime()
		);
		
		$result = pdo_insert('cwgl_staff_bpf', $data);
		
		if (!empty($result)) {
			//修改评价状态
	        pdo_update('cwgl_service_order', array('pjstate' => 1), array('id' => $id,'weid' => $_W['uniacid']));
			message('评价成功！', $urltk, 'success');
		}else{
			message('评价失败！', $urltk, 'success');
		}
		
	}
	
	include $this->template('user_order_wypj');
		
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
		$where .= " AND a.yguid != '0' AND a.paystatus = '1' and a.ygcomplete = '0'";
	}elseif($_GPC['type']==2){
		$where .= " AND a.yguid != '0' AND a.paystatus = '1' and a.ygcomplete = '1'";
	}else{
		$where .= " AND a.yguid = '0'";
	}
	
	if (!empty($_GPC['keyword'])) {
		$where .= " AND ( (b.compname LIKE '%{$_GPC['keyword']}%') OR (a.orderid LIKE '%{$_GPC['keyword']}%') OR (p.titlename LIKE '%{$_GPC['keyword']}%') )";
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_order')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid LEFT JOIN ".tablename('cwgl_service_list')." AS p on a.sid=p.id WHERE a.weid = '{$_W['uniacid']}' and a.uid = '{$_W['member']['uid']}' {$where}");
	if($total){
		$list = pdo_fetchall("SELECT a.*,b.compname,p.titlename,p.imgurl FROM ".tablename('cwgl_service_order')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid LEFT JOIN ".tablename('cwgl_service_list')." AS p on a.sid=p.id WHERE a.weid = '{$_W['uniacid']}' and a.uid = '{$_W['member']['uid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
	include $this->template('user_order');

}