<?php

/**
* 乐视直播业务层
*/

class LetvPlayBusiness {

	private $player;

	function __construct() {
		$this->player = new LivePlayComponent();
	}

	/*
	创建频道
	默认高清，流畅直播
	*/
	function createActivity($activityName,$coverImgUrl,$description) {

		$startTime = date("YmdHis");
		$endTime = date("YmdHis",strtotime('+2 years'));
		$codeRateTypes = 16;
		$playMode = 1;
		$r = $this->player->createActivity($activityName,$startTime,$endTime,$coverImgUrl,$description,$codeRateTypes,$playMode);

		return $r->activityId ? $r : false;
	}

}