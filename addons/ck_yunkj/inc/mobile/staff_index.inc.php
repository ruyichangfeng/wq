<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";
require "staff_common.php";

//未读通知数量
$total_notice_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_notice')."  WHERE weid = '{$_W['uniacid']}' and uid = '{$_W['member']['uid']}' and readt = '0'");

//未读投诉数量
$total_user_toushu_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_toushu')."  WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' and readt = '0'");

//未读评价数量
$total_staff_bpf_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_staff_bpf')."  WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' and readt = '0'");

//未读服务订单
$total_staff_order_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_order')." WHERE weid = '{$_W['uniacid']}' and readt = '0'");

//未读业务申请
$total_staff_ywlist_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_ywlist')." WHERE weid = '{$_W['uniacid']}' and yguid = '0' ");
	
include $this->template('staff_index');