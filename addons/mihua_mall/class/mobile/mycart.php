<?php
$id = $profile['id'];
$op = $_GPC['op'];
if ($op == 'add') {
	$goodsid = intval($_GPC['id']);
	$total = intval($_GPC['total']);
	$total = empty($total) ? 1 : $total;
	$optionid = intval($_GPC['optionid']);
	$goods = pdo_fetch("SELECT id, type, total,marketprice,maxbuy FROM " . tablename('mihua_mall_goods') . " WHERE id = :id", array(':id' => $goodsid));
	if (empty($goods)) {
		$result['message'] = '抱歉，该商品不存在或是已经被删除！';
		message($result, '', 'ajax');
	}
	$marketprice = $goods['marketprice'];
	$goodsOptionStock = 0;
	$goodsOptionStock = $goods['total'];
	if (!empty($optionid)) {
		$option = pdo_fetch("select marketprice,stock from " . tablename('mihua_mall_goods_option') . " where id=:id limit 1", array(":id" => $optionid));
		if (!empty($option)) {
			$marketprice = $option['marketprice'];
			$goodsOptionStock = $option['stock'];
		}
	}
	if ($goodsOptionStock <= $total && $goodsOptionStock != -1) {
		$result = array('result' => 0, 'maxbuy' => $goodsOptionStock);
		die(json_encode($result));
		exit;
	}
	$row = pdo_fetch("SELECT id, total FROM " . tablename('mihua_mall_cart') . " WHERE from_user = :from_user AND uniacid = '{$_W['uniacid']}' AND goodsid = :goodsid  and optionid=:optionid", array(':from_user' => $from_user, ':goodsid' => $goodsid, ':optionid' => $optionid));
	if ($row == false) {
		$data = array('uniacid' => $_W['uniacid'], 'goodsid' => $goodsid, 'goodstype' => $goods['type'], 'marketprice' => $marketprice, 'from_user' => $from_user, 'total' => $total, 'optionid' => $optionid);
		pdo_insert('mihua_mall_cart', $data);
	} else {
		$t = $total + $row['total'];
		if (!empty($goods['maxbuy'])) {
			if ($t > $goods['maxbuy']) {
				$t = $goods['maxbuy'];
			}
		}
		$data = array('marketprice' => $marketprice, 'total' => $t, 'optionid' => $optionid);
		pdo_update('mihua_mall_cart', $data, array('id' => $row['id']));
	}
	$carttotal = $this->getCartTotal();
	$result = array('result' => 1, 'total' => $carttotal);
	die(json_encode($result));
} else if ($op == 'clear') {
	pdo_delete('mihua_mall_cart', array('from_user' => $from_user, 'uniacid' => $_W['uniacid']));
	die(json_encode(array("result" => 1)));
} else if ($op == 'remove') {
	$id = intval($_GPC['id']);
	pdo_delete('mihua_mall_cart', array('from_user' => $from_user, 'uniacid' => $_W['uniacid'], 'id' => $id));
	die(json_encode(array("result" => 1, "cartid" => $id)));
} else if ($op == 'update') {
	$id = intval($_GPC['id']);
	$num = intval($_GPC['num']);
	$sql = "update " . tablename('mihua_mall_cart') . " set total=$num where id=:id";
	pdo_query($sql, array(":id" => $id));
	die(json_encode(array("result" => 1)));
} else {
	$list = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_cart') . " WHERE  uniacid = '{$_W['uniacid']}' AND from_user = '" . $from_user . "'");
	$totalprice = 0;
	if (!empty($list)) {
		foreach ($list as &$item) {
			$goods = pdo_fetch("SELECT  title, thumb, marketprice, unit, total,maxbuy FROM " . tablename('mihua_mall_goods') . " WHERE id=:id limit 1", array(":id" => $item['goodsid']));
			$option = pdo_fetch("select title,marketprice,stock from " . tablename("mihua_mall_goods_option") . " where id=:id limit 1", array(":id" => $item['optionid']));
			if ($option) {
				$goods['title'] = $goods['title'];
				$goods['optionname'] = $option['title'];
				$goods['marketprice'] = $option['marketprice'];
				$goods['total'] = $option['stock'];
			}
			$item['goods'] = $goods;
			$item['totalprice'] = (floatval($goods['marketprice']) * intval($item['total']));
			$totalprice += $item['totalprice'];
		}
		unset($item);
	}
	include $this->template('cart');
}