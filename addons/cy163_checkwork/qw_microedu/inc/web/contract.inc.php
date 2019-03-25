<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$action = $_GPC['action'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';


// 合同首页（列表页）
if ($page == 'index') {
    $sql = "SELECT * FROM " . tablename('qw_microedu_contracts') . " WHERE uniacid=:uniacid ORDER BY id ASC";
    $contracts = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

    include $this->template('web/contract/index');

// 添加合同
} elseif ($page == 'create') {
    if (!empty($_POST)) {
        $contract_name = $_GPC['contract-name'];
        $contract_description = $_GPC['contract-detail'];
        $contract_price = $_GPC['contract-price'];
        $contract_duration = $_GPC['contract-time'];
        validateData($contract_name,
                        $contract_description,
                        $contract_price,
                        $contract_duration);

        pdo_insert('qw_microedu_contracts', array(
            'uniacid' => $_W['uniacid'],
            'contract_name' => $contract_name,
            'contract_description' => html_entity_decode($contract_description),
            'contract_price' => $contract_price,
            'contract_duration' => $contract_duration
        ));

        message('合同添加成功', $this->createWebUrl('contract'), 'success');
    }

    include $this->template('web/contract/create');

// 编辑合同
} elseif ($page == 'edit') {
    if (!empty($_POST)) {
        $id = $_GPC['id'];
        $contract_name = $_GPC['contract-name'];
        $contract_description = $_GPC['contract-detail'];
        $contract_price = $_GPC['contract-price'];
        $contract_duration = $_GPC['contract-time'];

        validateData($contract_name, $contract_description, $contract_price, $contract_duration);

        pdo_update('qw_microedu_contracts',
            array(
                'contract_name'             =>      $contract_name,
                'contract_description'      =>      html_entity_decode($contract_description),
                'contract_price'            =>      $contract_price,
                'contract_duration'         =>      $contract_duration
            ),
            array(
                'id'        =>      $id,
                'uniacid'   =>      $_W['uniacid']
            ));

        message('合同修改成功', $this->createWebUrl('contract'), 'success');
    }

    $id = $_GPC['id'];
    $sql = "SELECT * FROM "
                . tablename('qw_microedu_contracts')
                . " WHERE id=?";
    $contract = pdo_fetch($sql, array($id));

    if (!$contract) message('该教师不存在', $this->createWebUrl('contract'), 'error');

    include $this->template('web/contract/edit');

// 搜索合同
} elseif ($page == 'search') {
    if (empty($_GPC['search-contract-name'])) {
        message('请输入搜索条件', 'referer', 'error');
    }

    $sql = "SELECT * FROM " .
                tablename('qw_microedu_contracts') .
                " WHERE uniacid=:uniacid AND " .
                " contract_name LIKE :contract_name " .
                " ORDER BY id ASC";

    $contracts = pdo_fetchall($sql, array(
        ':uniacid' => $_W['uniacid'],
        ':contract_name' => '%' . $_GPC['search-contract-name'] . '%'
    ));

    include $this->template('web/contract/index');

// 删除合同
} elseif ($page == 'delete') {
    if (!empty($_GPC['id'])) {
        // 1. 合同包含课时的情况已经在课时管理中检查过
        // 2. 检查该合同是否包含课程
        $sql = "SELECT * FROM " .
                    tablename('qw_microedu_contractsclasses') .
                    " WHERE uniacid=:uniacid AND " .
                    " contract_id=:contract_id";

        $classes = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':contract_id'      =>          $_GPC['id']
        ));

        if (empty($classes)) {
            // 2. 该合同不包含任何课程
            // 3. 检查该合同是否被签订过
            $sql = "SELECT * FROM " .
                        tablename('qw_microedu_parentscontracts') .
                        " WHERE uniacid=:uniaicd AND " .
                        " contract_id=:contract_id";

            $parentscontracts = pdo_fetchall($sql, array(
                ':uniacid'          =>          $_W['uniacid'],
                ':contract_id'      =>          $_GPC['id']
            ));

            if (empty($parentscontracts)) {
                // 3. 该合同从未被签订过，可以删除
                // 4. 删除contractclasshours中
                //  所有该contract的课时链接记录
                $result = pdo_delete('qw_microedu_contractsclasshours', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'contract_id'       =>          $_GPC['id']
                ));

                // 5. 删除合同本身
                $result = pdo_delete('qw_microedu_contracts', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'id'                =>          $_GPC['id']
                ));
                if(!empty($result)) {
                    message('合同删除成功', $this->createWebUrl('contract'), 'success');
                }
            } else {
                message('该合同已被客户签订过，不能删除。', 'referer', 'error');
            }
        } else {
            message('该合同已包含课程，请删除相应课程后再试。', 'referer', 'error');
        }

        message('合同删除失败', 'referer', 'error');
    }

// 管理课时
} elseif ($page == 'period') {
    // 通过POST方式添加课时
    if (!empty($_POST)) {
        $id = $_GPC['id'];
        $classhour_id = $_GPC['classhour_id'];
        $classhour_amount = $_GPC['classhour_amount'];

        // 检查POST参数
        if (!empty($classhour_amount)) {
            if (!is_numeric($classhour_amount) || (floor($classhour_amount) != $classhour_amount))
            {
                message('课时时长必须为整数', 'referer', 'error');
            }
        } else {
            message('请输入课时时长', 'referer', 'error');
        }

        pdo_insert('qw_microedu_contractsclasshours', array(
            'uniacid'           =>          $_W['uniacid'],
            'contract_id'       =>          $id,
            'classhour_id'      =>          $classhour_id,
            'amount'            =>          $classhour_amount
        ));

        message('课时添加成功', 'referer', 'success');
    }

    // 通过GET方式显示课时管理页面
    $id = $_GPC['id'];

    // 1. 获取指定合同
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_contracts') .
                " WHERE uniacid=:uniacid AND " .
                " id=:id";
    $contract = pdo_fetch($sql, array(
        ':uniacid'           =>          $_W['uniacid'],
        ':id'                =>          $id
    ));
    if (!$contract) message('该合同不存在', $this->createWebUrl('contract'), 'error');

    // 2. 获取所有课时类型
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_classhours') .
                " WHERE uniacid=:uniacid";
    $classhours = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid']
    ));

    // 3. 获取该合同已经包含的课时类型
    // Oh how I fucking love redundent code.
    $sql = "SELECT classhours.classhour_name, " .
                    " contractsclasshours.id, " .
                    " contractsclasshours.amount FROM " .
                    tablename('qw_microedu_contractsclasshours') .
                    " AS contractsclasshours JOIN " .
                    tablename('qw_microedu_classhours') .
                    " AS classhours ON ".
                    " contractsclasshours.classhour_id = classhours.id " .
                    " WHERE classhours.uniacid=:classhours_uniacid AND " .
                    " contractsclasshours.uniacid=:contractsclasshours_uniacid AND " .
                    " contractsclasshours.contract_id=:id";
    $contractclasshours = pdo_fetchall($sql, array(
        ':classhours_uniacid'               =>      $_W['uniacid'],
        ':contractsclasshours_uniacid'      =>      $_W['uniacid'],
        ':id'                               =>      $id
    ));

    include $this->template('web/contract/period');

// 课时管理 - 删除课时
} elseif ($page == 'period_delete') {
    if (!empty($_GPC['contractsclasshours_id'])) {
        $result = pdo_delete('qw_microedu_contractsclasshours', array(
            'uniacid'           =>          $_W['uniacid'],
            'id'                =>          $_GPC['contractsclasshours_id']
        ));
        if (!empty($result)) {
            message('该课时类型已经从此合同中移除', 'referer', 'success');
        } else {
            message('删除失败', 'referer', 'error');
        }
    }

// 管理课程
} elseif ($page == 'class') {
    // 通过POST请求添加课程
    if (!empty($_POST)) {
        $id = $_GPC['id'];
        $class_name = $_GPC['class_name'];
        $class_description = $_GPC['class_description'];
        $class_level = $_GPC['class_level'];

        // 检查POST参数
        if (empty($class_name) ||
                empty($class_description) ||
                empty($class_level)) {
            message('请完成表单内容', 'referer', 'error');
        }

        pdo_insert('qw_microedu_contractsclasses', array(
            'uniacid'               =>          $_W['uniacid'],
            'contract_id'           =>          $id,
            'class_name'            =>          $class_name,
            'class_description'     =>          $class_description,
            'class_level'           =>          $class_level
        ));

        message('课程添加成功', 'referer', 'success');
    }

    // 通过GET请求显示列表页面
    $id = $_GPC['id'];

    // 1. 获取指定合同
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_contracts') .
                " WHERE uniacid=:uniacid AND " .
                " id=:id";
    $contract = pdo_fetch($sql, array(
        ':uniacid'           =>          $_W['uniacid'],
        ':id'                =>          $id
    ));
    if (!$contract) message('该合同不存在', $this->createWebUrl('contract'), 'error');

    // 2. 获取指定合同所包含的课程
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_contractsclasses') .
                " WHERE uniacid=:uniacid AND " .
                " contract_id=:contract_id";

    $contractsclasses = pdo_fetchall($sql, array(
        'uniacid'           =>          $_W['uniacid'],
        'contract_id'       =>          $id
    ));

    include $this->template('web/contract/class');

// 管理课程 - 编辑课程
}elseif ($page == 'class_edit') {
    // 通过POST更新合同课程
    if (!empty($_POST)) {
        $id = $_GPC['contractclass_id'];
        $class_name = $_GPC['class_name'];
        $class_description = $_GPC['class_description'];
        $class_level = $_GPC['class_level'];

        // 检查POST参数
        if (empty($class_name) || empty($class_level)) {
            message('请输入课程名及课程等级', 'referer', 'error');
        }
        if (mb_strlen($class_name) > 100 || mb_strlen($class_level) > 100) {
            message('课程名及课程等级不得超过100个字符', 'referer', 'error');
        }
        if (mb_strlen($class_description) > 10000) {
            message('课程简介不得超过10000个字符', 'referer', 'error');
        }

        pdo_update('qw_microedu_contractsclasses',
            array(
                'class_name'             =>      $class_name,
                'class_description'      =>      html_entity_decode($class_description),
                'class_level'            =>      $class_level
            ),
            array(
                'id'        =>      $id,
                'uniacid'   =>      $_W['uniacid']
            ));

        message('课程修改成功', $this->createWebUrl('contract'), 'success');
    }

    // 通过GET读取合同详情
    $id = $_GPC['contractclass_id'];
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_contractsclasses') .
                " WHERE uniacid=:uniacid AND " .
                " id=:id";
    $contractclass = pdo_fetch($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));
    if (!$contractclass) message('该课程不存在', 'referer', 'error');

    include $this->template('web/contract/class_edit');

// 管理课程 - 删除课程
} elseif ($page == 'class_delete') {
    if (!empty($_GPC['contractclass_id'])) {
        $contractclass_id = $_GPC['contractclass_id'];
        $sql = "SELECT * FROM " .
                    tablename('qw_microedu_schedules') .
                    " AS schedules " .
                    " WHERE schedules.uniacid=:uniacid " .
                    " AND schedules.contractclass_id=:contractclass_id";
        $schedule = pdo_fetch($sql, array(
            ':uniacid'           =>          $_W['uniacid'],
            ':contractclass_id'  =>          $contractclass_id
        ));
        if ($schedule)  {
            message('该课程已有排课记录，不能被删除', 'referer', 'error');
        }

        $result = pdo_delete('qw_microedu_contractsclasses', array(
            'uniacid'           =>          $_W['uniacid'],
            'id'                =>          $_GPC['contractclass_id']
        ));
        if (!empty($result)) {
            message('该课程已经从此合同中移除', 'referer', 'success');
        } else {
            message('删除失败', 'referer', 'error');
        }
    } else {
        message('参数错误', 'referer', 'error');
    }
}

function validateData($contract_name, $contract_description, $contract_price, $contract_duration) {
    if (empty($contract_name)) {
        message('请输入合同名称', 'referer', 'error');
    }

    if (empty($contract_price)) {
        message('请输入合同价格', 'referer', 'error');
    }

    if (empty($contract_duration)) {
        message('请输入合同时长', 'referer', 'error');
    }

    if (!is_numeric($contract_price)) {
        message('合同价格必须为数字', 'referer', 'error');
    }

    if (!is_numeric($contract_duration)) {
        message('合同时长必须为数字', 'referer', 'error');
    }

    if (mb_strlen($contract_description) > 10000) {
        message('合同简介不得超过10000', 'referer', 'error');
    }
}
