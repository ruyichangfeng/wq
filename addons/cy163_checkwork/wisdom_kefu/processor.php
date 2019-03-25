<?php
/**
 * @author    QQ：1006822260
 */
defined('IN_IA') or exit('Access Denied');

class Wisdom_kefuModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W,$_GPC;
		$content = $this->message['content'];
		$wait = $this->module['config']['wait'];
		$openid = $_W['fans']['from_user'];
		$start1 = $this->module['config']['start1'];
		$start2 = $this->module['config']['start2'];
		$end1 = $this->module['config']['end1'];
		$end2 = $this->module['config']['end2'];
		$busy = $this->module['config']['busy'];
		$nhour = date('H', TIMESTAMP);
		$flag = 0;
		if($start1 == 0 && $end1 == 23) {
			$flag = 1;
		} elseif($start1 != '-1' && ($nhour >= $start1) && ($nhour <= $end1)) {
			$flag = 1;
		} elseif($start2 != '-1' &&  ($nhour >= $start2) && ($nhour <= $end2)) {
			$flag = 1;
		} else {
			$flag = 0;
		}
		if($flag == 1) { 
                       
                        $reply['content'] = $content;
			$this->sendtext("$wait",$openid);
                   
			return $this->service($reply['content']);
		} else {
			$content = $_W['account']['name'].'提醒您，客服在线时间为：' . $start1 .'时~' . $end1 . '时';
			if($start2 != '-1') {
				$content .= ',' . $start2 . '时~' . $end2 . '时';
			}
			$reply['content'] = $content;
			$this->sendtext("$busy",$openid);
			return $this->respText($reply['content']);
		}

	}
        private function service() {
		$response = array();
		$response['FromUserName'] = $this->message['to'];
		$response['ToUserName'] = $this->message['from'];
		$response['MsgType'] = 'transfer_customer_service';
		return $response;
	}
	private function sendtext($txt,$openid){
		global $_W;
		$acid=$_W['account']['acid'];
		if(!$acid){
			$acid=pdo_fetchcolumn("SELECT acid FROM ".tablename('account')." WHERE uniacid=:uniacid ",array(':uniacid'=>$_W['uniacid']));
		}
		$acc = WeAccount::create($acid);
		$data = $acc->sendCustomNotice(array('touser'=>$openid,'msgtype'=>'text','text'=>array('content'=>urlencode($txt))));
		return $data;
	}
}


