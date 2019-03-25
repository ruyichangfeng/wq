<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:40
 */
defined('IN_IA') or exit('Access Denied');
		foreach ($_GPC['idArr'] as $k => $kid) {
			$id = intval($kid);
			if ($id == 0)
				continue;
			pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("kid" => $id));
			pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array("kid" => $id));
			pdo_delete(DBUtil::$TABLE_XKWKJ_USER, array("kid" => $id));
			pdo_delete(DBUtil::$TABLE_XKWKJ, array('id' => $id));
		}
		echo json_encode(array('code' => 200));