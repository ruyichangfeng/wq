<?php

defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;


//
// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['title'] = $_POST['title'];
    $data['avatar'] = $_POST['avatar'];
    $data['description'] = $_POST['description'];

    $res = pdo_insert(getTableName('activity'), $data);

    if ($res) {
        message('活动创建成功', $this->createWebUrl('activities'), 'success');
    } else {
        message('活动创建失败');
    }
}



//
// GET
include $this->template('create-activity');
