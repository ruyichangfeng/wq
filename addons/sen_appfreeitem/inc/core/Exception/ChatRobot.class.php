<?php
/* 
聊天机器人
*/

class ChatRobot  {
	public $url;
	public $room_id;
	public $key =true;

	function __construct($settings) {
		// 如果未开启开关，关闭机器人
		if($settings['robot_key'] != 'open')  {
			$this->key = false;
		}
		$this->url = $settings['robot_url'];
		if(!$this->url) {
			$this->url = "http://www.niurenqushi.com/app/simsimi/ajax.aspx?txt=";
		}
		// 频率计算
		$rate = $settings['robot_rate'];
		// 如果当前标志位在   设置的rate之前触发！
		if(rand(1,100) > $rate) {
			$this->key = false;
		}
	}
	// 请求
	function get($msg) {
		if(!$this->key) {
			return false;
		}
		$response = file_get_contents($this->url.$msg);
		if(Filter::init($response)) {
			return false;
		}
		return $response;
	}

	// 聊天室请求
	function think($msg,$room_id) {
		// 判断聊天室是否开启机器人
		$room_info = ChatroomTableHandle::info($room_id);
		if($room_info['is_robot'] != 'y') {
			return false;
		}
		$response = $this->get($msg);
		if($response) {
			$this->say($response,$room_id);	
		}
	}

	function say($response,$room_id) {
		$info = MemberTableHandle::info('i_robot');
		global $_W;
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['rid'] = $room_id;
		$data['openid'] = $info['openid'];
		$data['content'] = $response;
		$data['type'] = 'text';
		$data['add_time'] = date('Y-m-d H:i:s');

		$res = pdo_insert('intelligent_kindergarten_chatroom_log',$data);
	}

	// 私聊
	function chat($chat_message,$self_openid) {
		global $_W;
		$response = $this->get($chat_message);

		if($response) {
			// 构造数据数组
			$msg = array();
			$msg['uniacid'] = $_W['uniacid'];
			$msg['talk_sign'] = ChatTableHandle::talkSign($self_openid,'i_robot');
			$msg['send_openid'] = 'i_robot';
			$msg['chat_message'] = $response;
			$msg['type'] = 'text';
			$msg['add_time'] = date('Y-m-d H:i:s');
			
			$res = pdo_insert('intelligent_kindergarten_chatmessage',$msg);
		}

	}

}
