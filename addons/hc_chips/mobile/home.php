<?php
	$member = pdo_fetch("select * from ".tablename('hc_chips_member')." where uniacid = ".$uniacid." and openid = '".$_W['openid']."'");
	if(empty($member)){
		$urlcookie = "hc_chips_url".$_W['uniacid'];
		$url = $this->createMobileUrl('home');
		setcookie($urlcookie, $url, time()+3600*240);
		$this->CheckCookie(time());
	}
	$rule = pdo_fetch("select * from ".tablename('hc_chips_rule')." where uniacid = ".$uniacid);
	if($op=='mychips'){
		$mychips = pdo_fetchall("select c.* from ".tablename('hc_chips_takechip')." as t left join ".tablename('hc_chips_chip')." as c on t.uniacid = c.uniacid and t.chipid = c.id where t.uniacid = ".$uniacid." and mid = ".$member['id']); 
		$takechips = pdo_fetchall("select chipid, count(id) as num from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid." group by chipid");
		$takechip = array();
		foreach($takechips as $t){
			$takechip[$t['chipid']] = $t['num'];
		}
		include $this->template('mychips');
		exit;
	}

	include $this->template('home');
?>