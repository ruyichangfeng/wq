<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
$kid = $_GPC['kid'];
$uid = $_GPC['uid'];
$fopenid = $_GPC['openid'];
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);
MonUtil::emtpyMsg($xkwkj, "砍价活动不存在或已删除!");
$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $uid);
MonUtil::emtpyMsg($user, "用户删除或不存在!");
$firend = $this->getClientUserInfo($kid);
$userInfo = $this->getClientUserInfo($kid);
$userInfo['nickname'] = $user['nickname'];
if ($firend['openid'] == $user['openid']) {//自己点了自己分析的链接
	$indexUrl = MonUtil::str_murl($this->createMobileUrl('index', array('kid' => $kid, 'openid' => $fopenid), true));
	header("location: $indexUrl");
	exit;
}
$joinCount = $this->getJoinCount($xkwkj);
$leftCount = $this->getLeftCount($xkwkj);
$starttime = date("Y/m/d  H:i:s", $xkwkj['starttime'] );
$endtime = date("Y/m/d  H:i:s", $xkwkj['endtime'] );
$curtime = date("Y/m/d  H:i:s", TIMESTAMP);


$status = $this->getStatus($xkwkj, $user);
$statusText = $this->getStatusText($status);

$joinFirend = $this->findJoinUser($kid, $firend['openid']);
$firendJoined = false;
if (!empty($joinFirend)) {
	$firendJoined = true;// 哥们自己有参加过活动
}

//		if ($xkwkj['one_kj_enable'] == 1) {
//			$dbFirend = $this->findHelpFirendLimit($kid, $firend['openid']);
//		} else {
//			$dbFirend = $this->findHelpFirend($uid, $firend['openid']);
//		}


$dbFirend = $this->findHelpFirend($uid, $firend['openid']);

$join_rank_num = $xkwkj['join_rank_num'];
$ranklist = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " WHERE kid =:kid   ORDER BY price asc, createtime desc limit 0,  ".$join_rank_num , array(':kid'=>$kid));

$helped = false;
$follow = 1;
if (!empty($_W['fans']['follow'])){
	$follow = 2;
}


$mobileTemplate = $this->getMobileTemplate($xkwkj['templateid']);

$sql = "select nickname as user_name, ac as action, kname as seq_name ,kd as seq_weapon, k_price as amount, createtime as time, headimgurl as avatar from"
	. tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " where uid=:uid order by createtime desc  limit 0,".$xkwkj['rank_num'];
$friends = pdo_fetchall($sql, array(":uid" => $user['id']));


if (!empty($dbFirend)) {
	$helped = true;//已经帮好友看过了。。。。。
	include $this->template($mobileTemplate."firend_yk");

} else {
	include $this->template($mobileTemplate."friend_index");
}