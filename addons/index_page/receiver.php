<?php

defined('IN_IA') or exit('Access Denied');

class Index_pageModuleReceiver extends WeModuleReceiver {

	public function receive() {
		global $_W,$_GPC;
		$fromuser = $this->message['from'];

		if ($this->message['msgtype'] == 'event') {
			if ($this->message['event'] == 'subscribe' && !empty($this->message['scene'])) {

				$member = pdo_fetch("SELECT * FROM ".tablename('index_page_member')." WHERE uniacid=:uniacid AND openid=:openid",array(':uniacid'=>$_W['uniacid'],':openid'=>$fromuser));
				$inviter = pdo_fetch("SELECT * FROM ".tablename('index_page_member')." WHERE uniacid=:uniacid AND qrcodeid=:qrcodeid",array(':uniacid'=>$_W['uniacid'],':qrcodeid'=>$this->message['scene']));
				if (empty($member) && !empty($inviter)) {
					load()->model('mc');
					$insert = array(
						'uniacid' => $_W['uniacid'],
						'uid' => mc_openid2uid($fromuser),
						'openid' => $fromuser,
						'inviter' => $inviter['id'],
						'createtime'=>time(),
						'childtime' => time()
						);
					pdo_insert('index_page_member', $insert);
				}
			}
		}
		return '';
	}
}