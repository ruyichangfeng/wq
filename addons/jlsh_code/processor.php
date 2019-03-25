<?php
/**
 * 积分二维码模块处理程序
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');define('OD_ROOT', IA_ROOT . '/addons/jlsh_code');

class Jlsh_codeModuleProcessor extends WeModuleProcessor {
	public function respond() {		global $_W;				
		$content = $this->message['content'];
		$rid = $this->rule;
		
		$uniacid = $_W['uniacid'];
		
		
		$openid = $this->message['from'];
		
		load()->model('mc');
		$uid = mc_openid2uid($openid);
						$jifen_sql = "select * from ".tablename('jc_setting')." where ruleid = ".$rid;
		$jifen_list = pdo_fetch($jifen_sql);		if(!empty($jifen_list)){			$user = pdo_fetch('select nickname,credit1 from '.tablename('mc_members').' where uid = :uid',array(":uid"=>$uid));
			
			if(empty($user)){
				return $this->respText("积分添加异常,请告知店员重新生成二维码");
			}else{
					
				mc_credit_update($uid,'credit1',$jifen_list['number'],array($uid,"二维码积分".$jifen_list['number']));
									$data = array(					'weid' => $uniacid,
					'title' => $jifen_list['title'],
					'number' => $jifen_list['number'],
					'openid' => $user['nickname'],
					'addtime' => TIMESTAMP,					'ruleid' => $rid,					'sid' => $jifen_list['id'],
				);								pdo_insert('jc_jilu',$data);												$str = str_replace('{nickname}',$user['nickname'],$jifen_list['remind']);				$str = str_replace('{jifen}',$jifen_list['number'],$str);				$str = str_replace('{sum}',($user['credit1'] + $jifen_list['number']),$str);								return $this->respText($str);			}		}else {			return $this->respText("积分添加异常,请告知店员重新生成二维码");		}
	}
}