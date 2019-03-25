<?php
/**
 * 微信用户关注发送消息管理员模块定义
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class D1sj_follows_noticesModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$dat = array(
				'openid'=>trim($_GPC['openid']),
				'username'=>$_GPC['username'],
				'template_id'=>$_GPC['template_id'],
				
				);
			if($this->saveSettings($dat)){
				message('保存成功','refresh');
			}
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}