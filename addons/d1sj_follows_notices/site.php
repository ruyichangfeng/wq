<?php
/**
 * 微信用户关注发送消息管理员模块微站定义
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class D1sj_follows_noticesModuleSite extends WeModuleSite {

	public function doMobileIndex() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		$openid=$_W['openid'];
		
		include $this->template('index');
	}
	public function doWebMember() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}

}