<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$uid = $_GPC['uid'];
$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $uid);
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $user['kid']);
$friends = array();
if (!empty($uid)) {
	$sql = "select nickname as user_name, ac as action, kname as seq_name ,kd as seq_weapon, k_price as amount, createtime as time, headimgurl as avatar from"
		. tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " where uid=:uid order by createtime desc  limit 0,".$xkwkj['rank_num'];
	$friends = pdo_fetchall($sql, array(":uid" => $uid));
}

$res = array();
$res["Status"] = 1;
$res["Message"] = "";
$res["Data"] = $friends;
die(json_encode($res));