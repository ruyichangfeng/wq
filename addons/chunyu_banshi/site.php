<?php
/**
 * 网上办事大厅模块微站定义
 *
 * @author chunyu1988
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Chunyu_banshiModuleSite extends WeModuleSite {

	protected function get_base(){
		global $_W,$_GPC;
						
		$res=pdo_fetch("SELECT * FROM ".tablename('chunyu_banshi_base')." WHERE uniacid=:uniacid",array(':uniacid'=>$_W['uniacid']));   		
		return $res;
	}

	protected function get_share(){
		global $_W,$_GPC;
						
		$res=pdo_fetch("SELECT * FROM ".tablename('chunyu_banshi_share')." WHERE uniacid=:uniacid",array(':uniacid'=>$_W['uniacid']));   		
		return $res;
	}

 	protected function get_mid(){
	    	global $_W,$_GPC;
			//所有页面都要引用这个方法，判断用户是否关注
			mc_oauth_userinfo();
			$mid=0;
			
			$member=$_W['fans'];
			$user=pdo_fetch("SELECT * FROM ".tablename('chunyu_banshi_member')." WHERE uniacid=:uniacid AND openid=:openid",array(':uniacid'=>$_W['uniacid'],':openid'=>$member['openid']));
		if($member){
			if(empty($user)){
		
				$data = array(
					'uniacid'=>$_W['uniacid'],
					'openid'=>$member['openid'],
					'nickname'=>$member['tag']['nickname'],
					'tel'=>'',
					'address'=>'',
					'avatar'=>$member['avatar'],
					'country'=>$member['tag']['country'],
					'province'=>$member['tag']['province'],
					'city'=>$member['tag']['city'],
					'createtime'=>time(),
				);
				$result = pdo_insert('chunyu_banshi_member', $data);
		
				if($result){
					$userinfo=pdo_fetch("SELECT * FROM ".tablename('chunyu_banshi_member')." WHERE uniacid=:uniacid AND openid=:openid",array(':uniacid'=>$_W['uniacid'],':openid'=>$member['openid']));
			
					if(!empty($userinfo)){
						$mid=$userinfo['mid'];			
					}	
				}

			}else{
		
				$mid=$user['mid'];
			}

			return $mid;
		}
	}

	// public function doMobileRukou() {
	// 	//这个操作被定义用来呈现 功能封面
	// }
	// public function doWebGuanli() {
	// 	//这个操作被定义用来呈现 管理中心导航菜单
	// }
	// public function doMobileShouye() {
	// 	//这个操作被定义用来呈现 微站首页导航图标
	// }
	// public function doMobileGeren() {
	// 	//这个操作被定义用来呈现 微站个人中心导航
	// }
	// public function doMobileKuaijie() {
	// 	//这个操作被定义用来呈现 微站快捷功能导航
	// }
	// public function doWebDuli() {
	// 	//这个操作被定义用来呈现 微站独立功能
	// }

}