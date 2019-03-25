<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/8/21
 * Time: 22:26
 */


$gid = $_GPC['gid'];

if (!empty($gid)) {
	$goods = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_GOODS, array(":id" => $gid));
}

if (checksubmit('submit')) {
	$data = array(
		'weid' => $this->weid,
		'p_name' => $_GPC['p_name'],
		'p_pic' => $_GPC['p_pic'],
		'p_preview_pic' => $_GPC['p_preview_pic'],
		'p_url' => $_GPC['p_url'],
	);

	if (empty($gid)) {
		$data['createtime'] = TIMESTAMP;
		DBUtil::create(DBUtil::$TABLE_XKWKJ_GOODS, $data);
		message('添加商品成功！', $this->createWebUrl('goodsManage', array(
			'op' => 'display'
		)), 'success');
	} else {

		DBUtil::updateById(DBUtil::$TABLE_XKWKJ_GOODS, $data, $gid);
		message('更新商品成功！', $this->createWebUrl('goodsManage', array(
			'op' => 'display'
		)), 'success');
	}
}

include $this->template("goods_edit");