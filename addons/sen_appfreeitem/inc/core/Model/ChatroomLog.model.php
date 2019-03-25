<?php

class ChatroomLogTableHandle 
{
	/*
	聊天记录删除
	*/
	static function del($id,$room_id)
	{
		global $_W;

		return pdo_update("intelligent_kindergarten_chatroom_log",array('is_del'=>'y'),array('uniacid'=>$_W['uniacid'],'id'=>$id,'rid'=>$room_id));
	}

	/*
	获取某个聊天室的未读消息数量！！
	*/
	static function unReadNums($room_id,$openid) {

		global $_W;

		return pdo_fetch("select count(*) as num from (select id,openid from ".tablename('intelligent_kindergarten_chatroom_log')." where rid=:rid and openid=:openid and uniacid={$_W['uniacid']} order by id desc limit 1) as n,".tablename('intelligent_kindergarten_chatroom_log')." as t where t.id>n.id and t.rid=:rid",array(':rid'=>$room_id,':openid'=>$openid));

	}

	/*
	获取聊天室的历史记录
	*/
	static function history($room_id,$prev_logid = '',$num = 30) {
		global $_W;

		if($prev_logid) {
			$sql = " and id < $prev_logid ";
		}

		return pdo_fetchall("select * from (select * from ".tablename('intelligent_kindergarten_chatroom_log')." where rid=:rid and uniacid={$_W['uniacid']} $sql order by add_time desc limit $num) as n order by add_time asc",array(':rid'=>$room_id));
	}

	/*
	获取聊天室的新记录
	*/
	static function getUnreadList($room_id,$openid,$logid) {
		global $_W;
		return pdo_fetchall("select * from (select * from ".tablename('intelligent_kindergarten_chatroom_log')." where id>:id and rid=:rid and openid <> :openid and uniacid={$_W['uniacid']}) as n order by add_time asc",array(':id'=>$logid,':rid'=>$room_id,':openid'=>$openid));
	}
}