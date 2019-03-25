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

$urlt = $this->createWebUrl('user_toushu');

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_toushu', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	//获取公司名称
	$user_comp = pdo_get('cwgl_user_list', array('uid' => $srdb['uid']));
	
	//获取头像
	$usershow = pdo_get('mc_members', array('uid' => $srdb['uid']));

}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_toushu', array('id' => $id));
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
					pdo_delete('cwgl_user_toushu', array('id' => $ids[$i]));
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

if (!empty($_GPC['keyword'])) {
	$where .= " AND ( (titlename LIKE '%{$_GPC['keyword']}%') OR (content LIKE '%{$_GPC['keyword']}%') )";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_toushu')."  WHERE weid = '{$_W['uniacid']}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_toushu')."  WHERE weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize);

include $this->template('user_toushu');
?>