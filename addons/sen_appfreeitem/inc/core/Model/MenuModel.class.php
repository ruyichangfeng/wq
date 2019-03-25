<?php
/*
自定义菜单表
*/
class MenuModel {


	static function addItem($data) {

		return pdo_insert('intelligent_kindergarten_menu',$data);
	}

	static function getListByType($type) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_menu')." where uniacid='{$_W['uniacid']}' and type='$type' and is_del='n' order by order_id desc");
	}

	static function updateItem($data,$where) {
		global $_W;

		return pdo_update('intelligent_kindergarten_menu',$data,$where);
	}
}