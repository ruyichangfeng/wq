<?php
	$rule = pdo_fetch("select * from ".tablename('hc_chips_rule')." where uniacid = ".$uniacid);
	if($op=='display'){
		$chips = pdo_fetchall("select * from ".tablename('hc_chips_chip')." where uniacid = ".$uniacid." and isopen = 1 order by listorder desc, id desc");
	}
	include $this->template('index');
?>