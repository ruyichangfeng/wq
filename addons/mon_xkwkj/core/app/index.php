<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
MonUtil::checkmobile();
$kid = $_GPC['kid'];
$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
MonUtil::emtpyMsg($xkwkj, "炫酷砍价活动不存在或已删除");
$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);
$join = false;
$userInfo =$this->getClientUserInfo();
$user = $this->findJoinUser($kid, $userInfo['openid']);

$starttime = date("Y/m/d  H:i:s", $xkwkj['starttime'] );
$endtime = date("Y/m/d  H:i:s", $xkwkj['endtime'] );
$curtime = date("Y/m/d  H:i:s", TIMESTAMP);
$leftCount = $this->getLeftCount($xkwkj);
$status = $this->getStatus($xkwkj, $user);
$statusText = $this->getStatusText($status);
$joinCount = $this->getJoinCount($xkwkj);


$join_rank_num = $xkwkj['join_rank_num'];
$ranklist = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " WHERE kid =:kid   ORDER BY price asc, createtime desc limit 0,  ".$join_rank_num , array(':kid'=>$kid));

$mobileTemplate = $this->getMobileTemplate($xkwkj['templateid']);




if (!empty($user)) {   //已参加
	$orderInfo = $this->findOrderInfo($kid, $user['id']);

	$allowSubmit = false;
	if ($user['price'] <= $xkwkj['submit_money_limit']) {
		$allowSubmit = true;
	}

	if (!$allowSubmit) {
		$leftPrice = $user['price'] - $xkwkj['submit_money_limit'];
		$allowSubmitText = "您离提交订单金额还差" .$leftPrice . ",继续努力哦!" ;
	}

	$sql = "select nickname as user_name, ac as action, kname as seq_name ,kd as seq_weapon, k_price as amount, createtime as time, headimgurl as avatar from"
			. tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " where uid=:uid order by createtime desc  limit 0,".$xkwkj['rank_num'];
	$friends = pdo_fetchall($sql, array(":uid" => $user['id']));


	include $this->template($mobileTemplate.'m_kj');

} else { //没有参加
	$kjPrice = $this->getKjPrice($xkwkj, $xkwkj['p_y_price']);
	$collectUserInfo = false;

	if ($this->xkkjSetting['is_collect_user_info'] == 1) { //要求手机用户注册信息
		if (empty($uc['uname']) || empty($uc['tel']) || empty($uc)) {
			$collectUserInfo = true;
		}
	}
	//$collectUserInfo = false;
	include $this->template($mobileTemplate.'m_index');
}