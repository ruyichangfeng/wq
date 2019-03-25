<?php
/*
defriend table handle
拉黑
*/
class DefriendModel {

	// defriend handle
	static function defriend($openid,$defriend_openid) {
		global $_W;

		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['defriend_openid'] = $defriend_openid;
		$data['add_time'] = date('Y-m-d H:i:s');
		$data['status'] = 'y';

		return pdo_insert('intelligent_kindergarten_defriend',$data,true);
	}
	// relieve handle
	static function relieve($openid,$defriend_openid) {
		global $_W;

		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['defriend_openid'] = $defriend_openid;
		$data['add_time'] = date('Y-m-d H:i:s');
		$data['status'] = 'n';

		return pdo_insert('intelligent_kindergarten_defriend',$data,true);
	}
	// status
	static function info($openid,$defriend_openid) {
		global $_W;

		$r = pdo_fetch("select * from ".tablename('intelligent_kindergarten_defriend')." where uniacid={$_W['uniacid']} and openid='$openid' and defriend_openid='$defriend_openid'");
		return $r;
	}
	// 判断是否拉黑  true 拉黑  false 未拉黑
	static function status($openid,$defriend_openid) {
		$info = self::info($openid,$defriend_openid);

		if(isset($info['status'])) {
			if($info['status'] == 'y') {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	//获取黑名单列表
	static function lists($openid) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_defriend')." where uniacid={$_W['uniacid']} and openid='$openid' and status='y'");
	}
}