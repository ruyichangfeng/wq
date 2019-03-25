<?php

if (isset($_GPC['section']) && strtotime($_GPC['section']['start']) < strtotime($_GPC['section']['end'])) {
    $starttime = strtotime($_GPC['section']['start']);
    $endtime   = strtotime($_GPC['section']['end']);
} else {
    $starttime = strtotime(date('Y/m/d', strtotime('-7 days')));
    $endtime   = time();
}

$chartlabel = array();
$all        = array();
$pay        = array();
$nopay      = array();
$cancelpay  = array();
$temp       = 0;
for ( $i=0; ($temp + $starttime) < $endtime; $i++ ) {
    $temp      = $i * 3600*24;
    $chartlabel[] = '"'.date('Y/m/d', $starttime + $temp).'"';
    $pay_tmp   = getDataSectionOrders($starttime+$temp, $starttime + $temp + 3600*24, 1);
    $nopay_tmp = getDataSectionOrders($starttime+$temp, $starttime  + $temp + 3600*24, 0);
    $cancel_tmp= getDataSectionOrders($starttime+$temp, $starttime  + $temp + 3600*24, -2);
    $all_tmp   = $pay_tmp + $nopay_tmp + $cancel_tmp;
    $pay[]     = $pay_tmp;
    $nopay[]   = $nopay_tmp;
    $cancelpay[]= $cancel_tmp;
    $all[]     = $all_tmp;
}


//获取今天，本周，本月
$today = getDataSectionOrders(strtotime(date('Y/m/d', time())), strtotime(date('Y/m/d'), strtotime('+1 days')));
$week  = getDataSectionOrders(strtotime(date('Y/m/d', strtotime('-7 days'))), strtotime(date('Y/m/d', time())));
$month = getDataSectionOrders(strtotime(date('Y/m/d', strtotime('-30 days'))), strtotime(date('Y/m/d', time())));

include_once $this->template('charts');