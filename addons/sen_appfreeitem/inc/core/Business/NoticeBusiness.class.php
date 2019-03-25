<?php

class NoticeBusiness {

	private $obj;

	function __construct() {
		
	}

	/*
	通知管理员有提现申请
	*/
	static function sendApplyDrawNotice($openid,$money,$commision,$url) {
		global $_W;
		$user = MemberModel::info($openid);
		$notice = new NoticeComponent();
		$first = "用户\"".$user['nickname']."\"发起了提现申请";
		$remark = "请及时到后台进行审核";

		$list = AdminModel::getList();
		foreach($list as $item) {
			$notice -> sendWaitDrawTpl($item['openid'],$first,$money,$commision,$money-$commision,'社区提现',$remark,$url);
		}
	}

	/*
	通知管理员有新的消息反馈
	*/
	static function sendFeedbackNotice($openid,$content,$url) {
		global $_W;
		$user = MemberModel::info($openid);
		$notice = new NoticeComponent();
		$first = "收到了新的意见反馈";
		$name = $user['nickname'];
		$content = $content;

		$list = AdminModel::getList();
		foreach($list as $item) {
			$notice -> sendNewNoticeTpl($item['openid'],$name,$content,$url,$first);
		}
	}
}