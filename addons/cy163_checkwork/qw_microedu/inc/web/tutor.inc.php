<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';

// 教师首页（列表页）
if ($page == 'index') {
    $sql = "SELECT tutors.id AS tutor_id, " .
                " users.* " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid AND " .
                " users.role_type=:role_type AND " .
                " tutors.enabled = 1 " .
                " ORDER BY tutors.id ASC";

    $tutors = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':role_type'         =>          'tutors'
    ));

    include $this->template('web/tutor/index');

// 搜索教师
} elseif ($page == 'index-search') {
    if (!empty($_GPC['search-condition'])) $search_condition = $_GPC['search-condition'];

    $sql = "SELECT tutors.id AS tutor_id, " .
                " users.* " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid AND " .
                " users.role_type=:role_type AND " .
                " tutors.enabled = 1 ";

    if ($search_condition) {
        $sql = $sql . " AND ( users.fullname LIKE binary :condition " .
                        " OR users.mobile LIKE binary :condition " .
                        " OR users.dob LIKE binary :condition " .
                        " OR users.ic LIKE binary :condition " .
                        " OR users.address LIKE binary :condition )";
    }

    $sql = $sql . " ORDER BY tutors.id ASC";

    if ($search_condition) {
        $tutors = pdo_fetchall($sql, array(
            ':uniacid'              =>          $_W['uniacid'],
            ':role_type'            =>          'tutors',
            ':condition'            =>          '%' . $search_condition . '%'
        ));
    } else {
        $tutors = pdo_fetchall($sql, array(
            ':uniacid'              =>          $_W['uniacid'],
            ':role_type'            =>          'tutors',
            ':condition'            =>          $search_condition
        ));
    }

    include $this->template('web/tutor/index');

// 新增教师
} elseif ($page == 'create') {
    if (!empty($_POST)) {
        validateData($_GPC['fullname'], $_GPC['mobile'], $_GPC['address'], $_GPC['ic'], $_GPC['address']);

        // 1. Insert into Users
        pdo_insert('qw_microedu_users', array(
            'uniacid'           =>          $_W['uniacid'],
            'fullname'          =>          $_GPC['fullname'],
            'mobile'            =>          $_GPC['mobile'],
            'gender'            =>          $_GPC['gender'],
            'dob'               =>          $_GPC['dob'],
            'ic'                =>          $_GPC['ic'],
            'address'           =>          $_GPC['address'],
            'role_type'         =>          'tutors'
        ));
        $user_id = pdo_insertid();

        // 2. Insert into tutors
        pdo_insert('qw_microedu_tutors', array(
            'uniacid'           =>          $_W['uniacid'],
            'enabled'           =>          1
        ));
        $tutor_id = pdo_insertid();

        // 3. Update users table
        pdo_update('qw_microedu_users', array(
            'role_id'           =>          $tutor_id
        ), array(
            'uniacid'           =>          $_W['uniacid'],
            'id'                =>          $user_id
        ));

        message('教师添加成功', $this->createWebUrl('tutor'), 'success');
    }

    include $this->template('web/tutor/create');

// 编辑教师信息
} elseif ($page == 'edit') {
    if (!empty($_POST)) {
        validateData($_GPC['fullname'], $_GPC['mobile'], $_GPC['address'], $_GPC['ic'], $_GPC['address']);

        pdo_update('qw_microedu_users', array(
            'fullname'          =>          $_GPC['fullname'],
            'mobile'            =>          $_GPC['mobile'],
            'gender'            =>          $_GPC['gender'],
            'dob'               =>          $_GPC['dob'],
            'ic'                =>          $_GPC['ic'],
            'address'           =>          $_GPC['address']
        ), array(
            'uniacid'           =>          $_W['uniacid'],
            'id'                =>          $_GPC['user_id']
        ));

        message('教师修改成功', $this->createWebUrl('tutor'), 'success');
    }

    $sql = "SELECT tutors.id AS tutor_id, " .
                " users.* " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid AND " .
                " tutors.id=:tutor_id AND " .
                " users.role_type=:role_type";

    $tutor = pdo_fetch($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':tutor_id'         =>          $_GPC['tutor_id'],
        ':role_type'        =>          'tutors'
    ));

    if (!$tutor) message('未找到教师', $this->createWebUrl('tutor'), 'error');

    include $this->template('web/tutor/edit');

} elseif ($page == 'delete') {
    if (!empty($_GPC['tutor_id'])) {
        pdo_update('qw_microedu_tutors', array(
            'enabled'           =>          0
        ), array(
            'uniacid'           =>          $_W['uniacid'],
            'id'                =>          $_GPC['tutor_id']
        ));

        message('教师删除成功', 'referer', 'success');
    }

// 可教课程
} elseif ($page == 'able') {
    // POST method
    if (!empty($_POST)) {
        // Remove canteach classes
        if (!empty($_GPC['tobepotentialedclasses'])) {
            // Get tutor info
            $tutor_id = $_GPC['tutor_id'];
            $sql = "SELECT users.fullname, " .
                        " tutors.* " .
                        " FROM " .
                        tablename('qw_microedu_tutors') .
                        " AS tutors JOIN " .
                        tablename('qw_microedu_users') .
                        " AS users ON " .
                        " tutors.id=users.role_id " .
                        " WHERE tutors.uniacid=:uniacid " .
                        " AND tutors.id=:tutor_id " .
                        " AND users.role_type=:role_type ";

            $tutor = pdo_fetch($sql, array(
                ':uniacid'           =>          $_W['uniacid'],
                ':tutor_id'          =>          $tutor_id,
                ':role_type'         =>          'tutors'
            ));

            if (!$tutor) message('该教师不存在', $this->createWebUrl('tutor'), 'error');

            $tobepotentialedclasses = $_GPC['tobepotentialedclasses'];
            foreach ($tobepotentialedclasses as $tobepotentialedclass) {
                $sql = pdo_delete('qw_microedu_tutorcanteach', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'tutor_id'          =>          $tutor_id,
                    'contractclass_id'  =>          $tobepotentialedclass
                ));
            }

            message('选中的课程已从该教师可上课程中移除', 'referer', 'success');
        }

        // Add canteach classes
        if (!empty($_GPC['tobecantaughtclasses'])) {
            // Get tutor info
            $tutor_id = $_GPC['tutor_id'];
            $sql = "SELECT users.fullname, " .
                        " tutors.* " .
                        " FROM " .
                        tablename('qw_microedu_tutors') .
                        " AS tutors JOIN " .
                        tablename('qw_microedu_users') .
                        " AS users ON " .
                        " tutors.id=users.role_id " .
                        " WHERE tutors.uniacid=:uniacid " .
                        " AND tutors.id=:tutor_id " .
                        " AND users.role_type=:role_type ";

            $tutor = pdo_fetch($sql, array(
                ':uniacid'           =>          $_W['uniacid'],
                ':tutor_id'          =>          $tutor_id,
                ':role_type'         =>          'tutors'
            ));

            if (!$tutor) message('该教师不存在', $this->createWebUrl('tutor'), 'error');

            $tobecantaughtclasses = $_GPC['tobecantaughtclasses'];
            foreach ($tobecantaughtclasses as $tobecantaughtclass) {
                $sql = pdo_insert('qw_microedu_tutorcanteach', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'tutor_id'          =>          $tutor_id,
                    'contractclass_id'  =>          $tobecantaughtclass
                ));
            }

            message('选中课程已被添加至该教师可上课程列表中', 'referer', 'success');
        }
    }

    // GET method. Displaying page.
    // 1. Get the tutor info
    $tutor_id = $_GPC['tutor_id'];
    $sql = "SELECT users.fullname, " .
                " tutors.* " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid " .
                " AND tutors.id=:tutor_id " .
                " AND users.role_type=:role_type ";

    $tutor = pdo_fetch($sql, array(
        ':uniacid'           =>          $_W['uniacid'],
        ':tutor_id'          =>          $tutor_id,
        ':role_type'         =>          'tutors'
    ));

    if (!$tutor) message('该教师不存在', $this->createWebUrl('tutor'), 'error');

    // 2. Get can teach classes for this tutor
    $sql = "SELECT tutorcanteach.id, " .
                " tutorcanteach.tutor_id, " .
                " tutorcanteach.contractclass_id, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_tutorcanteach') .
                " AS tutorcanteach JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " tutorcanteach.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE tutorcanteach.uniacid=:uniacid AND " .
                " tutorcanteach.tutor_id=:tutor_id ";

    $canteach_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':tutor_id'         =>          $tutor_id
    ));

    // 3. Get all other classes
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
                " ( SELECT contractclass_id FROM " .
                    tablename('qw_microedu_tutorcanteach') .
                    " WHERE tutor_id=:tutor_id )";
    $potential_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':tutor_id'         =>          $tutor_id
    ));

    include $this->template('web/tutor/able');

// Search canteach classes
} elseif ($page == "able-search-canteach") {
    $tutor_id = $_GPC['tutor_id'];
    $sql = "SELECT users.fullname, " .
                " tutors.* " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid " .
                " AND tutors.id=:tutor_id " .
                " AND users.role_type=:role_type ";

    $tutor = pdo_fetch($sql, array(
        ':uniacid'           =>          $_W['uniacid'],
        ':tutor_id'          =>          $tutor_id,
        ':role_type'         =>          'tutors'
    ));

    if (!$tutor) message('该教师不存在', $this->createWebUrl('tutor'), 'error');

    // Get can teach classes according to search critiria
    $sql = "SELECT tutorcanteach.id, " .
                " tutorcanteach.tutor_id, " .
                " tutorcanteach.contractclass_id, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_tutorcanteach') .
                " AS tutorcanteach JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " tutorcanteach.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE tutorcanteach.uniacid=:uniacid AND " .
                " tutorcanteach.tutor_id=:tutor_id ";

    $canteach_condition = $_GPC['canteach_condition'];

    if ($canteach_condition) {
        $sql = $sql . " AND ( contractsclasses.class_name LIKE :condition " .
                        " OR contracts.contract_name LIKE :condition )";
        $canteach_classes = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor_id,
            ':condition'        =>          '%' . $canteach_condition . '%'
        ));
    } else {
        $canteach_classes = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor_id
        ));
    }

    // Get potential classes AS IS
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
                " ( SELECT contractclass_id FROM " .
                    tablename('qw_microedu_tutorcanteach') .
                    " WHERE tutor_id=:tutor_id )";
    $potential_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':tutor_id'         =>          $tutor_id
    ));

    include $this->template('web/tutor/able');

// Search potential classes
} elseif ($page == "able-search-potential") {
    $tutor_id = $_GPC['tutor_id'];
    $sql = "SELECT users.fullname, " .
                " tutors.* " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid " .
                " AND tutors.id=:tutor_id " .
                " AND users.role_type=:role_type ";

    $tutor = pdo_fetch($sql, array(
        ':uniacid'           =>          $_W['uniacid'],
        ':tutor_id'          =>          $tutor_id,
        ':role_type'         =>          'tutors'
    ));

    if (!$tutor) message('该教师不存在', $this->createWebUrl('tutor'), 'error');

    // Get potential classes according to search critiria
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
                " ( SELECT contractclass_id FROM " .
                    tablename('qw_microedu_tutorcanteach') .
                    " WHERE tutor_id=:tutor_id )";

    $potential_condition = $_GPC['potential_condition'];
    if ($potential_condition) {
        $sql = $sql . " AND ( contractsclasses.class_name LIKE :condition " .
                        " OR contracts.contract_name LIKE :condition )";
        $potential_classes = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor_id,
            ':condition'        =>          '%' . $potential_condition . '%'
        ));
    } else {
        $potential_classes = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor_id
        ));
    }

    // Get can teach classes AS IS
    $sql = "SELECT tutorcanteach.id, " .
                " tutorcanteach.tutor_id, " .
                " tutorcanteach.contractclass_id, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_tutorcanteach') .
                " AS tutorcanteach JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " tutorcanteach.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE tutorcanteach.uniacid=:uniacid AND " .
                " tutorcanteach.tutor_id=:tutor_id ";

    $canteach_classes = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':tutor_id'         =>          $tutor_id
    ));

    include $this->template('web/tutor/able');
}


function validateData($name, $mobile, $address, $ic, $address) {
    if (empty($name)) {
        message('请输入教师姓名', 'referer', 'error');
    }

    if (mb_strlen($name) > 10) {
        message('教师姓名不得超过10个字', 'referer', 'error');
    }

    if (empty($mobile)) {
        message('请输入手机号', 'referer', 'error');
    }

    if (mb_strlen($mobile) != 11) {
        message('手机号需为11个数字', 'referer', 'error');
    }

    if (empty($ic) || strlen($ic) != 18) {
        message('请输入身份证号码', 'referer', 'error');
    }

    if (mb_strlen($address) > 200) {
        message('地址不得超过200个字', 'referer', 'error');
    }
}
