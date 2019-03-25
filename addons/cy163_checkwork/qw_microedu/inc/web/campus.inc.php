<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$page = isset($_GPC['page']) && !isset($_GPC['action']) ? $_GPC['page'] : 'index';

// 校区首页（列表页）
if ($page == 'index') {
    $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE uniacid=:uniacid ORDER BY id ASC";
    $campuses = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

    include $this->template('web/campus/index');

// 添加校区
} elseif ($page == 'create') {
    if (!empty($_POST)) {
        $name = $_GPC['name'];
        $address = $_GPC['address'];
        $enabled = $_GPC['enabled'];

        pdo_insert('qw_microedu_campuses', array(
            'uniacid' => $_W['uniacid'],
            'name' => $name,
            'address' => $address,
            'enabled' => $enabled,
        ));

        message('校区添加成功', $this->createWebUrl('campus'), 'success');
    }

    include $this->template('web/campus/create');

// 编辑校区
} elseif ($page == 'edit') {
    if (!empty($_POST)) {
        $id = $_GPC['id'];
        $name = $_GPC['name'];
        $address = $_GPC['address'];
        $enabled = $_GPC['enabled'];

        validateData($name, $address);

        pdo_update('qw_microedu_campuses', array(
            'name' => $name, 'address' => $address, 'enabled' => $enabled
        ), array('id' => $id, 'uniacid' => $_W['uniacid']));

        message('校区修改成功', $this->createWebUrl('campus'), 'success');
    }

    $id = $_GPC['id'];
    $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE id=?";
    $campus = pdo_fetch($sql, array($id));

    if (!$campus) message('校区不存在', $this->createWebUrl('campus'), 'error');

    include $this->template('web/campus/edit');

// 搜索校区
} elseif ($page == 'search') {
    if (empty($_GPC['name']) && empty($_GPC['address'])) {
        message('请输入搜索条件', 'referer', 'error');
    }

    $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE uniacid=:uniacid AND name LIKE :name AND address LIKE :address ORDER BY id ASC";
    $campuses = pdo_fetchall($sql, array(
        ':uniacid' => $_W['uniacid'],
        ':name' => '%' . $_GPC['name'] . '%',
        ':address' => '%' . $_GPC['address'] . '%',
    ));

    include $this->template('web/campus/index');

// 禁用课程
} elseif ($page == 'disable') {
    // POST method.
    if (!empty($_POST)) {
        // Disabling Classes
        if (!empty($_GPC['tobedisabledclasses']))  {
            $campus_id = $_GPC['campus_id'];
            $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE id=?";
            $campus = pdo_fetch($sql, array($campus_id));

            if (!$campus) message('校区不存在', $this->createWebUrl('campus'), 'error');

            $tobedisabledclasses = $_GPC['tobedisabledclasses'];
            foreach ($tobedisabledclasses as $tobedisabledclass) {
                $sql = pdo_insert('qw_microedu_campuscannotschedule', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'campus_id'         =>          $campus_id,
                    'contractclass_id'  =>          $tobedisabledclass
                ));
            }

            message('课程禁用成功', 'referer', 'success');
        }

        // Re-enabling Classes
        if (!empty($_GPC['tobeenabledclasses'])) {
            $campus_id = $_GPC['campus_id'];
            $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE id=?";
            $campus = pdo_fetch($sql, array($campus_id));

            if (!$campus) message('校区不存在', $this->createWebUrl('campus'), 'error');

            $tobeenabledclasses = $_GPC['tobeenabledclasses'];
            foreach ($tobeenabledclasses as $tobeenabledclass) {
                $sql = pdo_delete('qw_microedu_campuscannotschedule', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'campus_id'         =>          $campus_id,
                    'contractclass_id'  =>          $tobeenabledclass
                ));
            }

            message('选中课程已重新启用', 'referer', 'success');
        }
    }

    // GET method. Displaying page.
    // 1. Get the campus info
    $id = $_GPC['id'];
    $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE id=?";
    $campus = pdo_fetch($sql, array($id));

    if (!$campus) message('校区不存在', $this->createWebUrl('campus'), 'error');

    // 2. Get already disabled classes
    $sql = "SELECT campuscannotschedule.id, " .
                " campuscannotschedule.campus_id, " .
                " campuscannotschedule.contractclass_id, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_campuscannotschedule') .
                " AS campuscannotschedule JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " campuscannotschedule.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE campuscannotschedule.uniacid=:uniacid AND " .
                " campuscannotschedule.campus_id=:id";

    $disabled_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));

    // 3. Get enabled classes
    $sql = "SELECT contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE contractsclasses.uniacid=:uniacid AND " .
                " contractsclasses.id NOT IN " .
                " (SELECT contractclass_id FROM " .
                tablename('qw_microedu_campuscannotschedule') .
                " WHERE campus_id=:id )";

    $enabled_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));

    include $this->template('web/campus/disable');

// Search Disabled Class
} elseif ($page == "disable-search-disabled") {
    $id = $_GPC['campus_id'];
    $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE id=?";
    $campus = pdo_fetch($sql, array($id));

    if (!$campus) message('校区不存在', $this->createWebUrl('campus'), 'error');

    // Get disabled classes according to search critiria
    if (empty($_GPC['disabled_condition'])) {
        message('请输入搜索条件', 'referer', 'error');
    }

    $sql = "SELECT campuscannotschedule.id, " .
                " campuscannotschedule.campus_id, " .
                " campuscannotschedule.contractclass_id, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_campuscannotschedule') .
                " AS campuscannotschedule JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " campuscannotschedule.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE campuscannotschedule.uniacid=:uniacid AND " .
                " campuscannotschedule.campus_id=:id AND " .
                " (contractsclasses.class_name LIKE :condition " .
                " OR contracts.contract_name LIKE :condition)";

    $disabled_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $_GPC['campus_id'],
        ':condition'       =>          '%' . $_GPC['disabled_condition'] . '%'
    ));

    // Get enabled classes AS IS
    $sql = "SELECT contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE contractsclasses.uniacid=:uniacid AND " .
                " contractsclasses.id NOT IN " .
                " (SELECT contractclass_id FROM " .
                tablename('qw_microedu_campuscannotschedule') .
                " WHERE campus_id=:id )";

    $enabled_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));

    include $this->template('web/campus/disable');

// Search Enabled Classes
} elseif($page == "disable-search-enabled") {
    $id = $_GPC['campus_id'];
    $sql = "SELECT * FROM " . tablename('qw_microedu_campuses') . " WHERE id=?";
    $campus = pdo_fetch($sql, array($id));

    if (!$campus) message('校区不存在', $this->createWebUrl('campus'), 'error');

    // Get Enabled Classes According To Search Critiria
    if (empty($_GPC['enabled_condition'])) {
        message('请输入搜索条件', 'referer', 'error');
    }

    $sql = "SELECT contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE contractsclasses.uniacid=:uniacid AND " .
                " contractsclasses.id NOT IN " .
                " (SELECT contractclass_id FROM " .
                tablename('qw_microedu_campuscannotschedule') .
                " WHERE campus_id=:id )" .
                " AND (contractsclasses.class_name LIKE :condition " .
                " OR contracts.contract_name LIKE :condition)";

    $enabled_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id,
        ':condition'       =>          '%' . $_GPC['enabled_condition'] . '%'
    ));

    // Get disabled classes AS IS
    $sql = "SELECT campuscannotschedule.id, " .
                " campuscannotschedule.campus_id, " .
                " campuscannotschedule.contractclass_id, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_campuscannotschedule') .
                " AS campuscannotschedule JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " campuscannotschedule.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE campuscannotschedule.uniacid=:uniacid AND " .
                " campuscannotschedule.campus_id=:id";

    $disabled_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));

    include $this->template('web/campus/disable');

}

function validateData($name, $address) {
    // if (empty(trim($name))) {
    if(!trime($name)) {
        message('请输入校区名称', 'referer', 'error');
    }

    if (mb_strlen($name) > 10) {
        message('校区名称不得超过10个字', 'referer', 'error');
    }

    if (mb_strlen($address) > 300) {
        message('校区地址不得超过300个字', 'referer', 'error');
    }
}
