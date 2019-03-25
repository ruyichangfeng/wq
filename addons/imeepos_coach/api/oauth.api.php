<?php

class oauthApi{
	public function getInfo(){
		global $_W,$_GPC;

		$userinfo = M('member')->getInfo($_W['openid']);
		$group = M('group')->getInfo($userinfo['group_id']);

		$data = array();
		$data['userinfo'] = $userinfo;
		$data['group'] = $group;
		return $data;
	}
}