<?php

class DrawLogComponent {
	/*
	获取是否可以提现
	*/
	static function  isCanDraw($openid) {

		$r = self::getColdTime($openid);
		if($r === false) {
			return true;
		}else {
			return false;
		}
	}
	/*
	获取提现冷却时间
	*/
	static function getColdTime($openid) {

		$info = DrawLogModel::getLastDrawLog($openid);

		$add_date = strtotime($info['add_time']);
		$now_date = time();

		$cold_time = 7*24*3600 - ($now_date - $add_date) ;

		if($cold_time > 0) {
			return S::timeDiffNew($cold_time);
		}else {
			return false;
		}
	}
}