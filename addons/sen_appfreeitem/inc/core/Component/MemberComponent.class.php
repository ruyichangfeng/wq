<?php

class MemberComponent {
	/*
	用于对数组列表的拼接，直接拼接uinfo节点为用户信息
	*/
	static function listJoin($list,$openid_name = 'openid') {
		global $_W;
		foreach($list as &$item) {
			$item['uinfo'] = MemberModel::info($item[$openid_name]);
		}
		
		return $list;
	}
	/*
	更新验证码
	*/
	static function updateCaptcha($openid,$mobile,$captcha) {
		global $_W,$_GPC;

		if(!$captcha || !$openid) {
			return false;
		}
		
		$userinfo = array();
		$userinfo['mobile'] = $mobile;
		$userinfo['mobile_captcha'] = $captcha;
		$userinfo['mobile_captcha_send_time'] = date("Y-m-d H:i:s");

		return MemberModel::updateUserInfo($openid,$userinfo);
	}

	/*
	更新验证状态
	*/
	static function captchaOk($openid) {
		global $_W;

		$userinfo = array();
		$userinfo['mobile_status'] = 'y';

		return MemberModel::updateUserInfo($openid,$userinfo);
	}

	/*
	判断手机号码是否已经认证
	*/
	static function isVerifyMobile($openid) {
		global $_W;

		$info = MemberModel::info($openid);
		if(!$info) {
			return false;
		}
		if($info['mobile_status'] == 'n') {
			return false;
		}
		return true;
	}

	/*
	检查用户的资料是否完整
	*/
	static function isVerifyOk($openid) {
		global $_W;

		$info = MemberModel::info($openid);
		// $v['uniacid'] = $info['uniacid'];
		// $v['openid'] = $info['openid'];
		$v['nickname'] = $info['nickname'];
		$v['sex'] = $info['sex'];
		$v['age'] = $info['age'];
		$v['work'] = $info['work'];
		$v['self_intro'] = $info['self_intro'];
		$v['province'] = $info['province'];
		$v['city'] = $info['city'];
		$v['country'] = $info['country'];
		$v['wx_number'] = $info['wx_number'];
		// $v['headimgurl'] = $info['headimgurl'];
		// $v['update_time'] = $info['update_time'];
		// $v['lng'] = $info['lng'];
		// $v['lat'] = $info['lat'];
		// $v['isvisible'] = $info['isvisible'];
		$v['user_qrcode'] = $info['user_qrcode'];
		// $v['add_time'] = $info['add_time'];

		foreach($v as $k=>$item) {
			if(!$item) {
				return false;
			}
		}
		return true;
	}
	/*
	冻结资金划入可提现资金池
	*/
	static function unFrozenMoney($openid,$money) {
		global $_W;

		$user = MemberModel::info($openid);

		$frozen_money = $user['frozen_money'] - $money;
		$avaliable_money = $user['avaliable_money'] + $money;

		$userinfo = array();
		$userinfo['frozen_money'] = $frozen_money >= 0 ? $frozen_money : 0;
		$userinfo['avaliable_money'] = $avaliable_money >=0 ? $avaliable_money : 0;

		return MemberModel::updateUserInfo($openid,$userinfo);
	}
	
	/*
	申请提现的操作
	*/
	static function applyDrawMoney($openid,$money) {

		global $_W;
		pdo_begin();

		

		$user = MemberModel::info($openid);

		$avaliable_money = $user['avaliable_money'] - $money;
		$draw_money = $user['draw_money'] + $money;

		$userinfo = array();
		$userinfo['avaliable_money'] = $avaliable_money >= 0 ? $avaliable_money : 0;
		$userinfo['draw_money'] = $draw_money >=0 ? $draw_money : 0;

		return MemberModel::updateUserInfo($openid,$userinfo);
	}

	/*
	
	*/
}