<?php

/*
设置表
*/
class SettingsTableHandle {

	static function all() {
		global $_W;
		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_setting')." where uniacid={$_W['uniacid']}");
		if($list === false)
		{
			return false;
		}
		foreach ($list as $key => $value) {
			# code...
			$settings[$value['name']] = $value['value'];
		}
		return $settings;
	}
}