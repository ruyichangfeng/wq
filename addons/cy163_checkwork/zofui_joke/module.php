<?php
/**
 * 模块定义
 *
 * @author 众惠科技
 * @url http://bbs.we7.cc/
 */
global $_W;
defined('IN_IA') or exit('Access Denied');
define('MODULE_ROOT',IA_ROOT.'/addons/zofui_joke/');
define('MODULE_URL',$_W['siteroot'].'/addons/zofui_joke/');
define('MODULE','zofui_joke');

require_once(MODULE_ROOT.'class/autoload.php');

class Zofui_jokeModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;


		if(checksubmit('submit')) {
			$_GPC = Util::trimWithArray($_GPC);
			
			

			$dat = array(
				'jointype' => intval( $_GPC['jointype'] ),
				'substr' => $_GPC['substr'],
				'sharetitle' => $_GPC['sharetitle'],
				'sharedesc' => $_GPC['sharedesc'],
				'shareimg' => $_GPC['shareimg'],
				'topimg' => $_GPC['topimg'],
            );
			


			if ($this->saveSettings($dat)) {
                message('保存成功', 'refresh');
            }
		}
		
		include $this->template('web/setting');
	}

}