<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->func('tpl');

$dos = array('display', 'post', 'mine', 'use', 'deliver', 'confirm');
$do = in_array($_GPC['do'], $dos) ? $_GPC['do'] : 'display';

$profile = mc_fetch($_W['member']['uid']);
if($do == 'display') {
	if ($unisettings['exchange_enable'] != '1') {
		message('未开启兑换功能');
	}
	$lists = pdo_fetchall('SELECT id,title,extra,thumb,type,credittype,endtime,description,credit FROM ' . tablename('activity_exchange') . ' WHERE uniacid = :uniacid AND type = :type AND endtime > :endtime AND status = 1 ORDER BY endtime ASC ', array(':uniacid' => $_W['uniacid'], ':type' => 3, ':endtime' => TIMESTAMP));
	foreach($lists as &$li) {
		$li['extra'] = iunserializer($li['extra']);
		if(!is_array($li['extra'])) {
			$li['extra'] = array();
		}
	}
}
if($do == 'post') {
	if ($unisettings['exchange_enable'] != '1') {
		message(error(-1, '未开启兑换功能'), '', 'ajax');
	}
	$id = intval($_GPC['id']); 
	$shipping_data = array(
		'name' => trim($_GPC['username']),
		'mobile' => trim($_GPC['mobile']),
		'zipcode' => trim($_GPC['zipcode']),
		'province' => trim($_GPC['address_province']),
		'city' => trim($_GPC['address_city']),
		'district' => trim($_GPC['address_district']),
		'address' => trim($_GPC['address_addr']),
	);
	foreach ($shipping_data as $val) {
		if (empty($val)) {
			message(error(-1, '请填写收货人信息'), '', 'ajax');
		}
	}
	$goods = activity_exchange_info($id, $_W['uniacid']);
	if(empty($goods)){
		message(error(-1, '没有指定的礼品兑换'), '', 'ajax');
	}
	$credit = mc_credit_fetch($_W['member']['uid'], array($goods['credittype']));
	if ($credit[$goods['credittype']] < $goods['credit']) {
		message(error(-1, "{$creditnames[$goods['credittype']]}不足"), '', 'ajax');
	}
	$ret = activity_goods_grant($_W['member']['uid'], $id);
	if(is_error($ret)) {
		message($ret, '', 'ajax');
	}
	pdo_update('activity_exchange_trades_shipping', $shipping_data, array('tid' => $ret));
	mc_credit_update($_W['member']['uid'], $goods['credittype'], -1 * $goods['credit'], array($_W['member']['uid'], '礼品兑换:' . $goods['title'] . ' 消耗 ' . $creditnames[$goods['credittype']] . ':' . $goods['credit']));
		if($goods['credittype'] == 'credit1') {
		mc_notice_credit1($_W['openid'], $_W['member']['uid'], -1 * $goods['credit'], '兑换礼品消耗积分');
	} else {
		mc_notice_credit2($_W['openid'], $_W['member']['uid'], -1 * $goods['credit'], 0, '线上消费，兑换礼品');
	}
	message(error($ret, "兑换成功"), url('activity/goods/mine'), 'ajax');
}
if($do == 'deliver') {
	$tid = intval($_GPC['tid']);	$id = intval($_GPC['id']);
	$type = trim($_GPC['type']);
	$goods_info = pdo_get('activity_exchange', array('id' => $id));
	$goods_info['reside'] = $goods_info['total'] - $goods_info['num'];
	$goods_info['exp_date'] = '有效期:' . date('Y.m.d', $goods_info['starttime']) . '-' . date('Y.m.d', $goods_info['endtime']);
	$goods_info['description'] = htmlspecialchars_decode($goods_info['description']);
	$credit = mc_credit_fetch($_W['member']['uid'], array($goods_info['credittype']));
	$credit['name'] = $creditnames[$goods_info['credittype']];
	$is_exchange['error'] = '1';
	if ($type == 'edit') {
		$is_exchange['name'] = '修改信息';
	} else {
		if ($goods_info['credit'] > $credit[$goods_info['credittype']]) {
			$is_exchange['name'] = $credit['name'] . '不足';
			$is_exchange['error'] = '-1';
		} else {
			$is_exchange['name'] = '立即兑换';
		}
		
	}
	if (empty($tid)) {
		$address_data = pdo_get('mc_member_address', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	} else {
		$address_data = pdo_get('activity_exchange_trades_shipping', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'tid' => $tid));
		$address_data['username'] = $address_data['name'];
	}
	if($_W['isajax']) {
		$data = array(
			'name' => trim($_GPC['username']),
			'mobile' => trim($_GPC['mobile']),
			'province' => trim($_GPC['address_province']),
			'city' => trim($_GPC['address_city']),
			'district' => trim($_GPC['address_district']),
			'address' => trim($_GPC['address_addr']),
			'zipcode' => trim($_GPC['zipcode']),
		);
		pdo_update('activity_exchange_trades_shipping', $data, array('tid' => intval($_GPC['tid']), 'uid' => $_W['member']['uid']));
		message(error(0,'修改成功'), url('activity/goods/mine'), 'ajax');
	}
}
if($do == 'mine') {
	$psize = 10;
	$pindex = max(1, intval($_GPC['page']));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('activity_exchange_trades_shipping') . ' WHERE uid = :uid', array(':uid' => $_W['member']['uid'])); 
	$lists = pdo_fetchall("SELECT a.*, b.id AS gid,b.title,b.extra,b.thumb,b.type,b.credittype,b.endtime,b.description,b.credit FROM " . tablename('activity_exchange_trades_shipping') . " AS a LEFT JOIN " . tablename('activity_exchange'). " AS b ON a.exid = b.id WHERE a.uid = :uid ORDER BY a.status LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(':uid' => $_W['member']['uid']));
	foreach($lists as &$list) {
		$list['extra'] = iunserializer($list['extra']);
		if(!is_array($list['extra'])) {
			$list['extra'] = array();
		}
	}
	$pager = pagination($total, $pindex, $psize);
}
if($do == 'confirm') {
	if ($_W['isajax']) {
		$tid = intval($_GPC['tid']);
		$ship = pdo_fetch('SELECT tid FROM ' . tablename('activity_exchange_trades_shipping') . ' WHERE tid = :tid AND uid = :uid', array(':tid' => $tid, ':uid' => $_W['member']['uid']));
		if(empty($ship)) {
			message(error(-1,'订单信息不存在'), '', 'ajax');
		}
		pdo_update('activity_exchange_trades_shipping', array('status' => 2), array('uid' => $_W['member']['uid'], 'tid' => $tid));
		message(error(1,'确认收货成功'), url('activity/goods/mine', array('status' => 2)), 'ajax');
	}
}

template('activity/goods');
