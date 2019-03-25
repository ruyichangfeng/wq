<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$kid = $_GPC['kid'];
		if ($operation == 'display') {

			$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);

			if (empty($xkwkj)) {
				message("砍价活动删除或不存在");

			}

			$keyword = $_GPC['keyword'];
			$where = '';
			$params = array(
				':kid' => $kid
			);

			$wxorder_no = $_GPC['wxorder_no'];

			if (!empty($wxorder_no)) {
				$where .= 'and wxorder_no =:wxorder_no';
				$params[":wxorder_no"] = $wxorder_no;
			}

			if (!empty($keyword)) {
				$where .= ' and (order_no like :keyword) or (r.tel like :keyword)';
				$params[':keyword'] = "%$keyword%";

			}
            $status = $_GPC['status'];
			if ($_GPC['status'] != '') {
				$where .= ' and status =:status';
				$params[':status'] = $_GPC['status'];
			}
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT r.*, u.nickname as nickname,u.headimgurl as headimgurl FROM "
				. tablename(DBUtil::$TABLE_XKWJK_ORDER) . " r left join ".tablename(DBUtil::$TABLE_XKWKJ_USER)
				."  u  on r.uid = u.id  WHERE r.kid =:kid " . $where . "  ORDER BY r.createtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " r WHERE kid =:kid  " . $where, $params);
			$pager = pagination($total, $pindex, $psize);

		} else if ($operation == 'delete') {
			$id = $_GPC['id'];
			pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("id" => $id));
			message('删除成功！', $this->createWebUrl('OrderList',array('kid'=>$kid)), 'success');
		} else if($operation == 'fh') {
			$id = $_GPC['id'];
			DBUtil::updateById(DBUtil::$TABLE_XKWJK_ORDER, array('status'=>$this::$KJ_STATUS_YFH), $id );
            $order = DBUtil::findById(DBUtil::$TABLE_XKWJK_ORDER, $id);
			$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $order['kid']);
			$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $order['uid']);
			$this->sendFHTemplateMsg($xkwkj, $user, $order);
			message('发货成功！', $this->createWebUrl('OrderList',array('kid'=>$kid)), 'success');
		}

		include $this->template("order_list");