<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "public.php";
require "admin_common.php";

//客户数量
$total_admin_userlist = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_list')." WHERE weid = '{$_W['uniacid']}' and type = '1'");

//购买成为正式客户数量
$total_admin_payofficial_fp = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_list')." AS a LEFT JOIN ".tablename('cwgl_user_payofficial')." AS b on a.uid=b.uid WHERE b.weid = '{$_W['uniacid']}' and b.status = '1' and a.yguid = '0'");

//未读投诉数量
$total_admin_toushu_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_toushu')."  WHERE weid = '{$_W['uniacid']}' and readt = '0'");

//未读服务订单
$total_admin_order_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_order')." WHERE weid = '{$_W['uniacid']}' and yguid = '0' and paystatus = '1'");

//未读业务申请
$total_admin_ywlist_wd = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_ywlist')." WHERE weid = '{$_W['uniacid']}' and yguid = '0'");
	
include $this->template('admin_index');