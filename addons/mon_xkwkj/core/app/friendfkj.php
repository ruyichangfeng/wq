<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$res = array();
$kid = $_GPC['kid'];
$seq_weapon = $_GPC['seq_weapon'];
$name_seq = $_GPC['name_seq'];
$uid = $_GPC['uid'];
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER,$uid);

if (empty($xkwkj)) {
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = '砍价活动删除或不存在';
	die(json_encode($res));
}

if (TIMESTAMP > $xkwkj['endtime']) {
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = '活动已结束';
	die(json_encode($res));
}

if (empty($user)) {
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = '分享主人删除或不存在';
	die(json_encode($res));
}


$status = $this->getStatus($xkwkj, $user);


if ($status != $this::$KJ_STATUS_ZC) {
	$statusText = $this->getStatusText($status);
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = "对不起，当前活动".$statusText;
	die(json_encode($res));
}



$friend = $this->getClientUserInfo();

if (empty($friend)) {
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = '无法获取砍价人信息，请检查你的JSSDK分享权限设置!';
	die(json_encode($res));
}


if ($xkwkj['kj_follow_enable'] == 1 && empty($_W['fans']['follow'])) {
	$res['code'] = 2;
	$res['price'] = 0;
	$res['msg'] = '请关注公众号后再帮助好友砍价！';
	die(json_encode($res));
}


$friendHelpCount = $this->findSameKJHelpCount($kid, $friend['openid']);

if ($friendHelpCount >= $xkwkj['help_limit']) {
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = '你帮助此商品砍价好友砍价已经超过次数啦,下次再来帮助好友吧！';
	die(json_encode($res));
}


$totalHelpProductCount = $this->findHelpProductCount($friend['openid']);


if (!empty($this->xkkjSetting['help_kj_limit']) && $totalHelpProductCount >= $this->xkkjSetting['help_kj_limit']) {
	$res['code'] = 0;
	$res['price'] = 0;
	$res['msg'] = '您帮助不同的商品砍价已经超过次数啦，下次再来帮助砍价吧！';
	die(json_encode($res));
}

$kj_res = $this->createFriendKj($xkwkj, $uid, $friend['openid'], $friend['nickname'], $friend['headimgurl'], $seq_weapon, $name_seq);
$res['code'] = $kj_res[0];
$res['price'] = $kj_res[1];
$res['msg'] = $kj_res[2];
die(json_encode($res));