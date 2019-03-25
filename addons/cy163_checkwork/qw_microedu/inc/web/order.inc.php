<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$action = $_GPC['action'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';

// 排课首页 - 列出所有合同课程
if ($page == 'index') {
    $sql = "SELECT contracts.contract_name, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contractsclasses.class_description FROM " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE contractsclasses.uniacid=:uniacid AND " .
                " contracts.uniacid=:uniacid ORDER BY contracts.contract_name ASC";
    $contractsclasses = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid']
    ));

    include $this->template('web/order/index');

// 排课首页 - 搜索合同课程
} elseif ($page == 'index_search') {
    if (empty($_GPC['search_contract_name']) &&
        empty($_GPC['search_class_name'])) {
        message('请输入搜索条件', 'referer', 'error');
    }

    $sql = "SELECT contracts.contract_name, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contractsclasses.class_description FROM " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE contractsclasses.uniacid=:uniacid AND " .
                " contracts.uniacid=:uniacid";

    if (!empty($_GPC['search_contract_name'])) {
        $sql = $sql . " AND contracts.contract_name LIKE :contract_name";
    }
    if (!empty($_GPC['search_class_name'])) {
        $sql = $sql . " AND contractsclasses.class_name LIKE :class_name";
    }
    $sql = $sql . " ORDER BY contracts.contract_name ASC";

    $contractsclasses = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':contract_name'    =>          '%' . $_GPC['search_contract_name'] . '%',
        ':class_name'       =>          '%' . $_GPC['search_class_name'] . '%'
    ));

    include $this->template('web/order/index');

// 排课页面
} elseif ($page == 'add-class') {
    // 通过POST方式排课
    if (!empty($_POST)) {
        // 1. 获取该合同课程contractclass_id
        $id = $_GPC['contractclass_id'];
        // 2. 获取排课基本信息
        // 2.1 获取校区ID
        $campus_id = $_GPC['campus_id'];
        // 2.2 获取教师ID
        $tutor_id = $_GPC['tutor_id'];
        // 2.3 获取消耗的课时类型ID
        $classhour_id = $_GPC['classhour_id'];
        // 2.4 获取课程时长
        $duration = $_GPC['duration'];
        // 2.5 获取教室
        $classroom = $_GPC['classroom'];
        // 2.6 获取是否可以试听
        $trialable = $_GPC['trialable'];
        // 3. 获取学员信息
        $chosen_children = $_GPC['chosen_children'];
        // 4. 获取时间信息
        $chosen_dates = $_GPC['chosen_dates'];

        // 检查POST参数
        if (empty($id)) {
            message('无法获取合同课程', 'referer', 'error');
        }
        if (empty($campus_id)) {
            message('请选择校区', 'referer', 'error');
        }
        if (empty($tutor_id)) {
            message('请选择教师', 'referer', 'error');
        }
        if (empty($classhour_id)) {
            message('请选择消耗的课时类型', 'referer', 'error');
        }
        if (empty($duration)) {
            message('请输入课程时长', 'referer', 'error');
        }
        if (!is_numeric($duration) || (floor($duration) != $duration)) {
            message('课程时长必须为整数', 'referer', 'error');
        }
        if (empty($classroom)) {
            message('请输入教室', 'referer', 'error');
        }
        if ($trialable != 0 && $trialable != 1) {
            message('试听参数错误', 'refere', 'error');
        }
        if (empty($chosen_children)) {
            message('需要选择至少一位学员', 'referer', 'error');
        }
        if (empty($chosen_dates)) {
            message('需要选择至少一个日期', 'referer', 'error');
        }

        // 循环所有学员，确保其家长拥有足够的指定课时余额
        // 有多个孩子的家长会被检查多次，but I don't fucking give a shit.
        // 想要牛逼的排课算法？那你特么倒是多给点项目款啊？
        // 我用基因算法给你排课吼不吼？吼？十万！没钱？那你逼逼个屁啊。
        // 老子已经十几天没休息了你懂不懂啊？
        // 中秋节女朋友在家哭我特么在给你写代码你了不了啊？
        // By: 一位临时员工，已经被开除。
        // TODO: Consider including calculating existing schedules for classhour balance
        foreach ($chosen_children as $chosen_child) {
            // 获取该学员家长信息
            $sql = "SELECT parents.id, " .
                        " users.fullname FROM "  .
                        tablename('qw_microedu_children') .
                        " AS children JOIN " .
                        tablename('qw_microedu_parents') .
                        " AS parents ON " .
                        " children.parent_id=parents.id JOIN " .
                        tablename('qw_microedu_users') .
                        " AS users ON " .
                        " parents.id=users.role_id " .
                        " WHERE children.uniacid=:uniacid AND " .
                        " children.id=:id AND " .
                        " users.role_type=:role_type";
            $theparent = pdo_fetch($sql, array(
                ':uniacid'          =>          $_W['uniacid'],
                ':id'               =>          $chosen_child,
                ':role_type'         =>         'parents'
            ));

            // 获取该家长有几个熊孩子
            $sql = "SELECT * FROM " .
                        tablename('qw_microedu_children') .
                        " WHERE uniacid=:uniacid AND " .
                        " parent_id=:parent_id";

            $children = pdo_fetchall($sql, array(
                ':uniacid'          =>          $_W['uniacid'],
                ':parent_id'        =>          $theparent['id']
            ));
            $childrencount = count($children);

            // 算算总共要消耗多少课时
            $totalclasshour = $childrencount * $duration * count($chosen_dates);
            // 算算已经排过多少此类课时(还未开始，未正式扣课时的)
            /*
            $totalexistingclasshour = 0;
            foreach ($children as $child) { // 循环该家长的所有子女
                $sql = "SELECT COALESCE(sum(schedules.duration), 0) AS value " .
                            " FROM " .
                            tablename('qw_microedu_attendance') .
                            " AS attendance JOIN " .
                            tablename('qw_microedu_schedules') .
                            " AS schedules ON " .
                            " attendance.schedule_id=schedules.id " .
                            " WHERE attendance.uniacid=:uniacid " .
                            " AND attendance.child_id=:child_id " .
                            " AND attendance.status=0 " .
                            " AND schedules.timeslot>:current_time " .
                            " AND schedules.classhour_id=:classhour_id ";
                $duration = pdo_fetch($sql, array(
                    ':uniacid'          =>          $_W['uniacid'],
                    ':child_id'         =>          $child['id'],
                    ':current_time'     =>          date('Y-m-d H:i:s'),
                    ':classhour_id'     =>          $classhour_id
                ));

                $totalexistingclasshour = $totalexistingclasshour + $duration['value'];
            }
            $totalclasshour = $totalclasshour + $totalexistingclasshour;
            */

            $sql = "SELECT parentsremainingclasshours.amount FROM " .
                        tablename('qw_microedu_parentsremainingclasshours') .
                        " AS parentsremainingclasshours JOIN " .
                        tablename('qw_microedu_parentscontracts') .
                        " AS parentscontracts ON " .
                        " parentsremainingclasshours.parentscontract_id=parentscontracts.id JOIN " .
                        tablename('qw_microedu_contracts') .
                        " AS contracts ON " .
                        " parentscontracts.contract_id=contracts.id JOIN " .
                        tablename('qw_microedu_contractsclasses') .
                        " AS contractsclasses ON " .
                        " contracts.id=contractsclasses.contract_id " .
                        " WHERE parentsremainingclasshours.uniacid=:uniacid AND " .
                        " parentsremainingclasshours.classhour_id=:classhour_id AND " .
                        " parentscontracts.parent_id=:parent_id AND " .
                        " contractsclasses.id=:id";
            $amount = pdo_fetch($sql, array(
                ':uniacid'          =>          $_W['uniacid'],
                ':classhour_id'     =>          $classhour_id,
                ':parent_id'        =>          $theparent['id'],
                ':id'               =>          $id
            ));

            if ($totalclasshour > $amount['amount']) {
                message('家长' . $theparent['fullname'] . '所剩余的指定课时余额不足', 'referer', 'error');
            }
        }

        // 上述循环全部完成没有错误跳转
        // 说明所有熊孩子的家长们都有足够的指定课时
        // 所有条件检查结束，写入排课数据
        // 注意1： 不用检查教师是否日程重复，因为有可能多个合同课程合并
        // 注意2: 不用检查学员是否日程重复，因为客户业务逻辑中，学员可以随意选择去上哪门课。
        foreach ($chosen_dates as $chosen_date) {
            pdo_insert('qw_microedu_schedules', array(
                'uniacid'           =>          $_W['uniacid'],
                'contractclass_id'  =>          $id,
                'campus_id'         =>          $campus_id,
                'tutor_id'          =>          $tutor_id,
                'classhour_id'      =>          $classhour_id,
                'duration'          =>          $duration,
                'classroom'         =>          $classroom,
                'trialable'         =>          $trialable,
                'timeslot'          =>          $chosen_date
            ));
            $schedule_id = pdo_insertid();

            foreach ($chosen_children as $chosen_child) {
                pdo_insert('qw_microedu_attendance', array(
                    'uniacid'           =>          $_W['uniacid'],
                    'schedule_id'       =>          $schedule_id,
                    'child_id'          =>          $chosen_child,
                    'status'            =>          0 //课程未举行，或学员未出勤
                ));
            }
        }

        message('排课成功', 'referer', 'success');
    }

    // 通过GET方式显示排课页面
    $id = $_GPC['contractclass_id'];

    // 1. 获取指定合同课程信息
    $sql = "SELECT contracts.contract_name, " .
                " contractsclasses.id, " .
                " contractsclasses.class_name, " .
                " contractsclasses.class_description FROM " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id " .
                " WHERE contractsclasses.uniacid=:uniacid AND " .
                " contracts.uniacid=:uniacid AND " .
                " contractsclasses.id=:id " .
                " ORDER BY contracts.contract_name ASC";
    $contractclass = pdo_fetch($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));
    if (!$contractclass) message('该合同课程不存在', $this->createWebUrl('order'), 'error');

    // 2. 获取所有校区信息
    $sql = "SELECT * FROM " .
                tablename('qw_microedu_campuses') .
                " WHERE uniacid=:uniacid AND " .
                " enabled=1";
    $campuses = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid']
    ));

    // 2.1 过滤所有不能上本节课的校区
    foreach ($campuses as $index => $campus) {
        $sql = "SELECT * FROM " .
                    tablename('qw_microedu_campuscannotschedule') .
                    " WHERE uniacid=:uniacid AND " .
                    " campus_id=:campus_id AND " .
                    " contractclass_id=:contractclass_id";
        $disabled = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':campus_id'        =>          $campus['id'],
            ':contractclass_id' =>          $contractclass['id']
        ));
        if ($disabled) unset($campuses[$index]);
    }

    // 3. 获取所有教师信息
    $sql = "SELECT tutors.id, " .
                " users.fullname, users.mobile FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " users.role_id=tutors.id " .
                " WHERE tutors.uniacid=:uniacid AND " .
                " enabled=1 AND " .
                " users.role_type=:role_type";
    $tutors = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':role_type'        =>          'tutors'
    ));

    // 3.1 只显示会教本课的教师
    foreach ($tutors as $index => $tutor) {
        $sql = "SELECT * FROM " .
                    tablename('qw_microedu_tutorcanteach') .
                    " WHERE uniacid=:uniacid AND " .
                    " tutor_id=:tutor_id AND " .
                    " contractclass_id=:contractclass_id";
        $canteach = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor['id'],
            ':contractclass_id' =>          $contractclass['id']
        ));
        if (!$canteach) unset($tutors[$index]);
    }

    // 4. 获取本合同所包含的所有课时类型
    $sql = "SELECT classhours.id, " .
                "classhours.classhour_name FROM " .
                tablename('qw_microedu_classhours') .
                " AS classhours JOIN " .
                tablename('qw_microedu_contractsclasshours') .
                " AS contractsclasshours ON " .
                " classhours.id=contractsclasshours.classhour_id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasshours.contract_id=contracts.id JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " contracts.id=contractsclasses.contract_id " .
                " WHERE classhours.uniacid=:uniacid AND " .
                " contractsclasses.id=:id";
    $classhours = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':id'               =>          $id
    ));


    // 5. 获得所有签订本合同课程的学员名单
    $sql = "SELECT children.id, " .
                "children.fullname AS pupil_fullname, " .
                "users.fullname AS parent_fullname, " .
                "users.mobile AS parent_mobile FROM " .
                tablename('qw_microedu_children') . " AS children JOIN " .
                tablename('qw_microedu_parents') . " AS parents ON " .
                " children.parent_id=parents.id JOIN " .
                tablename('qw_microedu_users') . " AS users ON " .
                " parents.id=users.role_id JOIN " .
                tablename('qw_microedu_parentscontracts') . " AS parentscontracts ON " .
                " parents.id=parentscontracts.parent_id JOIN " .
                tablename('qw_microedu_contracts') . " AS contracts ON " .
                " parentscontracts.contract_id=contracts.id JOIN " .
                tablename('qw_microedu_contractsclasses') . " AS contractsclasses ON " .
                " contracts.id=contractsclasses.contract_id " .
                " WHERE children.uniacid=:uniacid AND " .
                " users.role_type=:role_type AND " .
                " contractsclasses.id=:id " .
                " GROUP BY children.fullname, users.fullname ";

    $children = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':role_type'        =>          'parents',
        ':id'               =>          $id
    ));

    include $this->template('web/order/add-class');

// 排课表页面
} elseif ($page == 'orderlist') {
    if (empty($starttime) || empty($endtime)) {
        //$starttime = TIMESTAMP;
        $starttime = strtotime('-1 month');
        $endtime = strtotime('+1 month');
    }

    if (!empty($_POST)) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $condition .= " AND o.createtime >= :starttime AND o.createtime <= :endtime ";
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;

        if (!empty($_GPC['search-condition'])) $search_condition = $_GPC['search-condition'];
    }

    // 默认显示本月课程表
    $sql = "SELECT schedules.id, " .
                " schedules.contractclass_id, " .
                " campuses.name AS campus_name, " .
                " schedules.classroom, " .
                " users.fullname AS tutor_fullname, " .
                " contracts.contract_name, " .
                " contractsclasses.class_name, " .
                " schedules.timeslot, " .
                " schedules.duration, " .
                " classhours.classhour_name, " .
                " count(attendance.id) AS pupils_count " .
                " FROM " .
                tablename('qw_microedu_schedules') .
                " AS schedules JOIN " .
                tablename('qw_microedu_contractsclasses') .
                " AS contractsclasses ON " .
                " schedules.contractclass_id=contractsclasses.id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " contractsclasses.contract_id=contracts.id JOIN " .
                tablename('qw_microedu_campuses') .
                " AS campuses ON " .
                " schedules.campus_id=campuses.id JOIN " .
                tablename('qw_microedu_tutors') .
                " AS tutors ON " .
                " schedules.tutor_id=tutors.id JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id JOIN " .
                tablename('qw_microedu_classhours') .
                " AS classhours ON " .
                " schedules.classhour_id=classhours.id JOIN " .
                tablename('qw_microedu_attendance') .
                " AS attendance ON " .
                " schedules.id=attendance.schedule_id " .
                " WHERE schedules.uniacid=:uniacid AND " .
                " schedules.timeslot>=:starttime AND " .
                " schedules.timeslot<=:endtime AND " .
                " users.role_type=:role_type ";

    if ($search_condition) {
        $sql = $sql . " AND ( campuses.name LIKE binary :condition " .
                        " OR schedules.classroom LIKE binary :condition " .
                        " OR users.fullname LIKE binary :condition " .
                        " OR contracts.contract_name LIKE binary :condition " .
                        " OR contractsclasses.class_name LIKE binary :condition " .
                        " OR schedules.timeslot LIKE binary :condition " .
                        " OR schedules.duration LIKE binary :condition " .
                        " OR classhours.classhour_name LIKE binary :condition ) ";
    }

    $sql = $sql . " GROUP BY schedules.contractclass_id, schedules.timeslot, schedules.classroom";

    if ($search_condition) {
        $schedules = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':starttime'        =>          date('Y-m-d H:i:s', $starttime),
            ':endtime'          =>          date('Y-m-d H:i:s', $endtime),
            ':role_type'        =>          'tutors',
            ':condition'        =>          '%' . $search_condition . '%'
        ));
    } else {
        $schedules = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':starttime'        =>          date('Y-m-d H:i:s', $starttime),
            ':endtime'          =>          date('Y-m-d H:i:s', $endtime),
            ':role_type'        =>          'tutors'
        ));
    }

    include $this->template('web/order/orderlist');
}
