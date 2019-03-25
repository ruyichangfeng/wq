<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('sign_display', 'sign', 'sign_record', 'notice', 'sign_strategy', 'share', 'mycard', 'add_recharge', 'addnums', 'recharge_record', 'receive_card', 'personal_info', 'consume');
$do = in_array($do, $dos) ? $do : 'mycard';
load()->model('user');
load()->model('card');
load()->func('tpl');
activity_coupon_type_init();
$notice_count = card_notice_stat();
$setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid']));
if($do == 'sign_display') {
	$title = '签到-会员卡';
	$credit_set = card_credit_setting();
	$sign_set = $credit_set['sign'];
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_card_sign_record') . ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']));
	$current_month_days = date('t', TIMESTAMP);
	$sign_rules = array(
		$sign_set['first_group_day'] => $sign_set['first_group_num'],
		$sign_set['second_group_day'] => $sign_set['second_group_num'],
		$sign_set['third_group_day'] => $sign_set['third_group_num'],
		$current_month_days => $sign_set['full_sign_num'],
	);
	if (!empty($sign_rules[$total])) {
		$today_sign_credit = $sign_rules[$total];
	} else {
		$today_sign_credit = $sign_set['everydaynum'];
	}
	if (!empty($sign_rules[$total + 1])) {
		$tomorrow_sign_credit = $sign_rules[$total + 1];
		$sign_credit = $sign_rules[$total + 1];
	} else {
		$tomorrow_sign_credit = $sign_set['everydaynum'];
		$sign_credit = $sign_set['everydaynum'];
	}
	$data = array(
		'uniacid' => $_W['uniacid'],
		'uid' => $_W['member']['uid'],
		'credit' => $sign_credit,
		'is_grant' => 0,
		'addtime' => TIMESTAMP,
	);
	$today_signed = pdo_get('mc_card_sign_record', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'addtime >' => strtotime(date('Y-m-d'))), 'id');
	if(empty($today_signed)) {
		$status = pdo_insert('mc_card_sign_record', $data);
		if (!empty($status) && $today_sign_credit > 0) {
			$log = "用户签到赠送【{$today_sign_credit}】积分";
			mc_credit_update($_W['member']['uid'], 'credit1', $today_sign_credit, array(0, $log, 'sign'));
			mc_notice_credit1($_W['openid'], $_W['member']['uid'], $today_sign_credit, $log);
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_card_sign_record') . ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']));
	}
}

if($do == 'sign_record') {
	$title = '签到记录-会员卡';
	$psize = 20;
	$pindex = max(1, intval($_GPC['page']));
	$period = intval($_GPC['period']);
	if ($period == '1') {
		$starttime = date('Ym01',strtotime(0));
		$endtime = date('Ymd His', time());
	} elseif($period == '0') {
		$starttime = date('Ym01', strtotime(1*$period . "month"));
		$endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
	} else {
		$starttime = date('Ym01', strtotime(1*$period . "month"));
		$endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
	}
	$where = '';
	$params = array();
	$where = ' WHERE `uniacid` = :uniacid AND `uid` = :uid AND `addtime` >= :starttime AND `addtime` < :endtime';
	$params[':uniacid'] = $_W['uniacid'];
	$params[':uid'] = $_W['member']['uid'];
	$params[':starttime'] = strtotime($starttime);
	$params[':endtime'] = strtotime($endtime);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_card_sign_record') . $where, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('mc_card_sign_record') . $where . ' ORDER BY id DESC LIMIT ' . ($pindex - 1) * $psize . ", {$psize}", $params);
	$pagenums = ceil($total / $psize);
	foreach ($data as &$value) {
		$value['addtime'] = date('Y.m.d', $value['addtime']);
	}
	if($_W['isajax'] && $_W['ispost']) {
		if (!empty($data)){
			message(error(0, $data), '', 'ajax');
		} else {
			message(error(1, 'error'), '', 'ajax');
		}
	}
}

if($do == 'sign_strategy') {
	$set = card_credit_setting();
	$content = $set['content'];
}

if($do == 'notice') {
	$title = '系统消息-会员卡';
	if($_W['isajax']) {
		$id = intval($_GPC['id']);
		if($id > 0) {
			pdo_update('mc_card_notices_unread', array('is_new' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'notice_id' => $id));
			$total = card_notice_stat();
			exit($total);
		}
	}
	$psize = 20;
	$pindex = max(1, intval($_GPC['page']));
	$type = intval($_GPC['type']) ? intval($_GPC['type']) : 1;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_card_notices_unread') . ' WHERE uniacid = :uniacid AND uid = :uid AND type = :type', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':type' => $type));
	$data = pdo_fetchall('SELECT a.*,b.* FROM ' . tablename('mc_card_notices_unread') . ' AS a LEFT JOIN ' . tablename('mc_card_notices') . ' AS b ON a.notice_id = b.id WHERE a.uniacid = b.uniacid AND a.uniacid = :uniacid AND a.uid = :uid AND a.type = :type ORDER BY a.notice_id DESC LIMIT ' . ($pindex - 1) * $psize . ", {$psize}", array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':type' => $type));
	$pager = pagination($total, $pindex, $psize);
}


if ($do == 'receive_card') {
	$mcard = pdo_get('mc_card_members', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']), array('id'));
	if(!empty($mcard)) {
		header('Location:' . url('mc/card/mycard'));
		exit;
	}
	
	$sql = 'SELECT * FROM ' . tablename('mc_card') . " WHERE `uniacid` = :uniacid AND `status` = '1'";
	$setting = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
	if (!empty($setting)) {
		$setting['color'] = iunserializer($setting['color']);
		$setting['background'] = iunserializer($setting['background']);
		$setting['fields'] = iunserializer($setting['fields']);
		$setting['grant'] = iunserializer($setting['grant']);
		if (!empty($setting['grant']['coupon']) && is_array($setting['grant']['coupon'])) {
			foreach ($setting['grant']['coupon'] as $grant_coupon) {
				$coupon_title .= "{$grant_coupon['couponTitle']}|";
			}
		}
	} else {
		message('公众号尚未开启会员卡功能', url('mc'), 'error');
	}

	if(!empty($setting['fields'])) {
		$fields = array('email');
		foreach($setting['fields'] as $li) {
			if($li['bind'] == 'birth') {
				$fields[] = 'birthyear';
				$fields[] = 'birthmonth';
				$fields[] = 'birthday';
			} elseif($li['bind'] == 'reside') {
				$fields[] = 'resideprovince';
				$fields[] = 'residecity';
				$fields[] = 'residedist';
			} else {
				$fields[] = $li['bind'];
			}
		}
		$member_info = mc_fetch($_W['member']['uid'], $fields);
		$reregister = 0;
		if(strlen($member_info['email']) == 39 && strexists($member_info['email'], '@we7.cc')) {
			$member_info['email'] = '';
			$reregister = 1;
		}
	}
	if ($_W['isajax'] && $_W['ispost']) {
		$data = array();
		$realname = trim($_GPC['realname']);
		if(empty($realname)) {
			message('请输入姓名', referer(), 'info');
		}
		$data['realname'] = $realname;
		$mobile = trim($_GPC['mobile']);
		if (!preg_match(REGULAR_MOBILE, $mobile)) {
			message('手机号有误', referer(), 'info');
		}
		$data['mobile'] = $mobile;
		if (!empty($setting['fields'])) {
			foreach ($setting['fields'] as $row) {
				if (!empty($row['require']) && ($row['bind'] == 'birth' || $row['bind'] == 'birthyear')) {
					if (empty($_GPC['birth']['year']) || empty($_GPC['birth']['month']) || empty($_GPC['birth']['day'])) {
						message('请输入出生日期', referer(), 'info');
					}
					$row['bind'] = 'birth';
				} elseif (!empty($row['require']) && $row['bind'] == 'resideprovince') {
					if (empty($_GPC['reside']['province']) || empty($_GPC['reside']['city']) || empty($_GPC['reside']['district'])) {
						message('请输入居住地', referer(), 'info');
					}
					$row['bind'] = 'reside';
				} elseif (!empty($row['require']) && empty($_GPC[$row['bind']])) {
					message('请输入'.$row['title'].'！', referer(), 'info');
				}
				$data[$row['bind']] = $_GPC[$row['bind']];
			}
		}
		$check = mc_check($data);
		if(is_error($check)) {
			message($check['message'], referer(), 'error');
		}
		
		$sql = 'SELECT COUNT(*)  FROM ' . tablename('mc_card_members') . " WHERE `uid` = :uid AND `cid` = :cid AND uniacid = :uniacid";
		$count = pdo_fetchcolumn($sql, array(':uid' => $_W['member']['uid'], ':cid' => $_GPC['cardid'], ':uniacid' => $_W['uniacid']));
		if ($count >= 1) {
			message('已领取过该会员卡.', referer(), 'error');
		}

		$record = array(
			'uniacid' => $_W['uniacid'],
			'openid' => $_W['openid'],
			'uid' => $_W['member']['uid'],
			'cid' => $_GPC['cardid'],
			'cardsn' => $data['mobile'],
			'status' => '1',
			'createtime' => TIMESTAMP,
			'endtime' => TIMESTAMP
		);

		if(pdo_insert('mc_card_members', $record)) {
			if(!empty($data)){
				mc_update($_W['member']['uid'], $data);
			}
						$notice = '';
			if(is_array($setting['grant'])) {
				if($setting['grant']['credit1'] > 0) {
					$log = array(
						$_W['member']['uid'],
						"领取会员卡，赠送{$setting['grant']['credit1']}积分"
					);
					mc_credit_update($_W['member']['uid'], 'credit1', $setting['grant']['credit1'], $log);
					$notice .= "赠送【{$setting['grant']['credit1']}】积分";
				}
				if($setting['grant']['credit2'] > 0) {
					$log = array(
						$_W['member']['uid'],
						"领取会员卡，赠送{$setting['credit2']['credit1']}余额"
					);
					mc_credit_update($_W['member']['uid'], 'credit2', $setting['grant']['credit2'], $log);
					$notice .= ",赠送【{$setting['grant']['credit2']}】余额";
				}
				if (!empty($setting['grant']['coupon']) && is_array($setting['grant']['coupon'])) {
					foreach ($setting['grant']['coupon'] as $grant_coupon) {
						$status = activity_coupon_grant($grant_coupon['coupon'], $_W['member']['uid']);
						if(!is_error($status)) {
							$coupon_title .= ",{$grant_coupon['couponTitle']}";
						}
					}
					$notice .= ",赠送【{$coupon_title}】优惠券";
				}
			}
			$time = date('Y-m-d H:i');
			$url = murl('mc/card/mycard/', array(), true, true);
			$title = "【{$_W['account']['name']}】- 领取会员卡通知\n";
			$info = "您在{$time}成功领取会员卡，{$notice}。\n\n";
			$info .= "<a href='{$url}'>点击查看详情</a>";
			$status = mc_notice_custom_text($_W['openid'], $title, $info);
			message("领取会员卡成功", url('mc/card/mycard'), 'success');
		} else {
			message('领取会员卡失败.', referer(), 'error');
		}
	}
}



if ($do == 'mycard') {
	$mcard = pdo_fetch('SELECT * FROM ' . tablename('mc_card_members') . ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']));
	$title = $setting['title'];
	if(empty($mcard)) {
		header('Location:' . url('mc/card/receive_card'));
	}
	if(empty($mcard['openid']) && !empty($_W['openid'])) {
		pdo_update('mc_card_members', array('openid' => $_W['openid']), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	}
	if (!empty($mcard['status'])) {
		$setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid']));
		if(!empty($setting)) {
			$setting['color'] = iunserializer($setting['color']);
			$setting['background'] = iunserializer($setting['background']);;
		}
	}
	load()->model('activity');
	$coupons = activity_coupon_owned();
	$nums_recharge = iunserializer($setting['nums']);
	$times_recharge = iunserializer($setting['times']);
	$total = count($coupons);
	load()->model('card');
	$activity_setting = card_params_setting('cardActivity');
	$notice_count = card_notice_stat();

	$params = json_decode($setting['params'], true);
	foreach ($params as $key => $value) {
		$params_new[$value['id']] = $value;  
	}
	$activity_info = $params_new['cardActivity'];
	$recharge_info = $params_new['cardRecharge'];
	$nums_info = $params_new['cardNums'];
	$times_info = $params_new['cardTimes'];
	$activity_description_show = false;
	if ($activity_info['params']['discount_type'] != 0 || $recharge_info['params']['recharge_type'] != 0 || $nums_info['params']['nums_status'] != 0 || $times_info['params']['times_status'] != 0) {
		$activity_description_show = true;
	}

}

if ($do == 'activity_description') {
	$params = json_decode($setting['params'], true);
	foreach ($params as $key => $value) {
		$params_new[$value['id']] = $value;  
	}
	$activity_info = $params_new['cardActivity'];
	$recharge_info = $params_new['cardRecharge'];
	$nums_info = $params_new['cardNums'];
	$times_info = $params_new['cardTimes'];
	if ($activity_info['params']['discount_type'] == 0 && $recharge_info['params']['recharge_type'] == 0 && $nums_info['params']['nums_status'] == 0 && $times_info['params']['times_status'] == 0) {
		message('暂无优惠信息', referer(), 'error');
	}
	if ($activity_info['params']['discount_type'] != 0) {
		foreach ($activity_info['params']['discounts'] as $key => $val) {
			$activity_description[$key][0] = $val['title'];
			if ($activity_info['params']['discount_type'] == 1) {
				if (!empty($val['condition_1']) && !empty($val['discount_1'])) {
					$activity_description[$key][1] = '消费 <span class="mui-badge mui-badge-danger">满</span> ' . $val['condition_1'] . ' 元，<span class="mui-badge mui-badge-danger">减</span> ' . $val['discount_1'] . ' 元';
				} else {
					unset($activity_description[$key]);
				}
			} else {
				if (!empty($val['condition_2']) && !empty($val['discount_2'])) {
					$activity_description[$key][1] = '消费 <span class="mui-badge mui-badge-danger">满</span> ' . $val['condition_2'] . ' 元，<span class="mui-badge mui-badge-danger">打</span>'  . $val['discount_2'] . ' 折';
				} else {
					unset($activity_description[$key]);
				}
			}
		}
	}

	if ($recharge_info['params']['recharge_type'] == 1) {
		foreach ($recharge_info['params']['recharges'] as $key => $value) {
			if ($value['backtype'] == '0') {
				$recharge_description[$key] = '<span class="mui-badge mui-badge-danger">充</span> ' . $value['condition'] . ' 元，<span class="mui-badge mui-badge-danger">返</span> ' . $value['back'] . ' 元';
			} else {
				$recharge_description[$key] = '<span class="mui-badge mui-badge-danger">充</span> ' . $value['condition'] . ' 元，<span class="mui-badge mui-badge-danger">返</span> ' . $value['back'] . ' 积分';
			}
		}
	}

	if ($nums_info['params']['nums_status'] == 1) {
		foreach ($nums_info['params']['nums'] as $key => $value) {
			if (!empty($value['recharge']) && !empty($value['num'])) {
				$nums_description[$key] = '<span class="mui-badge mui-badge-danger">充</span> ' . $value['recharge'] . ' 元， ' . $value['num'] . ' 次';
			}
		}
	}

	if ($times_info['params']['times_status'] == 1) {
		foreach ($times_info['params']['times'] as $key => $value) {
			if (!empty($value['recharge']) && !empty($value['time'])) {
				$times_description[$key] = '<span class="mui-badge mui-badge-danger">充</span> ' . $value['recharge'] . ' 元， ' . $value['time'] . ' 天';
			}
		}
	}
}


if($do == 'add_recharge') {
	$type = trim($_GPC['type']);
	$mcard = pdo_get('mc_card_members', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	$mcard['status'] = '1';
	if (!empty($mcard['status'])) {
		$setting = pdo_fetch('SELECT * FROM ' . tablename('mc_card') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		$setting = iunserializer($setting[$type]);
	}
}

if($do == 'recharge_record') {
	$period = $_GPC['period'];
	$period_date = ($period == '1') ? date('Y.m', strtotime('now')) : date('Y.m', strtotime('now' . ($_GPC['period'] * 1) . ' month'));
	$starttime = ($period == '1') ? date('Ym01') : date('Ym01', strtotime(1*$period . "month"));
	$endtime = date('Ymd', strtotime("$starttime + 1 month - 1 day"));
	$setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid']), array('nums_text', 'times_text'));
	$card = pdo_get('mc_card_members', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	$type = trim($_GPC['type']);
	$where = ' WHERE uniacid = :uniacid AND uid = :uid AND type = :type AND addtime >= :starttime AND addtime <= :endtime';
	$params = array(
		':uniacid' => $_W['uniacid'],
		':uid' => $_W['member']['uid'],
		':type' => $type,
		':starttime' => strtotime($starttime),
		':endtime' => strtotime($endtime)
	);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('mc_card_record') . $where . ' ORDER BY id DESC ', $params);
}

if ($do == 'personal_info') {
	$setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid'], 'status' => '1'));
	if (!empty($setting['fields'])) {
		$mc_fields = iunserializer($setting['fields']);
		foreach ($mc_fields as $key => &$row) {
			if (!empty($row['require']) && ($row['bind'] == 'birth' || $row['bind'] == 'birthyear') || $row['bind'] == 'birthday') {
				$row['bind'] = 'birth';
			} elseif (!empty($row['require']) && ($row['bind'] == 'resideprovince' || $row['bind'] == 'residecity' || $row['bind'] == 'residedist')) {
				$row['bind'] = 'reside';
			}
			if ($row['bind'] == 'mobile') {
				unset($mc_fields[$key]);
			}

		}
	}
	$profile = mc_fetch($_W['member']['uid']);
	$mcard = pdo_fetch('SELECT * FROM ' . tablename('mc_card_members') . ' WHERE uniacid = :uniacid AND uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']));

}

if ($do == 'consume') {
	$card_settings = card_setting();
	$discount_params = $card_settings['discount'];
	$group = mc_fetch($_W['member']['uid'], array('groupid'));
	$stores = pdo_getall('activity_stores', array('uniacid' => $_W['uniacid'], 'source' => COUPON_TYPE, 'status' => '1'), array('id', 'business_name', 'branch_name'));
	$stores_data['data'] = array();
	if (!empty($stores) && is_array($stores)) {
		foreach ($stores as $key => $value) {
			$stores_data['data'][$key]['text'] = $value['business_name'];
			$stores_data['data'][$key]['value'] = $value['id'];
			if (!empty($value['branch_name'])) {
				$stores_data['data'][$key]['text'] = $value['business_name'] . '-' . $value['branch_name'];
			}
		}
	}
	if(checksubmit()) {
		$fee = trim($_GPC['fee']);
		$store_id = intval($_GPC['store_id']);
		$body = '会员卡消费' . $fee . '元';
		if (!empty($stores_data['data'])) {
			if (empty($store_id)) {
				message('请选择门店', '', 'error');
			}
		}
		if (empty($fee) || $fee <= 0) {
			message('收款金额有误', '', 'error');
		}
		$final_fee = card_discount_fee($fee);
		$data = array(
			'uniacid' => $_W['uniacid'],
			'clerk_id' => 0,
			'clerk_type' => 3,
			'store_id' => intval($_GPC['store_id']),
			'body' => $body,
			'fee' => $fee,
			'final_fee' => $final_fee,
			'credit_status' => 1,
			'createtime' => TIMESTAMP,
		);
		pdo_insert('paycenter_order', $data);
		$id = pdo_insertid();
		header('Location:' . murl('entry', array('m' => 'paycenter', 'do' => 'pay', 'id' => $id), true, true));
		die;
	}
	template('mc/consume');
	exit();
}

template('mc/card');