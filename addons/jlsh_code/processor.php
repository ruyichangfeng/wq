<?php
/**
 * 积分二维码模块处理程序
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Jlsh_codeModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		$rid = $this->rule;
		
		$uniacid = $_W['uniacid'];
		
		
		$openid = $this->message['from'];
		
		load()->model('mc');
		$uid = mc_openid2uid($openid);
		
		$jifen_list = pdo_fetch($jifen_sql);
			
			if(empty($user)){
				return $this->respText("积分添加异常,请告知店员重新生成二维码");
			}else{
					
				mc_credit_update($uid,'credit1',$jifen_list['number'],array($uid,"二维码积分".$jifen_list['number']));
					
					'title' => $jifen_list['title'],
					'number' => $jifen_list['number'],
					'openid' => $user['nickname'],
					'addtime' => TIMESTAMP,
				);
	}
}