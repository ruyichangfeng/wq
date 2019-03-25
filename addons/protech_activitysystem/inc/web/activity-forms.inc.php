<?php

defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;

if ($_GET['id']) {
    $forms = pdo_getall(getTableName('activity_forms'), ['activity_id' => $_GET['id']]);
    $activity = pdo_get(getTableName('activity'), ['id' => $_GET['id']]);

    include $this->template('activity-forms');
    return true;
}

message('操作失败');
