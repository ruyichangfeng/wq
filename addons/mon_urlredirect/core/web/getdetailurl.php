<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/8/6
 * Time: 16:12
 */
/**
 * Created by wanglu on 2017/8/6.
 */
defined('IN_IA') or exit('Access Denied');
$uid = $_GPC['uid'];
$url = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT_URL, $uid);
echo json_encode($url);
