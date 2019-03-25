<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

		$cid = $_GPC['cid'];

		if (!empty($cid)) {
			$category = DBUtil::findById(DBUtil::$TABLE_XKWKJ_CATEGORY, $cid);
		}

		if (checksubmit('submit')) {
			$data = array(
				'weid' => $this->weid,
				'typname' => trim($_GPC['typname']),
				'typeicon' => $_GPC['typeicon'],
				'display_sort' => $_GPC['display_sort'],
				'icon_type' => $_GPC['icon_type'],
				'systypeicon' => $_GPC['systypeicon']
			);
			if (!empty($cid)) {
				DBUtil::updateById(DBUtil::$TABLE_XKWKJ_CATEGORY, $data, $cid);
				message('更新类别设置成功！', $this->createWebUrl('categorySetting', array(
					'op' => 'display'
				)), 'success');

			} else {
				DBUtil::create(DBUtil::$TABLE_XKWKJ_CATEGORY, $data);

				message('添加类别设置成功！', $this->createWebUrl('categorySetting', array(
					'op' => 'display'
				)), 'success');
			}

		} else {
			include $this->template("category_edit");
		}




