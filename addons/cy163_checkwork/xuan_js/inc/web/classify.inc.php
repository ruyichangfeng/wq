<?php
//商品分类
global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	if (!empty($_GPC['displayorder'])) {
		foreach ($_GPC['displayorder'] as $id => $displayorder) {
			pdo_update('xuan_js_category', array('displayorder' => $displayorder), array('id' => $id));
		}
		message('分类排序更新成功！', $this->createWebUrl('classify', array('op' => 'display')), 'success');
	}
	$children = array();
	$category = m('category')->getList(array('order'=>'parentid asc,displayorder desc','by'=>''));
	foreach ($category as $index => $row) {
		if (!empty($row['parentid'])) {
			$children[$row['parentid']][] = $row;
			unset($category[$index]);
		}
	}
	include $this->template('web/classify'); 
} elseif ($operation == 'post') {
	$parentid = intval($_GPC['parentid']);
	$id = intval($_GPC['id']);
	if (!empty($id)) {
		$category = m('category')->getList(array('fetch'=>1,'id'=>$id));
		$cate=unserialize($category['sheding']);
	} else {
		$category = array(
			'displayorder' => 0,
		);
	}
	if (!empty($parentid)) {
		$parent = pdo_fetch("SELECT id, name FROM " . tablename('xuan_js_category') . " WHERE id = '$parentid'");
		if (empty($parent)) {
			message('抱歉，上级分类不存在或是已经被删除！', $this->createWebUrl('classify'), 'error');
		}
	}
	if (checksubmit('submit')) {
		if (empty($_GPC['catename'])) {
			message('抱歉，请输入分类名称！');
		}
		$cate=array(
			'nametishi'=>$_GPC['nametishi'],
			'number'=>$_GPC['number'],
			'xiala1'=>$_GPC['xiala1'],
			'xiala1name'=>$_GPC['xiala1name'],
			'xiala1tishi'=>$_GPC['xiala1tishi'],
			'xiala1content'=>$_GPC['xiala1content'],
			'xiala2'=>$_GPC['xiala2'],
			'xiala2name'=>$_GPC['xiala2name'],
			'xiala2tishi'=>$_GPC['xiala2tishi'],
			'xiala2content'=>$_GPC['xiala2content'],
			'texttishi'=>$_GPC['texttishi'],
		);

		$data = array(
			'uniacid' => $_W['uniacid'],
			'name' => $_GPC['catename'],
			'enabled' => intval($_GPC['enabled']),
			'displayorder' => intval($_GPC['displayorder']),
			'sheding' => serialize($cate),
			'description' => $_GPC['description'],
			'parentid' => intval($parentid),
			'thumb' => $_GPC['thumb']
		);
		if (!empty($id)) {
			unset($data['parentid']);
			pdo_update('xuan_js_category', $data, array('id' => $id));
			load()->func('file');
			file_delete($_GPC['thumb_old']);
		} else {
			pdo_insert('xuan_js_category', $data);
			$id = pdo_insertid();
		}
		message('更新分类成功！', $this->createWebUrl('classify', array('op' => 'display')), 'success');
	}
	include $this->template('web/classify');
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$category = m('category')->getList(array('fetch'=>1,'id'=>$id));
	if (empty($category)) {
		message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('classify', array('op' => 'display')), 'error');
	}
	pdo_delete('xuan_js_category', array('id' => $id, 'parentid' => $id), 'OR');
	message('分类删除成功！', $this->createWebUrl('classify', array('op' => 'display')), 'success');
}