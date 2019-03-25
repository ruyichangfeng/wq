<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');


$openid = $_GPC['openid'];

$user = $this->findUniUserInfo($openid, $this->weid);


$addresses = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER_ADDRESS) . " WHERE openid =:openid and weid=:weid order by createtime desc",
	array(':openid'=> $user['openid'], ":weid"=> $this->weid));




include $this->template("user_detail");
