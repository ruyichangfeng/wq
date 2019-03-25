<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/8
 * Time: 23:56
 */

defined('IN_IA') or exit('Access Denied');

		$edtype = $_GPC['edtype'];
		$bid = $_GPC['bid'];
		$aid = $_GPC['aid'];
        $business = DBUtil::findById(DBUtil::$TABLE_COUPON_BUSINESS, $bid);
        $cid = $_GPC['cid'];

		if (!empty($cid)) {
			$coupon = DBUtil::findById(DBUtil::$TABLE_COUPON, $cid);
		}

		if (checksubmit('submit')) {

			if ($edtype == 1) {
				$startNum = $_GPC['start_num'];
				$endNum = $_GPC['end_num'];
				$expir = strtotime($_GPC['expire']);

				if ($endNum - $startNum + 1 >100) {
					message('生成优惠券失败,每次最多生成不能超过100个！', $this->createWebUrl('couponmanage', array(
						'op' => 'display',
						'bid' => $bid,
						'aid' => $aid
					)), 'warning');
				}

				for ($num = $startNum; $num <= $endNum; $num ++ ) {
					$couponCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " WHERE bid=:bid and coupon_num =:coupon_num", array(':bid' => $bid, ":coupon_num" => $num));
					if ($couponCount > 0 ) continue;
					$couponData = array(
						'weid' => $this -> weid,
					    'bid' => $bid,
						'aid' => $aid,
						'coupon_num' => $num,
						'expire' => $expir,
						'status' => 1,
						'createtime' => TIMESTAMP
					);
					DBUtil::create(DBUtil::$TABLE_COUPON, $couponData);
				}

				message('生成优惠券成功！', $this->createWebUrl('couponmanage', array(
					'op' => 'display',
					'bid' => $bid,
					'aid' => $aid
				)), 'success');

			}

			if ($edtype == 2) {
				$num = $_GPC['coupon_num'];
				$expir = strtotime($_GPC['expire']);
				$couponCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " WHERE bid=:bid and coupon_num =:coupon_num", array(':bid' => $bid, ":coupon_num" => $num));

				if ($couponCount > 0) {

					message('生成优惠券失败,兑换码已存在！', $this->createWebUrl('couponmanage', array(
						'op' => 'display',
						'bid' => $bid,
					)), 'warning');

				} else {

					$couponData = array(
						'weid' => $this -> weid,
						'bid' => $bid,
						'aid' => $aid,
						'coupon_num' => $num,
						'expire' => $expir,
						'status' => 1,
						'createtime' => TIMESTAMP
					);

					DBUtil::create(DBUtil::$TABLE_COUPON, $couponData);
					message('生成优惠券成功！', $this->createWebUrl('couponmanage', array(
						'op' => 'display',
						'bid' => $bid,
						'aid' => $aid
					)), 'success');
				}

			}

			if ($edtype == 0) {

				if (!empty($coupon) && $coupon['status'] != 1) {
					message('已领取不可以修改！', $this->createWebUrl('couponmanage', array(
						'op' => 'display',
						'bid' => $bid,
						'aid' => $aid
					)), 'warning');
				}

				$num = $_GPC['coupon_num'];
				$expir = strtotime($_GPC['expire']);
				$couponCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_COUPON) . " WHERE bid=:bid and coupon_num =:coupon_num", array(':bid' => $bid, ":coupon_num" => $num));
				if ($couponCount > 0 && $coupon['coupon_num'] != $num ) {
					message('修改优惠券失败,兑换码已存在！', $this->createWebUrl('couponmanage', array(
						'op' => 'display',
						'bid' => $bid,
						'aid'=> $aid,
					)), 'warning');
				}

				$couponData = array(
					'coupon_num' => $num,
					'expire' => $expir,
				);

				DBUtil::updateById(DBUtil::$TABLE_COUPON, $couponData, $cid);
				message('修改优惠券成功！', $this->createWebUrl('couponmanage', array(
					'op' => 'display',
					'bid' => $bid,
					'aid' => $aid
				)), 'success');
			}

		} else {
			$template = "web/coupon_edit";
			switch($edtype) {
				case 0:
					if (!empty($coupon) && $coupon['status'] == 2) {
						message('已领取不可以修改！', $this->createWebUrl('couponmanage', array(
							'op' => 'display',
							'bid' => $bid,
							'aid' => $aid
						)), 'warning');
					}
					$template = "web/coupon_edit";
					break;
				//批量生成
				case 1:
					$template = "web/coupon_batch_add";
					break;
				case 2:
					$template = "web/coupon_edit";
					break;

			}

			load()->func('tpl');
			include $this->template($template);

}