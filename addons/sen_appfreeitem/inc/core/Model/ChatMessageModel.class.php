<?php

class ChatMessageModel  {


	// 未读消息检查(未用)
	static function remindChatMessage($send_openid,$self_openid)
	{
		global $_W;
		// 生成talkchat
		$talk_sign = ChatModel::talkSign($send_openid,$self_openid);

		$info = pdo_fetch("select * from ".tablename('intelligent_kindergarten_chatmessage')." where readed='n' and send_openid='$send_openid' and talk_sign='{$talk_sign}' and uniacid={$_W['uniacid']} order by id desc limit 1");

		if($info)
		{
			return array('res'=>'100','msg'=>$info['chat_message']);
		}
		else
		{
			return array('res'=>'101','msg'=>'');
		}
	}

	// 获取未读消息列表，用于加载完历史记录后，进行未读消息加载~然后触发实时加载
	static function getChatList($talk_sign,$chat_openid)
	{
		global $_W;
		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_chatmessage')." where talk_sign='{$talk_sign}' and send_openid='{$chat_openid}' and readed='n' and uniacid={$_W['uniacid']}");

		self::setReadStatus($list,$talk_sign,$chat_openid);

		return $list;
	}

	// 将列表中的内容置为已读
	static function setReadStatus($list,$talk_sign,$chat_openid)
	{
		global $_W;
		if($list)
		{
			//修改readed状态
			foreach($list as $k=>$v)
			{
				$arr[$v['id']] = $v['id'];
			}

			sort($arr);
			reset($arr);

			$start_id = current($arr);
			$end_id = end($arr);

			pdo_query("update ".tablename('intelligent_kindergarten_chatmessage')." set readed='y' where id>='{$start_id}' and id<='{$end_id}' and talk_sign='$talk_sign' and send_openid='$chat_openid' and uniacid={$_W['uniacid']}");
		}

	}

	// 获取聊天记录中的历史消息(默认加载30条)
	static function historyList($sign,$logid) {
		global $_W;
		$time = date("Y-m-d H:i:s");
		$logid_sql = '';
		if($logid) {
			$logid_sql = " and id < $logid ";
		}
		$list = pdo_fetchall("select * from (select * from ".tablename('intelligent_kindergarten_chatmessage')." where talk_sign = '{$sign}' and add_time <='{$time}' and uniacid={$_W['uniacid']} $logid_sql order by add_time desc limit 30) as t order by t.add_time asc");
		return $list;
	}


	/*获取是否有未读的打招呼消息*/
	static function remindMessage($openid)
	{
		global $_W;
		$talk_unread = pdo_fetch("select count(*) as num from ".tablename("intelligent_kindergarten_chatmessage")." where talk_sign like '%{$openid}%' and readed='n' and send_openid <> '{$openid}' and uniacid={$_W['uniacid']}");
		return $talk_unread['num'];
	}
}