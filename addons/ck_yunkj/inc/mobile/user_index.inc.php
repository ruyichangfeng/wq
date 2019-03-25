<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";
require "user_common.php";

$newtimes =  mktime();

//未读通知数量
$total_notice_wd1 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_notice')."  WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and readt = '0' and type = 'system'");

//未读欠费通知数量
$total_notice_wd2 = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_notice')."  WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and readt = '0' and type = 'owe'");

//未付款订单
$total_order_w = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_order')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and paystatus = '0'");

//未读待记账数
$total_tallys_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_report')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and readt = '0'");

//服务数量
$total_service = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_list')."  WHERE weid = '{$_W['uniacid']}' and shelves = '1'");

//未支付缴费信息
$total_pay_wz = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_paycost')." WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and status = '0'");
	
include $this->template('user_index');

?>