<?php
$uniacid = $_W['uniacid'];
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
$cfg = $this->module['config'];
if ($cfg['globalCommissionLevel'] < 2) {
	$level2enable = ' and 1!=1 ';
}
if ($cfg['globalCommissionLevel'] < 3) {
	$level3enable = ' and 1!=1 ';
}
$id = $profile['id'];

if (intval($profile['id']) && $profile['status'] == 0) {
	include $this->template('forbidden');
	exit;
}
if (empty($profile)) {
	message('请先注册', $this->createMobileUrl('register'), 'error');
	exit;
}
$status = 0;
$condition = '';
$condition .= " AND status >= '" . intval($status) . "'";

$user = pdo_fetch("select * from " . tablename('mihua_mall_member') . " where id = " . $profile['id'] . " and uniacid = " . $_W['uniacid']);

$conditionx = " AND o.status >= '" . intval($status) . "'";
$condition1 = $conditionx . " AND (o.shareid = '" . $profile['id'] . "')  AND o.createtime>=" . $profile['flagtime'] . " AND o.from_user<>'" . $from_user . "'";
$condition2 = $conditionx . " AND (o.shareid2 = '" . $profile['id'] . "') AND o.createtime>=" . $profile['flagtime'] . " $level2enable AND o.from_user<>'" . $from_user . "'";
$condition3 = $conditionx . " AND (o.shareid3 = '" . $profile['id'] . "') AND o.createtime>=" . $profile['flagtime'] . " $level3enable AND o.from_user<>'" . $from_user . "'";

$condition .= " AND (shareid = '" . $profile['id'] . "' or (shareid2 = '" . $profile['id'] . "' $level2enable) or (shareid3 = '" . $profile['id'] . "' $level3enable)) AND createtime>=" . $profile['flagtime'] . " AND from_user<>'" . $from_user . "'";

$conditionMember = "select m.realname from " . tablename('mihua_mall_member') . " m where m.from_user=o.from_user and m.uniacid=" . $_W['uniacid'];

$pindex = max(1, intval($_GPC['page']));
$psize = 30;
$list = pdo_fetchall("SELECT o.*,'' as commissions,1 as level,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " o WHERE o.uniacid = '{$_W['uniacid']}' $condition1  union all (SELECT o.*,'' as commissions,2 as level,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " o WHERE o.uniacid = '{$_W['uniacid']}' $condition2 ) union all (SELECT o.*,'' as commissions,3 as level,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " o WHERE o.uniacid = '{$_W['uniacid']}' $condition3 )  ORDER BY  createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
$listx = pdo_fetchall("SELECT o.*,'' as commissions,1 as level,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " o WHERE o.uniacid = '{$_W['uniacid']}' $condition1  union all (SELECT o.*,'' as commissions,2 as level,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " o WHERE o.uniacid = '{$_W['uniacid']}' $condition2 ) union all (SELECT o.*,'' as commissions,3 as level,( $conditionMember) realname FROM " . tablename('mihua_mall_order') . " o WHERE o.uniacid = '{$_W['uniacid']}' $condition3 )  ");
$total = sizeof($listx);
$pager = pagination($total, $pindex, $psize);
$allcount = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('mihua_mall_order') . " 	WHERE uniacid = '{$_W['uniacid']}' $condition  ORDER BY status ASC, createtime DESC");
$countYestay = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('mihua_mall_order') . " WHERE uniacid = '{$_W['uniacid']}' $condition and createtime>=" . strtotime(date('Y-m-d 00:00:00', strtotime('-1 day'))) . " and createtime<=" . strtotime(date('Y-m-d 23:59:59', strtotime('-1 day'))) . "  ORDER BY status ASC, createtime DESC");
$countToday = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('mihua_mall_order') . " WHERE uniacid = '{$_W['uniacid']}' $condition and createtime>=" . strtotime(date('Y-m-d 00:00:00', strtotime('0 day'))) . " and createtime<=" . strtotime(date('Y-m-d 23:59:59', strtotime('0 day'))) . "  ORDER BY status ASC, createtime DESC");

if (!empty($list)) {
	foreach ($list as $lkey => $l) {
		$commissions = pdo_fetchall("select *,'' as title,'' as thumb from " . tablename('mihua_mall_order_goods') . " where orderid = " . $l['id']);
		foreach ($commissions as $key => $commission) {
			$goods = pdo_fetch("select title,thumb from " . tablename('mihua_mall_goods') . " where id = " . $commission['goodsid']);
			$commissions[$key]['thumb'] = $goods['thumb'];
			$commissions[$key]['title'] = $goods['title'];
			if ($l['level'] == 1) {
				$commissions[$key]['commission'] = $commission['commission'] * $commission['total'];
			}
			if ($l['level'] == 2) {
				$commissions[$key]['commission'] = $commission['commission2'] * $commission['total'];
			}
			if ($l['level'] == 3) {
				$commissions[$key]['commission'] = $commission['commission3'] * $commission['total'];
			}
		}
		$list[$lkey]['commissions'] = $commissions;
	}
}
if (!empty($list)) {
	foreach ($list as &$row) {
		!empty($row['addressid']) && $addressids[$row['addressid']] = $row['addressid'];
		$row['dispatch'] = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_dispatch') . " WHERE id = :id", array(':id' => $row['dispatch']));
	}
	unset($row);
}
if (!empty($addressids)) {
	$address = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_address') . " WHERE id IN ('" . implode("','", $addressids) . "')", array(), 'id');
}
include $this->template('fansorder');