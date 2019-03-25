<?php

class CreditModel  {
	/*
	用户的签到记录
	*/
	static function signLog($openid) {

		global $_W;
		
		$log = pdo_fetch("select * from ".tablename('intelligent_kindergarten_credit')." where openid=:openid and uniacid={$_W['uniacid']} order by add_date desc limit 1",array(':openid'=>$openid));

		// 获取所有记录
		if($log['sid']>1)
		{
			$list = pdo_fetchall("select * from (select * from ".tablename('intelligent_kindergarten_credit')." where openid=:openid and uniacid={$_W['uniacid']} order by add_date desc limit ".$log['sid']." ) as n order by n.add_date asc",array(':openid'=>$openid));
			return $list;
		}

		if($log)
		{
			return array($log);
		}
		return array();
	}

	/*
	判断用户某天是否签到
	*/
	static function isSign($openid,$date) {
		global $_W;

		$log = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_credit')." where openid=:openid and add_date=:add_date and uniacid={$_W['uniacid']}",array(':openid'=>$openid,':add_date'=>$date));

		return $log['num'];
	}

	/*
	获取用户最新的签到记录
	*/
	static function  lastSignLog($openid) {
		global $_W;
		return  pdo_fetch("select * from ".tablename('intelligent_kindergarten_credit')." where openid=:openid and uniacid={$_W['uniacid']} order by add_date desc limit 1",array(':openid'=>$openid));
	}

	/*
	获取用户的所有签到历史记录
	*/
	static function history($openid) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_credit')." where openid=:openid and uniacid={$_W['uniacid']} order by id desc",array(':openid'=>$openid));
	}
}