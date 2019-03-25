<?php

defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;

$activities = pdo_getall(getTableName('activity'));

include $this->template('activities');
