<?php

defined('IN_IA') or exit('Access Denied');
		global $_W, $_GPC;
		$uniacid = $_W['uniacid'];
		$setting = $this->baseset($uniacid);

$all_all = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tableitemall) . " WHERE uniacid = '{$_W['uniacid']}' ");

$all_user = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' ");


		 include $this->template('opcenter');
        

	
	
		