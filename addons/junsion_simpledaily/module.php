<?php
/**
 * 简记模块定义
 *
 * @author boyhood
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('ROOT','../addons/junsion_simpledaily/');
define('RES',ROOT.'resource/');
define('OD_ROOT', IA_ROOT . '/addons/junsion_simpledaily/cert/');
class junsion_simpledailyModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$dat['leadurl'] = trim($_GPC['leadurl']);
			$dat['Agreement'] = htmlspecialchars_decode($_GPC['Agreement']);
			$dat['adv_content'] = htmlspecialchars_decode($_GPC['adv_content']);
			$dat['payrate'] = $_GPC['payrate'];
			$dat['reward_money'] = $_GPC['reward_money'];
			$dat['ip'] = $_GPC['ip'];
			$dat['appid'] = $_GPC['appid'];
			$dat['logo'] = $_GPC['logo'];
			$dat['appsecret'] = $_GPC['appsecret'];
			$dat['mchid'] = $_GPC['mchid'];
			$dat['apikey'] = $_GPC['apikey'];
			$dat['auth'] = $_GPC['auth'];
			$dat['credit'] = $_GPC['credit'];
			$dat['isqiniu'] = $_GPC['isqiniu'];
			$dat['isopenweb'] = $_GPC['isopenweb'];
			$dat['access_key'] = $_GPC['access_key'];
			$dat['secret_key'] = $_GPC['secret_key'];
			$dat['bucket'] = $_GPC['bucket'];
			$dat['qiniuUrl'] = $_GPC['qiniuUrl'];
			$dat['UI'] = $_GPC['UI'];
			$dat['share_title'] = $_GPC['share_title'];
			$dat['share_desc'] = $_GPC['share_desc'];
			$dat['share_thumb'] = $_GPC['share_thumb'];
			$dat['ms_title'] = $_GPC['ms_title'];
			$dat['ms_desc'] = $_GPC['ms_desc'];
			$dat['ms_thumb'] = $_GPC['ms_thumb'];
			$dat['qs_title'] = $_GPC['qs_title'];
			$dat['qs_desc'] = $_GPC['qs_desc'];
			$dat['qs_thumb'] = $_GPC['qs_thumb'];
			$dat['check'] = $_GPC['check'];
			$dat['openid'] = $_GPC['openid'];
			$dat['admin_check'] = $_GPC['admin_check'];
			$dat['admin_openid'] = $_GPC['admin_openid'];
			
			//微信支付商户功能参数设置
			load()->func('file');
			mkdirs(OD_ROOT);
			$r = true;
			if(!empty($_GPC['cert'])) {
				$ret = file_put_contents(OD_ROOT .md5("apiclient_{$_W['uniacid']}cert").".pem", trim($_GPC['cert']));
				$r = $r && $ret;
			}
			if(!empty($_GPC['key'])) {
				$ret = file_put_contents(OD_ROOT .md5("apiclient_{$_W['uniacid']}key").".pem", trim($_GPC['key']));
				$r = $r && $ret;
			}
			if(!empty($_GPC['ca'])) {
				$ret = file_put_contents(OD_ROOT .md5("root{$_W['uniacid']}ca").".pem", trim($_GPC['ca']));
				$r = $r && $ret;
			}
			if(!$r) {
				message('证书保存失败, 请保证 '.OD_ROOT.' 目录可写');
			}
			
			if ($this->saveSettings($dat)){
				message('保存成功',referer(),'sueccuss');
			}else{
				message('保存失败',referer(),'error');
			}
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}
