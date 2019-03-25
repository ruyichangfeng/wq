<?php
defined('IN_IA') or exit('Access Denied');

function we7_coupon_activity_coupon_type_init() {
	global $_W;
	static $coupon_api;
	if (!defined('COUPON_TYPE')) {
		load()->classs('coupon');
		if(empty($coupon_api)) {
			$coupon_api = new coupon();
		}
		$is_coupon_supported = $coupon_api->isCouponSupported();
		if (!empty($is_coupon_supported)) {
			define('COUPON_TYPE', WECHAT_COUPON);
		} else {
			define('COUPON_TYPE', SYSTEM_COUPON);
		}
	}
}

/**
 * 获取某卡券信息
 * @param int $couponid 卡券ID
 * @param int $uniacid 公众号ID
 * @return array
 */
function we7_coupon_activity_coupon_info($id) {
	global $_W;
	we7_coupon_activity_coupon_type_init();
	$id = intval($id);
	if (empty($_W['current_module']) && !empty($GLOBALS['site']) && is_object($GLOBALS['site']) && $GLOBALS['site'] instanceof WeModuleSite && !empty($GLOBALS['site']->module)) {
		$_W['current_module'] = $GLOBALS['site']->module;
	}
	$coupon = pdo_get('coupon', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if (empty($coupon)) {
		return error(1, '卡券不存在或是已经被删除');
	}
	$coupon['date_info'] = iunserializer($coupon['date_info']);
	if ($coupon['date_info']['time_type'] == '1'){
		$coupon['extra_date_info'] = '有效期:' . $coupon['date_info']['time_limit_start'] . '-' . $coupon['date_info']['time_limit_end'];
	} else {
		$coupon['extra_date_info'] = '有效期:领取后' . $coupon['date_info']['deadline'] . '天可用，有效期' . $coupon['date_info']['limit'] . '天';
	}
	if ($coupon['type'] == COUPON_TYPE_DISCOUNT) {
		$coupon['extra'] = iunserializer($coupon['extra']);
		$coupon['extra_instruction'] = '凭此券消费打' . $coupon['extra']['discount'] * 0.1 . '折';
	} elseif ($coupon['type'] == COUPON_TYPE_CASH) {
		$coupon['extra'] = iunserializer($coupon['extra']);
		$coupon['extra_instruction'] = '消费满' . $coupon['extra']['least_cost'] * 0.01 . '元，减' . $coupon['extra']['reduce_cost'] * 0.01 . '元';
	} else {

	}
	$coupon['logo_url'] = tomedia($coupon['logo_url']);
	$coupon['description'] = htmlspecialchars_decode($coupon['description']);
	$modules = pdo_getall('coupon_modules', array('uniacid' => $_W['uniacid'], 'couponid' => $coupon['id']), array(), 'module');
	if (!empty($modules)) {
		$unimodules = uni_modules();
		foreach ($modules as $modulename => $row) {
			$coupon['modules'][$modulename] = array('title' => $unimodules[$modulename]['title'], 'name' => $modulename);
		}
	}
	$stores = pdo_getall('coupon_store', array('uniacid' => $_W['uniacid'], 'couponid' => $coupon['id']), array(), 'storeid');
	if (!empty($stores)) {
		$stores = pdo_getall('activity_stores', array('id' => array_keys($stores)), array('business_name', 'location_id', 'id'), 'id');
		$coupon['location_id_list'] = $stores;
	}
	return $coupon;
}

/**
 * 指定会员使用指定卡券
 * @param int $couponid 卡券id
 * @param int $recid 可选的兑换记录ID
 * @param string $module 模块名称，默认为系统模块
 * @return mixed
 */
function we7_coupon_activity_coupon_use($couponid, $recid, $module = 'system') {
	global $_W, $_GPC;
	$clerk_name = $_W['user']['name'];
	$clerk_id = $_W['user']['clerk_id'];
	$clerk_type = $_W['user']['type'];
	$store_id = $_W['user']['store_id'];
	$coupon_record = pdo_get('coupon_record', array('id' => $recid, 'status' => '1'));
	$coupon_info = we7_coupon_activity_coupon_info(trim($couponid));
	$uid = $coupon_record['uid'];
	load()->model('mc');
	$user = mc_fetch($uid, array('groupid'));
	$fan = mc_fansinfo($uid, '', $_W['uniacid']);
	$coupongroup = pdo_fetchall("SELECT * FROM " . tablename('coupon_groups') . " WHERE `couponid` = :couponid", array(':couponid' => $couponid), 'groupid');
	$coupon_group = array_keys($coupongroup);
	if (COUPON_TYPE == WECHAT_COUPON) {
		$fan_groups = $fan['tag']['tagid_list'];
	} else {
		$fan_groups[] = $user['groupid'];
	}
	$group = @array_intersect($coupon_group, $fan_groups);
	if (empty($coupon_info)) {
		return error(-1, '没有指定的卡券信息');
	}
	if (empty($group) && !empty($coupon_group)) {
		return error(-1, '无法使用该卡券');
	}
	if ($module == 'paycenter') {
		if (!empty($coupon_info['location_id_list'])) {
			$store_ids = array_keys($coupon_info['location_id_list']);
		}
		if (!empty($store_ids) && !in_array($store_id, $store_ids)) {
			return error(-1, '门店信息错误');
		}
	} else {
		$coupon_modules = array_keys($coupon_info['modules']);
		if (!empty($coupon_info['modules']) && !in_array($module, $coupon_modules) && $module != 'system') {
			return error(-1, '非法模块');
		}
	}
	$date_info = iunserializer($coupon_info['date_info']);
	if ($date_info['time_type'] == '1') {
		if (strtotime(str_replace('.', '-', $date_info['time_limit_start'])) > strtotime(date('Y-m-d'))) {
			return error(-1, '卡券活动尚未开始');
		} elseif (strtotime(str_replace('.', '-', $date_info['time_limit_end'])) < strtotime(date('Y-m-d'))) {
			return error(-1, '卡券活动已经结束');
		}
	} else {
		$starttime = strtotime(date('Y-m-d', $coupon_record['addtime'])) + $date_info['deadline'] * 86400;
		$endtime = $starttime + $date_info['limit'] * 86400;
		if ($starttime > strtotime(date('Y-m-d'))) {
			return error(-1, '卡券活动尚未开始');
		} elseif ($endtime < strtotime(date('Y-m-d'))) {
			return error(-1, '卡券活动已经结束');
		}
	}
	if (empty($coupon_record)) {
		return error(-1, '没有可使用的卡券');
	}
	if ($coupon_info['source'] == '2') {
		load()->classs('coupon');
		$coupon_api = new coupon($_W['acid']);
		$status = $coupon_api->ConsumeCode(array('code' => $coupon_record['code']));
		if(is_error($status)) {
			return error('-1', $status['message']);
		}
	}
	$update = array(
			'status' => 3,
			'usetime' => TIMESTAMP,
			'clerk_name' => $clerk_name,
			'clerk_id' => intval($clerk_id),
			'clerk_type' => $clerk_type,
			'store_id' => $store_id
	);
	pdo_update('coupon_record', $update, array('id' => $coupon_record['id']));
	return true;
}

/**
 * 指定会员兑换指定真实物品
 * @param int $uid  会员UID
 * @param int $exid  真实物品ID
 * @return mixed
 */
function we7_coupon_activity_goods_grant($uid, $exid){
	global $_W;
	$exid = intval($exid);
	$uid = intval($uid);
	$exchange = we7_coupon_activity_exchange_info($exid, $_W['uniacid']);
	if (empty($exchange)) {
		return error(-1, '没有指定的实物兑换');
	}
	if ($exchange['starttime'] > TIMESTAMP) {
		return error(-1, '该实物兑换尚未开始');
	}
	if ($exchange['endtime'] < TIMESTAMP) {
		return error(-1, '该实物兑换已经结束');
	}
	$pnum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('activity_exchange_trades') . ' WHERE uniacid = :uniacid AND uid = :uid AND exid = :exid', array(':uniacid' => $_W['uniacid'], ':uid' => $uid, ':exid' => $exid));
	if ($pnum >= $exchange['pretotal']) {
		return error(-1, '该实物兑换每人只能使用' . $exchange['pretotal'] . '次');
	}
	if ($exchange['num'] >= $exchange['total']) {
		return error(-1, '该实物兑换已兑换完');
	}
	$data = array(
			'uniacid' => $_W['uniacid'],
			'uid' => $uid,
			'type' => 3,
			'exid' => $exid,
			'createtime' => TIMESTAMP,
	);
	pdo_insert('activity_exchange_trades', $data);
	$insert_id = pdo_insertid();
	if (empty($insert_id)) {
		return error(-1, '实物兑换失败');
	}
	//给收货人信息表中插入数据,用户完善的时候更新该数据(保持activity_exchange_trades表数据和activity_exchange_trades_shipping同步)
	$insert = array(
			'tid' => $insert_id,
			'uniacid' => $_W['uniacid'],
			'uid' => $uid,
			'status' => 0,
			'exid' => $exid,
			'createtime' => TIMESTAMP
	);
	pdo_insert('activity_exchange_trades_shipping', $insert);
	pdo_update('activity_exchange', array('num' => $exchange['num'] + 1), array('id' => $exid, 'uniacid' => $_W['uniacid']));
	return $insert_id;
}

/**
 * 同步微信卡券最新状态
 */
function we7_coupon_activity_coupon_sync() {
	global $_W;
	$cachekey = "couponsync:{$_W['uniacid']}";
	$cache = cache_load($cachekey);
	if (!empty($cache) && $cache['expire'] > time()) {
		return false;
	}
	$coupon_api = new coupon($_W['acid']);
	$cards = pdo_getall('coupon', array('acid' => $_W['acid']), array('id', 'status', 'card_id', 'acid'));
	foreach ($cards as $val) {
		$card = $coupon_api -> fetchCard($val['card_id']);
		if (is_error($card)) {
			return(error(-1, $card['message']));
		}
		$type = strtolower($card['card_type']);
		$coupon_status = we7_coupon_activity_coupon_status();
		$status = $coupon_status[$card[$type]['base_info']['status']];
		pdo_update('coupon', array('status' => $status), array('id' => $val['id']));
	}
	cache_write($cachekey, array('expire' => time() + 1800));
	return true;
}

/**
 * 获取卡券的颜色，参考微信接口
 * 考虑颜色数据很少变动，此处直接返回数据不走接口
 */
function we7_coupon_activity_coupon_colors() {
	$colors = array(
		'Color010' => '#55bd47',
		'Color020' => '#10ad61',
		'Color030' => '#35a4de',
		'Color040' => '#3d78da',
		'Color050' => '#9058cb',
		'Color060' => '#de9c33',
		'Color070' => '#ebac16',
		'Color080' => '#f9861f',
		'Color081' => '#f08500',
		'Color082' => '#a9d92d',
		'Color090' => '#e75735',
		'Color100' => '#d54036',
		'Color101' => '#cf3e36',
		'Color102' => '#5e6671',
	);
	return $colors;
}

/**
 * 获取礼品兑换信息(仅用于判断真实物品或活动参与次数)
 * @param int $exchangeid 兑换ID
 * @param int $uniacid 公众号ID
 * @return array
 **/
function we7_coupon_activity_exchange_info($exchangeid, $uniacid = 0){
	global $_W;
	$uniacid = intval($uniacid) ? intval($uniacid) : $_W['uniacid'];
	$exchange = pdo_fetch('SELECT * FROM '.tablename('activity_exchange').' WHERE id=:id AND uniacid = :uniacid', array(':id'=>$exchangeid, ':uniacid' => $uniacid));
	if (!empty($exchange) && !empty($exchange['extra'])) {
		$exchange['extra'] = iunserializer($exchange['extra']);
	}
	return $exchange;
}

function we7_coupon_activity_coupon_grant($id, $openid) {
	we7_coupon_activity_coupon_type_init();
	global $_W, $_GPC;
	if (empty($openid)) {
		$openid = $_W['openid'];
		if (empty($openid)) {
			$openid = $_W['member']['uid'];
		}
		if (empty($openid)) {
			return error(-1, '没有找到指定会员');
		}
	}
	$fan = mc_fansinfo($openid, '', $_W['uniacid']);
	$openid = $fan['openid'];
	if (empty($openid)) {
		return error(-1, '兑换失败');
	}
	$code = base_convert(md5(uniqid() . random(4)), 16, 10);
	$code = substr($code, 1, 16);
	$user = mc_fetch($fan['uid'], array('groupid'));
	$credit_names = array('credit1' => '积分', 'credit2' => '余额');
	$coupon = we7_coupon_activity_coupon_info($id);
	$pcount = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('coupon_record') . " WHERE `openid` = :openid AND `couponid` = :couponid", array(':couponid' => $id, ':openid' => $openid));
	$coupongroup = pdo_fetchall("SELECT * FROM " . tablename('coupon_groups') . " WHERE `couponid` = :couponid", array(':couponid' => $id), 'groupid');
	$coupon_group = array_keys($coupongroup);
	$member = pdo_get('mc_members', array('uniacid' => $_W['uniacid'], 'uid' => $fan['uid']));
	if (COUPON_TYPE == WECHAT_COUPON) {
		$fan_groups = $fan['tag']['tagid_list'];
	} else {
		$fan_groups[] = $user['groupid'];
	}
	$group = @array_intersect($coupon_group, $fan_groups);
	if (empty($coupon)) {
		return error(-1, '未找到指定卡券');
	} elseif (empty($group) && !empty($coupon_group)) {
		if (!empty($fan_groups)) {
			return error(-1, '无权限兑换');
		} else {
			if (is_array($coupon_group) && !in_array('0', $coupon_group)) {
				return error(-1, '无权限兑换');
			}
		}
	} elseif (strtotime(str_replace('.', '-', $coupon['date_info']['time_limit_end'])) < strtotime(date('Y-m-d')) && $coupon['date_info']['time_type'] != 2) {
		return error(-1, '活动已结束');
	} elseif ($coupon['quantity'] <= 0) {
		return error(-1, '卡券发放完毕');
	} elseif ($pcount >= $coupon['get_limit'] && !empty($coupon['get_limit'])) {
		return error(-1, '数量超限');
	} elseif (!empty($coupon['modules']) && !in_array($_W['current_module']['name'], array_keys($coupon['modules'])) && ($_GPC['c'] != 'activity' && $_GPC['c'] != 'mc' ) && $_W['current_module']['name'] != 'we7_coupon') {
		return error(-1, '该模块没有此卡券发放权限');
	}
	$give = $_W['activity_coupon_id'] ? true :false;
	$uid = !empty($_W['member']['uid']) ? $_W['member']['uid'] : $fan['uid'];
	$insert = array(
		'couponid' => $id,
		'uid' => $uid,
		'uniacid' => $_W['uniacid'],
		'openid' => $fan['openid'],
		'code' => $code,
		'grantmodule' => $give ? $_W['activity_coupon_id'] : $_W['current_module']['name'],
		'addtime' => TIMESTAMP,
		'status' => 1,
		'remark' => $give ? '系统赠送' : '用户使用' . $coupon['exchange']['credit'] . $credit_names[$coupon['exchange']['credittype']] . '兑换'
	);
	if ($coupon['source'] == 2) {
		$insert['card_id'] = $coupon['card_id'];
		$insert['code'] = '';
	}
	pdo_insert('coupon_record', $insert);
	pdo_update('coupon', array('quantity' => $coupon['quantity'] - 1, 'dosage' => $coupon['dosage'] + 1), array('uniacid' => $_W['uniacid'],'id' => $coupon['id']));
	return true;
}

function we7_coupon_activity_get_member($type, $param = array()) {
	we7_coupon_activity_coupon_type_init();
	global $_W;
	$types = array('new_member', 'old_member', 'quiet_member', 'activity_member', 'group_member', 'cash_time', 'openids');
	if (!in_array($type, $types)) {
		return error('1', '没有匹配的用户类型');
	}
	$members = array();
	//获取会员属性
	$propertys = we7_coupon_activity_member_propertys();
	//新会员，一个月内消费不超过一次
	if ($type == 'new_member') {
		$property_time = strtotime('-' . $propertys['newmember'] . ' month', time());
		$mc_members = pdo_getall('mc_members', array('uniacid' => $_W['uniacid'], 'createtime >' => $property_time), array('uid'), 'uid');
		$mc_uids = array_keys($mc_members);
		$uids = implode(',',$mc_uids);
		$mc_cash_record_sql = "SELECT uid FROM " . tablename('mc_cash_record') . " WHERE uid IN ( :uids ) AND createtime > :time GROUP BY uid HAVING COUNT(*) < 2 " ;
		$mc_cash_record = pdo_fetchall($mc_cash_record_sql, array(':uids' => $uids, ':time' => $property_time));
		if (!empty($mc_cash_record)) {
			foreach ($mc_cash_record as $v) {
				if (!in_array($v['uid'], $mc_uids)) {
					unset($mc_uids[$v['uid']]);
				}
			}
		}
	}
	//老会员，注册超过两个月的会员
	if ($type == 'old_member') {
		$property_time = strtotime('-' . $propertys['oldmember'] . ' month', time());
		$mc_members = pdo_getall('mc_members', array('uniacid' => $_W['uniacid'], 'createtime <' => $property_time), array('uid'), 'uid');
		$mc_uids = array_keys($mc_members);
	}
	if ($type == 'activity_member') {
		$property_time = strtotime('-' . $propertys['activitymember'] . ' month', time());
		$mc_cash_record_sql = "SELECT * FROM " . tablename('mc_cash_record') . " WHERE uniacid = :uniacid AND createtime > :time GROUP BY uid HAVING COUNT(*) > 2";
		$mc_cash_record = pdo_fetchall($mc_cash_record_sql, array(':uniacid' => $_W['uniacid'], ':time' => $property_time), 'uid');
		$mc_uids = array_keys($mc_cash_record);
	}
	if (!empty($mc_uids)) {
		$members = pdo_getall('mc_mapping_fans', array('uid' => $mc_uids, 'openid !=' => ''), array('openid'), 'openid');
	}
	if ($type == 'quiet_member') {
		$property_time = strtotime('-' . $propertys['quietmember'] . ' month', time());
		$members = pdo_fetchall("SELECT a.openid FROM " . tablename('mc_mapping_fans') . " as a LEFT JOIN " 
				. tablename('mc_cash_record')." as b ON a.uid = b.uid WHERE a.uniacid = :uniacid AND b.id is null 
				GROUP BY a.uid ", array(':uniacid' => $_W['uniacid']), 'openid');
		$member = pdo_fetchall("SELECT a.openid FROM " . tablename('mc_mapping_fans') . " as a LEFT JOIN "
				 . tablename('mc_cash_record')." as b ON a.uid = b.uid WHERE a.uniacid = :uniacid AND b.createtime > :time 
				GROUP BY a.uid ", array(':uniacid' => $_W['uniacid'], ':time' => $property_time), 'openid');
		if (!empty($member)) {
			foreach ($member as $key => $mem) {
				unset($members[$key]);
			}
		}
	}
	if ($type == 'group_member') {
		if (empty($param)) {
			return error(1, '请选择会员组');
		}
		if (COUPON_TYPE == WECHAT_COUPON) {
			$members = pdo_getall('mc_mapping_fans', array('uniacid' => $_W['uniacid']), array(), 'openid');
			foreach ($members as $key => &$fan) {
				$fan['groupid'] = explode(',', $fan['groupid']);
				if (!is_array($fan['groupid']) || !in_array($param['groupid'], $fan['groupid'])) {
					unset($members[$key]);
				}
			}
		} else {
			$mc_members = pdo_getall('mc_members', array('groupid' => $param['groupid'], 'uniacid' => $_W['uniacid']), array('uid'), 'uid');
			$mc_uids = array_keys($mc_members);
			$members = array();
			if (!empty($mc_uids)) {
				$members = pdo_getall('mc_mapping_fans', array('openid !=' => '', 'uid' => $mc_uids), array('openid'), 'openid');
			}
		}
	}
	if ($type == 'cash_time') {
		$mc_cash_record = pdo_fetchall("SELECT uid FROM " . tablename('mc_cash_record') . " WHERE createtime >= :start AND createtime <= :end", 
				array(':start' => $param['start'], ':end' => $param['end']), 'uid');
		$mc_uids = array_keys($mc_cash_record);
		$members = array();
		if (!empty($mc_uids)) {
			$members = pdo_getall('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'uid' => $mc_uids), array('openid'), 'openid');
		}
	}
	if ($type == 'openids') {
		$members = json_decode($_COOKIE['fans_openids'.$_W['uniacid']]);
	}

	if (is_array($members)) {
		$member = $type == 'openids' ? $members : array_keys($members);
		$members = array();
		$members['members'] = $member;
		$members['total'] = count($members['members']);
	} else {
		$members = array();
	}
	return $members;
}

function we7_coupon_activity_coupon_owned() {
	global $_W, $_GPC;
	$uid = $_W['member']['uid'];
	$param = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'status' => 1);
	$data = pdo_getall('coupon_record', $param);
	foreach ($data as $key => $record) {
		$coupon = we7_coupon_activity_coupon_info($record['couponid']);
		if ($coupon['source'] != COUPON_TYPE) {
			unset($data[$key]);
			continue;
		}
		if ($coupon['status'] != '3') {
			pdo_delete('coupon_record', array('id' => $record['id']));
			unset($data[$key]);
			continue;
		}
		if (is_error($coupon)) {
			unset($data[$key]);
			continue;
		}
		$modules = array();
		if (!empty($coupon['modules'])) {
			foreach ($coupon['modules'] as $module) {
				$modules[] = $module['name'];
			}
		}
		if (!empty($modules) && !in_array($_W['current_module']['name'], $modules) && !empty($_W['current_module']['name']) && $_W['current_module']['name'] != 'we7_coupon') {
			unset($data[$key]);
			continue;
		}
		if (is_array($coupon['date_info']) && $coupon['date_info']['time_type'] == '2') {
			$starttime = $record['addtime'] + $coupon['date_info']['deadline'] * 86400;
			$endtime = $starttime + ($coupon['date_info']['limit']) * 86400;
			if ($endtime < time()) {
				unset($data[$key]);
				pdo_delete('coupon_record', array('id' => $record['id']));
				continue;
			} else {
				$coupon['extra_date_info'] = '有效期:' . date('Y.m.d', $starttime) . '-' . date('Y.m.d', $endtime);
			}
		}
		if (is_array($coupon['date_info']) && $coupon['date_info']['time_type'] == '1') {
			$endtime = str_replace('.', '-', $coupon['date_info']['time_limit_end']);
			$endtime = strtotime($endtime);
			if ($endtime < time()) {
				pdo_delete('coupon_record', array('id' => $record['id']));
				unset($data[$key]);
				continue;
			}

		}
		if ($coupon['type'] == COUPON_TYPE_DISCOUNT) {
			$coupon['icon'] = '<div class="price">' . $coupon['extra']['discount'] * 0.1 . '<span>折</span></div>';
		} elseif($coupon['type'] == COUPON_TYPE_CASH) {
			$coupon['icon'] = '<div class="price">' . $coupon['extra']['reduce_cost'] * 0.01 . '<span>元</span></div><div class="condition">满' . $coupon['extra']['least_cost'] * 0.01 . '元可用</div>';
		} elseif($coupon['type'] == COUPON_TYPE_GIFT) {
			$coupon['icon'] = '<img src="resource/images/wx_gift.png" alt="" />';
		} elseif($coupon['type'] == COUPON_TYPE_GROUPON) {
			$coupon['icon'] = '<img src="resource/images/groupon.png" alt="" />';
		} elseif($coupon['type'] == COUPON_TYPE_GENERAL) {
			$coupon['icon'] = '<img src="resource/images/general_coupon.png" alt="" />';
		}
		$data[$key] = $coupon;
		$data[$key]['recid'] = $record['id'];
		$data[$key]['code'] = $record['code'];
		if ($coupon['source'] == '2') {
			if (empty($data[$key]['code'])) {
				$data[$key]['extra_ajax'] = url('entry', array('m' => 'we7_coupon', 'do' => 'activity', 'type' => 'coupon', 'op' => 'addcard'));
			} else {
				$data[$key]['extra_ajax'] = url('entry', array('m' => 'we7_coupon', 'do' => 'activity', 'type' => 'coupon', 'op' => 'opencard'));
			}
		}
	}
	return $data;
}

function we7_coupon_activity_paycenter_coupon_available() {
	$coupon_owned = we7_coupon_activity_coupon_owned();
	foreach ($coupon_owned as $key => &$val) {
		if (empty($val['code'])) {
			unset($val);
		}
		if ($val['type'] == '1' || $val['type'] == '2') {
			$coupon_available[$val['id']] = $val;
		}
	}
	return $coupon_available;
}

function we7_coupon_activity_store_sync() {
	global $_W;
	load()->classs('coupon');
	$cachekey = "storesync:{$_W['uniacid']}";
	$cache = cache_load($cachekey);
	if (!empty($cache) && $cache['expire'] > time()) {
		return false;
	}
	$stores = pdo_getall('activity_stores', array('uniacid' => $_W['uniacid'], 'source' => 2));
	foreach ($stores as $val) {
		if ($val['status'] == 3) {
			continue;
		}
		$coupon_api = new coupon($_W['acid']);
		$location = $coupon_api->LocationGet($val['location_id']);
		if (is_error($location)) {
			return error(-1, $location['message']);
		}
		$location = $location['business']['base_info'];
		$status2local = array('', 3, 2, 1, 3);
		$location['status'] = $status2local[$location['available_state']];
		$location['location_id'] = $location['poi_id'];
		$category_temp = explode(',', $location['categories'][0]);
		$location['category'] = iserializer(array('cate' => $category_temp[0], 'sub' => $category_temp[1], 'clas' => $category_temp[2]));
		$location['photo_list'] = iserializer($location['photo_list']);
		unset($location['categories'], $location['poi_id'], $location['update_status'], $location['available_state'], $location['offset_type'], $location['sid'], $location['type'], $location['qualification_list'], $location['upgrade_comment'], $location['upgrade_status'], $location['mapid']);
		pdo_update('activity_stores', $location, array('uniacid' => $_W['uniacid'], 'id' => $val['id']));
	}
	cache_write($cachekey, array('expire' => time() + 1800));
	return true;
}

function we7_coupon_paycenter_order_status() {
	/*		SUCCESS—支付成功
		REFUND—转入退款
		NOTPAY—未支付
		CLOSED—已关闭
		REVOKED—已撤销（刷卡支付）
		USERPAYING--用户支付中
		PAYERROR--支付失败(其他原因，如银行返回失败)*/
	return array(
		'0' => array(
			'text' => '未支付',
			'class' => 'text-danger',
		),
		'1' => array(
			'text' => '已支付',
			'class' => 'text-success',
		),
		'2' => array(
			'text' => '已支付,退款中...',
			'class' => 'text-default',
		),
	);
}

function we7_coupon_paycenter_order_types() {
	return array(
		'wechat' => '微信支付',
		'alipay' => '支付宝支付',
		'credit' => '余额支付',
		'baifubao' => '百付宝'
	);
}

function we7_coupon_paycenter_order_trade_types() {
	return array(
		'native' => '扫码支付',
		'jsapi' => '公众号支付',
		'micropay' => '刷卡支付'
	);
}

function we7_coupon_paycenter_check_login() {
	global $_W, $_GPC;
	if (empty($_W['uid']) && $_GPC['do'] != 'login') {
		message('抱歉，您无权进行该操作，请先登录', murl('entry', array('m' => 'we7_coupon', 'do' => 'clerk', 'op' => 'login'), true, true), 'error');
	}
	if ($_W['user']['type'] == ACCOUNT_OPERATE_CLERK) {
		isetcookie('__uniacid', $_W['user']['uniacid'], 7 * 86400);
		isetcookie('__uid', $_W['uid'], 7 * 86400);
	} else {
		message('非法访问', '', 'error');
	}
}
function we7_coupon_activity_get_coupon_label($type = '') {
	$types = array(
		COUPON_TYPE_DISCOUNT => array('title' => '折扣券', 'value' => 'discount'),
		COUPON_TYPE_CASH => array('title' => '代金券', 'value' => 'cash'),
		COUPON_TYPE_GIFT => array('title' => '礼品券', 'value' => 'gift'),
		COUPON_TYPE_GROUPON => array('title' => '团购券', 'value' => 'groupon'),
		COUPON_TYPE_GENERAL => array('title' => '优惠券', 'value' => 'general_coupon'),
	);
	return $types[$type] ? $types[$type] : $types;
}

/**
 * 检测会员信息是否存在(邮箱和手机号)
 * @param array $data 会员信息
 * @return mixed
 */
function we7_coupon_mc_check($data) {
	global $_W;
	if (!empty($data['email'])) {
		$email = trim($data['email']);
		if (!preg_match(REGULAR_EMAIL, $email)) {
			return error(-1, '邮箱格式不正确');
		}
		$isexist = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND email = :email AND uid != :uid', array(':uniacid' => $_W['uniacid'], ':email' => $email, ':uid' => $_W['member']['uid']));
		if ($isexist >= 1) {
			return error(-1, '邮箱已被注册');
		}
	}
	if (!empty($data['mobile'])) {
		$mobile = trim($data['mobile']);
		if (!preg_match(REGULAR_MOBILE, $mobile)) {
			return error(-1, '手机号格式不正确');
		}
		$isexist = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . ' WHERE uniacid = :uniacid AND mobile = :mobile AND uid != :uid', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile, ':uid' => $_W['member']['uid']));
		if ($isexist >= 1) {
			return error(-1, '手机号已被注册');
		}
	}
	return true;
}

/*
 * 会员积分|优惠券信息变更操作员
 * */
function we7_coupon_get_operator($clerk_type, $store_id, $clerk_id) {
	global $_W;
	if (empty($stores) || empty($clerks)) {
		$clerks = pdo_getall('activity_clerks', array('uniacid' => $_W['uniacid']), array('id', 'name', 'uid'), 'id');
		$stores = pdo_getall('activity_stores', array('uniacid' => $_W['uniacid']), array('id', 'business_name', 'branch_name'), 'id');
	}
	$data = array(
		'clerk_cn' => '',
		'store_cn' => '',
	);
	if($clerk_type == 1) {
		$data['clerk_cn'] = '系统';
	} elseif($clerk_type == 2) {
		$data['clerk_cn'] = pdo_fetchcolumn('SELECT username FROM ' . tablename('users') . ' WHERE uid = :uid', array(':uid' => $clerk_id));
	} elseif($clerk_type == 3) {
		if (empty($clerk_id)) {
			$data['clerk_cn'] = '本人操作';
		} else {
			$data['clerk_cn'] = $clerks[$clerk_id]['name'];
		}	
		$data['store_cn'] = $stores[$store_id]['business_name'] . ' ' . $stores[$store_id]['branch_name'];
	}
	if (empty($data['store_cn'])) {
		$data['store_cn'] = '暂无门店信息';
	}
	if (empty($data['clerk_cn'])) {
		$data['clerk_cn'] = '暂无操作员信息';
	}
	return $data;
}
function we7_coupon_activity_coupon_download($card_list) {
	global $_W;
	$coupon_api = new coupon($_W['acid']);
	$local_coupon_list = pdo_getall('coupon', array('acid' => $_W['acid'], 'source' => 2), array('id', 'status', 'card_id', 'type'), 'card_id');
	if (!empty($card_list['card_id_list'])) {
		foreach ($card_list['card_id_list'] as $card_id) {
			$coupon_info = $coupon_api->fetchCard($card_id);
			if (is_error($coupon_info)) {
				return(error(-1, $coupon_info['message']));
			}
			if ($coupon_info['card_type'] == 'DISCOUNT') {
				$type = 1;
			} elseif ($coupon_info['card_type'] == 'CASH') {
				$type = 2;
			} elseif ($coupon_info['card_type'] == 'GROUPON') {
				$type = 3;
			} elseif ($coupon_info['card_type'] == 'GIFT') {
				$type = 4;
			} elseif ($coupon_info['card_type'] == 'GENERAL_COUPON') {
				$type = 5;
			}
			$coupon_type_label = we7_coupon_activity_coupon_type_label($type);
			$coupon = Card::create($type);
			$coupon->logo_url = $coupon_info[$coupon_type_label[1]]['base_info']['logo_url'];
			$coupon->brand_name = $coupon_info[$coupon_type_label[1]]['base_info']['brand_name'];
			$coupon->title = $coupon_info[$coupon_type_label[1]]['base_info']['title'];
			$coupon->sub_title = $coupon_info[$coupon_type_label[1]]['base_info']['sub_title'];
			$coupon_colors = array_flip(we7_coupon_activity_coupon_colors());
			$coupon->color = $coupon_colors[$coupon_info[$coupon_type_label[1]]['base_info']['color']];
			$coupon->notice = $coupon_info[$coupon_type_label[1]]['base_info']['notice'];
			$coupon->service_phone = $coupon_info[$coupon_type_label[1]]['base_info']['service_phone'];
			$coupon->description = $coupon_info[$coupon_type_label[1]]['base_info']['description'];
			$coupon->get_limit = $coupon_info[$coupon_type_label[1]]['base_info']['get_limit'];
			$coupon->can_share = $coupon_info[$coupon_type_label[1]]['base_info']['can_share'];
			$coupon->can_give_friend = $coupon_info[$coupon_type_label[1]]['base_info']['can_give_friend'];
			if ($coupon_info[$coupon_type_label[1]]['base_info']['date_info']['type'] == 'DATE_TYPE_FIX_TIME_RANGE') {
				$coupon->date_info = array(
					'type' => 'DATE_TYPE_FIX_TIME_RANGE',//新版文档变更为字符串，数值1也可用
					'begin_timestamp' => $coupon_info[$coupon_type_label[1]]['base_info']['date_info']['begin_timestamp'],
					'end_timestamp' => $coupon_info[$coupon_type_label[1]]['base_info']['date_info']['end_timestamp'],
				);
			} elseif ($coupon_info[$coupon_type_label[1]]['base_info']['date_info']['type'] == 'DATE_TYPE_FIX_TERM') {
				$coupon->setDateinfoFix($coupon_info[$coupon_type_label[1]]['base_info']['date_info']['fixed_begin_term'], $coupon_info[$coupon_type_label[1]]['base_info']['date_info']['fixed_term']);
			}
			if (!empty($coupon_info[$coupon_type_label[1]]['base_info']['promotion_url_name']) && !empty($coupon_info[$coupon_type_label[1]]['base_info']['promotion_url'])) {
				$coupon->setPromotionMenu($coupon_info[$coupon_type_label[1]]['base_info']['promotion_url_name'], $coupon_info[$coupon_type_label[1]]['base_info']['promotion_url_sub_title'], $coupon_info[$coupon_type_label[1]]['base_info']['promotion_url']);
			}
			if (!empty($coupon_info[$coupon_type_label[1]]['base_info']['location_id_list'])) {
				$coupon->location_id_list = $coupon_info[$coupon_type_label[1]]['base_info']['location_id_list'];
			}
			$coupon->setCustomMenu('立即使用', '', murl('entry', array('m' => 'paycenter', 'do' => 'consume'), true, true));
			$coupon->setQuantity($coupon_info[$coupon_type_label[1]]['base_info']['sku']['quantity']);
			$coupon->code_type = $coupon_info[$coupon_type_label[1]]['base_info']['code_type'];
			//折扣券
			$coupon->discount = $coupon_info[$coupon_type_label[1]]['discount'];
			//代金券，单位为分
			$coupon->least_cost = $coupon_info[$coupon_type_label[1]]['least_cost'];
			$coupon->reduce_cost = $coupon_info[$coupon_type_label[1]]['reduce_cost'];
			//礼品券
			$coupon->gift = $coupon_info[$coupon_type_label[1]]['gift'];
			//团购券
			$coupon->deal_detail = $coupon_info[$coupon_type_label[1]]['deal_detail'];
			//优惠券
			$coupon->default_detail = $coupon_info[$coupon_type_label[1]]['default_detail'];
			$coupon->card_id = $coupon_info[$coupon_type_label[1]]['base_info']['id'];
			$coupon->source = 2;
			$coupon_status = we7_coupon_activity_coupon_status();
			$coupon->status = $coupon_status[$coupon_info[$coupon_type_label[1]]['base_info']['status']];
			$coupon_insert_data = $coupon->getCardArray();
			$coupon_insert_data['uniacid'] = $_W['uniacid'];
			$coupon_insert_data['acid'] = $_W['acid'];
			if (empty($local_coupon_list[$coupon_insert_data['card_id']])) {
				pdo_insert('coupon', $coupon_insert_data);
			}
		}
	}
	return true;
}

/**
 * 返回卡券类型的中文标题和英文标识，此标识与微信文档同步
 * @param int $type
 */
function we7_coupon_activity_coupon_type_label($type = '') {
	$types = array(
		COUPON_TYPE_DISCOUNT => array('折扣券', 'discount'),
		COUPON_TYPE_CASH => array('代金券', 'cash'),
		COUPON_TYPE_GIFT => array('礼品券', 'gift'),
		COUPON_TYPE_GROUPON => array('团购券', 'groupon'),
		COUPON_TYPE_GENERAL => array('优惠券', 'general_coupon'),
	);
	return $types[$type] ? $types[$type] : $types;
}

function we7_coupon_activity_coupon_status() {
	return array(
		'CARD_STATUS_NOT_VERIFY' => 1, //待审核
		'CARD_STATUS_VERIFY_FAIL' => 2, //未通过
		'CARD_STATUS_VERIFY_OK' => 3, //通过审核
		'CARD_STATUS_USER_DELETE' => 4,
		'CARD_STATUS_DELETE' => 4,//卡券被商户删除
		'CARD_STATUS_USER_DISPATCH' => 5, //在公众平台投放过的卡券
		'CARD_STATUS_DISPATCH' => 5, //在公众平台投放过的卡券
	);
}

function we7_coupon_activity_member_propertys() {
	global $_W;
	$current_property_info = pdo_get('mc_member_property', array('uniacid' => $_W['uniacid']));
	if (!empty($current_property_info)) {
		$propertys = json_decode($current_property_info['property'], true);
	} else {
		$propertys = array(
			'newmember' => '1',
			'oldmember' => '2',
			'activitymember' => '1',
			'quietmember' => '1'
		);
	}
	return $propertys;
}
