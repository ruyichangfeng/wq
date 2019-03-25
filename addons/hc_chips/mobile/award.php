<?php
	if($op=='display'){
		$chips = pdo_fetchall("select id, title from ".tablename('hc_chips_chip')." where uniacid = ".$uniacid);
		$chip = array();
		foreach($chips as $c){
			$chip[$c['id']] = $c['title'];
		}
		$awards = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where isaward = 1 and uniacid = ".$uniacid." order by id desc");
	}
	include $this->template('award');
?>