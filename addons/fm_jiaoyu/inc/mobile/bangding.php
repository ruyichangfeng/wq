<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
	global $_W, $_GPC;
	$weid = $_W ['uniacid'];
	$openid = $_W['openid'];
	$schoolid = intval($_GPC['schoolid']); 
	$school = pdo_fetch("SELECT title,bd_type FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");
	$bdset = get_weidset($weid,'bd_set');
	$sms_set = get_school_sms_set($schoolid);
	include $this->template('bangding');
		
?>