<?php

/*
设置表
*/
class SettingsModel {

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

	static function addItem($name,$value) {
		global $_W;

		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['name'] = $name;
		$data['value'] = $value;
		$data['add_time'] = date("Y-m-d H:i:s");

		return pdo_insert("intelligent_kindergarten_setting",$data,true);
	}
}