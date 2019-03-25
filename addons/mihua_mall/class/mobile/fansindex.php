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
$id = $profile['id'];
if (empty($profile['id'])) {
	include $this->template('forbidden');
	exit;
}
#订单统计
$order['all']=pdo_fetchcolumn("select count(*) from ".tablename('mihua_mall_order')." where status in(0,1,2,3) and from_user='{$from_user}' ");
$order['notpay']=pdo_fetchcolumn("select count(*) from ".tablename('mihua_mall_order')." where status=0 and from_user='{$from_user}' ");
$order['payed']=pdo_fetchcolumn("select count(*) from ".tablename('mihua_mall_order')." where status=1 and from_user='{$from_user}'  ");
$order['shou']=pdo_fetchcolumn("select count(*) from ".tablename('mihua_mall_order')." where  status=2 and from_user='{$from_user}' ");
$order['done']=pdo_fetchcolumn("select count(*) from ".tablename('mihua_mall_order')." where  status=3 and from_user='{$from_user}' ");
#end

$uid = mc_openid2uid($from_user);
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
include $this->template('newhome');