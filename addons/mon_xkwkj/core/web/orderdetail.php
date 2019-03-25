<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$kid = $_GPC['kid'];
$oid = $_GPC['oid'];
$order = DBUtil::findById(DBUtil::$TABLE_XKWJK_ORDER, $oid);
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);
include $this->template("order_detail");
