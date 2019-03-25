<?php
/*
系统级别踢出管理
*/

class ForbidComponent  {

	function __construct() {

	}
	/*
	从系统移除
	*/
	static function remove($openid) {
		$data['forbid_status'] = 'y';
		$data['forbid_add_time'] = date("Y-m-d H:i:s");
		$data['forbid_end_time'] = '3000-12-12';

		$where['openid'] = $openid;
		return MemberModel::update($data,$where);
	}
	/*
	恢复允许状态
	*/
	static function restore($openid) {
		$data['forbid_status'] = 'n';
		$data['forbid_add_time'] = date("Y-m-d H:i:s");

		$where['openid'] = $openid;
		return MemberModel::update($data,$where);
	}
	/*
	用户是否允许进入
	*/
	static function isAllow($openid) {

		$info = MemberModel::info($openid);
		if($info['forbid_status'] != 'y') {
			return true;
		}
		return false;
	}
}