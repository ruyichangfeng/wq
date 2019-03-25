<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:25
 */

defined('IN_IA') or exit('Access Denied');

$kid = $_GPC['kid'];
$show_index_enable = $_GPC['show_index_enable'];
DBUtil::updateById(DBUtil::$TABLE_XKWKJ,
	array("show_index_enable"=>$show_index_enable), $kid);
echo json_encode(array("code" => 200));