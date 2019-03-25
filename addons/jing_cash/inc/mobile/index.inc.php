<?php
/**
 * 餐饮商城模块微站定义
 *
 * @author 刘靜
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
load()->model('mc');
$schoolid = $_GPC['schoolid'];
$result = mc_credit_fetch($_W['member']['uid']);
include $this->template('index');
?>