<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$action = $_GPC['action'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';

if ($action == 'index') {

} elseif ($action == 'store') {

} elseif ($action == 'update') {

} elseif ($action == 'destroy') {

}

if ($page == 'index') {
    include $this->template('web/system/index');
} elseif ($page == 'gongzhonghao') {
    include $this->template('web/system/gongzhonghao');
}
