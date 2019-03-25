<?php
$uniacid = $_W['uniacid'];
$op      = $_GPC['op'] ? $_GPC['op'] : 'display';
$cfg     = $this->module['config'];
$this->checkisAgent($from_user, 1);

$ushareid = $this->getShareId();
if (!empty($ushareid) && $ushareid != 0) {
	$shareprofile = $this->getMember($ushareid);
}
if ($profile['status'] == 0) {
	$profile['flag'] = 0;
}
if (!empty($profile['id']) && $profile['flag'] == 1) {
	$count = 0;
	if (true) {
		$count1   = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid={$profile['id']} AND flag=0");
		$count1_1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid={$profile['id']} AND flag=1");
		
			$commission1_1 = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename("mihua_mall_member") . " as o left join " . tablename("mihua_mall_order_goods") . " as g on o.id=g.orderid and o.uniacid=g.uniacid WHERE o.shareid={$profile['id']} and o.uniacid={$_W['uniacid']} and o.status=3 and g.createtime>={$profile['flagtime']} and o.from_user<>'{$from_user}'");
			$price1_1      = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE  o.shareid=" . $profile['id'] . " and o.uniacid = " . $_W['uniacid'] . " and o.status =3 and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime']);
	}
	if (true && $cfg['globalCommissionLevel'] >= 2) {
		$p22 = pdo_fetchall("SELECT id FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid={$profile['id']}");
		$str = array(-1);
		foreach ($p22 as $row) {
			$str[] = $row['id'];
		}
		$count2   = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid IN(" . implode(",", $str) . ") AND flag=0");
		$count2_1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid IN(" . implode(",", $str) . ") AND flag=1");
			$commission2_1 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE o.shareid2=" . $profile['id'] . " and o.uniacid = " . $_W['uniacid'] . " and o.status =3 and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime']);
			$price2_1      = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE  o.shareid2=" . $profile['id'] . " and o.uniacid = " . $_W['uniacid'] . " and o.status =3  and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime']);
	} else {
		$str = 0;
	}
	if (true && $cfg['globalCommissionLevel'] >= 3) {
		$p33 = pdo_fetchall("SELECT id FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid IN (" . implode(",", $str) . ")");
		$str = array(-1);
		foreach ($p33 as $row) {
			$str[] = $row['id'];
		}
		$count3   = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid IN(" . implode(",", $str) . ") AND flag=0");
		$count3_1 = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("mihua_mall_member") . " WHERE id!=shareid AND shareid IN(" . implode(",", $str) . ") AND flag=1");
			$commission3_1 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE  o.shareid3=" . $profile['id'] . "  and o.uniacid = " . $_W['uniacid'] . " and o.status =3 and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime']);
			$price3_1      = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE  o.shareid3=" . $profile['id'] . " and o.uniacid = " . $_W['uniacid'] . " and o.status =3 and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime']);
	} else {
		$str3 = 0;
	}
	$count = $count1 + $count2 + $count3;
	$count = $count + $count1_1 + $count2_1 + $count3_1;
		$commissionTotal = $commission1_1 + $commission2_1 + $commission3_1;
		$priceTotal      = $price1_1 + $price2_1 + $price3_1;
	$clickcount  = $profile['clickcount'];
	$sql1_member = "select mber1.from_user from " . tablename('mihua_mall_member') . " mber1 where mber1.id!=mber1.shareid and mber1.shareid = " . $profile['id'];
	$followcount = pdo_fetchcolumn("	select count(fans.fanid) from " . tablename('mc_mapping_fans') . " fans where fans.follow=1 and fans.openid!='{$from_user}' and ( fans.openid in (" . $sql1_member . ") ) and fans.uniacid={$_W['uniacid']}");
} else {
	$count       = 0;
	$followcount = 0;
}
$id = $profile['id'];
if (empty($profile['id'])) {
	include $this->template('forbidden');
	exit;
}
$uid = mc_openid2uid($from_user);
// var_dump($uid);
$infos            = mc_fetch($uid, array('avatar'));
$myheadimg['tag'] = mc_credit_fetch($uid);

$this->memberQrcode($from_user);
if (!empty($profile['id']) && $profile['flag'] == 1) {
	$commissioningpe = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE o.shareid = " . $id . " and o.uniacid = " . $_W['uniacid'] . " and (g.status = 0 or g.status = 1) and o.status >= 3 and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime']);
	$fanscount       = pdo_fetch("select count(his.sharemid) count from " . tablename('mihua_mall_share_history') . " his where his.sharemid=:sharemid", array(':sharemid' => $profile['id']));
	$medal_name      = pdo_fetchcolumn('SELECT medal_name FROM ' . tablename('mihua_mall_phb_medal') . " WHERE uniacid = :uniacid and fans_count>=:fans_count  and fans_count<=:fans_count order by fans_count   limit 1", array(':uniacid' => $_W['uniacid'], ':fans_count' => $fanscount));
	if (empty($medal_name)) {
		$medal_name = '普通代理';
	}
} else {
	$fanscount  = 0;
	$medal_name = '普通会员';
}
if (empty($commissioningpe)) {
	$commissioningpe = 0;
}
$commtime   = pdo_fetch("select promotercount,promotermoney,promotertimes from " . tablename('mihua_mall_rules') . " where uniacid = " . $_W['uniacid']);
$total      = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('mihua_mall_order') . " WHERE status= '3' AND  uniacid = :uniacid  AND from_user = :from_user", array(':uniacid' => $_W['uniacid'], ':from_user' => $from_user));
$totalmoney = pdo_fetchcolumn('SELECT sum(price) FROM ' . tablename('mihua_mall_order') . " WHERE status= '3' AND  uniacid = :uniacid  AND from_user = :from_user", array(':uniacid' => $_W['uniacid'], ':from_user' => $from_user));
$tmsg       = '购买一单升级为代理';
if ($commtime['promotercount'] > $total && $commtime['promotertimes'] == 2) {
	$tmsg = '购买' . ($commtime['promotercount'] - $total) . '单才升级为代理';
}
if ($commtime['promotermoney'] > $totalmoney && $commtime['promotertimes'] == 3) {
	$tmsg = '购买' . ($commtime['promotermoney'] - $totalmoney) . '金额升级为代理';
}
$msg_count=count($this->web_msg());
#专题，商品
$zt_list=pdo_fetchcolumn("select count(*) from ".tablename('mihua_zt')." where status=1 ");
$goods_num=pdo_fetchcolumn("select count(*) from ".tablename('mihua_mall_goods')." where status=1 ");
include $this->template('newhome2');