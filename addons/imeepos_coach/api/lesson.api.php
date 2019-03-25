<?php

class lessonApi{
	public function getIndex(){
		global $_W;
		// ini_set("display_errors", "On");
		// error_reporting(E_ALL | E_STRICT);
		$day = date("w");
		$week = M('manage_week')->getDay($day);
		$nextday = date("w",strtotime("+1 day"));
		$nextweek = M('manage_week')->getDay($nextday);

		$list = M('manage')->getList(1," AND ishot = :ishot",array(':ishot'=>1));
		foreach ($list['list'] as &$li) {
			$li['teacher'] = M('teacher')->getInfo($li['teacher_id']);
			$li['content'] = htmlspecialchars_decode($li['content']);
		}
		$info = array();
		$info['week'] = $week;
		$info['next'] = $nextweek;
		$info['list'] = $list['list'];
		return $info;
	}

	public function getList($page){
		$list = M('manage')->getList($page);
		foreach ($list['list'] as &$li) {
			$li['teacher'] = M('teacher')->getInfo($li['teacher_id']);
			$li['content'] = htmlspecialchars_decode($li['content']);
		}
		return $list['list'];
	}
}