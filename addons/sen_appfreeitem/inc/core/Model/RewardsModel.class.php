<?php
/*
用户的打赏记录表
*/

class RewardsModel {

	static function info($id) {
		global $_W;

		return pdo_fetch("select * from ".tablename('intelligent_kindergarten_rewards')." where id='$id' and uniacid='{$_W['uniacid']}'");
	}

	/*
	将预打赏日志写入表
	*/
	static function addItem($openid,$to_openid,$money,$room_id,$money_type) {
		global $_W;
		$data['uniacid'] = $_W['uniacid'];
		$data['room_id'] = $room_id;
		$data['openid'] = $openid;
		$data['to_openid'] = $to_openid;
		$data['money'] = $money;
		$data['money_type'] = $money_type;
		$data['status'] = 'n';
		$data['add_time'] = date("Y-m-d H:i:s");
		$r = pdo_insert('intelligent_kindergarten_rewards',$data);
		if($r) {
			return pdo_insertid();
		}else {
			return false;
		}
	}
	/*
	修改打赏记录的状态为打赏成功
	*/
	static function setSuccess($id) {
		global $_W;


		$data = array();
		$data['status'] = 'y';

		$where = array();
		$where['id'] = $id;
		$where['uniacid'] = $_W['uniacid'];

		return pdo_update('intelligent_kindergarten_rewards',$data,$where);
	}

	/*
	获取某个用户所有的打赏记录
	*/

	static function getList($openid) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_rewards')." where uniacid='{$_W['uniacid']}' and to_openid='$openid' order by add_time desc");
	}

	static function getToOtherList($openid) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_rewards')." where uniacid='{$_W['uniacid']}' and openid='$openid' order by add_time desc");
	}

	/*
	获取最新一条记录
	*/
	static function getLastOne($room_id,$openid) {
		global $_W;

		return pdo_fetch("select * from ".tablename('intelligent_kindergarten_rewards')." where uniacid='{$_W['uniacid']}' and openid='$openid' and room_id='$room_id' and status='y' and money_type='room_money' order by add_time desc limit 1");
	}

}