<?php

defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;



//
// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['activity_id'] = $_GET['id'];
    $data['name'] = $_POST['name'];
    $data['gender'] = $_POST['gender'];
    $data['phone'] = $_POST['phone'];
    $data['remark'] = $_POST['remark'];

    $res = pdo_insert(getTableName('activity_form'), $data);

    if ($res) {
        $url = '/app/' . $this->createMobileUrl('complete');
        header('Location: ' . $url);
    } else {
        message('活动报名失败');
    }
}


message('请求错误');
