<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->func('tpl');
load()->model('card');

$dos = array('display', 'exchange', 'mine', 'use', 'detail', 'qrcode', 'opencard', 'addcard');
$do = in_array($_GPC['do'], $dos) ? $_GPC['do'] : 'display';
activity_coupon_type_init();
$colors = activity_coupon_colors();
if($do == 'display') {
	if ($unisettings['exchange_enable'] != '1') {
		message('未开启兑换功能');
	}
	$user = mc_fetch($_W['member']['uid'], array('groupid'));
	$fan = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	$groupid = $user['groupid'];
	$exchanges = pdo_fetchall("SELECT * FROM ". tablename('activity_exchange')." WHERE uniacid = :uniacid AND type = ".COUPON_TYPE." AND status = '1' AND starttime <= :time AND endtime >= :time", array(':uniacid' => $_W['uniacid'], ':time' => strtotime(date('Y-m-d'))), 'extra');
	foreach ($exchanges as $key => &$list) {
		$coupon_info = activity_coupon_info($list['extra']);
		$exchange_lists[$list['extra']] = $coupon_info;
		$person_total = pdo_fetchcolumn("SELECT COUNT(*) FROM ". tablename('coupon_record')."  WHERE uid = :uid AND uniacid = :uniacid AND couponid = :couponid", array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':couponid' => $list['extra']));
		if ($person_total >= $list['pretotal'] || $person_total >= $coupon_info['get_limit']){
			unset($exchange_lists[$list['extra']]);
			continue;
		}
		$stock = pdo_fetchcolumn("SELECT COUNT(*) FROM ". tablename('coupon_record')." WHERE uniacid = :uniacid AND couponid = :couponid",  array(':uniacid' => $_W['uniacid'], ':couponid' => $list['extra']));
		if ($stock > $coupon_info['quantity']) {
			unset($exchange_lists[$list['extra']]);
			continue;
		}
		$coupon_groups = pdo_getall('coupon_groups', array('uniacid' => $_W['uniacid'], 'couponid' => $list['extra']), array(), 'groupid');
		$coupon_groups = array_keys($coupon_groups);
		if (COUPON_TYPE == WECHAT_COUPON) {
			$fan_groups = explode(',', $fan['tag']);
			$group = array_intersect($coupon_groups, $fan_groups);
		} else {
			$group = pdo_get('coupon_groups', array('uniacid' => $_W['uniacid'], 'couponid' => $list['extra'], 'groupid' => $groupid));
		}
		if (empty($group) && !empty($coupon_groups)) {
			unset($exchange_lists[$list['extra']]);
			continue;
		}
		if (!empty($_W['current_module'])) {
			$coupon_modules = pdo_getall('coupon_modules', array('uniacid' => $_W['uniacid'], 'couponid' => $list['extra']), array(), 'module');
			if (!empty($coupon_modules) && !in_array($_W['current'], $coupon_modules)) {
				unset($exchange_lists[$list['extra']]);
				continue;
			}
		}
		$exchange_lists[$list['extra']]['extra_href'] = url('activity/coupon/exchange');
		if (!empty($exchange_lists[$list['extra']])) {
			$exchange_lists[$list['extra']]['extra_func'] = $list;
			$exchange_lists[$list['extra']]['extra_func']['pic'] = 'resource/images/icon-signed.png';
		}
	}
}
if($do == 'exchange') {
	if ($unisettings['exchange_enable'] != '1') {
		message(error(-1, '未开启兑换功能'), '', 'ajax');
	}
	$id = intval($_GPC['id']);
	$activity_exchange = pdo_get('activity_exchange', array('extra' => $id));
	$credit = mc_credit_fetch($_W['member']['uid'], array($activity_exchange['credittype']));
	if ($activity_exchange['credit'] < 0) {
		message(error(-1, '兑换' . $creditnames[$activity_exchange['credittype']] . '有误'), '', 'ajax');
	}
	if (intval($credit[$activity_exchange['credittype']]) < $activity_exchange['credit']) {
		message(error(-1, $creditnames[$activity_exchange['credittype']] . '不足'), '', 'ajax');
	}
	$pcount = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('coupon_record') . " WHERE `openid` = :openid AND `couponid` = :couponid", array(':couponid' => $coupon['id'], ':openid' => $_W['fans']['openid']));
	if ($pcount > $activity_exchange['pretotal']) {
		message(error(-1, '领取数量超限'), '', 'ajax');
	}
	if ($activity_exchange['starttime'] > strtotime(date('Y-m-d'))) {
		message(error(-1, '活动未开始'), '', 'ajax');
	}
	if ($activity_exchange['endtime'] < strtotime(date('Y-m-d'))) {
		message(error(-1, '活动已结束'), '', 'ajax');
	}
	$status = activity_coupon_grant($id, $_W['member']['uid']);
	if (is_error($status)) {
		message(error(-1, $status['message']), '', 'ajax');
	} else {
		mc_credit_update($_W['member']['uid'], $activity_exchange['credittype'], -1 * $activity_exchange['credit']);
		if ($activity_exchange['credittype'] == 'credit1') {
			mc_notice_credit1($_W['openid'], $_W['member']['uid'], -1 * $activity_exchange['credit'], '兑换卡券消耗积分');
		} else {
			$card_setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid']));
			$recharges_set = card_params_setting('cardRecharge');
			if (empty($recharges_set['params']['recharge_type'])) {
				$grant_rate = $card_setting['grant_rate'];
				mc_credit_update($_W['member']['uid'], 'credit1', $grant_rate * $activity_exchange['credit']);
			}
			mc_notice_credit2($_W['openid'], $_W['member']['uid'], -1 * $activity_exchange['credit'], $grant_rate * $activity_exchange['credit'], '兑换卡券消耗余额');
		}
		
		message(error(0, '兑换成功'), url('activity/coupon/mine'), 'ajax');
	}
}
if($do == 'mine') {
	$title = '我的卡券';
	activity_coupon_give();
	$coupon_records = activity_coupon_owned();
}
if($do == 'use') {
	$recid = intval($_GPC['recid']);
	$coupon_record = pdo_get('coupon_record', array('id' => $recid));
	$coupon_info = activity_coupon_info(trim($coupon_record['couponid']));
	$coupon_info['color'] = $colors[$coupon_info['color']] ? $colors[$coupon_info['color']] : '#63b359';
	if ($coupon_info['date_info']['time_type'] == '2') {
		$starttime = strtotime(date('Y-m-d', $coupon_record['addtime'])) + $coupon_info['date_info']['deadline'] * 86400;
		$endtime = $starttime + ($coupon_info['date_info']['limit'] - 1) * 86400;
		$coupon_info['extra_date_info'] = '有效期:' . date('Y.m.d', $starttime) . '-' . date('Y.m.d', $endtime);
	}
}

if ($do == 'detail') {
	$couponid = intval($_GPC['couponid']);
	$coupon_record = pdo_get('coupon_record', array('id' => intval($_GPC['recid'])));
	$coupon_info = activity_coupon_info($couponid);
	$coupon_info['description'] = $coupon_info['description'] ? $coupon_info['description'] : '暂无说明';
	if ($coupon_info['type'] == '1') {
		$coupon_info['discount_info'] = '凭此券消费打' . $coupon_info['extra']['discount'] * 0.1 . '折';
	} else {
		$coupon_info['discount_info'] = '价值' . $coupon_info['extra']['reduce_cost'] * 0.01 . '元代金券一张,消费满' . $coupon_info['extra']['least_cost'] * 0.01 . '元可使用';
	}
	if ($coupon_info['date_info']['time_type'] == '1') {
		$coupon_info['detail_date_info'] = $coupon_info['date_info']['time_limit_start'] . '-' . $coupon_info['date_info']['time_limit_end'];
	} else {
		$starttime = $coupon_record['addtime'] + $coupon_info['date_info']['deadline'] * 86400;
		$endtime = $starttime + ($coupon_info['date_info']['limit'] - 1) * 86400;
		$coupon_info['detail_date_info'] = date('Y.m.d', $starttime) . '-' . date('Y.m.d', $endtime);
	}
}

if ($do == 'qrcode') {
	$couponid = intval($_GPC['couponid']);
	$recid = intval($_GPC['recid']);
	
	$coupon_info = activity_coupon_info($couponid);
	$coupon_info['color'] = $colors[$coupon_info['color']] ? $colors[$coupon_info['color']] : '#63b359';
	$code_info = pdo_get('coupon_record', array('id' => $recid), array('code'));
	$coupon_info['code'] = $code_info['code'];
}
if ($do == 'opencard') {
	$id = intval($_GPC['id']);
	$code = trim($_GPC['code']);
	if($_W['isajax'] && $_W['ispost']) {
		$card = $coupon_api->BuildCardExt($id);
		if (is_error($card)) {
			message(error(1, $card['message']), '', 'ajax');
		} else {
			$openCard['card_id'] = $card['card_id'];
			$openCard['code'] = $code;
			message(error(0, $openCard), '', 'ajax');
		}
	}
}
if ($do == 'addcard') {
	$id = intval($_GPC['id']);
	if($_W['isajax'] && $_W['ispost']) {
		$card = $coupon_api->BuildCardExt($id);
		if (is_error($card)) {
			message(error(1, $card['message']), '', 'ajax');
		} else {
			message(error(0, $card), url('activity/coupon/mine'), 'ajax');
		}
	}
}
template('activity/coupon');
