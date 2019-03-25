<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');

$kid = $_GPC['kid'];
$op = $_GPC['op'];
$addid = $_GPC['addid'];

$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);

if ($xkwkj['lq_type'] ==self::LQ_TYPE_KD ) {
	$lq_type = self::LQ_TYPE_KD;
} else if ($xkwkj['lq_type'] ==self::LQ_TYPE_ZT) {
	$lq_type = self::LQ_TYPE_ZT;
} else {
	$lq_type = $_GPC['lq_type'];

	if (empty($lq_type)) {
		$lq_type = self::LQ_TYPE_KD;
	}
}



$uac =$this->findUserAc($kid,$uc['openid'] );
$orderInfo = $this->findOrderInfoByOpenid($kid, $uc['openid']);

if ($op == 'submit') {
	$res = array();

	if ($lq_type ==  self::LQ_TYPE_KD) {
		$orderAddress = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, $addid);
		$uname = $orderAddress['uname'];
		$tel = $orderAddress['tel'];
		$address = $orderAddress['address'];
        $province = $orderAddress['province'];
		$city = $orderAddress['city'];
		$county = $orderAddress['county'];
	}


	if ($lq_type == self::LQ_TYPE_ZT) {
		$uname = $_GPC['uname'];
		$tel = $_GPC['tel'];
		$address =  '';
		$province = '';
		$city = '';
		$county ='';
	}


	if (!empty($orderInfo)) {
		$res['code'] = 201;
		$res['msg'] = "订单已提交";
		die(json_encode($res));
	}


	$leftCount = $this->getLeftCount($xkwkj) -1;

	if ($leftCount < 0) {
		$res['code'] = 202;
		$res['msg'] = "库存已不足，下次再参加活动吧";
		die(json_encode($res));
	}

	$orderNo = $this->getOrderNo($kid, $uid);
	$order_array = array(
		'order_no' => $orderNo,
		'kid' => $xkwkj['id'],
		'uid' => $uac['id'],
		'unid' => $uc['id'],
		'uname' => $uname,
		'address' => $address,
		'privnce' => $province,
		'city' => $city,
		'town' => $county,
		'tel' => $tel,
		'openid' => $uc['openid'],
		'y_price' => $xkwkj['p_y_price'],
		'pay_type' => $xkwkj['pay_type'],
		'kh_price' => $uac['price'],
		'yf_price' => $xkwkj['yf_price'],
		'total_price' => $uac['price'] + $xkwkj['yf_price'],
		'status' => $this::$KJ_STATUS_XD,
		'p_model'=> $p_model,
		'createtime' => TIMESTAMP,
         'lq_type' => $lq_type,
		'pay_type'=>$xkwkj['pay_type'],
		'remark' => $_GPC['remark']
	);

	DBUtil::create(DBUtil::$TABLE_XKWJK_ORDER, $order_array);
	$oid = pdo_insertid();
	$orderInfo = DBUtil::findById(DBUtil::$TABLE_XKWJK_ORDER, $oid);
	$res['code'] = 200;
	$res['msg'] = "下单成功";
	die(json_encode($res));
}   else {

	if (!empty($orderInfo)) {
		$url =  $this->createMobileUrl('OrderDetail',array('kid'=>$xkwkj['id']),true);
		header("location: $url");
		exit;
	}





	MonUtil::emtpyMsg($xkwkj, "砍价活动删除或不存在");
	MonUtil::emtpyMsg($uac, "用户活动删除或不存在");
	$zfprice = $xkwkj['yf_price'] + $uac['price'];
	if (empty($addid)) {
		$addresses = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER_ADDRESS) . " WHERE openid =:openid and weid=:weid order by createtime desc",
			array(':openid'=> $uc['openid'], ":weid"=> $this->weid));
		foreach($addresses as $address) {
			if ($address['is_default'] == 1) {
				$orderAddress = $address;
				break;
			}
		}
	} else {
		$orderAddress = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER_ADDRESS, $addid);
	}
	include $this->template('order_submit');
}

