<?php
/**
 * 万能查询系统模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class tjtjtj_wannengchaxunModuleSite extends WeModuleSite {

	//后台程序 inc/web文件夹下
	public function __web($f_name){
		include_once  'inc/web/'.strtolower(substr($f_name,5)).'.inc.php';
	}
	//前台程序 inc/app文件夹下
	public function __app($f_name){
		include_once  'inc/app/'.strtolower(substr($f_name,8)).'.inc.php';
	}

	public function doMobileHome() {
		//这个操作被定义用来呈现 功能封面
		$this->__app(__FUNCTION__);
	}
	public function doWebSet() {
		//这个操作被定义用来呈现 管理中心导航菜单
		$this->__web(__FUNCTION__);
	}
	public function doWebModule() {
		//这个操作被定义用来呈现 管理中心导航菜单
		$this->__web(__FUNCTION__);
	}
	public function doWebData() {
		//这个操作被定义用来呈现 管理中心导航菜单
		$this->__web(__FUNCTION__);
	}

}