<?php
/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2017/1/10
 * Time: 下午12:39
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
$where = '';
$params = array(':uid' => $_W['member']['uid']);
$pindex = max(1, intval($_GPC['page']));
$psize = 15;

$period = intval($_GPC['period']);
if ($period == '1') {
    $starttime = date('Ym01',strtotime(0));
    $endtime = date('Ymd His', time());
} elseif($period == '0') {
    $starttime = date('Ym01', strtotime(1*$period . "month"));
    $endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
} else {
    $starttime = date('Ym01', strtotime(1*$period . "month"));
    $endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
}
$where = ' AND `createtime` >= :starttime AND `createtime` < :endtime';
$params[':starttime'] = strtotime($starttime);
$params[':endtime'] = strtotime($endtime);

$sql = 'SELECT `realname`, `avatar` FROM ' . tablename('mc_members') . " WHERE `uid` = :uid";
$user = pdo_fetch($sql, array(':uid' => $_W['member']['uid']));
if ($_GPC['credittype']) {

    if ($_GPC['type'] == 'order') {
        $sql = 'SELECT * FROM ' . tablename('mc_credits_recharge') . " WHERE `uid` = :uid $where LIMIT " . ($pindex - 1) * $psize. ',' . $psize;
        $orders = pdo_fetchall($sql, $params);
        foreach ($orders as &$value) {
            $value['createtime'] = date('Y-m-d', $value['createtime']);
            $value['fee'] = number_format($value['fee'], 2);
            if ($value['status'] == 1) {
                $orderspay += $value['fee'];
            }
            unset($value);
        }

        $ordersql = 'SELECT COUNT(*) FROM ' .tablename('mc_credits_recharge') . "WHERE `uid` = :uid {$where}";
        $total = pdo_fetchcolumn($ordersql, $params);
        $orderpager = pagination($total, $pindex, $psize, '', array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
        template('mc/bond');
        exit();
    }
    $where .= " AND `credittype` = '{$_GPC['credittype']}'";
}


$sql = 'SELECT `num` FROM ' . tablename('mc_credits_record') . " WHERE `uid` = :uid $where";
$nums = pdo_fetchall($sql, $params);
$pay = $income = 0;
foreach ($nums as $value) {
    if ($value['num'] > 0) {
        $income += $value['num'];
    } else {
        $pay += abs($value['num']);
    }
}
if ($_GPC['credittype'] == 'credit2') {
    $pay = number_format($pay, 2);
    $income = number_format($income, 2);
}

$sql = 'SELECT * FROM ' . tablename('mc_credits_record') . " WHERE `uid` = :uid {$where} ORDER BY `createtime` DESC LIMIT " . ($pindex - 1) * $psize.','. $psize;
$data = pdo_fetchall($sql, $params);
foreach ($data as $key=>$value) {
    $data[$key]['credittype'] = $creditnames[$data[$key]['credittype']]['title'];
    $data[$key]['createtime'] = date('Y-m-d H:i', $data[$key]['createtime']);
    $data[$key]['num'] = number_format($value['num'], 2);
    if ($data[$key]['num'] < 0) {
        $data[$key]['color'] = "#000";
    } else {
        $data[$key]['color'] = "#04be02";
        $data[$key]['num'] = "+" . $data[$key]['num'];
    }
    $data[$key]['remark'] = str_replace('credit1', '积分', $data[$key]['remark']);
    $data[$key]['remark'] = str_replace('credit2', '余额', $data[$key]['remark']);
    $data[$key]['remark'] = empty($data[$key]['remark']) ? '未记录' : $data[$key]['remark'];
    if(!empty($data[$key]['remark']) && preg_match('/消费/',$data[$key]['remark'])){
        $data[$key]['remark'] = '余额提现';
    }
}

$pagesql = 'SELECT COUNT(*) FROM ' .tablename('mc_credits_record') . "WHERE `uid` = :uid {$where}";
$total = pdo_fetchcolumn($pagesql, $params);
$pager = pagination($total, $pindex, $psize, '', array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
$pagenums = ceil($total / $psize);
if($_W['isajax'] && $_W['ispost']) {
    if (!empty($data)){
        exit(json_encode($data));
    } else {
        exit(json_encode(array('state'=>'error')));
    }
}
$type = trim($_GPC['type']);
if ($type == 'recorddetail') {
    $id = intval($_GPC['id']);
    $credittype = $_GPC['credittype'];
    $data = pdo_fetch("SELECT r.*, u.username FROM " . tablename('mc_credits_record') . ' AS r LEFT JOIN ' .tablename('users') . ' AS u ON r.operator = u.uid ' . ' WHERE r.id = :id AND r.uniacid = :uniacid AND r.credittype = :credittype ORDER BY id DESC LIMIT ' . ($pindex - 1) * $psize .',' . $psize, array(':uniacid' => $_W['uniacid'], ':id' => $id, ':credittype' => $credittype));
    if ($data['credittype'] == 'credit2') {
        $data['credittype'] = '余额';
    } elseif ($data['credittype'] == 'credit1') {
        $data['credittype'] = '积分';
    }
    $data['remark'] = str_replace('credit1', '积分', $data['remark']);
    $data['remark'] = str_replace('credit2', '余额', $data['remark']);
    $data['remark'] = empty($data['remark']) ? '暂无记录' : $data['remark'];
}
include $this->template('bond');