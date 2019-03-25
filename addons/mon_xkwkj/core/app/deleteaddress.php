<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$aid = $_GPC['aid'];
pdo_delete(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, array("id" => $aid));
die(json_encode(array('code'=> 200)));





