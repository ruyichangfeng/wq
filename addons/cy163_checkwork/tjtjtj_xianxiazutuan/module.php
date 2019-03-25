<?php
/**
 * 线下组团模块定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tjtjtj_xianxiazutuanModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {

			$dat = array();

			$field = array(
				'shop_name','shop_logo','auto_cancel_order_days','auto_sign_days','service_tel',
				'notify_pay_success','notify_pay_success_header','notify_pay_success_footer',
				'notify_cancel_order','notify_cancel_order_header','notify_cancel_order_footer',
				'notify_group_success','notify_group_success_header','notify_group_success_footer',
				'notify_group_fail','notify_group_fail_header','notify_group_fail_footer',
				'notify_deliver','notify_deliver_header','notify_deliver_footer',
				'notify_refund','notify_refund_header','notify_refund_footer',
				'open_user_refund',
				'weixin_mchid',
				'weixin_secret',
				'weixin_apiclient_cert',
				'weixin_apiclient_key'
			);

			foreach ($_GPC as $key => $val) {
				if (in_array($key, $field)) {
					$dat[$key] = $val;
				}
			}

			$this->saveSettings($dat);
			message('编辑成功', 'refresh', 'success');
		}
		include $this->template('setting');
	}

}