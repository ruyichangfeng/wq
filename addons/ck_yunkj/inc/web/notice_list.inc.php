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

$urlt = $this->createWebUrl('notice_list');

$newtimes = mktime();

//操作
if(checksubmit('add_submit') || checksubmit('edit_submit')){

	if (empty($_GPC['titlename'])) {
		message('请输入公告标题！');
	}

	$data = array(
		'weid' => $_W['uniacid'],
		'titlename' => $_GPC['titlename'],
		'message' => $_GPC['message'],
		'listorder' => $_GPC['listorder']
	);
	
	//添加
	if(checksubmit('add_submit')){
		 $data['dateline'] = mktime();
		 pdo_insert('cwgl_notice_list', $data);
		 message('添加成功', $urlt, 'success');
	}
	
	//修改
	if(checksubmit('edit_submit')){
		pdo_update('cwgl_notice_list', $data, array('id' => $_GPC['idd']));
		message('修改成功', $urlt, 'success');
	}
	
}

//读取
if($op == 'edit'){
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_notice_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！');
	}
	
}

//删除
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_notice_list', array('id' => $id));
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
				$listorder = $_GPC['listorder'];
				for($i=0;$i < count($ids); $i++){
					pdo_delete('cwgl_notice_list', array('id' => $ids[$i]));
				}
				break;
		}
		message('批量删除成功', $urlt, 'success');
	}else{
		message('批量删除失败', $urlt, 'success');
	}
}

//列表--------------------
$pindex = max(1, intval($_GPC['page']));
$psize = 12;

$list = pdo_fetchall("SELECT * FROM " . tablename('cwgl_notice_list') . " WHERE weid = '{$_W['uniacid']}' ORDER BY listorder ASC,id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cwgl_notice_list') . " WHERE weid = '{$_W['uniacid']}'");
$pager = pagination($total, $pindex, $psize);

include $this->template('notice_list');
?>