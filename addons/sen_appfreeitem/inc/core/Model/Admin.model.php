<?php
/*
管理员表
*/
class AdminTableHandle
{

	/*
	返回所有列表
	*/
	static function getList()
	{
		global $_W;

		static $list = array();
		if(!$list)
		{
			$list =  pdo_fetchall("select * from ".tablename('intelligent_kindergarten_admin')." where uniacid={$_W['uniacid']} and is_del='n'");
		}
		return $list;
	}
	/*
	判断是否是管理员身份
	*/
	static function isAdmin($openid)
	{
		$info = self::info($openid);
		if($info)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	/*
	返回某个管理员的信息
	*/
	static function info($openid)
	{
		global $_W;
		static $infos = array();

		if(!isset($infos[$openid]))
		{
			$infos[$openid] = pdo_fetch("select * from ".tablename('intelligent_kindergarten_admin')." where uniacid={$_W['uniacid']} and is_del='n' and openid='$openid'");
		}
		return $infos[$openid];
	}
}