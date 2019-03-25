<?php

global $_W, $_GPC;

if ($_GET['id']) {
    $activity = pdo_get(getTableName('activity'), ['id' => $_GET['id']]);
    $protechPage['title'] = $activity['title'];

    include $this->template('register-terms');
    return true;
}

message('活动不存在');
