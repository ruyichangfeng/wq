<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$action = $_GPC['action'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';

// 课时列表
if ($page == 'index') {
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_classhours') .
                " WHERE uniacid=:uniacid ORDER BY id ASC";
    $classhours = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

    include $this->template('web/period/index');

// 创建课时
} elseif ($page == 'create') {
    if (!empty($_POST)) {
        $classhour_name = $_GPC['period-name'];
        $classhour_description = $_GPC['period-add'];

        validateData($classhour_name, $classhour_description);

        pdo_insert('qw_microedu_classhours', array(
            'uniacid'                   =>      $_W['uniacid'],
            'classhour_name'            =>      $classhour_name,
            'classhour_description'     =>      $classhour_description
        ));

        message('课时添加成功', $this->createWebUrl('period'), 'success');
    }
    include $this->template('web/period/create');

// 编辑课时
} elseif ($page == 'edit') {
    if (!empty($_POST)) {
        $id = $_GPC['id'];
        $classhour_name = $_GPC['period-name'];
        $classhour_description = $_GPC['period-add'];

        validateData($classhour_name, $classhour_description);

        pdo_update('qw_microedu_classhours',
        array(
            'classhour_name'            =>          $classhour_name,
            'classhour_description'     =>          $classhour_description
        ),
        array(
            'id'                        =>          $id,
            'uniacid'                   =>          $_W['uniacid']
        ));

        message('课时修改成功', $this->createWebUrl('period'), 'success');
    }

    $id = $_GPC['id'];
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_classhours') .
                " WHERE id=?";
    $classhour = pdo_fetch($sql, array($id));

    if (!$classhour) message('该课时类型不存在', $this->createWebUrl('period'), 'error');

    include $this->template('web/period/edit');

// 搜索课时
} elseif ($page == 'search') {
    if (empty($_GPC['search-period-name'])) {
        message('请输入搜索条件', 'referer', 'error');
    }

    $sql = "SELECT * FROM " .
                tablename('qw_microedu_classhours') .
                " WHERE uniacid=:uniacid AND " .
                " classhour_name LIKE :classhour_name" .
                " ORDER BY id ASC";

    $classhours = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':classhour_name'   =>          '%' . $_GPC['search-period-name'] . '%'
    ));

    include $this->template('web/period/index');

// 删除课时
} elseif ($page == 'delete') {
    if (!empty($_GPC['id'])) {
        // 检查该课时是否被应用与合同中
        $sql = "SELECT * FROM " .
                    tablename('qw_microedu_contractsclasshours') .
                    " WHERE uniacid=:uniacid AND " .
                    " classhour_id=:classhour_id";

        $classhours = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':classhour_id'     =>          $_GPC['id']
        ));

        if (empty($classhours)) {
            // 该课时类型没有包含在任何合同中，可以删除
            $result = pdo_delete('qw_microedu_classhours', array(
                'uniacid'           =>      $_W['uniacid'],
                'id'                =>      $_GPC['id']
            ));
            if(!empty($result)) {
                message('课时删除成功', $this->createWebUrl('period'), 'success');
            }
        } else {
            message('该课时已被应用与合同中，请删除相应合同后再试。', 'referer', 'error');
        }
    }
}

function validateData($classhour_name, $classhour_description) {
    if (empty($classhour_name)) {
        message('请输入课时名称', 'referer', 'error');
    }

    if (mb_strlen($classhour_description) > 50) {
        message('课时简介不得超过50', 'referer', 'error');
    }
}
