<?php
$orderid = intval($_GPC['orderid']);
$order = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE id = :id", array(':id' => $orderid));
$goodsstr = "";
$bodygoods = "";
if ($order['status'] != '0') {
	message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('myorder'), 'error');
}
$ordergoods = pdo_fetchall("SELECT goodsid, total,optionid FROM " . tablename('mihua_mall_order_goods') . " WHERE orderid = '{$orderid}'", array(), 'goodsid');
if (!empty($ordergoods)) {
	$goods = pdo_fetchall("SELECT id, title, thumb, marketprice, unit, total,credit FROM " . tablename('mihua_mall_goods') . " WHERE id IN ('" . implode("','", array_keys($ordergoods)) . "')");
}
if (!empty($goods)) {
	foreach ($goods as $row) {
		$goodsstr .= "{$row['title']}({$ordergoods[$row['id']]['total']})<br/>";
		$bodygoods .= "名称：{$row['title']} ，数量：{$ordergoods[$row['id']]['total']} <br />";
	}
}
if (checksubmit('codsubmit')) {
	if (!empty($this->module['config']['noticeemail'])) {
		$address = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_address') . " WHERE id = :id", array(':id' => $order['addressid']));
		$body = "<h3>购买商品清单</h3> <br />";
		if (!empty($goods)) {
			$body .= $bodygoods;
		}
		$body .= "<br />总金额：{$order['price']}元 （货到付款）<br />";
		$body .= "<h3>购买用户详情</h3> <br />";
		$body .= "真实姓名：$address[realname] <br />";
		$body .= "地区：$address[province] - $address[city] - $address[area]<br />";
		$body .= "详细地址：$address[address] <br />";
		$body .= "手机：$address[mobile] <br />";
		ihttp_email($this->module['config']['noticeemail'], '微商城订单提醒', $body);
	}
	$tagent = $this->getMember($this->getShareId());
	$this->sendgmsptz($order['ordersn'], $order['price'], $profile['realname'], $tagent['from_user']);
	pdo_update('mihua_mall_order', array('status' => '1', 'paytype' => '3'), array('id' => $orderid));
	$this->sendMobilePayMsg($order, $goods, "付款完成", $ordergoods);
	message('订单提交成功，请您收到货时付款！', $this->createMobileUrl('myorder'), 'success');
}
if (checksubmit()) {
	if ($order['paytype'] == 1 && $_W['fans']['credit2'] < $order['price']) {
		message('抱歉，您帐户的余额不够支付该订单，请充值！', create_url('site/entry/charge', array('name' => 'member', 'uniacid' => $_W['uniacid'])), 'error');
	}
	if ($order['price'] == '0') {
		$this->payResult(array('tid' => $orderid, 'from' => 'return', 'type' => 'credit2'));
		exit;
	}
}
$params['tid'] = $orderid;
$params['user'] = $from_user;
$params['fee'] = $order['price'];
$params['title'] = $_W['account']['name'];
$params['ordersn'] = $order['ordersn'];
$params['virtual'] = $order['goodstype'] == 2 ? true : false;
if (empty($_GPC['topay'])) {
	$this->bjpay($params, $order['sendtype']);
} else {
	$this->bjpay($params, $order['sendtype']);
}