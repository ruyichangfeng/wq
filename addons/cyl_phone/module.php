<?php
/**
 * 便民电话模块定义
 *
 * @author 杨子
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cyl_phoneModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			$data = $_GPC['data'];
			//字段验证, 并获得正确的数据$dat
			if (!$this->saveSettings($data)) {
				message('保存信息失败','','error');   // 保存失败
			} else {
				message('保存信息成功','','success'); // 保存成功
			}
		}
		//这里来展示设置项表单
		load()->func('tpl');
		include $this->template('setting');
	}
	

}