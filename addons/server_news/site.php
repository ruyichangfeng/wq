<?php
/**
 * test模块微站定义
 *
 * @author WDD
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Server_newsModuleSite extends WeModuleSite {
	
	public function doWebRule1() {
		//这个操作被定义用来呈现 规则列表
	}
	public function doWebNav1() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	
	public function doMobileWebsite1() {
		//这个操作被定义用来呈现 微站首页导航图标
	}
	public function doMobileUser1() {
		//这个操作被定义用来呈现 微站个人中心导航
	}
	public function doMobileShortout1() {
		//这个操作被定义用来呈现 微站快捷功能导航
	}

}