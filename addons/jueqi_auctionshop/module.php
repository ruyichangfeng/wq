<?php
/**
 * 竞价商城
 * @author 崛企科技
 */
defined('IN_IA') or exit('Access Denied');
class Jueqi_auctionshopModule extends WeModule {
	
	public function fieldsFormDisplay($rid = 0) {
	   global $_W;
	}
	
	public function fieldsFormValidate($rid = 0) {
		return '';
	}
	
	public function fieldsFormSubmit($rid) {
         global $_W,$_GPC;
	}
	
	public function ruleDeleted($rid) {
		  global $_W;
	}
	
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {
			$this->saveSettings($dat);
		}
		include $this->template('setting');
	}
}