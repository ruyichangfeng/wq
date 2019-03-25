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

$urlt = $this->createWebUrl('service_list');

//分类列表-------------
$category = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'fw' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category)) {
	$children = '';
	foreach ($category as $cid => $cate) {
		if (!empty($cate['pid'])) {
			$children[$cate['pid']][$cate['cid']] = array($cate['cid'], $cate['name']);
		}
	}
}

//修改
if(checksubmit('add_submit') || checksubmit('edit_submit')){
	
	$data = array(
		'weid' => $_W['uniacid'],
		'titlename' => $_GPC['titlename'],
		'imgurl' => $_GPC['imgurl'],
		'price' => round($_GPC['price'], 2),
		'jianjie' => $_GPC['jianjie'],
		'content' => $_GPC['content'],
		'shelves' => $_GPC['shelves'],
		'type' => $_GPC['type']
	);
	
	//添加
	if(checksubmit('add_submit')){
		 $data['dateline'] =  mktime();
		 $result = pdo_insert('cwgl_service_list', $data);
		
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
	
			pdo_update('cwgl_service_list', $data, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
			message('修改成功！', $urlt, 'success');
			
		}else{
			message('修改失败！');
		}
		
	}
	
}

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
}

//上架
if($op == 'onja'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_update('cwgl_service_list', array('shelves' => 1), array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
		message('上架成功', $urlt, 'success');
	}else{
		message('上架失败', $urlt, 'success');
	}
}

//下架
if($op == 'upja'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_update('cwgl_service_list', array('shelves' => 0), array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
		message('下架成功', $urlt, 'success');
	}else{
		message('下架失败', $urlt, 'success');
	}
}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_service_list', array('id' => $id));
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
					pdo_delete('cwgl_service_list', array('id' => $ids[$i]));
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
	$where .= " AND ( (titlename LIKE '%{$_GPC['keyword']}%') OR (jianjie LIKE '%{$_GPC['keyword']}%') OR (content LIKE '%{$_GPC['keyword']}%') )";
}

$shelves = array($_GPC['sxj']=>' selected');
if($_GPC['sxj'] == 1){
	$where .= " AND shelves = '1'";
}elseif($_GPC['sxj'] == 2){
	$where .= " AND shelves = '0'";
}

$typecla = array($_GPC['type']=>' selected');
if (!empty($_GPC['type'])) {
	$where .= " AND type = ".$_GPC['type'];
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_list')."  WHERE weid = '{$_W['uniacid']}' {$where}");
if($total){
	$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_list')."  WHERE weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
}
$pager = pagination($total, $pindex, $psize);

include $this->template('service_list');
?>