<?php

class ChatroomDefriendModel
{
	/*
	加入房间黑名单
	*/
	static function defriend($room_id,$openid,$creator)
	{
		global $_W;

		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['room_id'] = $room_id;
		$data['openid'] = $openid;
		$data['creator'] = $creator;
		$data['add_time'] = date("Y-m-d H:i:s");
		$data['status'] = 'y';

		return pdo_insert('intelligent_kindergarten_chatroom_defriend',$data,true);
	}
	/*
	从房间黑名单中移除
	*/
	static function relieve($room_id,$openid,$creator)
	{
		global $_W;

		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['room_id'] = $room_id;
		$data['openid'] = $openid;
		$data['creator'] = $creator;
		$data['add_time'] = date("Y-m-d H:i:s");
		$data['status'] = 'n';

		return pdo_insert('intelligent_kindergarten_chatroom_defriend',$data,true);
	}

	/*
	判断是否在黑名单中
	*/
	static function isDefriend($openid,$room_id)
	{
		global $_W;

		static $infos = array();
		if(!isset($infos[$openid][$room_id]))
		{
			$info = pdo_fetch("select * from ".tablename('intelligent_kindergarten_chatroom_defriend')." where uniacid={$_W['uniacid']} and room_id=$room_id and openid='$openid'");

			if($info['status'] == 'y')
			{
				$infos[$openid][$room_id] = true;
			}
			else
			{
				$infos[$openid][$room_id] = false;	
			}
		}

		return $infos[$openid][$room_id];
	}

}