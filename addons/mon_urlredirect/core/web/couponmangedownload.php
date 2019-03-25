<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/9
 * Time: 23:07
 */

defined('IN_IA') or exit('Access Denied');

$dc = $_GPC['dc'];


$status = $_GPC['status'];
$aid = $_GPC['aid'];
$bid = $_GPC['bid'];
$params[':weid'] = $this -> weid;
$params[':bid'] = $bid;
$params[':aid'] = $aid;

if (isset($_GPC['keyword'])) {
	$where .= ' AND c.`coupon_num` LIKE :keywords';
	$params[':keywords'] = "%{$_GPC['keyword']}%";
}

if (!empty($status)) {
	$where .= " and c.status =:status";
	$params[":status"] = $status;
}

if (isset($aid)) {
	$where .= " and c.aid =:aid";
	$params[":aid"] = $aid;
}



$sqlNickName = "(select nickname from " . tablename(DBUtil::$TABLE_COUPON_USER) .
	" u where u.id = c.uid ) as nickname";

$list = pdo_fetchall("SELECT c.*, a.title as atitle, ".$sqlNickName." FROM " . tablename(DBUtil::$TABLE_COUPON) . "
	 c left join ".tablename(DBUtil::$TABLE_COUPON_ACTIVITY)." a on c.aid=a.id WHERE c.bid =:bid" .
	$where . " ORDER BY createtime DESC", $params);

$i = 0;
foreach ($list as $key => $value) {
	$arr[$i]['atitle'] = $value['atitle'];
	if($value['nickname']) {
		$arr[$i]['nickname'] = $value['nickname'];
	} else {
		$arr[$i]['nickname'] = '';
	}
	$arr[$i]['coupon_num'] = $value['coupon_num'];


	if ($value['status'] == 1) {
		$arr[$i]['status'] = '未兑换';
	}

	if ($value['status'] == self::COUPON_GET) {
		$arr[$i]['status'] = '未兑换';
	}

	if ($value['status'] == self::COUPON_USED) {
		$arr[$i]['status'] = '已兑换';
	}

	$arr[$i]['expire'] = date("Y-m-d H:i:s", $value['expire']);
	$arr[$i]['createtime'] = date("Y-m-d H:i:s",$value['createtime']);
	$i++;
}

MonUtil::exportexcel($arr, array('使用活动', '领取用户', '兑换码', "状态", "过期时间",  '创建时间'), $dc ,'兑换码');