<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/8/6
 * Time: 15:44
 */
/**
 * Created by wanglu on 2017/8/6.
 */

defined('IN_IA') or exit('Access Denied');


$redid = $_GPC['redid'];

$redirect = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $redid);

$res = array();
if (empty($redirect)) {
    $res['code'] = 500;
    $res['msg'] = "请先定义转发再配置URL";
    die(json_encode($res));
}


$uid = $_GPC['uid'];

$data = array(
    'weid' => $this->weid,
    'urlname' => $_GPC['urlname'],
    'redid' => $redid,
    'url' => $_GPC['url'],
    'is_enable' => $_GPC['is_enable'],
    'display_sort' => 0
);

if (empty($uid)) {
    $data['createtime'] = time();
    DBUtil::create(DBUtil::$TABLE_URLREDIRECT_URL, $data);
    $res['msg'] = "添加转发URL成功";
} else {
    DBUtil::updateById(DBUtil::$TABLE_URLREDIRECT_URL, $data, $uid);
    $res['msg'] = "修改转发URL成功";
}

$res['code'] = 200;

die(json_encode($res));





