<?php
/**
 * 活动报名加强版模块微站定义
 *
 * @author laite
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Activities_signUpModuleSite extends WeModuleSite {

	/*public function doMobileIndex1() {
		//定义在inc下mobile文件夹下面
		
	}*/
	public function doWebRule1() {
		//这个操作被定义用来呈现 规则列表
	}
	public function doWebManage() {
		global $_W,$_GPC;
		load()->func('tpl'); 
	
		if( checksubmit('submit') ){
			//var_dump($_GPC);exit;
			$data['uniacid'] = $_W['uniacid'];
			$data['title'] = $_GPC['title'];
			$data['start_time'] = $_GPC['activityTime']['start'];
			$data['end_time'] = $_GPC['activityTime']['end'];
			$data['detail'] = $_GPC['detail'];
			$data['thumb'] = $_GPC['thumb'];
			$data['place'] = $_GPC['place'];
		
			$res = pdo_insert('activities_recording',$data); 
			if($res){
				//成功
				message('编辑活动成功',$this->createWebUrl('manage'),'success'); //自动跳转页面
			}else{
				//失败
				message('编辑活动失败','','error');
			}
			
		}

		$activity = pdo_fetch("SELECT * FROM ".tablename('activities_recording')." WHERE `uniacid`=:uniacid ORDER BY `id` DESC ",array(':uniacid'=>$_W['uniacid']) ); // 参数最好加上1左边那个符号 微擎推荐那个 :uniacid
		include $this->template('manage');
	}
	 
	public function doMobileWebsite1() {
		//这个操作被定义用来呈现 微站首页导航图标
	}
	public function doMobileUser1() {
		//这个操作被定义用来呈现 微站个人中心导航
	}
	public function doMobileShortcut1() {
		//这个操作被定义用来呈现 微站快捷功能导航
	}
}