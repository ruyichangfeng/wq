<?php
/**
 * 便利店模块订阅器
 *
 * @author Gorden
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class gd_zlyqkModuleReceiver extends WeModuleReceiver {
	public function receive() {
		global $_W;
		$type = $this->message['type'];
        $c = '';
        foreach ($this->message as $key => $value) {
            $c .= "$key : $value \r\n";
        }
        file_put_contents('/a/receive.txt', $c);
	}
}
