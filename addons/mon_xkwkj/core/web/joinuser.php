<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

		if ($operation == 'display') {

			$kid = $_GPC['kid'];

			$wkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);

			if (empty($wkj)) {
				message("砍价活动删除或不存在");

			}

			$keyword = $_GPC['keyword'];
			$where = '';
			$params = array(
				':kid' => $kid
			);


			if (!empty($keyword)) {
				$where .= ' and (u.nickname like :nickname)';
				$params[':nickname'] = "%$keyword%";

			}

			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT u.*, ui.uname as uname, ui.tel as tel FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u left join ".tablename(DBUtil::$TABLE_XKWKJ_USER_INFO)." ui on ui.openid= u.openid WHERE u.kid =:kid " . $where . "  ORDER BY createtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u WHERE u.kid =:kid  " . $where, $params);
			$pager = pagination($total, $pindex, $psize);

		} else if ($operation == 'delete') {
			$uid = $_GPC['uid'];
			pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("uid" => $uid));
			pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array("uid" => $uid));
			pdo_delete(DBUtil::$TABLE_XKWKJ_USER, array("id" => $uid));
			message('删除成功！', referer(), 'success');
		}


		include $this->template("user_list");
