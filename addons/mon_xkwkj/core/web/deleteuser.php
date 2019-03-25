<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

foreach ($_GPC['idArr'] as $k => $uid) {
	$id = intval($uid);
	if ($id == 0)
		continue;
	pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("uid" => $id));
	pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array("uid" => $id));
	pdo_delete(DBUtil::$TABLE_XKWKJ_USER, array("id" => $id));
}
echo json_encode(array('code' => 200));