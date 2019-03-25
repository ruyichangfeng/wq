<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/8
 * Time: 23:57
 */

defined('IN_IA') or exit('Access Denied');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {

			$keyword = $_GPC['keyword'];
			$where = '';
			$params = array(
				':weid' => $this->weid
			);

			if (!empty($keyword)) {
				$where .= ' and (nickname like :nickname)';
				$params[':nickname'] = "%$keyword%";

			}

			if ($_GPC['uid'] != '') {
				$where .= ' and id=:uid';
				$params[':uid'] = $_GPC['uid'];
			}

			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_COUPON_USER) . " WHERE weid =:weid " . $where . "  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON_USER) . " WHERE weid =:weid  " . $where, $params);
			$pager = pagination($total, $pindex, $psize);
			include $this->template("web/user_list");
		} else if ($operation == 'delete') {
			$id = $_GPC['uid'];
			pdo_delete(DBUtil::$TABLE_COUPON, array("uid" => $id));
			pdo_delete(DBUtil::$TABLE_COUPON_USER, array("id" => $id));
			message('删除成功！', referer(), 'success');
		}