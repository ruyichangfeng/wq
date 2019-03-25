<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

		global $_GPC, $_W;
		foreach ($_GPC['idArr'] as $k => $oid) {
			$id = intval($oid);
			if ($id == 0)
				continue;
			pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("id" => $id));

		}
		echo json_encode(array('code' => 200));