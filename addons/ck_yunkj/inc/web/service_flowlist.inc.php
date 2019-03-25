<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$op = $_GPC['op'];

$urlt = $this->createWebUrl('service_flowlist');

//操作
if(checksubmit('add_submit') || checksubmit('edit_submit') || checksubmit('addnext_submit')){

	if (empty($_GPC['name'])) {
		message('请输入名称！');
	}
	$data = array(
		'weid' => $_W['uniacid'],
		'pid' => intval($_GPC['pid']),
		'name' => $_GPC['name'],
		'listorder' => intval($_GPC['listorder']),
		'type' => 'lc'
	);

	//添加
	if(checksubmit('add_submit')){
		 pdo_insert('cwgl_staff_class', $data);
		 message('添加成功', $urlt, 'success');
	}
	
	//修改
	if(checksubmit('edit_submit')){
		pdo_update('cwgl_staff_class', $data, array('cid' => $_GPC['cid']));
		message('修改成功', $urlt, 'success');
	}
	
}

//读取
if($op == 'edit'){
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_staff_class', array('cid' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！');
	}	
}

//删除
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_staff_class', array('cid' => $id));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'success');
	}
}

//批量修改
if (checksubmit('listsubmit')) {
	if($_GPC['ids'] && is_array($_GPC['ids']) && $_GPC['optype']) {
		switch ($_GPC['optype']) {
			case '1':
				$ids = $_GPC['ids'];
				$listorder = $_GPC['listorder'];
				$name = $_GPC['name'];
				for($i=0;$i < count($ids); $i++){
					pdo_query("UPDATE ".tablename('cwgl_staff_class')." SET listorder = '{$listorder[$ids[$i]]}',name = '{$name[$ids[$i]]}' WHERE cid = '{$ids[$i]}'");
				}
				break;
		}
		message('批量修改成功', $urlt, 'success');
	}else{
		message('批量修改失败', $urlt, 'success');
	}
}

//列表--------------------
$pindex = max(1, intval($_GPC['page']));
$psize = 12;

$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and pid = '0' and type = 'lc'");
if($total){
	$list = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and pid = '0' and type = 'lc' ORDER BY listorder ASC, cid DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	$pager = pagination($total, $pindex, $psize);
}

include $this->template('service_flowlist');
?>