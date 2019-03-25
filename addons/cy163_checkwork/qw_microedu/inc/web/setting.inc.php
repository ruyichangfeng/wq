<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$action = $_GPC['action'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';

if ($page == 'index') {
    include $this->template('web/setting/index');

} elseif ($page == 'edit') {
    include $this->template('web/setting/edit');
} elseif ($page == 'create') {
    include $this->template('web/setting/create');
}elseif ($page == 'team') {
    include $this->template('web/setting/team');
} elseif ($page == 'team-edit') {
    include $this->template('web/setting/team-edit');
} elseif ($page == 'team-create') {
    include $this->template('web/setting/team-create');
} elseif ($page == 'team-manage') {
    include $this->template('web/setting/team-manage');
}
