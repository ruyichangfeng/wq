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

$uid = $_GPC['uid'];
if (empty($uid)) {
	message('抱歉！UID值为空不能访问！', $this->createWebUrl('user_list'), 'error');
}

$urlt = $this->createWebUrl('user_report')."&uid=".$_GPC['uid'];

//获取配置信息
$mb_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));

$newtimes =  mktime();

//年
$yearhtml = '';
$nowy = date('Y',mktime());
$nowm = date('m',mktime());
for ($i=0; $i<50; $i++) {
	$they = $nowy - $i;
	if($_GPC['years']){
		$selectstr = $they == $_GPC['years']?' selected':'';
	}
	$yearhtml .= "<option value=\"$they\" $selectstr >$they</option>";
}

//月
$monthhtml = '';
for ($i=1; $i<13; $i++) {
	if($_GPC['month']){
		$selectstrm = $i == $_GPC['month']?' selected':'';
	}else{
		$selectstrm = $i == $nowm?' selected':'';
	}
	$monthhtml .= "<option value=\"$i\" $selectstrm >$i</option>";
}

//获取客户信息
$usershow = pdo_get('mc_members', array('uid' => $uid));
$usershow2 = pdo_get('cwgl_user_list', array('uid' => $uid));

//修改
if(checksubmit('add_submit') || checksubmit('edit_submit')){
	
	require_once ('weixin.class.php');
	
	$datapp = array(
		'weid' => $_W['uniacid'],
		'uid' => $uid,
		'years' => $_GPC['years'],
		'month' => $_GPC['month'],
		'message1' => $_GPC['message1'],
		'message2' => $_GPC['message2'],
		'message3' => $_GPC['message3'],
		'message4' => $_GPC['message4'],
		'message5' => $_GPC['message5'],
		'message6' => $_GPC['message6'],
		'message7' => $_GPC['message7'],
		'message8' => $_GPC['message8'],
		'message9' => $_GPC['message9'],
		'message10' => $_GPC['message10'],
		'message11' => $_GPC['message11'],
		'message12' => $_GPC['message12'],
		'message13' => $_GPC['message13'],
		'message14' => $_GPC['message14'],
		'message15' => $_GPC['message15'],
		'message16' => $_GPC['message16'],
		'message17' => $_GPC['message17'],
		'message18' => $_GPC['message18'],
		'message19' => $_GPC['message19'],
		'message20' => $_GPC['message20'],
		'message21' => $_GPC['message21'],
		'message22' => $_GPC['message22'],
		'message23' => $_GPC['message23'],
		'message24' => $_GPC['message24'],
		'message25' => $_GPC['message25'],
		'message26' => $_GPC['message26'],
		'message27' => $_GPC['message27'],
		'message28' => $_GPC['message28'],
		'message29' => $_GPC['message29'],
		'message30' => $_GPC['message30']
	);
	
	//添加
	if(checksubmit('add_submit')){
		
		 //判断是否是相同年月份的报表
		 $srdbkk = pdo_get('cwgl_user_report', array('years' => $_GPC['years'],'month' => $_GPC['month'],'uid' => $uid));
		 if(empty($srdbkk)){
		 	 $datapp['deadline'] =  mktime();
			 $result = pdo_insert('cwgl_user_report', $datapp);
			
			 if (!empty($result)) {
				$idd = pdo_insertid();
				message('保存成功', $urlt, 'success');
			 }else{
				message('添加失败', $urlt, 'success');
			 }
		 }else{
		 	message('抱歉！您添加的月份报表已经存在！请注意查看！', $urlt, 'success');
		 }
		 
		 
		 
	}
	
	//修改
	if(checksubmit('edit_submit')){
		
		if(!empty($_GPC['id'])){
			pdo_update('cwgl_user_report', $datapp, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
			message('修改成功！', $urlt, 'success');
		}else{
			message('修改失败！');
		}
		
	}
	
}

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_report', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	//年
	$yearhtml = '';
	$nowy = date('Y',mktime());
	for ($i=0; $i<100; $i++) {
		$they = $nowy - $i;
		$selectstr = $they == $srdb['years']?' selected':'';
		$yearhtml .= "<option value=\"$they\" $selectstr >$they</option>";
	}
	
	//月
	$monthhtml = '';
	for ($i=1; $i<13; $i++) {
		$selectstr = $i == $srdb['month']?' selected':'';
		$monthhtml .= "<option value=\"$i\" $selectstr >$i</option>";
	}
		
}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_report', array('id' => $id));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'success');
	}
}

//批量删除
if (checksubmit('listsubmit')) {
	if($_GPC['ids'] && is_array($_GPC['ids']) && $_GPC['optype']) {
		switch ($_GPC['optype']) {
			case '1':
				$ids = $_GPC['ids'];
				for($i=0;$i < count($ids); $i++){
					pdo_delete('cwgl_user_report', array('id' => $ids[$i],'weid' => $_W['uniacid']));
				}
			break;
		}
		message('批量删除成功', $urlt, 'success');
	}else{
		message('批量删除失败', $urlt, 'success');
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

if(!empty($_GPC['years'])){
	$where .= " AND years = ".$_GPC['years'];
}

if(!empty($_GPC['month'])){
	$where .= " AND month = ".$_GPC['month'];
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_report')." WHERE weid = '{$_W['uniacid']}' and uid = '{$uid}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_report')." WHERE weid = '{$_W['uniacid']}' and uid = '{$uid}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}

$pager = pagination($total, $pindex, $psize);

include $this->template('user_report');
?>