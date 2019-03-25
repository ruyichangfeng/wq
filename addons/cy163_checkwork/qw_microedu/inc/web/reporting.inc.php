<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$action = $_GPC['action'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';

if ($page == 'index') {
    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = TIMESTAMP;
    }
    if (!empty($_POST)) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $condition .= " AND o.createtime >= :starttime AND o.createtime <= :endtime ";
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;
    }

    // 默认显示上月报表
    $sql = "SELECT users.fullname AS parent_fullname, " .
                " users.mobile AS parent_mobile, " .
                " contracts.contract_name, " .
                " parentscontracts.contract_startdate, " .
                " parentscontracts.contract_price, " .
                " consultants.id AS consultant_id" .
                " FROM " .
                tablename('qw_microedu_parents') .
                " AS parents JOIN " .
                tablename('qw_microedu_parentscontracts') .
                " AS parentscontracts ON " .
                " parents.id=parentscontracts.parent_id JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " parentscontracts.contract_id=contracts.id JOIN " .
                tablename('qw_microedu_consultants') .
                " AS consultants ON " .
                " parents.consultant_id=consultants.id JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " parents.id=users.role_id " .
                " WHERE parents.uniacid=:uniacid " .
                " AND parentscontracts.contract_startdate>=:starttime " .
                " AND parentscontracts.contract_startdate<=:endtime " .
                " AND parentscontracts.status=1 " .
                " AND users.role_type=:role_type ";

    $items = pdo_fetchall($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
        ':starttime'        =>          date('Y-m-d H:i:s', $starttime),
        ':endtime'          =>          date('Y-m-d H:i:s', $endtime),
        ':role_type'        =>          'parents'
    ));

    // Get Total Commissions
    $sql = "SELECT COALESCE(sum(commissions.amount), 0) AS value" .
                " FROM " .
                tablename('qw_microedu_commissions') .
                " AS commissions " .
                " WHERE commissions.uniacid=:uniacid ";
    $total_commission = pdo_fetch($sql, array(
        ':uniacid'          =>          $_W['uniacid']
    ));
    $total_commission = $total_commission['value'];

    $total_sales = 0;
    //$total_commission = 0;
    foreach ($items as $index => $item) {
        $sql = "SELECT users.fullname AS consultant_fullname, " .
                    " consultants.rate " .
                    " FROM " .
                    tablename('qw_microedu_consultants') .
                    " AS consultants JOIN " .
                    tablename('qw_microedu_users') .
                    " AS users ON " .
                    " consultants.id=users.role_id " .
                    " WHERE consultants.uniacid=:uniacid " .
                    " AND consultants.id=:consultant_id " .
                    " AND users.role_type=:role_type ";

        $consultant = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':consultant_id'    =>          $item['consultant_id'],
            ':role_type'        =>          'consultants'
        ));
        $items[$index]['consultant_fullname'] = $consultant['consultant_fullname'];
        $total_sales = $total_sales + $item['contract_price'];
        //$total_commission = $total_commission + $item['contract_price'] * $consultant['rate'] * 0.01;
    }

    include $this->template('web/reporting/index');

// 合同报表
} elseif ($page == 'contract') {
    if (!empty($_POST)) {
        $search_contract_name = $_GPC['search-contract-name'];
    }

    $sql = "SELECT DISTINCT(parentscontracts.contract_id), " .
                " contracts.contract_name " .
                " FROM " .
                tablename('qw_microedu_parentscontracts') .
                " AS parentscontracts JOIN " .
                tablename('qw_microedu_contracts') .
                " AS contracts ON " .
                " parentscontracts.contract_id=contracts.id " .
                " WHERE parentscontracts.uniacid=:uniacid " .
                " AND parentscontracts.status=1 ";

    if (empty($search_contract_name)) {
        $contracts = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid']
        ));
    } else {
        $sql = $sql . " AND contracts.contract_name LIKE :search_contract_name ";
        $contracts = pdo_fetchall($sql, array(
            ':uniacid'                  =>          $_W['uniacid'],
            ':search_contract_name'     =>          '%'. $search_contract_name . '%'
        ));
    }

    $total_classes = 0;
    foreach ($contracts as $index => $contract) {
        // 1. Get how many classes are included in the contract
        $sql = "SELECT count(contractsclasses.id) AS value" .
                    " FROM " .
                    tablename('qw_microedu_contractsclasses') .
                    " AS contractsclasses " .
                    " WHERE contractsclasses.uniacid=:uniacid " .
                    " AND contractsclasses.contract_id=:contract_id ";
        $contract_classcount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':contract_id'       =>          $contract['contract_id']
        ));
        $contracts[$index]['contract_classcount'] = $contract_classcount['value'];
        $total_classes = $total_classes + $contract_classcount['value'];

        // 2. Get how many contracts were sold
        $sql = "SELECT count(parentscontracts.id) AS value" .
                    " FROM " .
                    tablename('qw_microedu_parentscontracts') .
                    " AS parentscontracts " .
                    " WHERE parentscontracts.uniacid=:uniacid " .
                    " AND parentscontracts.contract_id=:contract_id " .
                    " AND parentscontracts.status=1";
        $contract_soldcount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':contract_id'       =>          $contract['contract_id']
        ));
        $contracts[$index]['contract_soldcount'] = $contract_soldcount['value'];

        // 3. Get total sales for this contract (YES I AM AWARE OF THE REDUNDANCY)
        $sql = "SELECT COALESCE(sum(parentscontracts.contract_price), 0) AS value" .
                    " FROM " .
                    tablename('qw_microedu_parentscontracts') .
                    " AS parentscontracts " .
                    " WHERE parentscontracts.uniacid=:uniacid " .
                    " AND parentscontracts.contract_id=:contract_id " .
                    " AND parentscontracts.status=1";
        $contract_sales = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':contract_id'      =>          $contract['contract_id']
        ));
        $contracts[$index]['contract_sales'] = $contract_sales['value'];
    }

    include $this->template('web/reporting/contract');

// 校区报表
} elseif ($page == 'campus') {
    if (!empty($_POST)) {
        $search_campus_name = $_GPC['search-campus-name'];
    }

    $sql = "SELECT campuses.id, " .
                " campuses.name " .
                " FROM " .
                tablename('qw_microedu_campuses') .
                " AS campuses " .
                " WHERE campuses.uniacid=:uniacid " .
                " AND campuses.enabled=1 ";

    if (empty($search_campus_name)) {
        $campuses = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid']
        ));
    } else {
        $sql = $sql . " AND campuses.name LIKE :search_campus_name ";
        $campuses = pdo_fetchall($sql, array(
            ':uniacid'              =>          $_W['uniacid'],
            ':search_campus_name'   =>          '%' . $search_campus_name . '%'
        ));
    }
    $total_schedules = 0;
    foreach ($campuses as $index => $campus) {
        // 1. Get how many schedules this campus had in total
        $sql = "SELECT count(schedules.id) AS value" .
                    " FROM " .
                    tablename('qw_microedu_schedules') .
                    " AS schedules " .
                    " WHERE schedules.uniacid=:uniacid " .
                    " AND schedules.campus_id=:campus_id ";
        $campus_schedulecount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':campus_id'        =>          $campus['id']
        ));
        $campuses[$index]['campus_schedulecount'] = $campus_schedulecount['value'];
        $total_schedules = $total_schedules + $campus_schedulecount['value'];

        // 2. Get how many classhours this campus held in total
        $sql = "SELECT COALESCE(sum(schedules.duration), 0) AS value" .
                    " FROM " .
                    tablename('qw_microedu_schedules') .
                    " AS schedules " .
                    " WHERE schedules.uniacid=:uniacid " .
                    " AND schedules.campus_id=:campus_id ";
        $campus_classhourcount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':campus_id'        =>          $campus['id']
        ));
        $campus_classhourcount = round($campus_classhourcount['value'] / 60, 2);
        $campuses[$index]['campus_classhourcount'] = $campus_classhourcount;
    }

    include $this->template('web/reporting/campus');

// Parent Report
// OMG, Do you seriously think I care about performance?
// In fact I do, just not for you.
} elseif ($page == 'parent') {
    if (!empty($_POST)) {
        $search_condition = $_GPC['search-condition'];
    }

    $sql = "SELECT parents.id, " .
                " users.fullname, " .
                " users.mobile " .
                " FROM " .
                tablename('qw_microedu_parents') .
                " AS parents JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " parents.id=users.role_id " .
                " WHERE parents.uniacid=:uniacid" .
                " AND users.role_type=:role_type ";
    if (empty($search_condition)) {
        $parents = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':role_type'        =>          'parents'
        ));
    } else {
        $sql = $sql . " AND (users.fullname LIKE :search_condition " .
                            " OR users.mobile LIKE :search_condition) ";
        $parents = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':role_type'        =>          'parents',
            ':search_condition' =>          '%' . $search_condition . '%'
        ));
    }

    $total_children = 0;
    $total_purchased_parents = 0;
    foreach ($parents as $index => $parent) {
        // 1. Get how many children this parent has
        $sql = "SELECT count(children.id) AS value " .
                    " FROM " .
                    tablename('qw_microedu_children') .
                    " AS children " .
                    " WHERE children.uniacid=:uniacid " .
                    " AND children.parent_id=:parent_id ";
        $parent_childrencount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':parent_id'        =>          $parent['id']
        ));
        $parents[$index]['parent_childrencount'] = $parent_childrencount['value'];
        $total_children = $total_children + $parent_childrencount['value'];

        // 2. Get how many contracts this parent purchased
        $sql = "SELECT count(parentscontracts.id) AS value " .
                    " FROM " .
                    tablename('qw_microedu_parentscontracts') .
                    " AS parentscontracts " .
                    " WHERE parentscontracts.uniacid=:uniacid " .
                    " AND parentscontracts.status=1 " .
                    " AND parentscontracts.parent_id=:parent_id ";
        $parent_contractcount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':parent_id'        =>          $parent['id']
        ));
        $parents[$index]['parent_contractcount'] = $parent_contractcount['value'];
        if ($parent_contractcount['value'] > 0) $total_purchased_parents = $total_purchased_parents + 1;

        // 3. Get how many classhours this parent consumed
        $sql = "SELECT COALESCE(sum(schedules.duration), 0) AS value " .
                    " FROM " .
                    tablename('qw_microedu_schedules') .
                    " AS schedules JOIN " .
                    tablename('qw_microedu_attendance') .
                    " AS attendance ON " .
                    " schedules.id=attendance.schedule_id " .
                    " WHERE schedules.uniacid=:uniacid " .
                    " AND attendance.status <> 0 " .
                    " AND attendance.status <> 4 " .
                    " AND attendance.status <> 5 " .
                    " AND attendance.child_id IN " .
                        " (SELECT children.id FROM " .
                        tablename('qw_microedu_children') .
                        " AS children " .
                        " WHERE children.uniacid=:uniacid " .
                        " AND children.parent_id=:parent_id) ";
        $parent_classhourcount = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':parent_id'        =>          $parent['id']
        ));
        if ($parent_classhourcount['value']) {
            $parent_classhourcount = round($parent_classhourcount['value'] / 60, 2);
            $parents[$index]['parent_classhourcount'] = $parent_classhourcount;
        } else {
            $parents[$index]['parent_classhourcount'] = 0;
        }

        // 4. Get how much this parent has spent
        /*
        $sql = "SELECT COALESCE(sum(parentscontracts.contract_price), 0) AS value " .
                    " FROM " .
                    tablename('qw_microedu_parentscontracts') .
                    " AS parentscontracts " .
                    " WHERE parentscontracts.uniacid=:uniacid " .
                    " AND parentscontracts.status=1 " .
                    " AND parentscontracts.parent_id=:parent_id";
        $parent_totalsum  = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':parent_id'        =>          $parent['id']
        ));
        $parents[$index]['parent_totalsum'] = $parent_totalsum['value'];
        */
        $sql = "SELECT COALESCE(sum(invoices.item_price), 0) AS value " .
                    " FROM " .
                    tablename('qw_microedu_invoices') .
                    " AS invoices " .
                    " WHERE invoices.uniacid=:uniacid " .
                    " AND invoices.parent_id=:parent_id ";
        $parent_totalsum = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':parent_id'        =>          $parent['id']
        ));
        $parents[$index]['parent_totalsum'] = $parent_totalsum['value'];
    }

    include $this->template('web/reporting/parent');

// 顾问报表
} elseif ($page == 'consultant') {
    if (!empty($_POST)) {
        $search_condition = $_GPC['search-condition'];
    }

    $sql = "SELECT consultants.id, " .
                " users.fullname, " .
                " users.mobile, " .
                " consultantgroups.group_name " .
                " FROM " .
                tablename('qw_microedu_consultants') .
                " AS consultants JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " consultants.id=users.role_id JOIN " .
                tablename('qw_microedu_consultantgroups') .
                " AS consultantgroups ON " .
                " consultants.consultantgroup_id=consultantgroups.id " .
                " WHERE consultants.uniacid=:uniacid " .
                " AND users.role_type=:role_type ";

    if (empty($search_condition)) {
        $consultants = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':role_type'        =>          'consultants'
        ));
    } else {
        $sql = $sql . " AND ( users.fullname LIKE :search_condition " .
                            " OR users.mobile LIKE :search_condition " .
                            " OR consultantgroups.group_name LIKE :search_condition )";
        $consultants = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':role_type'        =>          'consultants',
            ':search_condition' =>          '%' . $search_condition . '%'
        ));
    }

    // Get total consultant groups
    $sql = "SELECT count(consultantgroups.id) AS value " .
                " FROM " .
                tablename('qw_microedu_consultantgroups') .
                " AS consultantgroups " .
                " WHERE consultantgroups.uniacid=:uniacid";
    $total_groups = pdo_fetch($sql, array(
        ':uniacid'          =>          $_W['uniacid'],
    ));
    $total_groups = $total_groups['value'];

    foreach ($consultants as $index => $consultant) {
        // Get client purchase count and total sales of this consultant
        $sql = "SELECT count(parentscontracts.id) AS consultant_contractcount, " .
                    " COALESCE(sum(parentscontracts.contract_price), 0) AS consultant_sales " .
                    " FROM " .
                    tablename('qw_microedu_parentscontracts') .
                    " AS parentscontracts " .
                    " WHERE parentscontracts.uniacid=:uniacid " .
                    " AND parentscontracts.parent_id " .
                        " IN ( SELECT parents.id FROM " .
                        tablename('qw_microedu_parents') .
                        " AS parents " .
                        " WHERE parents.uniacid=:uniacid " .
                        " AND parents.consultant_id=:consultant_id ) ";
        $item = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':consultant_id'    =>          $consultant['id']
        ));
        $consultant_contractcount = $item['consultant_contractcount'];
        $consultant_sales = $item['consultant_sales'];

        // Get total commission for this consultant
        $sql = "SELECT COALESCE(sum(commissions.amount), 0) AS consultant_commission " .
                    " FROM " .
                    tablename('qw_microedu_commissions') .
                    " AS commissions " .
                    " WHERE commissions.uniacid=:uniacid " .
                    " AND commissions.consultant_id=:consultant_id ";
        $item = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':consultant_id'    =>          $consultant['id']
        ));
        $consultant_commission = $item['consultant_commission'];

        // Get client count for this consultant
        $sql = "SELECT count(parents.id) AS consultant_clientcount " .
                    " FROM " .
                    tablename('qw_microedu_parents') .
                    " AS parents " .
                    " WHERE parents.uniacid=:uniacid " .
                    " AND parents.consultant_id=:consultant_id";
        $item = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':consultant_id'    =>          $consultant['id']
        ));
        $consultant_clientcount = $item['consultant_clientcount'];

        $consultants[$index]['consultant_contractcount'] = $consultant_contractcount;
        $consultants[$index]['consultant_sales'] = $consultant_sales;
        $consultants[$index]['consultant_commission'] = $consultant_commission;
        $consultants[$index]['consultant_clientcount'] = $consultant_clientcount;
    }

    include $this->template('web/reporting/consultant');

// 教师报表
} elseif ($page == 'tutor') {
    if (!empty($_POST)) {
        $search_condition = $_GPC['search-condition'];
    }

    $sql = "SELECT tutors.id, " .
                " users.fullname, " .
                " users.mobile " .
                " FROM " .
                tablename('qw_microedu_tutors') .
                " AS tutors JOIN " .
                tablename('qw_microedu_users') .
                " AS users ON " .
                " tutors.id=users.role_id " .
                " WHERE tutors.uniacid=:uniacid " .
                " AND users.role_type=:role_type ";

    if (empty($search_condition)) {
        $tutors = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':role_type'        =>          'tutors'
        ));
    } else {
        $sql = $sql . " AND ( users.fullname LIKE :search_condition " .
                            " OR users.mobile LIKE :search_condition )" .
        $tutors = pdo_fetchall($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':role_type'        =>          'tutors',
            ':search_condition' =>          '%' . $search_condition . '%'
        ));
    }

    // Get total schedules
    $sql = "SELECT count(schedules.id) AS value " .
                " FROM " .
                tablename('qw_microedu_schedules') .
                " AS schedules " .
                " WHERE schedules.uniacid=:uniacid ";
    $total_schedules = pdo_fetch($sql, array(
        ':uniacid'          =>          $_W['uniacid']
    ));
    $total_schedules = $total_schedules['value'];

    foreach ($tutors as $index => $tutor) {
        // Get schedule count for this tutor
        $sql = "SELECT count(schedules.id) AS tutor_schedulecount " .
                    " FROM " .
                    tablename('qw_microedu_schedules') .
                    " AS schedules " .
                    " WHERE schedules.uniacid=:uniacid " .
                    " AND schedules.tutor_id=:tutor_id ";
        $item  = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor['id']
        ));
        $tutor_schedulecount = $item['tutor_schedulecount'];

        $sql = "SELECT COALESCE(sum(schedules.duration), 0) AS tutor_classhourcount " .
                    " FROM " .
                    tablename('qw_microedu_schedules') .
                    " AS schedules JOIN " .
                    tablename('qw_microedu_attendance') .
                    " AS attendance ON " .
                    " schedules.id=attendance.schedule_id " .
                    " WHERE schedules.uniacid=:uniacid " .
                    " AND schedules.tutor_id=:tutor_id " .
                    " AND attendance.status <> 0 " .
                    " AND attendance.status <> 4 " .
                    " AND attendance.status <> 5 ";
        $item = pdo_fetch($sql, array(
            ':uniacid'          =>          $_W['uniacid'],
            ':tutor_id'         =>          $tutor['id']
        ));
        $tutor_classhourcount = $item['tutor_classhourcount'];

        if ($tutor_classhourcount) {
            $tutor_classhourcount = round($tutor_classhourcount / 60, 2);
        }

        $tutors[$index]['tutor_schedulecount']  = $tutor_schedulecount;
        $tutors[$index]['tutor_classhourcount'] = $tutor_classhourcount;
    }

    include $this->template('web/reporting/tutor');
}
