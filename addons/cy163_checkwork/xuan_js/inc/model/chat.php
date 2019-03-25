<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}  
class Xuan_js_chat {
	public function noread_to_sb($sign,$uid){
		$read = pdo_fetchall("select sum(readed) as readed,count(readed) as allread from ".tablename('xuan_js_chat')." where to_user_id=:uid and circle_id=:circle_id group by circle_id ",array(':circle_id'=>$sign,':uid'=>$uid));

		return $read[0]['allread']-$read[0]['readed'];
	}
	public function allnoread($uid){
		$read = pdo_fetchall("select sum(readed) as readed,count(readed) as allread from ".tablename('xuan_js_chat')." where to_user_id=:uid  group by to_user_id ",array(':uid'=>$uid));
		 
		return $read[0]['allread']-$read[0]['readed'];
	}
	public function historyList($sign,$logid) {
		global $_W;
		$time = time();
		$logid_sql = '';
		if($logid) {
			$logid_sql = " and id < $logid ";
		}
		$list = pdo_fetchall("select * from ".tablename('xuan_js_chat')." where circle_id=:circle_id ".$logid_sql." order by id desc limit 20 ",array(':circle_id'=>$sign));
		$this->setReadStatus($list,$talk_sign,$chat_openid);
		
		return $list;
	}
	// 获取未读消息列表，用于加载完历史记录后，进行未读消息加载~然后触发实时加载
	public function getChatList($talk_sign,$chat_openid)
	{
		global $_W;
		$list = pdo_fetchall("select * from ".tablename('xuan_js_chat')." where circle_id='{$talk_sign}' and from_user_id='{$chat_openid}' and readed=0 ");

		$this->setReadStatus($list,$talk_sign,$chat_openid);

		return $list;
	}

	// 将列表中的内容置为已读
	public function setReadStatus($list,$talk_sign,$chat_openid)
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

			pdo_query("update ".tablename('xuan_js_chat')." set readed=1 where id>='{$start_id}' and id<='{$end_id}' and circle_id='$talk_sign' and from_user_id='$chat_openid'");
		}

	}


}