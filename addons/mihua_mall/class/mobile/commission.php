<?php
$uniacid = $_W['uniacid'];
$op      = $_GPC['op'] ? $_GPC['op'] : 'display';
$cfg     = $this->module['config'];
$id      = $profile['id'];
if (intval($profile['id']) && $profile['status'] == 0) {
	include $this->template('forbidden');
	exit;
}
if ($cfg['globalCommissionLevel'] < 2) {
	$level2enable = ' and 1!=1 ';
}
if ($cfg['globalCommissionLevel'] < 3) {
	$level3enable = ' and 1!=1 ';
}

if ($op == 'display') {
	$commissioningpe_re=pdo_fetch("select balance from ".tablename('mihua_mall_member')." where id={$profile['id']} ");
	$commissioningpe=$commissioningpe_re['balance'];
	if ($commissioningpe == 0) {
		$commissioningpe = "0.00";
	}
	$commission1   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid = " . $profile['id'] . " and g.status = 0)   )  and o.uniacid = " . $_W['uniacid'] . " and (o.status =1 or o.status =2)  and  g.createtime>=" . $profile['flagtime']);
	$commission1x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ( (o.shareid2 = " . $profile['id'] . " and g.status2 = 0)  )  and o.uniacid = " . $_W['uniacid'] . " and (o.status =1 or o.status =2) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission1x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ( (o.shareid3 = " . $profile['id'] . " and g.status3 = 0)  )  and o.uniacid = " . $_W['uniacid'] . " and (o.status =1 or o.status =2) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission1)) {
		$commission1 = 0;
	}
	if (empty($commission1x2)) {
		$commission1x2 = 0;
	}
	if (empty($commission1x3)) {
		$commission1x3 = 0;
	}
	$commission1 = $commission1 + $commission1x2 + $commission1x3;
	if ($commission1 == 0) {
		$commission1 = "0.00";
	}
	$commission2   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid = " . $profile['id'] . " and g.status = 1)  )   and o.uniacid = " . $_W['uniacid'] . "  and o.status >=3  and  g.createtime>=" . $profile['flagtime']);
	$commission2x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid2 = " . $profile['id'] . " and g.status2 = 1) )   and o.uniacid = " . $_W['uniacid'] . "  and o.status >=3  $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission2x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ( (o.shareid3 = " . $profile['id'] . " and g.status3 = 1)  )   and o.uniacid = " . $_W['uniacid'] . "  and o.status >=3  $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission2)) {
		$commission2 = 0;
	}
	if (empty($commission2x2)) {
		$commission2x2 = 0;
	}
	if (empty($commission2x3)) {
		$commission2x3 = 0;
	}
	$commission2 = $commission2 + $commission2x2 + $commission2x3;
	if ($commission2 == 0) {
		$commission2 = "0.00";
	}
	$commission3   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid = " . $profile['id'] . " and g.status = -1) ) and o.uniacid = " . $_W['uniacid'] . "   and  g.createtime>=" . $profile['flagtime']);
	$commission3x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid2 = " . $profile['id'] . " and g.status2 = -1) ) and o.uniacid = " . $_W['uniacid'] . "   $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission3x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid3 = " . $profile['id'] . " and g.status3 = -1) ) and o.uniacid = " . $_W['uniacid'] . "   $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission3)) {
		$commission3 = 0;
	}
	if (empty($commission3x2)) {
		$commission3x2 = 0;
	}
	if (empty($commission3x3)) {
		$commission3x3 = 0;
	}
	$commission3 = $commission3 + $commission3x2 + $commission3x3;
	if ($commission3 == 0) {
		$commission3 = "0.00";
	}
	$commission4   = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =0 or o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =0))  and  g.createtime>=" . $profile['flagtime']);
	$commission4x2 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =0 or o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =0)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission4x3 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =0 or o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =0)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission4)) {
		$commission4 = 0;
	}
	if (empty($commission4x2)) {
		$commission4x2 = 0;
	}
	if (empty($commission4x3)) {
		$commission4x3 = 0;
	}
	$commission4 = $commission4 + $commission4x2 + $commission4x3;
	if ($commission4 == 0) {
		$commission4 = "0.00";
	}
	$commission4_1   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =0 or o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =0))  and  g.createtime>=" . $profile['flagtime']);
	$commission4_1x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =0 or o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =0)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission4_1x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =0 or o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =0)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission4_1)) {
		$commission4_1 = 0;
	}
	if (empty($commission4_1x2)) {
		$commission4_1x2 = 0;
	}
	if (empty($commission4_1x3)) {
		$commission4_1x3 = 0;
	}
	$commission4_1 = $commission4_1 + $commission4_1x2 + $commission4_1x3;
	if ($commission4_1 == 0) {
		$commission4_1 = "0.00";
	}
	$commission5   = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ")  and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status >1)) or ((o.paytype=1 or o.paytype=2 ) and o.status >0))  and  g.createtime>=" . $profile['flagtime']);
	$commission5x2 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ")  and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status >1)) or ((o.paytype=1 or o.paytype=2 ) and o.status >0)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission5x3 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ")  and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status >1)) or ((o.paytype=1 or o.paytype=2 ) and o.status >0)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission5)) {
		$commission5 = 0;
	}
	if (empty($commission5x2)) {
		$commission5x2 = 0;
	}
	if (empty($commission5x3)) {
		$commission5x3 = 0;
	}
	$commission5 = $commission5 + $commission5x2 + $commission5x3;
	if ($commission5 == 0) {
		$commission5 = "0.00";
	}
	// die("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1))  and  g.createtime>=" . $profile['flagtime']);
	$commission5_1   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1))  and  g.createtime>=" . $profile['flagtime']);
	$commission5_1x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission5_1x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission5_1)) {
		$commission5_1 = 0;
	}
	if (empty($commission5_1x2)) {
		$commission5_1x2 = 0;
	}
	if (empty($commission5_1x3)) {
		$commission5_1x3 = 0;
	}
	$commission5_1 = $commission5_1 + $commission5_1x2 + $commission5_1x3;
	if ($commission5_1 == 0) {
		$commission5_1 = "0.00";
	}
	$commission6   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1 or o.status =0)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1))  and  g.createtime>=" . $profile['flagtime']);
	$commission6x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1 or o.status =0)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission6x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1 or o.status =0)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission6)) {
		$commission6 = 0;
	}
	if (empty($commission6x2)) {
		$commission6x2 = 0;
	}
	if (empty($commission6x3)) {
		$commission6x3 = 0;
	}
	$commission6 = $commission6 + $commission6x2 + $commission6x3;
	if ($commission6 == 0) {
		$commission6 = "0.00";
	}
	$commission6_1   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =2)) or ((o.paytype=1 or o.paytype=2 ) and o.status =2))  and  g.createtime>=" . $profile['flagtime']);
	$commission6_1x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =2)) or ((o.paytype=1 or o.paytype=2 ) and o.status =2)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission6_1x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =2)) or ((o.paytype=1 or o.paytype=2 ) and o.status =2)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission6_1)) {
		$commission6_1 = 0;
	}
	if (empty($commission6_1x2)) {
		$commission6_1x2 = 0;
	}
	if (empty($commission6_1x3)) {
		$commission6_1x3 = 0;
	}
	$commission6_1 = $commission6_1 + $commission6_1x2 + $commission6_1x3;
	if ($commission6_1 == 0) {
		$commission6_1 = "0.00";
	}
	$commission7   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and o.status =3   and  g.createtime>=" . $profile['flagtime']);
	$commission7x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and o.status =3 $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission7x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and o.status =3 $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission7)) {
		$commission7 = 0;
	}
	if (empty($commission7x2)) {
		$commission7x2 = 0;
	}
	if (empty($commission7x3)) {
		$commission7x3 = 0;
	}
	$commission7 = $commission7 + $commission7x2 + $commission7x3;
	if ($commission7 == 0) {
		$commission7 = "0.00";
	}
	$commission8   = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1 or o.status =0)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1))  and  g.createtime>=" . $profile['flagtime']);
	$commission8x2 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1 or o.status =0)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1)) $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission8x3 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and ( (o.paytype=3 and (o.status =1 or o.status =0)) or ((o.paytype=1 or o.paytype=2 ) and o.status =1)) $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission8)) {
		$commission8 = 0;
	}
	if (empty($commission8x2)) {
		$commission8x2 = 0;
	}
	if (empty($commission8x3)) {
		$commission8x3 = 0;
	}
	$commission8 = $commission8 + $commission8x2 + $commission8x3;
	if ($commission8 == 0) {
		$commission8 = "0.00";
	}
	$commission9   = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and o.status =3  and  g.createtime>=" . $profile['flagtime']);
	$commission9x2 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and o.status =3 $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission9x3 = pdo_fetchcolumn("SELECT sum((o.price)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . ") and o.uniacid = " . $_W['uniacid'] . " and o.status =3 $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission9)) {
		$commission9 = 0;
	}
	if (empty($commission9x2)) {
		$commission9x2 = 0;
	}
	if (empty($commission9x3)) {
		$commission9x3 = 0;
	}
	$commission9 = $commission9 + $commission9x2 + $commission9x3;
	if ($commission9 == 0) {
		$commission9 = "0.00";
	}
	$commission9_1   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid = " . $profile['id'] . "  and g.status=1)) and o.uniacid = " . $_W['uniacid'] . " and o.status =3   and  g.createtime>=" . $profile['flagtime']);
	$commission9_1x2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid2 = " . $profile['id'] . "  and g.status2=1)) and o.uniacid = " . $_W['uniacid'] . " and o.status =3 $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commission9_1x3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid3 = " . $profile['id'] . "  and g.status3=1)) and o.uniacid = " . $_W['uniacid'] . " and o.status =3 $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commission9_1)) {
		$commission9_1 = 0;
	}
	if (empty($commission9_1x2)) {
		$commission9_1x2 = 0;
	}
	if (empty($commission9_1x3)) {
		$commission9_1x3 = 0;
	}
	$commission9_1 = $commission9_1 + $commission9_1x2 + $commission9_1x3;
	if ($commission9_1 == 0) {
		$commission9_1 = "0.00";
	}
	$commissioned = $profile['commission'];
	$total        = pdo_fetchcolumn("select count(id) from " . tablename('mihua_mall_commission') . " where mid =" . $profile['id'] . " and flag = 0");
	if ($_GPC['opp'] == 'more') {
		$opp    = 'more';
		$pindex = max(1, intval($_GPC['page']));
		$psize  = 15;
		$list   = pdo_fetchall("select co.isshare,co.commission, co.createtime, og.orderid, og.goodsid, og.total,oo.ordersn from " . tablename('mihua_mall_commission') . " as co left join " . tablename('mihua_mall_order_goods') . " as og on co.ogid = og.id and co.uniacid = og.uniacid left join " . tablename('mihua_mall_order') . " as oo on oo.id = og.orderid and co.uniacid = og.uniacid where co.mid =" . $profile['id'] . " and co.flag = 0 ORDER BY co.createtime DESC limit " . ($pindex - 1) * $psize . ',' . $psize);
		$pager  = pagination($total, $pindex, $psize);
	} else {
		$list = pdo_fetchall("select co.isshare,co.commission, co.createtime, og.orderid, og.goodsid, og.total,oo.ordersn from " . tablename('mihua_mall_commission') . " as co left join " . tablename('mihua_mall_order_goods') . " as og on co.ogid = og.id and co.uniacid = og.uniacid left join " . tablename('mihua_mall_order') . " as oo on oo.id = og.orderid and co.uniacid = og.uniacid where co.mid =" . $profile['id'] . " and co.flag = 0 ORDER BY co.createtime DESC limit 10");
	}
	$addresss = pdo_fetchall("select id, realname from " . tablename('mihua_mall_address') . " where uniacid = " . $_W['uniacid']);
	$address  = array();
	foreach ($addresss as $adr) {
		$address[$adr['id']] = $adr['realname'];
	}
	$goods = pdo_fetchall("select id, title from " . tablename('mihua_mall_goods') . " where uniacid = " . $_W['uniacid']);
	$good  = array();
	foreach ($goods as $g) {
		$good[$g['id']] = $g['title'];
	}
}
if ($op == 'commissionDetail') {
	$pindex          = max(1, intval($_GPC['page']));
	$psize           = 30;
	$condition       = " and orders.status >= 0 ";
	$condition1      = $condition . " AND (orders.shareid = '" . $profile['id'] . "') AND orders.createtime>=" . $profile['flagtime'] . " AND orders.from_user<>'" . $from_user . "'";
	$condition2      = $condition . " AND (orders.shareid2 = '" . $profile['id'] . "') AND orders.createtime>=" . $profile['flagtime'] . " $level2enable AND orders.from_user<>'" . $from_user . "'";
	$condition3      = $condition . " AND (orders.shareid3 = '" . $profile['id'] . "') AND orders.createtime>=" . $profile['flagtime'] . " $level3enable AND orders.from_user<>'" . $from_user . "'";
	$conditionMember = "select m.realname from " . tablename('mihua_mall_member') . " m where m.from_user=orders.from_user and m.uniacid=" . $_W['uniacid'];
	$list            = pdo_fetchall("SELECT 1 as level,orders.status,orders.createtime,orders.ordersn,bjog.status as status1,bjog.commission*bjog.total as commission,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id WHERE  orders.uniacid = '{$_W['uniacid']}' and bjog.commission!=0 $condition1 union all (SELECT 2 as level,orders.status,orders.createtime,orders.ordersn,bjog.status2 as status1,bjog.commission2*bjog.total as commission,( $conditionMember) realname  FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id  WHERE  orders.uniacid = '{$_W['uniacid']}' and bjog.commission!=0 $condition2) union all(SELECT 3 as level,orders.status,orders.createtime,orders.ordersn,bjog.status3 as status1,bjog.commission3*bjog.total as commission,( $conditionMember) realname  FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id   WHERE  orders.uniacid = '{$_W['uniacid']}' and bjog.commission!=0 $condition3) ORDER BY  createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	$listx           = pdo_fetchall("SELECT 1 as level,orders.status,orders.createtime,orders.ordersn,bjog.status as status1,bjog.commission*bjog.total as commission,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id WHERE  orders.uniacid = '{$_W['uniacid']}' and bjog.commission!=0 $condition1 union all (SELECT 2 as level,orders.status,orders.createtime,orders.ordersn,bjog.status2 as status1,bjog.commission2*bjog.total as commission,( $conditionMember) realname  FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id  WHERE  orders.uniacid = '{$_W['uniacid']}' and bjog.commission!=0 $condition2) union all(SELECT 3 as level,orders.status,orders.createtime,orders.ordersn,bjog.status3 as status1,bjog.commission3*bjog.total as commission,( $conditionMember) realname  FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id   WHERE  orders.uniacid = '{$_W['uniacid']}' and bjog.commission!=0 $condition3) ");
	$total           = sizeof($listx);
	$pager           = pagination($total, $pindex, $psize);
	$list2           = pdo_fetchall("SELECT * FROM " . tablename('core_paylog') . " WHERE openid='" . $from_user . "' AND type='zhifu' AND uniacid=" . $_W['uniacid'] . " ORDER BY plid DESC ");
	include $this->template('page_commissionDetail');
	exit;
}
if ($op == 'commapply') {
	$bankcard = pdo_fetch("select id, bankcard, banktype,alipay from " . tablename('mihua_mall_member') . " where uniacid = " . $_W['uniacid'] . " and from_user = '" . $from_user . "'");
	if (empty($bankcard['bankcard']) || empty($bankcard['banktype'])) {
		message('请先完善银行卡信息！', $this->createMobileUrl('bankcard', array('id' => $bankcard['id'], 'opp' => 'complated')), 'error');
	}
	$commissioningpe   = pdo_fetchcolumn("SELECT sum((g.commission*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid = " . $profile['id'] . " and g.status = 0)  ) and o.uniacid = " . $_W['uniacid'] . " and   o.status >= 3  and  g.createtime>=" . $profile['flagtime']);
	$commissioningpex2 = pdo_fetchcolumn("SELECT sum((g.commission2*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid2 = " . $profile['id'] . " and g.status2 = 0)  ) and o.uniacid = " . $_W['uniacid'] . " and   o.status >= 3 $level2enable  and  g.createtime>=" . $profile['flagtime']);
	$commissioningpex3 = pdo_fetchcolumn("SELECT sum((g.commission3*g.total)) FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE ((o.shareid3 = " . $profile['id'] . " and g.status3 = 0)  ) and o.uniacid = " . $_W['uniacid'] . " and   o.status >= 3 $level3enable  and  g.createtime>=" . $profile['flagtime']);
	if (empty($commissioningpex3)) {
		$commissioningpex3 = 0;
	}
	if (empty($commissioningpex2)) {
		$commissioningpex2 = 0;
	}
	if (empty($commissioningpe)) {
		$commissioningpe = 0;
	}
	$commissioningpe = $commissioningpe + $commissioningpex2 + $commissioningpex3;
	if ($commissioningpe == 0) {
		$commissioningpe = "0.00";
	}
	$zhifucommission = $cfg['zhifuCommission'];
	if ($commissioningpe < $zhifucommission) {
		message('您还未满足打款金额！', referer(), 'error');
	}
	$conditionMember = "select m.realname from " . tablename('mihua_mall_member') . " m where m.from_user=orders.from_user and m.uniacid=" . $_W['uniacid'];
	$list2           = pdo_fetchall("SELECT 1 as level,orders.status,orders.createtime,orders.ordersn,bjog.status as status1,bjog.commission*bjog.total as commission,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id  WHERE  ((orders.shareid = " . $profile['id'] . " and bjog.status = 0) ) and orders.uniacid = '{$_W['uniacid']}' and  orders.status >= 3 and orders.from_user != '" . $from_user . "' and  bjog.createtime>=" . $profile['flagtime'] . " union all (" . "SELECT 2 as level,orders.status,orders.createtime,orders.ordersn,bjog.status2 as status1,bjog.commission2*bjog.total as commission,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id  WHERE  ((orders.shareid2 = " . $profile['id'] . " and bjog.status2 = 0) ) and orders.uniacid = '{$_W['uniacid']}' and  orders.status >= 3 and orders.from_user != '" . $from_user . "' and  bjog.createtime>=" . $profile['flagtime'] . ") union all (" . "SELECT 3 as level,orders.status,orders.createtime,orders.ordersn,bjog.status3 as status1,bjog.commission3*bjog.total as commission,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " orders left join  " . tablename('mihua_mall_order_goods') . " bjog on bjog.orderid=orders.id  WHERE  ((orders.shareid3 = " . $profile['id'] . " and bjog.status3 = 0) ) and orders.uniacid = '{$_W['uniacid']}' and  orders.status >= 3 and orders.from_user != '" . $from_user . "' and  bjog.createtime>=" . $profile['flagtime'] . ")");
	include $this->template('page_commapply');
	exit;
}
if ($op == 'applyed') {
	if ($profile['flag'] == 0) {
		message('申请佣金失败！');
	}
	$isbank = pdo_fetch("select id, bankcard, banktype from " . tablename('mihua_mall_member') . " where uniacid = " . $_W['uniacid'] . " and from_user = '" . $from_user . "'");
	if (empty($isbank['bankcard']) || empty($isbank['banktype'])) {
		message('请先完善银行卡信息！', $this->createMobileUrl('bankcard', array('id' => $isbank['id'], 'opp' => 'complated')), 'error');
	}
	$orders  = pdo_fetchall("SELECT 1 as level,g.id,g.commission as commission,g.total,g.createtime,o.shareid as shareid FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid = " . $profile['id'] . " and g.status = 0) and o.uniacid = " . $_W['uniacid'] . "  and o.status >= 3 and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime'] . " union all (" . "SELECT 2 as level,g.id,g.commission2 as commission,g.total,g.createtime,o.shareid2 as shareid FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid2 = " . $profile['id'] . " and g.status2 = 0) and o.uniacid = " . $_W['uniacid'] . "  and o.status >= 3 $level2enable and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime'] . ")" . " union all (" . "SELECT 3 as level,g.id,g.commission3 as commission,g.total,g.createtime,o.shareid3 as shareid FROM " . tablename('mihua_mall_order') . " as o left join " . tablename('mihua_mall_order_goods') . " as g on o.id = g.orderid and o.uniacid = g.uniacid WHERE (o.shareid3 = " . $profile['id'] . " and g.status3 = 0) and o.uniacid = " . $_W['uniacid'] . "  and o.status >= 3 $level3enable and o.from_user != '" . $from_user . "' and  g.createtime>=" . $profile['flagtime'] . ")");
	$almoney = 0;
	foreach ($orders as $order) {
		if ($order['shareid'] == $profile['id']) {
			if (!empty($order['commission']) && $order['commission'] > 0 && $order['createtime'] >= $profile['flagtime']) {
				if ($order['level'] == 1) {
					$update = array('status' => 1, 'applytime' => time());
				}
				if ($order['level'] == 2) {
					$update = array('status2' => 1, 'applytime2' => time());
				}
				if ($order['level'] == 3) {
					$update = array('status3' => 1, 'applytime3' => time());
				}
				pdo_update('mihua_mall_order_goods', $update, array('id' => $order['id']));
				$almoney = $almoney + ($order['commission'] * $order['total']);
			}
		}
	}
	$tagent = $this->getMember($this->getShareId());
	$this->sendyjsqtz($almoney, $profile['realname'], $tagent['from_user']);
	message('申请成功！', $this->createMobileUrl('commission'), 'success');
}
include $this->template('page_commission');