<?php

/*
提现日志表
*/
class DrawLogModel {


	static function info($draw_id) {
		global $_W;

		return pdo_fetch("select * from ".tablename('intelligent_kindergarten_draw_log')." where uniacid='{$_W['uniacid']}' and id='{$draw_id}'");
	}

	static function setHandle($draw_id) {
		global $_W;
		$data['status'] = 'handle';
		$data['update_time'] = date("Y-m-d H:i:s");

		$where['id'] = $draw_id;
		$where['uniacid'] = $_W['uniacid'];
		return pdo_update('intelligent_kindergarten_draw_log',$data,$where);
	}

	static function addItem($openid,$money,$commision) {
		global $_W;

		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['money'] = $money;
		$data['commision'] = $commision;
		$data['act_draw'] = $money-$commision;
		$data['status'] = 'wait';
		$data['add_time'] = date("Y-m-d H:i:s");

		return pdo_insert('intelligent_kindergarten_draw_log',$data);
	}
	/*
	获取最新的一条提现记录
	*/
	static function getLastDrawLog($openid) {
		global $_W;

		return pdo_fetch("select * from ".tablename('intelligent_kindergarten_draw_log')." where openid='$openid' and uniacid= '{$_W['uniacid']}' order by add_time desc");
	}

	static function getList($status,$begin,$offset) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_draw_log')." where status='$status' and uniacid='{$_W['uniacid']}' order by add_time desc limit $begin,$offset");
	}

	static function getListCount($status) {
		global $_W;

		$r = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_draw_log')." where status='$status' and uniacid='{$_W['uniacid']}'");

		if($r['num']) {
			return $r['num'];
		}
		return 0;
	}

	/*
	获取某用户的提现列表
	*/
	static function getListByOpenid($openid) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_draw_log')." where openid='$openid' and uniacid='{$_W['uniacid']}' order by add_time desc");
	}

}