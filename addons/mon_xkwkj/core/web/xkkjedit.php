<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/8/21
 * Time: 22:26
 */


$kid = $_GPC['kid'];
$gid = $_GPC['gid'];

if (!empty($kid)) {
	$reply = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ, array(":id" => $kid));
	$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $reply['gid']);
	$reply['starttime'] = date("Y-m-d  H:i", $reply['starttime']);
	$reply['endtime'] = date("Y-m-d  H:i", $reply['endtime']);
	$rule_items = unserialize($reply['kj_rule']);
}

$categoryies = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_CATEGORY) . " WHERE weid =:weid  ORDER BY display_sort asc ", array(':weid' => $this->weid));
$templates = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_TEMPLATE) . "   ORDER BY createtime asc ");

if (!empty($gid)) {
	$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $gid);
}


if (checksubmit('submit')) {

	if (empty($_GPC['gid'])) {
		message("请选择您要发布的活动的商品！！！" , referer(), 'warning');
	}

	$kj_rules = array();
	$rule_ids = $_GPC['rule_id'];
	$rule_prices = $_GPC['rule_pice'];
	$rule_start = $_GPC['rule_start'];
	$rule_end = $_GPC['rule_end'];

	if (is_array($rule_ids)) {
		foreach ($rule_ids as $key => $value) {
			$d = array(
				'rule_pice' => $rule_prices[$key],
				'rule_start' => $rule_start[$key],
				'rule_end' => $rule_end[$key]
			);
			$kj_rules[] = $d;
		}
	}

	$data = array(
		'weid' => $this->weid,
		'title' => $_GPC['title'],
		'starttime' => strtotime($_GPC['starttime']),
		'endtime' => strtotime($_GPC['endtime']),
		'gid' => $_GPC['gid'],
		'p_kc' => $_GPC['p_kc'],
		'p_y_price' => $_GPC['p_y_price'],
		'p_low_price' => $_GPC['p_low_price'],
		'yf_price' => $_GPC['yf_price'],
		'share_title' => $_GPC['share_title'],
		'share_icon' => $_GPC['share_icon'],
		'share_content' => $_GPC['share_content'],
		'hot_tel' => $_GPC['hot_tel'],
		'kj_intro' => htmlspecialchars_decode($_GPC['kj_intro']),
		'kj_dialog_tip' => $_GPC['kj_dialog_tip'],
		'u_fist_tip' => $_GPC['u_fist_tip'],
		'u_already_tip' => $_GPC['u_already_tip'],
		'rank_tip' => $_GPC['rank_tip'],
		'fk_fist_tip' => $_GPC['fk_fist_tip'],
		'fk_already_tip' => $_GPC['fk_already_tip'],
		'pay_type' => $_GPC['pay_type'],
		'p_model' => $_GPC['p_model'],
		'kj_rule' => serialize($kj_rules),
		'createtime' => TIMESTAMP,
		'kj_follow_enable' => $_GPC['kj_follow_enable'],
		'join_follow_enable' => $_GPC['join_follow_enable'],
		'follow_btn_name' => $_GPC['follow_btn_name'],
		'share_bg' => $_GPC['share_bg'],
		'follow_dlg_tip' => $_GPC['follow_dlg_tip'],
		'rank_num' => $_GPC['rank_num'],
		'v_user' => $_GPC['v_user'],
		'join_rank_num' => $_GPC['join_rank_num'],
		'zt_address' => $_GPC['zt_address'],
		'one_kj_enable' => $_GPC['one_kj_enable'],
		'day_help_count' => $_GPC['day_help_count'],
		'kj_follow_enable' => $_GPC['kj_follow_enable'],
		'submit_money_limit' => $_GPC['submit_money_limit'],
		'hx_enabled' => $_GPC['hx_enabled'],
		'show_index_enable' => $_GPC['show_index_enable'],
		'index_sort' => $_GPC['index_sort'],
		'announcement' => $_GPC['announcement'],
		'zgg_url' => $_GPC['zgg_url'],
		'join_user_limit' => $_GPC['join_user_limit'],
		'help_limit' => $_GPC['help_limit'],
		'locationlimit' => $_GPC['locationlimit'],
		'bgmusic' => $_GPC['bgmusic'],
		'erweim' => $_GPC['erweim'],
		'kc_type' => $_GPC['kc_type'],
		'lq_type' => $_GPC['lq_type'],
		'cid' => $_GPC['cid'],
		'shtel' => $_GPC['shtel'],
		'templateid' => $_GPC['templateid'],
		'hfbk_enable' => $_GPC['hfbk_enable'],
		'v_vcount' => $_GPC['v_vcount'],
		'v_sharecount' => $_GPC['v_sharecount']

	);

	if (empty($kid)) {
		DBUtil::create(DBUtil::$TABLE_XKWKJ, $data);
		message('添加砍价活动成功！', $this->createWebUrl('xkkjManage', array(
			'op' => 'display'
		)), 'success');
	} else {
		DBUtil::updateById(DBUtil::$TABLE_XKWKJ, $data, $kid);
		message('更新砍价活动成功！', $this->createWebUrl('xkkjManage', array(
			'op' => 'display'
		)), 'success');
	}
}


include $this->template("kj_edit");