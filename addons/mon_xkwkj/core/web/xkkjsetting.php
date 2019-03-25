<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');

		$kjsetting = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_SETTING, array(':weid' => $this->weid));
		if (checksubmit('submit')) {
			$data = array(
				'weid' => $this->weid,
				'appid' => trim($_GPC['appid']),
				'appsecret' => trim($_GPC['appsecret']),
				'mchid' => trim($_GPC['mchid']),
				'shkey' => trim($_GPC['shkey']),
				'is_collect_user_info' => $_GPC['is_collect_user_info'],
				'help_kj_limit' => $_GPC['help_kj_limit'],

				'tmp_enable' => $_GPC['tmp_enable'],
				'tmpId' => $_GPC['tmpId'],
				'fh_tmp_enable' => $_GPC['fh_tmp_enable'],
				'fh_tmp_id' => $_GPC['fh_tmp_id'],
				'kf' => $_GPC['kf']
			);
			if (!empty($kjsetting)) {
				DBUtil::updateById(DBUtil::$TABLE_XKWKJ_SETTING, $data, $kjsetting['id']);
			} else {
				DBUtil::create(DBUtil::$TABLE_XKWKJ_SETTING, $data);
			}
			message('参数设置成功！', $this->createWebUrl('XKKjSetting', array(
				'op' => 'display'
			)), 'success');
		}
		include $this->template("kjsetting");