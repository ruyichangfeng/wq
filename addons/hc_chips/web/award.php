<?php
	if($op=='display'){
		$chips = pdo_fetchall("select id, title from ".tablename('hc_chips_chip')." where uniacid = ".$uniacid);
		$chip = array();
		foreach($chips as $c){
			$chip[$c['id']] = $c['title'];
		}
		$members = pdo_fetchall("select id, realname from ".tablename('hc_chips_member')." where uniacid = ".$uniacid);
		$member = array();
		foreach($members as $m){
			$member[$m['id']] = base64_decode($m['realname']);
		}
		$awards = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where isaward = 1 and uniacid = ".$uniacid." order by id desc");
	}
	
	if($op=='delete'){
		$id = intval($_GPC['id']);
		pdo_update('hc_chips_takechip', array('isaward'=>0), array('id'=>$id));
		message('删除成功！', $this->createWebUrl('award'), 'success');
	}
	
	include $this->template('web/award_list');
?>