<?php
	$chipid = $_GPC['id'];
	if(intval($chipid)){
		if($op=='detail'){
			$title = '卡券详情';
			$rule = pdo_fetch("select id, view, title, description, picture, detail as rule from ".tablename('hc_chips_chip')." where id = ".$chipid);
		} else {
			$title = '活动规则';
			$rule = pdo_fetch("select id, view, title, description, picture, rule from ".tablename('hc_chips_chip')." where id = ".$chipid);
		}
		pdo_update('hc_chips_chip', array('view'=>$rule['view']+1), array('id'=>$rule['id']));
	} else {
		$title = '活动规则';
		$rule = pdo_fetch("select * from ".tablename('hc_chips_rule')." where uniacid = ".$uniacid);
	}
	include $this->template('rule');
?>