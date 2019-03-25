<?php
/**
 * 图像上传(赢+微擎演示模块)模块微站定义
 *
 * @author 赢+
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Weyj_txscModuleSite extends WeModuleSite {

	public function doMobileYjshangchuantuxiang() {
		//这个操作被定义用来呈现 功能封面
		global $_W, $_GPC;
		checkauth();
		load()->model('mc');
		$uid = mc_openid2uid($_W['member']['uid']);
		$yj_mc=  mc_fetch($uid);
		//var_dump($yj_mc);
		//exit;
		load()->func('tpl');
		include $this->template('shangchuantuxiang');
	}
	public function doMobileYjbaocuntouxiang(){
		global $_W, $_GPC;
		if($_GPC['data']['avatar']){
			$fm['avatar'] = $_GPC['data']['avatar'];
			load()->model('mc');
			$uid = mc_openid2uid($_W['member']['uid']);
			$res=  mc_update($uid,$fm);
			if($res){
				message('保存成功!','','success');
			}else{
				message('保存失败!','','error');
			}
		}else{
			message('您没有上传图像!','','error');
		}
		load()->func('tpl');
	}
	public function doMobileYjchakantuxiang() {
		//这个操作被定义用来呈现 功能封面
	}
	public function doWebYjshangchuanliebiao() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	public function doWebYjapi() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include $this->template('api');
	}

}