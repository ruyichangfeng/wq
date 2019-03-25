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
		$userInfo = $this->getClientUserInfo();
		$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
        $user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $uid);
		$zfprice = $xkwkj['yf_price'] + $user['price'];
		$p_models=explode('|',$xkwkj['p_model']);


		$leftCount = $this->getLeftCount($xkwkj);

		include $this->template("address");
